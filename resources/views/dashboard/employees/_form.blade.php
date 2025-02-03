<!-- Nav tabs -->
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/custom/employeeForm.css') }}">
    <style>
        hr {
            position: absolute;
            top: 50px;
            right: 15px;
            width: 35%;
            height: 5px;
            border-radius: 10px;
            background: linear-gradient(to right, rgba(210, 255, 82, 1) 0%, rgba(40, 64, 18, 1) 100%);
            margin: 0;
        }

        .drop-container {
            position: relative;
            display: flex;
            gap: 10px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 200px;
            padding: 20px;
            border-radius: 10px;
            border: 2px dashed #555;
            color: #444;
            cursor: pointer;
            transition: background .2s ease-in-out, border .2s ease-in-out;
        }

        .drop-container:hover {
            background: #eee;
            border-color: #111;
        }

        .drop-container:hover .drop-title {
            color: #222;
        }

        .drop-title {
            color: #444;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            transition: color .2s ease-in-out;
        }
    </style>
@endpush
@push('styles')
<link rel="stylesheet" href="{{asset('css/datatable/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('css/datatable/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('css/datatable/dataTables.dataTables.css')}}">
<link rel="stylesheet" href="{{asset('css/datatable/buttons.dataTables.css')}}">

{{-- sticky table --}}
<link id="stickyTableLight" rel="stylesheet" href="{{ asset('css/custom/stickyTable.css') }}">
<link id="stickyTableDark" rel="stylesheet" href="{{ asset('css/custom/stickyTableDark.css') }}" disabled>

{{-- custom css --}}
<link rel="stylesheet" href="{{ asset('css/custom/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/custom/datatableIndex.css') }}">
<style>
    thead{
        background-color: #a9d08e !important;
    }
    tfoot{
        background-color: #a9d08e !important;
    }
    th.sticky{
        background-color: #a9d08e !important;
    }
    table.sticky thead th{
        color: #000 !important;
    }
    table.sticky tfoot td{
        color: #000 !important;
    }
    td.dt-type-numeric{
        text-align: center !important;
    }

</style>
@endpush
<div class="col-xl-12">
    @if (isset($btn_label))
        <h3 class="text-primary">الموظف : {{ $employee->name }}</h3>
    @else
        <h3 class="text-primary">إضافة موظف جديد</h3>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="nav-align-top mb-6">
                <ul class="nav nav-pills mb-4 nav-fill" role="tablist">
                    <li class="nav-item mb-1 mb-sm-0">
                        <button type="button" id="tab1" class="nav-link active" data-bs-target="#menu1" aria-controls="menu1"  role="tab" data-bs-toggle="tab" aria-selected="true">
                            <span class="d-none d-sm-block">
                                البيانات الشخصية
                                <i class="ti ti-home ti-sm d-sm-none"></i>
                            </span>
                        </button>
                    </li>
                    <li class="nav-item mb-1 mb-sm-0">
                        <button type="button" id="tab2"  class="nav-link" data-bs-target="#menu2" aria-controls="menu2"  role="tab" data-bs-toggle="tab" aria-selected="true">
                            <span class="d-none d-sm-block">
                                بيانات العمل
                                <i class="ti ti-home ti-sm d-sm-none"></i>
                            </span>
                        </button>
                    </li>
                    <li class="nav-item mb-1 mb-sm-0">
                        <button type="button" id="tab3" class="nav-link" data-bs-target="#menu3" aria-controls="menu3"  role="tab" data-bs-toggle="tab" aria-selected="true">
                            <span class="d-none d-sm-block">
                                بيانات البنك
                                <i class="ti ti-home ti-sm d-sm-none"></i>
                            </span>
                        </button>
                    </li>
                    <li class="nav-item mb-1 mb-sm-0">
                        <button type="button" id="tab4" class="nav-link" data-bs-target="#menu4" aria-controls="menu4"  role="tab" data-bs-toggle="tab" aria-selected="true">
                            <span class="d-none d-sm-block">
                                الإجماليات
                                <i class="ti ti-home ti-sm d-sm-none"></i>
                            </span>
                        </button>
                    </li>
                    @if (isset($btn_label))
                    <li class="nav-item mb-1 mb-sm-0">
                        <button type="button" id="tab5" class="nav-link" data-bs-target="#menu5" aria-controls="menu5"  role="tab" data-bs-toggle="tab" aria-selected="true">
                            <span class="d-none d-sm-block">
                                ملفات شخصية
                                <i class="ti ti-home ti-sm d-sm-none"></i>
                            </span>
                        </button>
                    </li>
                    <li class="nav-item mb-1 mb-sm-0">
                        <button type="button" id="tab6" class="nav-link" data-bs-target="#menu6" aria-controls="menu6"  role="tab" data-bs-toggle="tab" aria-selected="true">
                            <span class="d-none d-sm-block">
                                الصرف
                                <i class="ti ti-home ti-sm d-sm-none"></i>
                            </span>
                        </button>
                    </li>
                    <li class="nav-item mb-1 mb-sm-0">
                        <button type="button" id="tab7" class="nav-link" data-bs-target="#menu7" aria-controls="menu7"  role="tab" data-bs-toggle="tab" aria-selected="true">
                            <span class="d-none d-sm-block">
                                عرض رواتب السنة
                                <i class="ti ti-home ti-sm d-sm-none"></i>
                            </span>
                        </button>
                    </li>
                    @endif
                    
                </ul>
                <div class="tab-content">
                    <div  class="tab-pane fade" role="tabpanel" id="menu1">
                        <div class="row">
                            <div class="col-md-3 my-2">
                                <x-form.input label="إسم الموظف" :value="$employee->name" name="name" placeholder="أحمد محمد ...."
                                    required />
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input label="رقم الهوية" minlength="9" maxlength="9" :value="$employee->employee_id" name="employee_id"
                                    placeholder="400000000" required />
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input type="date" label="تاريخ الميلاد" :value="$employee->date_of_birth" name="date_of_birth" required />
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input type="number" label="العمر" :value="$employee->age" name="age" readonly />
                            </div>
                            <div class="col-md-3 my-2">
                                <label for="gender">الجنس</label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="ذكر">ذكر</option>
                                    <option value="انثى">انثى</option>
                                </select>
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.select name="matrimonial_status" :options="$matrimonial_status_Array" :value="$employee->matrimonial_status"
                                    label="الحالة الزوجية" :required="true" />
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input type="number" label="عدد الزوجات" min="0"
                                    value="{{ $employee->number_wives ?? 0 }}" name="number_wives" placeholder="0" required />
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input type="number" label="عدد الأولاد" min="0"
                                    value="{{ $employee->number_children ?? 0 }}" name="number_children" placeholder="0" required />
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input type="number" label="عدد الأولاد في الجامعة" min="0"
                                    value="{{ $employee->number_university_children ?? 0 }}" name="number_university_children"
                                    placeholder="0" required />
                            </div>
                            <div class="form-group p-3 col-md-3">
                                <x-form.input name="scientific_qualification" placeholder="أدخل المؤهل العلمي" :value="$employee->scientific_qualification"
                                    label="المؤهل العلمي" list="scientific_qualification_list" required />
                                <datalist id="scientific_qualification_list">
                                    @foreach ($scientific_qualification_array as $scientific_qualification)
                                        <option value="{{ $scientific_qualification }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input type="text" label="التخصص" :value="$employee->specialization" name="specialization"
                                    placeholder="محاسبة...." />
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input type="text" label="الجامعة" :value="$employee->university" name="university"
                                    placeholder="الأزهر...." />
                            </div>
                            <div class="form-group p-3 col-md-3">
                                <x-form.input name="area" placeholder="أدخل المنطقة" :value="$employee->area" label="المنظقة"
                                    list="areas_list" required />
                                <datalist id="areas_list">
                                    @foreach ($areas as $area)
                                        <option value="{{ $area }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input type="text" label="العنوان بالتفصيل" :value="$employee->address" name="address"
                                    placeholder="دير البلح - شارع يافا - حي البشارة - مستشفى يافا" />
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input type="email" label="الإيميل" :value="$employee->email" name="email"
                                    placeholder="email@example.com" />
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input type="text" label="رقم الهاتف" :value="$employee->phone_number" name="phone_number"
                                    placeholder="(734) 767-4418" />
                            </div>
                            
                        </div>
                        <div class="row justify-content-end align-items-center mt-4">
                            <button type="button" class="btn btn-primary mx-2 next col-2" data-num="1">
                                التالي
                            </button>
                        </div>
                    </div>
                    <div  class="tab-pane fade" role="tabpanel" id="menu2">
                        <div class="row">
                            <div class="col-md-3 my-2">
                                <label for="type_appointment">أدخل نوع التعين (العقد)</label>
                                <select class="form-select" id="type_appointment" name="type_appointment" required>
                                    <option value="" disabled @selected($workData->type_appointment == null)>عرض القيم المتوفرة</option>
                                    <option value="مثبت" @selected($workData->type_appointment == 'مثبت')>مثبت</option>
                                    <option value="نسبة" @selected($workData->type_appointment == 'نسبة')>نسبة</option>
                                    <option value="خاص" @selected($workData->type_appointment == 'خاص')>خاص</option>
                                    <option value="رياض" @selected($workData->type_appointment == 'رياض')>رياض</option>
                                    <option value="فصلي" @selected($workData->type_appointment == 'فصلي')>فصلي</option>
                                    <option value="يومي" @selected($workData->type_appointment == 'يومي')>يومي</option>
                                    <option value="مؤقت" @selected($workData->type_appointment == 'مؤقت')>مؤقت</option>
                                </select>
                            </div>
                
                            {{-- حقول خاصة بالموظف الثابت --}}
                            <div class="row" id="proven"
                                @if ($workData->type_appointment == 'مثبت') style="display: flex; margin: 0; " @else style="display: none" @endif>
                                <div class="form-group p-3 col-3">
                                    <x-form.input type="number" class="required" label="درجة العلاوة من السلم" min="0"
                                        max="40" :value="$workData->allowance" name="allowance" placeholder="0" />
                                </div>
                                <div class="form-group p-3 col-3">
                                    <label for="grade">الدرجة في سلم الرواتب</label>
                                    <select class="form-select required" id="grade" name="grade">
                                        <option value="" disabled>عرض القيم المتوفرة</option>
                                        <option value="10" @selected($workData->grade == 10)>10</option>
                                        <option value="9" @selected($workData->grade == 9)>9</option>
                                        <option value="8" @selected($workData->grade == 8)>8</option>
                                        <option value="7" @selected($workData->grade == 7)>7</option>
                                        <option value="6" @selected($workData->grade == 6)>6</option>
                                        <option value="5" @selected($workData->grade == 5)>5</option>
                                        <option value="4" @selected($workData->grade == 4)>4</option>
                                        <option value="3" @selected($workData->grade == 3)>3</option>
                                        <option value="2" @selected($workData->grade == 2)>2</option>
                                        <option value="1" @selected($workData->grade == 1)>1</option>
                                        <option value="C" @selected($workData->grade == 'C')>C</option>
                                        <option value="B" @selected($workData->grade == 'B')>B</option>
                                        <option value="A" @selected($workData->grade == 'A')>A</option>
                                    </select>
                                </div>
                                <div class="form-group p-3 col-3">
                                    <x-form.input type="number" class="required" label="نسبة علاوة درجة" step="0.01"
                                        :value="$workData->grade_allowance_ratio" name="grade_allowance_ratio" placeholder="5%" />
                                </div>
                                <div class="form-group p-3 col-3">
                                    <x-form.input type="number" label="نسبة علاوة طبيعة العمل" :value="$workData->percentage_allowance"
                                        name="percentage_allowance" placeholder="10.." />
                                </div>
                                <div class="form-group p-3 col-3">
                                    <label for="salary_category">فئة الراتب</label>
                                    <select class="form-select required" id="salary_category" name="salary_category">
                                        <option value="" disabled>عرض القيم المتوفرة</option>
                                        <option value="1" @selected($workData->salary_category == 1)>الأولى</option>
                                        <option value="2" @selected($workData->salary_category == 2)>الثانية</option>
                                        <option value="3" @selected($workData->salary_category == 3)>الثالثة</option>
                                        <option value="4" @selected($workData->salary_category == 4)>الرابعة</option>
                                        <option value="5" @selected($workData->salary_category == 5)>الخامسة</option>
                                    </select>
                                </div>
                                <div class="form-group p-3 col-3">
                                    <label for="installation_new">هل هو مثبت جديد</label>
                                    <select class="form-select" id="installation_new" name="installation_new">
                                        <option value="" @selected($workData->installation_new == null)>عرض القيم المتوفرة</option>
                                        <option value="مثبت جديد" @selected($workData->installation_new == 'مثبت جديد')>مثبت جديد (العلاوة * 10)</option>
                                        <option value="مثبت جديد2" @selected($workData->installation_new == 'مثبت جديد2')>مثبت جديد (العلاوة * 20)</option>
                                    </select>
                                </div>
                            </div>
                
                            <div id="notProven" class="form-group p-3 col-3" style="{{ $workData->type_appointment != 'مثبت' && $workData->type_appointment != 'نسبة' && $workData->type_appointment != null ? 'display: block; margin: 0; ' : 'display: none' }}">
                                <x-form.input type="number" label="الراتب المحدد" min="0" :value="$employee->specificSalaries()->where('month', '0000-00')->first()->salary ?? 0"
                                    name="specific_salary" placeholder="0" />
                            </div>
                
                            <div class="row col-md-9" id="daily"
                                @if ($workData->type_appointment == 'يومي') style="display: flex; margin: 0; " @else style="display: none" @endif>
                                <div class="form-group p-3 col-4">
                                    <x-form.input type="number" label="عدد الأيام" class="daily_fields" min="0"
                                        data-name="number_of_days" :value="$employee->specificSalaries()->where('month', '0000-00')->first()->number_of_days ??
                                            0" name="number_of_days" placeholder="0" />
                                </div>
                                <div class="form-group p-3 col-4">
                                    <x-form.input type="number" label="سعر اليوم" class="daily_fields" min="0"
                                        data-name="today_price" :value="$employee->specificSalaries()->where('month', '0000-00')->first()->today_price ?? 0" name="today_price" placeholder="0" />
                                </div>
                                <div class="form-group p-3 col-4">
                                    <x-form.input type="number" label="الراتب المحدد" class="daily_fields" :value="$employee->specificSalaries()->where('month', '0000-00')->first()->salary ?? 0"
                                        name="specificSalary" placeholder="0" readonly />
                                </div>
                            </div>
                
                
                            <div class="form-group p-3 col-3">
                                <x-form.input type="date" label="تاريخ العمل" :value="$workData->working_date" name="working_date" required />
                            </div>
                            <div class="form-group p-3 col-3">
                                <x-form.input type="date" label="تاريخ التثبيت" :value="$workData->date_installation" name="date_installation" />
                            </div>
                            <div class="form-group p-3 col-3">
                                <x-form.input type="number" label="سنوات الخدمة" :value="$workData->years_service" name="years_service"
                                    placeholder="0" readonly />
                            </div>
                
                            <div class="form-group p-3 col-3">
                                <x-form.input type="date" label="تاريخ التقاعد" :value="$workData->date_retirement" name="date_retirement"
                                    readonly />
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input name="working_status" placeholder="أدخل حالة الدوام" :value="$workData->working_status"
                                    label="حالة الدوام" list="working_status_list" required />
                                <datalist id="working_status_list">
                                    @foreach ($working_status as $working_status)
                                        <option value="{{ $working_status }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="form-group p-3 col-3">
                                <x-form.input label="عدد الأيام العمل" :value="$employee->number_working_days" name="number_working_days" />
                                <datalist id="number_working_days">
                                    <option value="جزئي">
                                    <option value="يومي">
                                </datalist>
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input name="contract_type" placeholder="أدخل نوع العقد" :value="$workData->contract_type" label="نوع العقد"
                                    list="contract_type_list" />
                                <datalist id="contract_type_list">
                                    @foreach ($contract_type as $contract_type)
                                        <option value="{{ $contract_type }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="form-group p-3 col-3">
                                <label for="dual_function">مزدوج الوظيفة</label>
                                <select class="form-select" id="dual_function" name="dual_function" required>
                                    <option value="غير موظف" @selected($workData->dual_function == 'غير موظف' || $workData->dual_function == null)>غير موظف</option>
                                    <option value="موظف" @selected($workData->dual_function == 'موظف')>موظف</option>
                                </select>
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input name="field_action" placeholder="أدخل مجال العمل" :value="$workData->field_action" label="مجال العمل"
                                    list="field_action_list" required />
                                <datalist id="field_action_list">
                                    @foreach ($field_action as $field_action)
                                        <option value="{{ $field_action }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input name="state_effectiveness" placeholder="أدخل حالة الفعالية" :value="$workData->state_effectiveness"
                                    label="حالة الفعالية" list="state_effectiveness_list" required />
                                <datalist id="state_effectiveness_list">
                                    @foreach ($state_effectiveness as $state_effectiveness)
                                        <option value="{{ $state_effectiveness }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input name="nature_work" placeholder="أدخل طبيعة العمل" :value="$workData->nature_work"
                                    label="طبيعة العمل" list="nature_work_list" required />
                                <datalist id="nature_work_list">
                                    @foreach ($nature_work as $nature_work)
                                        <option value="{{ $nature_work }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input name="association" placeholder="أدخل الجمعية" :value="$workData->association" label="الجمعية"
                                    list="association_list" required />
                                <datalist id="association_list">
                                    @foreach ($association as $association)
                                        <option value="{{ $association }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input name="workplace" placeholder="أدخل مكان العمل" :value="$workData->workplace" label="مكان العمل"
                                    list="workplace_list" required />
                                <datalist id="workplace_list">
                                    @foreach ($workplace as $workplace)
                                        <option value="{{ $workplace }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input name="section" placeholder="أدخل القسم" :value="$workData->section" label="القسم"
                                    list="section_list" required />
                                <datalist id="section_list">
                                    @foreach ($section as $section)
                                        <option value="{{ $section }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input name="dependence" placeholder="أدخل التبعية" :value="$workData->dependence" label="التبعية"
                                    list="dependence_list" required />
                                <datalist id="dependence_list">
                                    @foreach ($dependence as $dependence)
                                        <option value="{{ $dependence }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input name="establishment" placeholder="أدخل المنشأة" :value="$workData->establishment" label="المنشأة"
                                    list="establishment_list" required />
                                <datalist id="establishment_list">
                                    @foreach ($establishment as $establishment)
                                        <option value="{{ $establishment }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input name="foundation_E" placeholder="أدخل المؤسسة بالإنجليزي" :value="$workData->foundation_E"
                                    label="المؤسسة بالإنجليزي" list="foundation_E_list" required />
                                <datalist id="foundation_E_list">
                                    @foreach ($foundation_E as $foundation_E)
                                        <option value="{{ $foundation_E }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-md-3 my-2">
                                <x-form.input name="payroll_statement" placeholder="أدخل بيان الراتب" :value="$workData->payroll_statement"
                                    label="بيان الراتب" list="payroll_statement_list" required />
                                <datalist id="payroll_statement_list">
                                    @foreach ($payroll_statement as $payroll_statement)
                                        <option value="{{ $payroll_statement }}">
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                        <div class="row justify-content-end align-items-center mt-4">
                            <button type="button" class="btn btn-primary mx-2 prev col-2" data-num="2">
                                السابق
                            </button>
                            <button type="button" class="btn btn-primary mx-2 next col-2" data-num="2">
                                التالي
                            </button>
                            {{-- <button type="submit" class="btn btn-primary mx-2 col-2">
                                تعديل
                            </button> --}}
                        </div>
                    </div>
                    <div  class="tab-pane fade" role="tabpanel" id="menu3">
                        <input type="hidden" name="num_accounts" id="num_accounts" value="{{ $accounts_count }}">
                        <div class="row accounts">
                            @foreach ($accounts as $account)
                            <div class="row" id="accout-{{ $loop->iteration }}">
                                <div class="col-2 my-2 d-flex align-items-center">
                                    <span class="display-6" style="font-size: 18px;" id="account-{{ $loop->iteration }}">بيانات الحساب  : {{ $loop->iteration }}</span>
                                </div>
                                <div class="col-md-4 my-2">
                                    <label for="bank_id-{{ $loop->iteration }}" class="form-label" >البنك - الفرع</label>
                                    <select class="form-select" id="bank_id-{{ $loop->iteration }}" name="bank_id-{{ $loop->iteration }}" required>
                                        <option value="" @selected($account->bank_id == null)>عرض القيم المتوفرة</option>
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank->id }}" {{ $bank->id == $account->bank_id ? 'selected' : '' }}>
                                                {{ $bank->name }} - {{ $bank->branch }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 my-2">
                                    <x-form.input name="account_number-{{ $loop->iteration }}" placeholder="4000000" :value="$account->account_number" label="رقم الحساب" required />
                                </div>
                                <div class="col-md-1 my-2 d-flex align-items-center">
                                    <div class="switches-stacked">
                                        <label class="switch">
                                            <input type="radio" class="switch-input" name="default" value="{{ $loop->iteration }}" @checked($account->default == 1)>
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on"></span>
                                                <span class="switch-off"></span>
                                            </span>
                                            <span class="switch-label">أساسي</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-1 my-2 d-flex align-items-center justify-content-end">
                                    <button type="button" id="delete_bank-{{ $loop->iteration }}" data-num="{{ $loop->iteration }}" class="btn btn-icon btn-sm delete_bank" style="font-size: 18px;" title="حذف الحساب">
                                        <i class="fa-solid fa-trash-can text-danger"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="row" id="accounts">
                            
                        </div>
                        <div class="row" id="accout-0">
                            <div class="col-2 my-2 d-flex align-items-center">
                                <span class="display-6" style="font-size: 18px;" id="account-0">بيانات الحساب الجديد</span>
                            </div>
                            <div class="col-md-4 my-2">
                                <label for="bank_id-0" class="form-label" >البنك - الفرع</label>
                                <select class="form-select" id="bank_id-0" name="bank_id-0" disabled>
                                    <option value="" selected>عرض القيم المتوفرة</option>
                                </select>
                            </div>
                            <div class="col-md-4 my-2">
                                <x-form.input maxlength="9" label="رقم الحساب" name="account_number-1" placeholder="4000000" disabled />
                            </div>
                            <div class="col-md-1 my-2 d-flex align-items-center">
                                <div class="switches-stacked">
                                    <label class="switch">
                                        <input type="radio" class="switch-input" name="default" value="0" disabled>
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on"></span>
                                            <span class="switch-off"></span>
                                        </span>
                                        <span class="switch-label">أساسي</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-1 my-2 d-flex align-items-center justify-content-end">
                                <button type="button" id="add_bank" class="btn btn-icon btn-sm text-success">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row justify-content-end align-items-center mt-4">
                            <button type="button" class="btn btn-primary mx-2 prev col-2" data-num="3">
                                السابق
                            </button>
                            <button type="button" class="btn btn-primary mx-2 next col-2" data-num="3">
                                التالي
                            </button>
                            {{-- <button type="submit" class="btn btn-primary mx-2 col-2">
                                تعديل
                            </button> --}}
                        </div>
                    </div>
                    <div  class="tab-pane fade  show active" role="tabpanel" id="menu4">
                        <div class="row">
                            <div class="col-md-4 my-2">
                                <x-form.input type="number" step="0.01" label="إجمالي المستحقات"
                                    value="{{ $totals->total_receivables ?? 0 }}" name="total_receivables"
                                    placeholder="المستحقات الخاصة به" />
                            </div>
                            <div class="col-md-4 my-2">
                                <x-form.input type="number" step="0.01" label="إجمالي الإدخارات"
                                    value="{{ $totals->total_savings ?? 0 }}" name="total_savings"
                                    placeholder="الإدخارات الخاصة به" />
                            </div>
                            <div class="col-md-4 my-2">
                                <x-form.input type="number" step="0.01" min="0" label="قرض الجمعية"
                                    value="{{ $totals->total_association_loan ?? 0 }}" name="total_association_loan"
                                    placeholder="" />
                            </div>
                            <div class="col-md-4 my-2">
                                <x-form.input type="number" step="0.01" min="0" label="قرض الإدخار $"
                                    value="{{ $totals->total_savings_loan ?? 0 }}" name="total_savings_loan" placeholder="" />
                            </div>
                            <div class="col-md-4 my-2">
                                <x-form.input type="number" step="0.01" min="0" label="قرض اللجنة"
                                    value="{{ $totals->total_shekel_loan ?? 0 }}" name="total_shekel_loan" placeholder="" />
                            </div>
                        </div>
                        <div class="row justify-content-end align-items-center mt-4">
                            <button type="button" class="btn btn-primary mx-2 prev col-2" data-num="4">
                                السابق
                            </button>
                            <button type="submit" class="btn btn-primary mx-2 col-2">
                                {{ $btn_label ?? 'أضف' }}
                            </button>
                        </div>
                        <div class="row mt-4">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-white text-center">#</th>
                                            <th>السنة</th>
                                            <th>الرصيد</th>
                                            <th>يناير</th>
                                            <th>فبراير</th>
                                            <th>مارس</th>
                                            <th>أبريل</th>
                                            <th>مايو</th>
                                            <th>يونيو</th>
                                            <th>يوليه</th>
                                            <th>أغسطس</th>
                                            <th>سبتمبر</th>
                                            <th>أكتوبر</th>
                                            <th>نوفمبر</th>
                                            <th>ديسمبر</th>
                                            <th>الإجمالي</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $years = range(2024,Carbon\Carbon::now()->year);
                                            $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
                                            $field = 'savings_loan';
                                            $total = $employee->totals->total_savings_loan ?? 0;
                                            
                                        @endphp
                                        <tr>
                                            <td colspan="15">قرض الإدخار</td>
                                        </tr>
                                        @foreach ($years as $year)
                                        <tr>
                                            @php
                                                $loans = $employee->loans->whereBetween('month', [$year . '-01', $year . '-12']);
                                                $val = $loans->sum('savings_loan');
                                                $val = $total + $val;
                                            @endphp
                                            <td class="text-center">
                                                {{ $employee->id }}
                                            </td>
                                            <td class="text-center">
                                                {{ $year }}
                                            </td>
                                            <td>
                                                {{ $val ?? 0 }}
                                            </td>
                                            @foreach ($months as $month)
                                                    <td>{{$employee->loans->where('month',$year . '-' . $month)->first() ? $employee->loans->where('month',$year . '-' . $month)->first()[$field] : 0}}</td>
                                            @endforeach
                                            <td>
                                                {{ $employee->totals->total_savings_loan ?? 0 }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if (isset($btn_label))
                    <div  class="tab-pane fade" role="tabpanel" id="menu5">
                        <div class="row p-4">
                            <style>
                                td{
                                    color: #000 !important;
                                }
                                th,td{
                                    border-color: #ddd !important;
                                }
                            </style>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th colspan="2">اسم الملف</th>
                                        <th>تاريخ الرفع</th>
                                        <th>الحجم</th>
                                        <th>حدث</th>
                                    </tr>
                                </thead>
                                <tbody id="filesTbody">
                                    @foreach ($files as $index => $file)
                                        <tr id="file-{{$index}}">
                                            <td>{{$loop->iteration}}</td>
                                            <td class="text-center" style="width: 80px;">
                                                <div class="circle circle-sm bg-light">
                                                    <span class="fa-solid {{$file->icon}} fe-16 text-muted"></span>
                                                </div>
                                                <span class="dot dot-md bg-success mr-1"></span>
                                            </td>
                                            <td>{{$file->name}}</td>
                                            <td>{{$file->created_at}}</td>
                                            <td>{{ \App\Helper\FormatSize::formatSize($file->size) }}</td>
                                            <td style="width: 250px;">
                                                <div class="btn-group w-100">
                                                    <a href="{{asset($file->file_path)}}" target="_blank" class="btn btn-sm btn-primary">
                                                        <i class="fa-solid fa-eye"></i> عرض
                                                    </a>
                                                    <a href="{{asset($file->file_path)}}" target="_blank" download class="btn btn-sm btn-secondary">
                                                        <i class="fa-solid fa-download"></i> تحميل
                                                    </a>
                                                    <button data-index="{{$index}}" data-id="{{$employee->id}}" type="button" class="btn btn-sm btn-danger deleteFile">
                                                        <i class="fa-solid fa-trash"></i> حذف
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header">
                                        <strong>رفع ملفات شخصية</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group col-12">
                                            <x-form.input type="text" label="اسم الملف" name="fileName" />
                                        </div>
                                        <div class="form-group col-12">
                                            <x-form.input type="file" label="اختر الملف" name="fileUpload" />
                                        </div>
                                        <button type="button" id="sendFiles" class="btn btn-primary">ارسال</button>
                                    </div> <!-- .card-body -->
                                </div> <!-- .card -->
                            </div> <!-- .col -->
                        </div>
                        <div class="row justify-content-end align-items-center mt-4">
                            <button type="button" class="btn btn-primary mx-2 prev col-2" data-num="5">
                                السابق
                            </button>
                            <button type="button" class="btn btn-primary mx-2 next col-2" data-num="5">
                                التالي
                            </button>
                        </div>
                        @push('scripts')
                        <script>
                            $(document).ready(function() {
                                $("#sendFiles").click(function() {
                                    // إنشاء كائن FormData
                                    let formData = new FormData();
                                    formData.append('_token', "{{ csrf_token() }}");
                                    formData.append('fileName', $('input[name=fileName]').val());
                                    formData.append('fileUpload', $('input[name=fileUpload]')[0].files[0]);
                                    formData.append('employee_id', "{{ $employee->id }}");

                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('dashboard.employees.uplodeFiles') }}",
                                        data: formData,
                                        processData: false, // تعطيل المعالجة التلقائية للبيانات
                                        contentType: false, // تعطيل تحديد Content-Type تلقائيًا
                                        success: function(data) {
                                            console.log(data);
                                            $('#filesTbody').append(`
                                            <tr id="file-${data.index}">
                                                <td>${data.index + 1}</td>
                                                <td class="text-center" style="width: 80px;">
                                                    <div class="circle circle-sm bg-light">
                                                        <span class="fa-solid ${data.icon} fe-16 text-muted"></span>
                                                    </div>
                                                    <span class="dot dot-md bg-success mr-1"></span>
                                                </td>
                                                <td>${data.name}</td>
                                                <td>${data.created_at}</td>
                                                <td>${data.size}</td>
                                                <td style="width: 250px;">
                                                    <div class="btn-group w-100">
                                                        <a href="${data.file_path}" target="_blank" class="btn btn-sm btn-primary">
                                                            <i class="fa-solid fa-eye"></i> عرض
                                                        </a>
                                                        <a href="${data.file_path}" target="_blank" download class="btn btn-sm btn-secondary">
                                                            <i class="fa-solid fa-download"></i> تحميل
                                                        </a>
                                                        <button data-index="${data.index}" data-id="${data.employee_id}" type="button" class="btn btn-sm btn-danger deleteFile">
                                                            <i class="fa-solid fa-trash-2"></i> حذف
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            `);
                                            $('input[name=fileName]').val('');
                                            $('input[name=fileUpload]').val('');
                                            $('#alert-success').slideDown();
                                            $('#alert-success').text('تم رفع الملف بنجاح');
                                            setTimeout(() => {
                                                $('#alert-success').slideUp();
                                                $('#alert-success').text('');
                                            }, 3000);
                                        }
                                    })
                                });
                                $(document).on('click', '.deleteFile', function() {
                                    // إنشاء كائن FormData
                                    let index = $(this).data("index");
                                    let employee_id = $(this).data("id");
                                    $.ajax({
                                        type: "DELETE",
                                        url: "{{ route('dashboard.employees.files_destroy') }}",
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            "index": index,
                                            "employee_id": employee_id
                                        },
                                        success: function(data) {
                                            console.log(data);
                                            $('#filesTbody').empty();
                                            data.forEach(function(file, index) {
                                                $('#filesTbody').append(`
                                                    <tr id="file-${index}">
                                                        <td>${index + 1}</td>
                                                        <td class="text-center" style="width: 80px;">
                                                            <div class="circle circle-sm bg-light">
                                                                <span class="fa-solid ${file.icon} fe-16 text-muted"></span>
                                                            </div>
                                                            <span class="dot dot-md bg-success mr-1"></span>
                                                        </td>
                                                        <td>${file.name}</td>
                                                        <td>${file.created_at}</td>
                                                        <td>${file.size}</td>
                                                        <td style="width: 250px;">
                                                            <div class="btn-group w-100">
                                                                <a href="${file.file_path}" target="_blank" class="btn btn-sm btn-primary">
                                                                    <i class="fa-solid fa-eye"></i> عرض
                                                                </a>
                                                                <a href="${file.file_path}" target="_blank" download class="btn btn-sm btn-secondary">
                                                                    <i class="fa-solid fa-download"></i> تحميل
                                                                </a>
                                                                <button data-index="${index}" data-id="${file.employee_id}" type="button" class="btn btn-sm btn-danger deleteFile">
                                                                    <i class="fa-solid fa-trash"></i> حذف
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                `);
                                            })
                                            $('#alert-success').slideDown();
                                            $('#alert-success').text('تم حذف الملف بنجاح');
                                            setTimeout(() => {
                                                $('#alert-success').slideUp();
                                                $('#alert-success').text('');
                                            }, 3000);
                                        }
                                    })
                                });
                            });
                        </script>
                        @endpush
                    </div>
                    <div  class="tab-pane fade" role="tabpanel" id="menu6">
                        <div class="row justify-content-end">
                            <div class="form-group p-3">
                                @can('create', 'App\\Models\Exchange')
                                    <a href="{{ route('dashboard.exchanges.create') }}" target="_blank" class="btn btn-info">
                                        <i class="fa-solid fa-plus"></i> إضافة صرف جديد
                                    </a>
                                @endcan
                            </div>
                        </div>
                        <div class="row">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>تاريخ الصرف</th>
                                        <th>الموظف</th>
                                        <th>المبلغ المصروف</th>
                                        <th>المبلغ المضاف</th>
                                        <th>السبب</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <style>
                                    tbody tr.exchange_select td {
                                        padding: 7px 5px !important;
                                    }
                                </style>
                                <tbody>
                                    @foreach($exchanges as $exchange)
                                    <tr class="exchange_select" data-id="{{$exchange->id}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$exchange->exchange_date}}</td>
                                        <td style="white-space: nowrap; text-align: right !important;">{{$exchange->employee->name}}</td>
                                        <td>{{$exchange->receivables_discount}}</td>
                                        <td>{{$exchange->receivables_addition}}</td>
                                        <td style="text-align: right !important;">{{$exchange->notes}}</td>
                                        <td class="d-flex">
                                            <ul class="list-inline email-list-item-actions">
                                                @can('print', 'App\\Models\Exchange')
                                                <li class="list-inline-item email-read btn btn-icon btn-text-secondary rounded-pill waves-effect waves-light">
                                                    <a href="{{route('dashboard.exchanges.goToprint',$exchange->id)}}" target="_blank" type="submit" class="btn btn-icon" style="margin: 0.5rem -0.75rem; text-align: right;">
                                                        <i class="fa-solid fa-print"></i>
                                                    </a>
                                                </li>
                                                @endcan
                                                @can('delete', 'App\\Models\Exchange')
                                                <li class="list-inline-item email-read btn btn-icon btn-text-secondary rounded-pill waves-effect waves-light">
                                                    <a href="{{route('dashboard.exchanges.goToDestroy',$exchange->id)}}" type="submit" class="btn btn-icon" style="margin: 0.5rem -0.75rem; text-align: right;">
                                                        <i class="ti ti-trash me-1"></i>
                                                    </a>
                                                </li>
                                                @endcan
                                            </ul>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row justify-content-end align-items-center mt-4">
                            <button type="button" class="btn btn-primary mx-2 prev col-2" data-num="6">
                                السابق
                            </button>
                            <button type="button" class="btn btn-primary mx-2 next col-2" data-num="6">
                                التالي
                            </button>
                        </div>
                    </div>
                    <div  class="tab-pane fade" role="tabpanel" id="menu7">
                        <div class="row justify-content-end">
                            <div class="form-group my-0 mx-2 col-1">
                                <select name="year" id="year" class="form-control">
                                    @for ($yearNow = date('Y'); $yearNow >= 2024; $yearNow--)
                                        <option value="{{ $yearNow }}">{{ $yearNow }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <table id="salaries-table" class="table table-striped table-bordered table-hover sticky" style="width:100%; height: calc(100vh - 510px);">
                                <thead>
                                    <tr>
                                        <th class="text-white text-center">#</th>
                                        <th>الشهر</th>
                                        <th>العلاوة</th>
                                        <th>الدرجة</th>
                                        <th>الراتب الأولي</th>
                                        <th>علاوة درجة</th>
                                        <th>الراتب الأساسي</th>
                                        <th>ع الأولاد</th>
                                        <th>طبيعة عمل</th>
                                        <th>علاوة إدارية</th>
                                        <th>مواصلات</th>
                                        <th>بدل إضافي</th>
                                        <th>علاوة أغراض راتب</th>
                                        <th>إضافة بأثر رجعي</th>
                                        <th>علاوة جوال</th>
                                        <th>نهاية خدمة</th>
                                        <th>إجمالي الراتب</th>
                                        <th>تأمين صحي</th>
                                        <th>ض.دخل</th>
                                        <th>إدخار 5%</th>
                                        <th>قرض جمعية</th>
                                        <th>قرض إدخار</th>
                                        <th>قرض لجنة</th>
                                        <th>مستحقات متأخرة</th>
                                        <th>إجمالي الخصومات</th>
                                        <th>صافي الراتب</th>
                                        <th>رقم حساب البنك</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="text-white text-center" id="row_count">#</td>
                                        <td style="white-space: nowrap; background-color: #a9d08e !important;" class="text-left sticky">الإجمالي</td>
                                        <td></td>
                                        <td></td>
                                        <td id="total_6"></td>
                                        <td id="total_7"></td>
                                        <td id="total_8"></td>
                                        <td id="total_9"></td>
                                        <td id="total_10"></td>
                                        <td id="total_11"></td>
                                        <td id="total_12"></td>
                                        <td id="total_13"></td>
                                        <td id="total_14"></td>
                                        <td id="total_15"></td>
                                        <td id="total_16"></td>
                                        <td id="total_17"></td>
                                        <td id="total_18"></td>
                                        <td id="total_19"></td>
                                        <td id="total_20"></td>
                                        <td id="total_21"></td>
                                        <td id="total_22"></td>
                                        <td id="total_23"></td>
                                        <td id="total_24"></td>
                                        <td id="total_25"></td>
                                        <td id="total_26"></td>
                                        <td id="total_27"></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row justify-content-end align-items-center mt-4">
                            <button type="button" class="btn btn-primary mx-2 prev col-2" data-num="7">
                                السابق
                            </button>
                            {{-- <button type="submit" class="btn btn-primary mx-2 col-2">
                                تعديل
                            </button> --}}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    {{-- Files Js --}}
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>


    <script>
        const csrf_token = "{{ csrf_token() }}";
        const app_link = "{{ config('app.url') }}";
        const association = "{{ $employee->workData->association }}";
        const state_effectiveness = "{{ $workData->state_effectiveness }}";

        // accounts
        const num_accounts = {{ $accounts_count }};
        const banks = {!! json_encode($banks) !!};
    </script> 
    <!-- Your custom script -->
    <script src="{{ asset('js/plugins/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/custom/formEmployee.js?v=0.3') }}"></script>
    <script src="{{ asset('js/custom/exchange.js') }}"></script>
@endpush
@push('scripts')
    <!-- DataTables JS -->
    <script src="{{asset('js/plugins/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/plugins/datatable/dataTables.js')}}"></script>
    <script>
        const csrf_token = "{{csrf_token()}}";
        const app_link = "{{config('app.url')}}/";
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            let formatNumber = (number,min = 0,row = null) => {
                // التحقق إذا كانت القيمة فارغة أو غير صالحة كرقم
                if (number === null || number === undefined || isNaN(number)) {
                    return ''; // إرجاع قيمة فارغة إذا كان الرقم غير صالح
                }
                return new Intl.NumberFormat('en-US', { minimumFractionDigits: min, maximumFractionDigits: 2 }).format(number);
            };
            let table = $('#salaries-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                paging: false,              // تعطيل الترقيم
                searching: true,            // الإبقاء على البحث إذا كنت تريده
                info: false,                // تعطيل النص السفلي الذي يوضح عدد السجلات
                lengthChange: false,        // تعطيل قائمة تغيير عدد المدخلات
                "language": {
                    "url": "{{ asset('files/Arabic.json')}}"
                },
                ajax: {
                    url: '{{ route("dashboard.employees.getSalary") }}',
                    type: 'GET',
                    data: function(d) {
                        d.year = $('#year').val();
                        d.employee_id = {{ $employee->id }};
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false}, // عمود الترقيم التلقائي
                    { data: 'month', name: 'month'  , orderable: false, class: 'sticky'},
                    { data: 'allowance', name: 'allowance', orderable: false, class: 'text-center'},
                    { data: 'grade', name: 'grade', orderable: false, class: 'text-center'},
                    { data: 'initial_salary', name: 'initial_salary', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2);
                    }},
                    { data: 'grade_Allowance', name: 'grade_Allowance', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 0);
                    }},
                    { data: 'secondary_salary', name: 'secondary_salary', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2);
                    }},
                    { data: 'allowance_boys', name: 'allowance_boys', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2);
                    }},
                    { data: 'nature_work_increase', name: 'nature_work_increase', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2);
                    }},
                    { data: 'administrative_allowance', name: 'administrative_allowance', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2, row);
                    }},
                    { data: 'transport', name: 'transport', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2, row);
                    }},
                    { data: 'extra_allowance', name: 'extra_allowance', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2, row);
                    }},
                    { data: 'salary_allowance', name: 'salary_allowance', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2, row);
                    }},
                    { data: 'ex_addition', name: 'ex_addition', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2, row);
                    }},
                    { data: 'mobile_allowance', name: 'mobile_allowance', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2, row);
                    }},
                    { data: 'termination_service', name: 'termination_service', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2);
                    }},
                    { data: 'gross_salary', name: 'gross_salary', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2);
                    }},
                    { data: 'health_insurance', name: 'health_insurance', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2, row);
                    }},
                    { data: 'z_Income', name: 'z_Income', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2, row);
                    }},
                    { data: 'savings_rate', name: 'savings_rate', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2, row);
                    }},
                    { data: 'association_loan', name: 'association_loan', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2, row);
                    }},
                    { data: 'savings_loan', name: 'savings_loan', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2, row);
                    }},
                    { data: 'shekel_loan', name: 'shekel_loan', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2, row);
                    }},
                    { data: 'late_receivables', name: 'late_receivables', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2);
                    }},
                    { data: 'total_discounts', name: 'total_discounts', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2);
                    }},
                    { data: 'net_salary', name: 'net_salary', orderable: false, class: 'text-center',  render: function(data, type, row) {
                        return formatNumber(data, 2);
                    }},
                    { data: 'account_number', name: 'account_number', orderable: false},
                    { data: 'print', name: 'print', orderable: false, searchable: false, render: function (data, type, row) {
                        @can('print','App\\Models\Salary')
                        return `
                            <a href="{{route('dashboard.salaries.goToPrint',':salaries')}}" target="_blank" class="btn btn-icon p-1 text-inf">
                            <i class="fa-solid fa-print"></i>
                            </a>
                            `.replace(':salaries', data);
                        @else
                        return '';
                        @endcan
                    }},
                ],
                columnDefs: [
                    { targets: 0, searchable: false, orderable: false } // تعطيل الفرز والبحث على عمود الترقيم
                ],
                drawCallback: function(settings) {
                    // تطبيق التنسيق على خلايا العمود المحدد
                    $('#salaries-table tbody tr').each(function() {
                        $(this).find('td').eq(1).css('right', '0px');
                    });
                },
            });
            
            // تطبيق فلترة السنة عند تغير حقل السنة
            $('#year').on('change', function() {
                const year = $(this).val();
                table.ajax.reload();
            });
            // إعادة تحميل الجدول عند النقر على زر "Refresh"
            $(document).on('click', '#refreshData', function() {
                table.ajax.reload();
            });
        });
    </script>
@endpush