<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\AddSalaryEmployee;
use App\Http\Controllers\Controller;
use App\Models\Constant;
use App\Models\Employee;
use App\Models\Salary;
use App\Models\SpecificSalary;
use App\Models\WorkData;
use App\Models\ReceivablesLoans;
use App\Models\Bank;
use App\Models\Account;
use App\Models\Currency;
use App\Models\Exchange;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Helper\FormatSize;
use App\Models\FixedEntries;
use App\Models\Loan;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    protected $monthNameAr;
    public function __construct()
    {
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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Employee::class);
        $request = request();
        if($request->ajax()) {
            $employees = Employee::with(['workData'])->get()->map(function ($employee) {
                $employee->name = isset($employee->name)  ? preg_replace('/"(.*?)"/', '($1)', $employee->name)  : '';                
                $employee->working_status = $employee->workData->working_status ?? '';
                $employee->type_appointment = $employee->workData->type_appointment ?? '';
                $employee->field_action = $employee->workData->field_action ?? '';
                $employee->allowance = $employee->workData->allowance ?? '';
                $employee->grade = $employee->workData->grade ?? '';
                $employee->grade_allowance_ratio = $employee->workData->grade_allowance_ratio ?? '';
                $employee->dual_function = $employee->workData->dual_function ?? '';
                $employee->years_service = $employee->workData->years_service ?? '';
                $employee->nature_work = $employee->workData->nature_work ?? '';
                $employee->state_effectiveness = $employee->workData->state_effectiveness ?? '';
                $employee->association = $employee->workData->association ?? '';
                $employee->workplace = $employee->workData->workplace ?? '';
                $employee->section = $employee->workData->section ?? '';
                $employee->dependence = $employee->workData->dependence ?? '';
                $employee->working_date = $employee->workData->working_date ?? '';
                $employee->date_installation = $employee->workData->date_installation ?? '';
                $employee->date_retirement = $employee->workData->date_retirement ?? '';
                $employee->payroll_statement = $employee->workData->payroll_statement ?? '';
                $employee->establishment = $employee->workData->establishment ?? '';
                $employee->foundation_E = $employee->workData->foundation_E ?? '';
                $employee->salary_category = $employee->workData->salary_category ?? '';
                $employee->contract_type = $employee->workData->contract_type ?? '';
                return $employee;
            });

            // التصفية بناءً على التواريخ
            if ($request->from_date != null && $request->to_date != null) {
                $employees->whereBetween('date_of_birth', [$request->from_date, $request->to_date]);
            }
            return DataTables::of($employees)
                    ->addIndexColumn()  // إضافة عمود الترقيم التلقائي
                    ->addColumn('edit', function ($employee) {
                        return $employee->id;
                    })
                    ->addColumn('delete', function ($employee) {
                        return $employee->id;
                    })
                    ->make(true);
        }

        return view('dashboard.employees.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Employee::class);


        // Constants
        $constants = Constant::get();
        $advance_payment_rate = $constants->where('key','advance_payment_rate')->first('value') ? $constants->where('key','advance_payment_rate')->first('value')->value : 0;
        $advance_payment_permanent = $constants->where('key','advance_payment_permanent')->first('value') ? $constants->where('key','advance_payment_permanent')->first('value')->value : 0;
        $advance_payment_non_permanent = $constants->where('key','advance_payment_non_permanent')->first('value') ? $constants->where('key','advance_payment_non_permanent')->first('value')->value : 0;
        $advance_payment_riyadh = $constants->where('key','advance_payment_riyadh')->first('value') ? $constants->where('key','advance_payment_riyadh')->first('value')->value : 0;

        // Arrays
        $employees = Employee::query();
        $areas = $employees->select('area')->distinct()->pluck('area')->toArray();
        $matrimonial_status_Array = $employees->select('matrimonial_status')->distinct()->pluck('matrimonial_status')->toArray();
        $scientific_qualification_array = $employees->select('scientific_qualification')->distinct()->pluck('scientific_qualification')->toArray();

        $workdata = WorkData::query();
        $working_status = $workdata->select('working_status')->distinct()->pluck('working_status')->toArray();
        $nature_work = $workdata->select('nature_work')->distinct()->pluck('nature_work')->toArray();
        $type_appointment = $workdata->select('type_appointment')->distinct()->pluck('type_appointment')->toArray();
        $field_action = $workdata->select('field_action')->distinct()->pluck('field_action')->toArray();
        $state_effectiveness = $workdata->select('state_effectiveness')->distinct()->pluck('state_effectiveness')->toArray();
        $association =  $workdata->select('association')->distinct()->pluck('association')->toArray();
        $workplace = $workdata->select('workplace')->distinct()->pluck('workplace')->toArray();
        $section = $workdata->select('section')->distinct()->pluck('section')->toArray();
        $dependence = $workdata->select('dependence')->distinct()->pluck('dependence')->toArray();
        $establishment = $workdata->select('establishment')->distinct()->pluck('establishment')->toArray();
        $foundation_E = $workdata->select('foundation_E')->distinct()->pluck('foundation_E')->toArray();
        $payroll_statement = $workdata->select('payroll_statement')->distinct()->pluck('payroll_statement')->toArray();
        $contract_type = $workdata->select('contract_type')->distinct()->pluck('contract_type')->toArray();


        $employee = new Employee();
        $workData = new WorkData();
        $employee->workData = $workData;
        $totals = new ReceivablesLoans();
        $totals = [];
        $banks = Bank::all();
        $account = new Account();
        $accounts = Account::all();
        $accounts_count = 0;

        return view('dashboard.employees.create', compact('employee','workData','totals','banks','accounts','accounts_count',"advance_payment_rate","advance_payment_permanent","advance_payment_non_permanent","advance_payment_riyadh","areas","working_status","nature_work","type_appointment","field_action","matrimonial_status_Array","scientific_qualification_array","state_effectiveness","association","workplace","section","dependence","establishment","foundation_E","payroll_statement","contract_type"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Employee::class);
        DB::beginTransaction();
        try{
            $employee = Employee::create($request->all());
            $request->merge([
                'employee_id' => $employee->id,
                'default' => 1
            ]);
            WorkData::create($request->all());

            ReceivablesLoans::create($request->all());

            if($request->num_accounts == 0){
                for($i = 0; $i < $request->num_accounts; $i++){
                    Account::where('employee_id', $employee->id)->delete();
                    Account::create([
                        'employee_id' => $employee->id,
                        'bank_id' => $request['bank_id-'.$i],
                        'account_number' => $request['account_number-'.$i],
                        'default' => $request->default == $i ? 1 : 0,
                    ]);
                }
            }

            // الراتب المحدد
            if($request->type_appointment == 'يومي'){
                SpecificSalary::updateOrCreate([
                    'employee_id'=> $employee->id,
                    'month' => '0000-00',
                    ],[
                    'number_of_days' => $request->number_of_days,
                    'today_price' => $request->today_price,
                    'salary' => $request->specific_salary
                ]);
            }
            if(in_array($request->type_appointment,['خاص','مؤقت','فصلي','رياض'])){
                SpecificSalary::updateOrCreate([
                    'employee_id'=> $employee->id,
                    'month' => '0000-00',
                    ],[
                    'salary' => $request->specific_salary
                ]);
            }

            DB::commit();
            return redirect()->route('dashboard.employees.index')->with('success', 'تم اضافة الموظف الجديد');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('dashboard.employees.index')->with('danger', $e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Employee $employee)
    {
        if ($request->showModel == true) {
            $employee = Employee::with(['workData'])->find($employee->id);
            return $employee;
        }
        // return redirect()->route('employees.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,Employee $employee)
    {
        $this->authorize('update', Employee::class);
        // Constants
        $constants = Constant::get();
        $advance_payment_rate = $constants->where('key','advance_payment_rate')->first('value') ? $constants->where('key','advance_payment_rate')->first('value')->value : 0;
        $advance_payment_permanent = $constants->where('key','advance_payment_permanent')->first('value') ? $constants->where('key','advance_payment_permanent')->first('value')->value : 0;
        $advance_payment_non_permanent = $constants->where('key','advance_payment_non_permanent')->first('value') ? $constants->where('key','advance_payment_non_permanent')->first('value')->value : 0;
        $advance_payment_riyadh = $constants->where('key','advance_payment_riyadh')->first('value') ? $constants->where('key','advance_payment_riyadh')->first('value')->value : 0;

        // Arrays
        $employees = Employee::query();
        $areas = $employees->select('area')->distinct()->pluck('area')->toArray();
        $matrimonial_status_Array = $employees->select('matrimonial_status')->distinct()->pluck('matrimonial_status')->toArray();
        $scientific_qualification_array = $employees->select('scientific_qualification')->distinct()->pluck('scientific_qualification')->toArray();

        $workdata = WorkData::query();
        $working_status = $workdata->select('working_status')->distinct()->pluck('working_status')->toArray();
        $nature_work = $workdata->select('nature_work')->distinct()->pluck('nature_work')->toArray();
        $type_appointment = $workdata->select('type_appointment')->distinct()->pluck('type_appointment')->toArray();
        $field_action = $workdata->select('field_action')->distinct()->pluck('field_action')->toArray();
        $state_effectiveness = $workdata->select('state_effectiveness')->distinct()->pluck('state_effectiveness')->toArray();
        $association =  $workdata->select('association')->distinct()->pluck('association')->toArray();
        $workplace = $workdata->select('workplace')->distinct()->pluck('workplace')->toArray();
        $section = $workdata->select('section')->distinct()->pluck('section')->toArray();
        $dependence = $workdata->select('dependence')->distinct()->pluck('dependence')->toArray();
        $establishment = $workdata->select('establishment')->distinct()->pluck('establishment')->toArray();
        $foundation_E = $workdata->select('foundation_E')->distinct()->pluck('foundation_E')->toArray();
        $payroll_statement = $workdata->select('payroll_statement')->distinct()->pluck('payroll_statement')->toArray();
        $contract_type = $workdata->select('contract_type')->distinct()->pluck('contract_type')->toArray();



        $USD = Currency::where('code', 'USD')->first()->value;
        $month = Carbon::now()->format('Y') . '-01';
        $to_month = Carbon::now()->format('Y') . '-12';

        $salaries = Salary::where('employee_id', $employee->id)
                    ->whereBetween('month', [$month, $to_month])
                    ->get();


        $exchanges = Exchange::where('employee_id', $employee->id)
                ->get();

        $btn_label = "تعديل";
        $workData = WorkData::where('employee_id', $employee->id)->first();
        if ($workData == null) {
            $workData = new WorkData();
        }
        $totals = ReceivablesLoans::where('employee_id', $employee->id)->first();
        if ($totals == null) {
            $totals = new ReceivablesLoans();
        }
        $banks = Bank::all();

        $accounts = Account::where('employee_id', $employee->id)->get();
        $accounts_count = Account::where('employee_id', $employee->id)->count();
        if ($accounts == null) {
            $accounts = new Account();
        }


        // Files
        $files = json_decode($employee->workData->files) ?? [];
        return view('dashboard.employees.edit', compact('employee','workData','files','totals','banks','accounts','accounts_count','salaries','USD','exchanges','btn_label',"advance_payment_rate","advance_payment_permanent","advance_payment_non_permanent","advance_payment_riyadh","areas","working_status","nature_work","type_appointment","field_action","matrimonial_status_Array","scientific_qualification_array","state_effectiveness","association","workplace","section","dependence","establishment","foundation_E","payroll_statement",'contract_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $this->authorize('update', Employee::class);
        // $request->validate([
        //     'employee_id' => [
        //         'required',
        //         'string',
        //         "unique:employees,employee_id,$request->employee_id,employee_id"
        //     ]
        // ],[
        //     'unique' => ' هذا الحقل (:attribute) مكرر يرجى التحقق'
        // ]);
        DB::beginTransaction();
        try{
            $employee->update($request->all());
            $request->merge([
                'employee_id' => $employee->id,
                'default' => 1
            ]);
            $workData = $request->all();
            if($request->type_appointment != 'مثبت'){
                $workData['allowance'] = null;
                $workData['grade'] = null;
                $workData['grade_allowance_ratio'] = null;
                $workData['percentage_allowance'] = null;
                $workData['salary_category'] = null;
            }
            if($request->type_appointment != 'يومي'){
                $workData['number_of_days'] = null;
                $workData['today_price'] = null;
            }
            WorkData::updateOrCreate([
                'employee_id' => $employee->id
            ], $workData);

            ReceivablesLoans::updateOrCreate([
                'employee_id' => $employee->id
            ], $request->all());

            if($request->num_accounts != 0){
                Account::where('employee_id', $employee->id)->delete();
                for($i = 1; $i <= $request->num_accounts; $i++){
                    Account::create([
                        'employee_id' => $employee->id,
                        'bank_id' => $request['bank_id-'.$i],
                        'account_number' => $request['account_number-'.$i],
                        'default' => $request->default == $i ? 1 : 0,
                    ]);
                }
            }


            // الراتب المحدد
            if($request->type_appointment == 'يومي'){
                SpecificSalary::updateOrCreate([
                    'employee_id'=> $employee->id,
                    'month' => '0000-00',
                    ],[
                    'number_of_days' => $request->number_of_days,
                    'today_price' => $request->today_price,
                    'salary' => $request->specific_salary
                ]);
            }
            if(in_array($request->type_appointment,['خاص','مؤقت','فصلي','رياض'])){
                SpecificSalary::updateOrCreate([
                    'employee_id'=> $employee->id,
                    'month' => '0000-00',
                    ],[
                    'salary' => $request->specific_salary
                ]);
            }

            $salary = Salary::where('employee_id',$employee->id)->where('month',Carbon::now()->format('Y-m'))->first();
            if($salary != null){
                AddSalaryEmployee::addSalary($employee);
            }
            DB::commit();
            return redirect()->route('dashboard.employees.index')->with('success', 'تم تحديث بيانات الموظف المختار');
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Employee $employee)
    {
        $this->authorize('delete', Employee::class);
        $employee->delete();
        return redirect()->route('dashboard.employees.index')->with('danger', 'تم حذف بيانات الموظف المحدد');
    }


    // getEmployeeId for tables related to employees
    public function getEmployee(Request $request)
    {
        $employee_search_id = $request->get('employeeId');
        $employee_search_name = $request->get('employeeName');
        $employees = new Employee();
        if($employee_search_id != ""){
            $employees = $employees->where('employee_id','LIKE',"{$employee_search_id}%");
        }
        if($employee_search_name != ""){
            $valueS = str_replace('*', '%', $employee_search_name);
            $employees = $employees->where('name','LIKE',"%{$valueS}%");
        }


        return $employees->get();
    }

    public function uplodeFiles(Request $request){
        // uploade Files
        $employee = Employee::with('workData')->findOrFail($request->employee_id);
        $file = $request->file('fileUpload'); // احصل على الملف المرفوع
        if ($file) {
            $name_file = $request->fileName ?? $file->getClientOriginalName();
            $size_file = $file->getSize();
            $extension = $file->getClientOriginalExtension();
            if(in_array($extension, ['pdf','docx','xlsx','txt'])){
                $icon = 'fa-file-lines';
            }elseif(in_array($extension, ['jpg','png','jpeg'])){
                $icon = 'fa-image';
            }else{
                $icon = "fad-file";
            }
            // قم بتخزين الملف في المجلد الذي ترغب فيه
            $filePath = $file->storeAs('employeeFiles', Str::slug($name_file) . '.' . $extension . '-' . time(), 'public');
            $files = json_decode($employee->workData->files);
            $files[] = [
                'name' => $name_file,
                'size' => $size_file,
                'icon' => $icon,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'file_path' => asset('storage/' . $filePath),
                'employee_id' => $employee->id
            ];
            $employee->workData->files = json_encode($files);
            $employee->workData->save();
            // إذا أردت إرجاع رابط الوصول للملف
            return response()->json([
                'index' => count($files) - 1,
                'employee_id' => $employee->id,
                'file_path' => asset('storage/' . $filePath),
                'size' => FormatSize::formatSize($size_file),
                'name' => $name_file,
                'icon' => $icon,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ], 200);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
    public function files_destroy(Request $request){
        // uploade Files
        $index = $request->index;
        $employee = Employee::with('workData')->findOrFail($request->employee_id);
        $file = $employee->workData->files; // احصل على الملف المرفوع
        $file = json_decode($file);
        unset($file[$index]); // حذف العنصر المطلوب
        $file = array_values($file); // إعادة ترتيب المصفوفة بدون مفاتيح رقمية
        $employee->workData->files = json_encode($file, JSON_UNESCAPED_UNICODE);
        $employee->workData->save();

        $files = json_decode($employee->workData->files) ?? [];
        return response()->json($files, 200);
    }

    public function getSalary(Request $request){
        $this->authorize('view', Salary::class);
        $year = $request->year ?? Carbon::now()->format('Y');
        $employee_id = $request->employee_id;
        $USD = Currency::where('code', 'USD')->first() ? Currency::where('code', 'USD')->first()->value : 0;
        $salaries = Salary::with(['employee'])
            ->where('employee_id',$employee_id)
            ->whereBetween('month', [$year.'-01', $year.'-12'])
            ->get()->map(function ($salary) use ($USD) {
            $month = $salary->month;
            $employee = $salary->employee;

            $fixedEntries = $employee->fixedEntries->where('month', $month)->first();
            $fixedEntriesStatic = $employee->fixedEntries->where('month', '0000-00')->first();
            if($fixedEntries == null){
                $fixedEntries = new FixedEntries();
            }
            if($fixedEntriesStatic == null){
                $fixedEntriesStatic = $fixedEntries;
            }
            $salaries = $employee->salaries->where('month', $month)->first();
            $salary->month = $this->monthNameAr[Carbon::parse($month)->format('m')];                
            $salary->allowance = $employee->workData->allowance ?? '';
            $salary->grade = $employee->workData->grade ?? '';
            $salary->initial_salary = $salaries->initial_salary ?? 0;
            $salary->grade_Allowance = $salaries->grade_Allowance ?? 0;
            $salary->secondary_salary = $salaries->secondary_salary ?? 0;
            $salary->allowance_boys = $salaries->allowance_boys ?? 0;
            $salary->nature_work_increase = $salaries->nature_work_increase ?? 0;
            $salary->administrative_allowance = $fixedEntriesStatic->administrative_allowance != '-01' ? $fixedEntriesStatic->administrative_allowance : $fixedEntries->administrative_allowance;
            $salary->scientific_qualification_allowance = $fixedEntriesStatic->scientific_qualification_allowance != '-01' ? $fixedEntriesStatic->scientific_qualification_allowance : $fixedEntries->scientific_qualification_allowance;
            $salary->transport = $fixedEntriesStatic->transport != '-01' ? $fixedEntriesStatic->transport : $fixedEntries->transport;
            $salary->extra_allowance = $fixedEntriesStatic->extra_allowance != '-01' ? $fixedEntriesStatic->extra_allowance : $fixedEntries->extra_allowance;
            $salary->salary_allowance = $fixedEntriesStatic->salary_allowance != '-01' ? $fixedEntriesStatic->salary_allowance : $fixedEntries->salary_allowance;
            $salary->ex_addition = $fixedEntriesStatic->ex_addition != '-01' ? $fixedEntriesStatic->ex_addition : $fixedEntries->ex_addition;
            $salary->mobile_allowance = $fixedEntriesStatic->mobile_allowance != '-01' ? $fixedEntriesStatic->mobile_allowance : $fixedEntries->mobile_allowance;
            $salary->termination_service = $salaries->termination_service ?? 0;
            $salary->gross_salary = $salaries->gross_salary ?? 0;
            $salary->health_insurance = $fixedEntriesStatic->health_insurance != '-01' ? $fixedEntriesStatic->health_insurance : $fixedEntries->health_insurance;
            $salary->z_Income = $salaries->z_Income ?? 0;
            $salary->savings_rate = $salaries->savings_rate ?? 0;
            $salary->association_loan = $salaries->association_loan ?? 0;
            $salary->savings_loan = $salaries->savings_loan * $USD ?? 0;
            $salary->shekel_loan = $salaries->shekel_loan ?? 0;
            $salary->late_receivables = $salaries->late_receivables ?? 0;
            $salary->total_discounts = $salaries->total_discounts ?? 0;
            $salary->net_salary = $salaries->net_salary ?? 0;
            $salary->account_number = $salaries->account_number ?? '';
            return $salary;
        });


        if($request->ajax()) {
            return DataTables::of($salaries)
                    ->addIndexColumn()  // إضافة عمود الترقيم التلقائي
                    ->addColumn('print', function ($salary) {
                        return $salary->id;
                    })
                    ->make(true);
        }
    }
}
