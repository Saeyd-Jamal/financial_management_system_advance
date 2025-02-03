<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\AddSalaryEmployee;
use App\Http\Controllers\Controller;
use App\Models\Accreditation;
use App\Models\Constant;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\FixedEntries;
use App\Models\ReceivablesLoans;
use App\Models\Salary;
use Exception;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SalaryController extends Controller
{
    protected $monthNameAr;

    public function __construct(){
        // مصفوفة لأسماء الأشهر باللغة العربية
        $this->monthNameAr = [
            '01' => 'يناير',
            '02' => 'فبراير',
            '03' => 'مارس',
            '04' => 'أبريل',
            '05' => 'مايو',
            '06' => 'يونيو',
            '07' => 'يوليو',
            '08' => 'أغسطس',
            '09' => 'سبتمبر',
            '10' => 'أكتوبر',
            '11' => 'نوفمبر',
            '12' => 'ديسمبر'
        ];
    }
    public function fixedEntriesVal($fixedEntries,$fixedEntriesStatic,$filed){
        $val = 0;
        // $employee->health_insurance = $fixedEntriesStatic->health_insurance != '-01' ? $fixedEntriesStatic->health_insurance : $fixedEntries->health_insurance;
        if($fixedEntries[$filed] == 0){
            $val = $fixedEntriesStatic[$filed] != '-01' ? $fixedEntriesStatic[$filed] : 0;
        }else{
            $val = $fixedEntries[$filed];
        }
        // if($fixedEntriesStatic != null && $fixedEntriesStatic[$filed] != -1 ){
        //     $val = $fixedEntriesStatic[$filed];
        // }else{
        //     if($fixedEntries != null){
        //         $val = $fixedEntries[$filed];
        //     }else{
        //         $val = 0;
        //     }
        // }
        return $val;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Salary::class);
        $request = request();
        $month = $request->month ?? Carbon::now()->format('Y-m');
        $employee_ids = Salary::where('month', $month)->get('employee_id');
        $USD = Currency::where('code', 'USD')->first() ? Currency::where('code', 'USD')->first()->value : 0;
        $employees = Employee::with(['workData','loans','fixedEntries','salaries'])->whereIn('id',$employee_ids)->get()->map(function ($employee) use ($month, $USD) {
            $fixedEntriesStatic = $employee->fixedEntries->where('month', '0000-00')->first();
            if($fixedEntriesStatic == null){
                $fixedEntriesStatic = new FixedEntries();
            }
            $fixedEntries = $employee->fixedEntries->where('month', $month)->first();
            if($fixedEntries == null){
                $fixedEntries = new FixedEntries();
            }
            $salaries = $employee->salaries->where('month', $month)->first();
            $employee->name = isset($employee->name)  ? preg_replace('/"(.*?)"/', '($1)', $employee->name)  : '';                
            $employee->association = $employee->workData->association ?? '';
            $employee->workplace = $employee->workData->workplace ?? '';
            $employee->allowance = $employee->workData->allowance ?? '';
            $employee->grade = $employee->workData->grade ?? '';
            $employee->initial_salary = $salaries->initial_salary ?? 0;
            $employee->grade_Allowance = $salaries->grade_Allowance ?? 0;
            $employee->secondary_salary = $salaries->secondary_salary ?? 0;
            $employee->allowance_boys = $salaries->allowance_boys ?? 0;
            $employee->nature_work_increase = $salaries->nature_work_increase ?? 0;
            $employee->administrative_allowance = $this->fixedEntriesVal($fixedEntries,$fixedEntriesStatic,'administrative_allowance');
            $employee->scientific_qualification_allowance = $this->fixedEntriesVal($fixedEntries,$fixedEntriesStatic,'scientific_qualification_allowance');
            $employee->transport = $this->fixedEntriesVal($fixedEntries,$fixedEntriesStatic,'transport');
            $employee->extra_allowance = $this->fixedEntriesVal($fixedEntries,$fixedEntriesStatic,'extra_allowance');
            $employee->salary_allowance = $this->fixedEntriesVal($fixedEntries,$fixedEntriesStatic,'salary_allowance');
            $employee->ex_addition = $this->fixedEntriesVal($fixedEntries,$fixedEntriesStatic,'ex_addition');
            $employee->mobile_allowance = $this->fixedEntriesVal($fixedEntries,$fixedEntriesStatic,'mobile_allowance');
            $employee->termination_service = $salaries->termination_service ?? 0;
            $employee->gross_salary = $salaries->gross_salary ?? 0;
            $employee->health_insurance = $this->fixedEntriesVal($fixedEntries,$fixedEntriesStatic,'health_insurance');
            $employee->z_Income = $salaries->z_Income ?? 0;
            $employee->savings_rate = $salaries->savings_rate ?? 0;
            $employee->association_loan = $salaries->association_loan ?? 0;
            $employee->savings_loan = $salaries->savings_loan * $USD ?? 0;
            $employee->shekel_loan = $salaries->shekel_loan ?? 0;
            $employee->late_receivables = $salaries->late_receivables ?? 0;
            $employee->total_discounts = $salaries->total_discounts ?? 0;
            $employee->net_salary = $salaries->net_salary ?? 0;
            $employee->account_number = $salaries->account_number ?? '';
            return $employee;
        });

        if($request->ajax()) {
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

        $accreditations = Accreditation::get();
        $lastAccreditations = Accreditation::latest()->first();
        $monthDownload = ($lastAccreditations  != null) ? Carbon::parse($lastAccreditations->month)->addMonth()->format('Y-m') : '2024-07' ;
        $employee_ids = Salary::where('month', $monthDownload)->get('employee_id');
        $btn_download_salary = $employee_ids->isNotEmpty() ? "active" : null;
        if($employees->isEmpty()) {
            $btn_download_salary = "active";
        }
        foreach ($employees as $employee) {
            $salary = Salary::where('employee_id', $employee->id)->where('month', $monthDownload)->first();
            if ($salary == null) {
                $btn_download_salary = "active";
                break;
            }
        }
        $btn_delete_salary = $employee_ids->isNotEmpty() ? "active" : null;

        return view('dashboard.salaries.index',compact('month','monthDownload','accreditations','btn_download_salary','btn_delete_salary'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Salary $salary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salary $salary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $salary = Salary::findOrFail($id);
        $USD = Currency::where('code', 'USD')->first()->value;
        $fixedEntries = $salary->employee->fixedEntries->where('month', $salary->month)->first();
        // إجمالي الإدخارات (تم وضع معادلته سابقا لوجود مشكلة بالحسبة)
        $savings_loan = ($fixedEntries != null) ? $fixedEntries->savings_loan : 0;
        $savings_rate = ($fixedEntries != null) ? $fixedEntries->savings_rate : 0;
        $termination_service = $salary->termination_service ?? 0;

        $total_savings = $savings_loan + (($savings_rate + $termination_service) / $USD );

        ReceivablesLoans::updateOrCreate([
            'employee_id' => $salary->employee_id,
        ],[
            'total_receivables' => DB::raw('total_receivables - '. ($salary->late_receivables )),
            'total_savings' => DB::raw('total_savings - ' . $total_savings),
            'total_savings_loan' => DB::raw('total_savings_loan + '.$savings_loan),
            'total_shekel_loan' => DB::raw('total_shekel_loan + '.($fixedEntries->shekel_loan ?? 0)),
            'total_association_loan' => DB::raw('total_association_loan + '.($fixedEntries->association_loan ?? 0))
        ]);
        $salary->forceDelete();
        // $salary->delete();
        return redirect()->route('salaries.index')->with('success', 'تم الحذف بنجاح');
    }

    // Create All Salaries
    public function createAllSalaries(Request $request){
        $this->authorize('create-all', Salary::class);
        DB::beginTransaction();
        try {

            // التجربة لموظف
            // $employee = Employee::findOrFail(17);
            // $month = $request->month ?? Carbon::now()->format('Y-m');
            // AddSalaryEmployee::addSalary($employee,$month);

            $employees = Employee::get();
            $logRecords = [];
            $month = $request->month ?? Carbon::now()->format('Y-m');
            foreach ($employees as $employee) {
                try{
                    AddSalaryEmployee::addSalary($employee,$month);
                }catch(Exception $e){
                    $logRecords[] = [
                        'type' => 'errorSalary',
                        'related_id' => "employee_$employee->id",
                        'description' => 'خطأ في معالجة راتب الموظف : ' . $employee->name . '. الخطأ: ' . $e->getMessage(),
                    ];
                }
            }
            // الحصول على بداية ونهاية الشهر السابق
            $startOfPreviousMonth = Carbon::now()->subMonth()->startOfMonth();
            $endOfPreviousMonth = Carbon::now()->subMonth()->endOfMonth();
            DB::commit();
        }catch (Exception $exception){
            DB::rollBack();
            throw $exception;
        }
        return redirect()->route('dashboard.salaries.index')->with('success', 'تم اضافة الراتب لجميع الموظفين للشهر الحالي')
                ->with('error', $logRecords);
    }
    // Create All Salaries
    public function deleteAllSalaries(Request $request){
        $this->authorize('delete-all', Salary::class);
        DB::beginTransaction();
        try {
            $month = $request->month ?? Carbon::now()->format('Y-m');
            $salaries = Salary::where('month', $month)->get();
            foreach ($salaries as $salary) {
                try{
                    $USD = Currency::where('code', 'USD')->first()->value;
                    $loans = $salary->employee->loans->where('month', $salary->month)->first();
                    // إجمالي الإدخارات (تم وضع معادلته سابقا لوجود مشكلة بالحسبة)
                    $savings_loan = ($loans != null) ? $loans->savings_loan : 0;
                    $savings_rate = ($loans != null) ? $loans->savings_rate : 0;
                    $termination_service = $salary->termination_service ?? 0;
                    $total_savings = $savings_loan + (($savings_rate + $termination_service) / $USD );
                    ReceivablesLoans::updateOrCreate([
                        'employee_id' => $salary->employee_id,
                    ],[
                        'total_receivables' => DB::raw('total_receivables - '. ($salary->late_receivables )),
                        'total_savings' => DB::raw('total_savings - ' . $total_savings),
                    ]);
                    $salary->forceDelete();
                }catch (\Exception $exception){
                    DB::rollBack();
                    throw $exception;
                }
            }
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            throw $exception;
        }
        return redirect()->route('dashboard.home')->with('danger', 'تم حذف الراتب لجميع الموظفين للشهر الحالي');
    }

    public function viewPDF(Request $request,$id){
        $month = $request->month ?? Carbon::now()->format('Y-m');
        $year = Carbon::parse($month)->format('Y');
        $monthAr = $this->monthNameAr[Carbon::parse($month)->format('m')];
        $employee = Employee::with(['totals','salaries','fixedEntries','workData'])->find($id);
        
        $fixedEntries = $employee->fixedEntries->where('month', '0000-00')->first();
        if($fixedEntries == null){
            $fixedEntries = $employee->fixedEntries->where('month', $month)->first();
        }
        $salaries = $employee->salaries->where('month', $month)->first();
        $margin_top = 30;
        if($employee->workData->association == 'صلاح' || $employee->workData->association == 'حطين'){
            $margin_top = 45;
        }
        $pdf = PDF::loadView('dashboard.reports.employee.employee_salary',['employee' => $employee,'fixedEntries' => $fixedEntries,'salaries' => $salaries,'month' => $month,'year' => $year, 'monthAr' => $monthAr],[],
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
        return $pdf->stream('تقرير مستحقات للموظف : ' . $employee->name .'  _ '.$time.'.pdf');
    }
}
