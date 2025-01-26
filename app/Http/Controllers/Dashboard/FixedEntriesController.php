<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\AddSalaryEmployee;
use App\Http\Controllers\Controller;
use App\Models\Accreditation;
use App\Models\Constant;
use App\Models\Employee;
use App\Models\FixedEntries;
use App\Models\Salary;
use App\Models\ReceivablesLoans;
use App\Models\WorkData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class FixedEntriesController extends Controller
{

    public $monthNow;
    public function __construct(){
        $this->monthNow = Carbon::now()->format('Y-m');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('view', FixedEntries::class);

        // جلب بيانات المستخدمين من الجدول
        $year = $request->year ?? Carbon::now()->format('Y');
        $month = $request->month ?? Accreditation::orderBy('id', 'desc')->first()->month;
        $month_start  = Carbon::create($year, 1, 1)->format('Y-m');
        $month_end = Carbon::create($year, 12, 31)->format('Y-m');
        if($request->ajax()) {
            $employees = Employee::with(['totals','loans','fixedEntries'])->get()->map(function ($employee) use ($year,$month,$month_start, $month_end) {
                $fixedEntries = $employee->fixedEntries->where('month', $month)->first();
                if($fixedEntries == null){
                    $fixedEntries = new FixedEntries();
                }
                $employee->name = isset($employee->name)  ? preg_replace('/"(.*?)"/', '($1)', $employee->name)  : '';                
                $employee->association = $employee->workData->association ?? '';
                $employee->workplace = $employee->workData->workplace ?? '';
                $employee->administrative_allowance = $fixedEntries->administrative_allowance ?? '';
                $employee->scientific_qualification_allowance = $fixedEntries->scientific_qualification_allowance ?? '';
                $employee->transport = $fixedEntries->transport ?? '';
                $employee->extra_allowance = $fixedEntries->extra_allowance ?? '';
                $employee->salary_allowance = $fixedEntries->salary_allowance ?? '';
                $employee->ex_addition = $fixedEntries->ex_addition ?? '';
                $employee->mobile_allowance = $fixedEntries->mobile_allowance ?? '';
                $employee->health_insurance = $fixedEntries->health_insurance ?? '';
                $employee->f_Oredo = $fixedEntries->f_Oredo ?? '';
                $employee->tuition_fees = $fixedEntries->tuition_fees ?? '';
                $employee->voluntary_contributions = $fixedEntries->voluntary_contributions ?? '';
                $employee->paradise_discount = $fixedEntries->paradise_discount ?? '';
                $employee->other_discounts = $fixedEntries->other_discounts ?? '';
                $employee->proportion_voluntary = $fixedEntries->proportion_voluntary ?? '';
                $employee->savings_rate = $fixedEntries->savings_rate ?? '';
                return $employee;
            });

            

            return DataTables::of($employees)
                    ->addIndexColumn()  // إضافة عمود الترقيم التلقائي
                    ->addColumn('edit', function ($employee) {
                        return $employee->id;
                    })
                    ->make(true);
        }

        $year = Carbon::now()->format('Y');
        $lastMonth = Accreditation::orderBy('id', 'desc')->first() ? Accreditation::orderBy('id', 'desc')->first()->month : Carbon::now()->format('Y-m');
        $lastMonth = Carbon::parse($lastMonth)->format('m');
        return view('dashboard.fixed_entries.index', compact('year', 'lastMonth','month'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', FixedEntries::class);

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
        $this->authorize('update', FixedEntries::class);
        if($request->ajax()) {
            $fixedEntries = FixedEntries::where('employee_id', $id)->where('month', $this->monthNow)->first();
            if($fixedEntries != null){
                $year = Carbon::parse($fixedEntries->month)->format('Y');
                $month_start  = Carbon::create($year, 1, 1)->format('Y-m');
                $month_end = Carbon::create($year, 12, 31)->format('Y-m');

                $filteredEntries = FixedEntries::
                                    where('employee_id', $id)
                                    ->where(function($query) use ($month_start, $month_end){
                                        $query->whereBetween('month', [$month_start, $month_end])
                                        ->orWhere('month', '0000-00');
                                    })
                                    ->get();
            }else{
                $filteredEntries = FixedEntries::where('employee_id', $id)->where('month', '0000-00')->get();
            }
            return response()->json($filteredEntries);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update', FixedEntries::class);
        DB::beginTransaction();
        try{
            $year = $request->header('year');
            $month_last = Accreditation::orderBy('id', 'desc')->first() ? Accreditation::orderBy('id', 'desc')->first()->month : Carbon::now()->format('Y-m');
            dd($request->all());
            for ($i=1; $i <= 12; $i++) {
                $monthlast = Carbon::parse($month_last)->format('m');
                $i = $i < 10 ? '0'.$i : $i;
                if($monthlast != 12){
                    if($i <= $monthlast){
                        continue;
                    }
                }
                $month = $year.'-'.$i;
                $fixedEntriesOld = FixedEntries::where('employee_id', $id)->where('month', $month)->first();
                $fixedEntries = FixedEntries::updateOrCreate([
                    'employee_id' => $id,
                    'month' => $month
                    ],[
                    'administrative_allowance' => $request['administrative_allowance-'.$i] ?? 0,
                    'scientific_qualification_allowance' => $request['scientific_qualification_allowance-'.$i] ?? 0,
                    'transport' =>  $request['transport-'.$i] ?? 0,
                    'extra_allowance' =>  $request['extra_allowance-'.$i] ?? 0,
                    'salary_allowance' =>  $request['salary_allowance-'.$i] ?? 0,
                    'ex_addition' => $request['ex_addition-'.$i] ?? 0,
                    'mobile_allowance' => $request['mobile_allowance-'.$i] ?? 0,
                    'health_insurance' => $request['health_insurance-'.$i] ?? 0,
                    'f_Oredo' =>  $request['f_Oredo-'.$i] ?? 0,
                    'tuition_fees' => $request['tuition_fees-'.$i] ?? 0,
                    'voluntary_contributions' => $request['voluntary_contributions-'.$i] ?? 0,
                    'paradise_discount' => $request['paradise_discount-'.$i] ?? 0,
                    'other_discounts' => $request['other_discounts-'.$i] ?? 0,
                    'proportion_voluntary' => $request['proportion_voluntary-'.$i] ?? 0,
                    'savings_rate' => $request['savings_rate-'.$i] == "on" ? 1 : 0,
                ]);
            }            

            FixedEntries::updateOrCreate([
                'employee_id' => $id,
                'month' => '0000-00',
                ],[
                'administrative_allowance' => $request['administrative_allowance-0000'] ?? -01,
                'scientific_qualification_allowance' => $request['scientific_qualification_allowance-0000'] ?? -01,
                'transport' =>  $request['transport-0000'] ?? -01,
                'extra_allowance' =>  $request['extra_allowance-0000'] ?? -01,
                'salary_allowance' =>  $request['salary_allowance-0000'] ?? -01,
                'ex_addition' => $request['ex_addition-0000'] ?? -01,
                'mobile_allowance' => $request['mobile_allowance-0000'] ?? -01,
                'health_insurance' => $request['health_insurance-0000'] ?? -01,
                'f_Oredo' =>  $request['f_Oredo-0000'] ?? -01,
                'tuition_fees' => $request['tuition_fees-0000'] ?? -01,
                'voluntary_contributions' => $request['voluntary_contributions-0000'] ?? -01,
                'paradise_discount' => $request['paradise_discount-0000'] ?? -01,
                'other_discounts' => $request['other_discounts-0000'] ?? -01,
                'proportion_voluntary' => $request['proportion_voluntary-0000'] ?? -01,
                'savings_rate' => $request['savings_rate-0000'] == "on" ? 1 : -01,
            ]);
            $employee = Employee::findOrFail($id);
            $salary = Salary::where('employee_id',$id)->where('month',Carbon::now()->format('Y-m'))->first();
            if($salary != null){
                AddSalaryEmployee::addSalary($employee,$this->monthNow);
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['danger' => $e->getMessage()], 500);
        }

        if($request->ajax()) {
            return response()->json(['success' => 'تم تحديث الثوابت بنجاح']);
        }
        return redirect()->route('dashboard.fixed_entries.index')->with('success','تم تحديث الثوابت بنجاح');
    }

    public function getData(Request $request)
    {
        $id = $request->id;
        $employee = Employee::with(['workData'])->findOrFail($id);
        return $employee;
    }

}
