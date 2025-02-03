<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\AddSalaryEmployee;
use App\Http\Controllers\Controller;
use App\Models\Accreditation;
use App\Models\Employee;
use App\Models\Exchange;
use App\Models\Loan;
use App\Models\Salary;
use App\Models\ReceivablesLoans;
use App\Services\LoanService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Yajra\DataTables\Facades\DataTables;

class LoanController extends Controller
{
    public $monthNow;
    public function __construct(){
        $monthLast = Accreditation::orderBy('id', 'desc')->first() ? Accreditation::orderBy('id', 'desc')->first()->month : Carbon::now()->subMonth()->format('Y-m');
        $this->monthNow = Carbon::parse($monthLast)->addMonth()->format('Y-m');
    }
    public function getField($employee,$year,$month,$field){
        $val = $employee->loans->where('month',$year . '-' . $month)->first() ? $employee->loans->where('month',$year . '-' . $month)->first()[$field] : 0;
        return $val;
    }
    public function getTotalYear($employee,$year,$total_field,$field){
        $total = $employee->totals[$total_field] ?? 0;
        $loans = Loan::where('employee_id', $employee->id)->whereBetween('month', [$year . '-01', $year . '-12'])->get();
        $val = $loans->sum($field);
        for($i=1; $i <= 12; $i++) {
            $i = $i < 10 ? '0'.$i : $i;
            $salary = Salary::where('employee_id', $employee->id)->where('month', $year . '-' . $i)->first();
            if($salary != null){
                $total = $total + (Loan::where('employee_id', $employee->id)->where('month', $year . '-' . $i)->first()[$field] ?? 0);
            }
        }
        $val = $total - $val;
        return $val;
    }
    public function getPreviousBalance($employee,$year,$field,$total_field){
        $total = $employee->totals[$total_field] ?? 0;
        $loans = Loan::where('employee_id', $employee->id)->whereBetween('month', [$year . '-01', $year . '-12'])->get();
        $val = $loans->sum($field);
        $val = $total + $val;
        return $val;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('view', Loan::class);
        $this->authorize('view', ReceivablesLoans::class);
        $request = request();
        $year = $request->year ?? Carbon::now()->format('Y');
        if($request->ajax()) {
            $field = $request->field ?? 'savings_loan';
            $total_field = $request->total_field ?? 'total_savings_loan';
            $employees = Employee::with(['totals','loans'])->get()->map(function ($employee) use ($year,$field,$total_field) {
                $employee->name = isset($employee->name)  ? preg_replace('/"(.*?)"/', '($1)', $employee->name)  : '';                
                $employee->association = $employee->workData->association ?? '';
                $employee->previous_balance = $this->getPreviousBalance($employee,$year,$field,$total_field);
                $employee->month1 = $this->getField($employee,$year,'01',$field);
                $employee->month2 = $this->getField($employee,$year,'02',$field);
                $employee->month3 = $this->getField($employee,$year,'03',$field);
                $employee->month4 = $this->getField($employee,$year,'04',$field);
                $employee->month5 = $this->getField($employee,$year,'05',$field);
                $employee->month6 = $this->getField($employee,$year,'06',$field);
                $employee->month7 = $this->getField($employee,$year,'07',$field);
                $employee->month8 = $this->getField($employee,$year,'08',$field);
                $employee->month9 = $this->getField($employee,$year,'09',$field);
                $employee->month10 = $this->getField($employee,$year,'10',$field);
                $employee->month11 = $this->getField($employee,$year,'11',$field);
                $employee->month12 = $this->getField($employee,$year,'12',$field);
                $employee->total_year = $this->getTotalYear($employee,$year,$total_field,$field);
                $employee->total = $employee->totals[$total_field] ?? 0;
                return $employee;
            });
            return DataTables::of($employees)
                    ->addIndexColumn()  // إضافة عمود الترقيم التلقائي
                    ->addColumn('edit', function ($employee) {
                        return $employee->id;
                    })
                    ->addColumn('print', function ($employee) {
                        return $employee->id;
                    })
                    ->make(true);
        }
        $exchanges = Exchange::where('exchange_type','total_association_loan')
                                ->orWhere('exchange_type','total_savings_loan')
                                ->orWhere('exchange_type','total_shekel_loan')
                                ->get();
        $lastMonth = Accreditation::orderBy('id', 'desc')->first() ? Accreditation::orderBy('id', 'desc')->first()->month : Carbon::now()->format('Y-m');
        $nextLastMonth = Carbon::parse($lastMonth)->addMonth()->format('Y-m');
        $lastMonth = Carbon::parse($lastMonth)->format('m');
        $salaries = Salary::where('month', $nextLastMonth)->exists();
        $nextLastMonth = Carbon::parse($nextLastMonth)->format('m');
        $lastMonthAccreditations = $salaries;
        return view('dashboard.loans.index',compact('exchanges','year','lastMonth','nextLastMonth','lastMonthAccreditations'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Loan::class);
        $salary = Salary::where('employee_id',$request->employee_id)->where('month',$this->monthNow)->first();
        if($salary != null){
            $employee = Employee::findOrFail($request->employee_id);
            AddSalaryEmployee::addSalary($employee,$this->monthNow);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $this->authorize('update', Loan::class);
        if($request->ajax()) {
            $loans = Loan::where('employee_id', $id)->where('month', $this->monthNow)->first();
            if($loans != null){
                $year = Carbon::parse($loans->month)->format('Y');
                $month_start  = Carbon::create($year, 1, 1)->format('Y-m');
                $month_end = Carbon::create($year, 12, 31)->format('Y-m');
                $filteredloans = Loan::
                                    where('employee_id', $id)
                                    ->where(function($query) use ($month_start, $month_end){
                                        $query->whereBetween('month', [$month_start, $month_end])
                                        ->orWhere('month', '0000-00');
                                    })
                                    ->get();
            }else{
                $filteredloans = Loan::where('employee_id', $id)->where('month', '0000-00')->get();
            }
            return response()->json($filteredloans);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update', Loan::class);
        DB::beginTransaction();
        try{
            LoanService::store($request,$id,$this->monthNow);
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }

        if($request->ajax()) {
            return response()->json(['success' => 'تم تحديث الثوابت بنجاح']);
        }
        return redirect()->route('dashboard.loans.index')->with('success','تم تحديث الثوابت بنجاح');
    }

    public function getData(Request $request)
    {
        $id = $request->id;
        $year = $request->year;
        $employee = Employee::with(['workData','totals'])->findOrFail($id);
        $nextLastMonth = Carbon::parse($year . $request->nextLastMonth)->format('Y-m');
        $loans = Loan::where('employee_id', $id)->whereBetween('month',[$year .'-01', $year .'-12'])->get();
        $totals_last = Loan::where('employee_id', $id)->where('month', $nextLastMonth)->first();
        $employee->loans = $loans;
        $employee->totals_last = $totals_last;
        return response()->json([
            'employee' => $employee
        ]);
    }

    public function print(Request $request,$id)
    {
        $year = $request->year ?? Carbon::now()->year;
        $employee = Employee::with(['totals','loans'])->find($id);
        $name_loan = '';
        if($request['field'] == 'association_loan'){
            $name_loan = 'قرض الجمعية';
        }elseif($request['field'] == 'savings_loan'){
            $name_loan = 'قرض الإدخار';
        }elseif($request['field'] == 'shekel_loan'){
            $name_loan = 'قرض الشيكل';
        }
        $margin_top = 30;
        if($employee->workData->association == 'صلاح' || $employee->workData->association == 'حطين'){
            $margin_top = 45;
        }
        $pdf = PDF::loadView('dashboard.reports.employee.employee_loans',
        ['employee' => $employee,
            'year' => $year,
            'name_loan' => $name_loan,
            'field' => $request['field'],
            'total_field' => $request['total_field'],
            'previous_balance' => $request['previous_balance']
        ],[],
        [
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font_size' => 12,
            'default_font' => 'Arial',
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => $margin_top ,
            'margin_bottom' => 0,
        ]);
        $time = Carbon::now();
        return $pdf->stream('تقرير صرف ' . $name_loan .'  للموظف : ' . $employee->name .'  _ '.$time.'.pdf');
    }
}
