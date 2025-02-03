<x-front-layout  classC="shadow p-0 bg-white rounded">
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
    <x-slot:extra_nav>
        <div class="form-group my-0 mx-2">
            <x-form.input name="month" min="2024-07" id="month" type="month" value="{{$monthDownload}}" />
        </div>
        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#ExtraModal">
            <i class="fa-solid fa-up-right-and-down-left-from-center "></i>
        </button>
        <div class="nav-item mx-2">
            <div class="dropdown">
                <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1 waves-effect waves-light" type="button" id="earningReportsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fa-solid fa-filter fe-16"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsId" data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(4px, 38px);">
                    <a class="dropdown-item waves-effect" id="filterBtn" href="javascript:void(0);">تصفية</a>
                    <a class="dropdown-item waves-effect" id="filterBtnClear" href="javascript:void(0);">إزالة التصفية</a>
                </div>
            </div>
        </div>
        <div class="nav-item d-flex align-items-center justify-content-center mx-2">
            <button type="button" class="btn" id="refreshData">
                <i class="fa-solid fa-arrows-rotate"></i>
            </button>
        </div>
    </x-slot:extra_nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-container p-0">
                    <table id="salaries-table" class="table table-striped table-bordered table-hover sticky" style="width:100%; height: calc(100vh - 130px);">
                        <thead>
                            <tr>
                                <th class="text-white text-center">#</th>
                                <th class="sticky" style="right: 0px; white-space: nowrap;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>الاسم</span>
                                        <div class="filter-dropdown ml-4">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-filter" id="btn-filter-1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa-brands fa-get-pocket text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="employee_name_filter">
                                                    <!-- إضافة checkboxes بدلاً من select -->
                                                    <div class="searchable-checkbox">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <input type="search" class="form-control search-checkbox" data-index="1" placeholder="ابحث...">
                                                            <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="1" data-field="employee_name">
                                                                <i class="fa-solid fa-check"></i>
                                                            </button>
                                                        </div>
                                                        <div class="checkbox-list-box">
                                                            <label style="display: block;">
                                                                <input type="checkbox" value="all" class="all-checkbox" data-index="1"> الكل
                                                            </label>
                                                            <div class="checkbox-list checkbox-list-1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>الجمعية</span>
                                        <div class="filter-dropdown ml-4">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-filter" id="btn-filter-2" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fa-brands fa-get-pocket text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="association_filter">
                                                    <!-- إضافة checkboxes بدلاً من select -->
                                                    <div class="searchable-checkbox">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <input type="search" class="form-control search-checkbox" data-index="2" placeholder="ابحث...">
                                                            <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="2" data-field="association_field">
                                                                <i class="fa-solid fa-check"></i>
                                                            </button>
                                                        </div>
                                                        <div class="checkbox-list-box">
                                                            <label style="display: block;">
                                                                <input type="checkbox" value="all" class="all-checkbox" data-index="2"> الكل
                                                            </label>
                                                            <div class="checkbox-list checkbox-list-2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>مكان العمل</span>
                                        <div class="filter-dropdown ml-4">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-filter" id="btn-filter-3" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fe fa-brands fa-get-pocket text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="workplace_filter">
                                                    <!-- إضافة checkboxes بدلاً من select -->
                                                    <div class="searchable-checkbox">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <input type="search" class="form-control search-checkbox" data-index="3" placeholder="ابحث...">
                                                            <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="3" data-field="workplace_field">
                                                                <i class="fa-solid fa-check"></i>
                                                            </button>
                                                        </div>
                                                        <div class="checkbox-list-box">
                                                            <label style="display: block;">
                                                                <input type="checkbox" value="all" class="all-checkbox" data-index="3"> الكل
                                                            </label>
                                                            <div class="checkbox-list checkbox-list-3">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
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
                                <td colspan="2"></td>
                                <td colspan="2"></td>
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
            </div>
        </div>
    </div>

    <div class="modal fade" id="ExtraModal" tabindex="-1" role="dialog" aria-labelledby="ExtraModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row flex-column align-items-center">
                        @can('view','App\\Models\Accreditation')
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AccreditationModal">
                                اعتماد الأشهر
                            </button>
                        @endcan
                        @can('create-all', 'App\\Models\Salary')
                            @if ($btn_download_salary == "active")
                                <form action="{{route('dashboard.salaries.createAllSalaries')}}" method="post" class="mt-2">
                                    @csrf
                                    <input type="hidden" name="month" value="{{$monthDownload}}" >
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fe fe-activity"></i>
                                        <span>تحميل جميع الرواتب لشهر {{$monthDownload}}</span>
                                    </button>
                                </form>
                            @endif
                        @endcan
                        @can('delete-all', 'App\\Models\Salary')
                            @if ($btn_delete_salary == "active")
                            <form action="{{route('dashboard.salaries.deleteAllSalaries')}}" method="post" class="mt-2">
                                @csrf
                                <input type="hidden" name="month" value="{{$monthDownload}}" >
                                <button type="submit" class="btn btn-danger">
                                    <i class="fe fe-activity"></i>
                                    <span>حذف جميع الرواتب  لشهر {{$monthDownload}}</span>
                                </button>
                            </form>
                            @endif
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('error'))
    <div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="logModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logModalLongTitle">أخطاء حدتث في معالجة الراتب</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(is_array(session('error')))
                <ul class="list-group">
                    @foreach(session('error') as $error)
                        <li class="list-group-item">{{ $error['description'] }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </div>
    </div>
    @endif
    @can('view','App\\Models\Accreditation')
    <div class="modal fade" id="AccreditationModal" tabindex="-1" role="dialog" aria-labelledby="AccreditationModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AccreditationModalLongTitle">اعتماد الأشهر</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">الشهر</th>
                            <th scope="col">معتمد</th>
                            <th scope="col">المستخدم المعتمد</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accreditations as $accreditation)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $accreditation->month }}</td>
                            <td>{{ ($accreditation->status == 1 ? 'معتمد' : 'غير معتمد') }}</td>
                            <td>{{ $accreditation->user->name }}</td>
                            <td>
                                <form action="{{ route('dashboard.accreditations.destroy', $accreditation->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">حذف</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <form action="{{ route('dashboard.accreditations.store') }}" method="post" class="col-12">
                    @csrf
                    <h3>تحديد شهر معين للإعتماد</h3>
                    <div class="row">
                        <div class="form-group col-6">
                            <input type="month" name="month" min="{{ $monthDownload }}"  class="form-control" value="{{ $monthDownload }}">
                        </div>
                        <div class="form-group col-6">
                            <button type="submit" class="btn btn-primary">اعتماد</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    @endcan


    @push('scripts')
        <!-- DataTables JS -->
        <script src="{{asset('js/plugins/datatable/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('js/plugins/datatable/dataTables.js')}}"></script>
        <script>
            const csrf_token = "{{csrf_token()}}";
            const app_link = "{{config('app.url')}}/";
        </script>
        <script src="{{ asset('js/custom/exchange.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                let formatNumber = (number,min = 0,row = null) => {
                    // التحقق إذا كانت القيمة فارغة أو غير صالحة كرقم
                    if (number === null || number === undefined || isNaN(number)) {
                        return ''; // إرجاع قيمة فارغة إذا كان الرقم غير صالح
                    }
                    return new Intl.NumberFormat('en-US', { minimumFractionDigits: min, maximumFractionDigits: 2 }).format(number);
                };
                let formatData = (data,field) => {
                    if (data == null) {
                        return 0.00;
                    }
                    let jsonData = data.replace(/&quot;/g, '"');
                    let parsedData = JSON.parse(jsonData);
                    if (parsedData != null ) {
                        return formatNumber(parseFloat(parsedData[field]),2) || 0.00;
                    }else{
                        return 0.00;
                    }
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
                        url: '{{ route("dashboard.salaries.index") }}',
                        type: 'GET',
                        data: function(d) {
                            d.month = $('#month').val();
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false}, // عمود الترقيم التلقائي
                        { data: 'name', name: 'name'  , orderable: false, class: 'sticky'},
                        { data: 'association', name: 'association', orderable: false, class: 'text-center'},
                        { data: 'workplace', name: 'workplace', orderable: false, class: 'text-center'},
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
                        // { data: 'edit', name: 'edit', orderable: false, searchable: false, render: function(data, type, row) {
                        //     @can('update','App\\Models\ReceivablesLoans')
                        //     let link = `<button class="btn btn-sm btn-icon text-primary edit_row"  style="padding: 1px;" data-id=":salary"><i class="fa-solid fa-edit"></i></button>`.replace(':salary', data);
                        //     return link ;
                        //     @else
                        //     return '';
                        //     @endcan
                        // }},
                        { data: 'print', name: 'print', orderable: false, searchable: false, render: function (data, type, row) {
                            @can('print','App\\Models\Salary')
                            return `
                                <form method="post" action="{{ route('dashboard.salaries.view_pdf', ':salaries' )}}" target="_blank">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="btn btn-icon p-1 text-info">
                                        <i class="fa-solid fa-print"></i>
                                    </button>
                                </form>
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
                            $(this).find('td').eq(2).css('right', '0px');
                            
                        });
                    },
                    footerCallback: function(row, data, start, end, display) {
                        let api = this.api();
                        // تحويل القيم النصية إلى أرقام
                        let intVal = function(i) {
                            return typeof i === 'string' ?
                                parseFloat(i.replace(/[\$,]/g, '')) :
                                typeof i === 'number' ? i : 0;
                        };
                        // 1. حساب عدد الأسطر في الصفحة الحالية
                        let rowCount = display.length;

                        for (let i = 6; i < 28; i++) {
                            var total = api
                                .column(i, { page: 'current' }) // العمود الرابع
                                .data()
                                .reduce(function(a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);
                            $('#total_' + i).html(formatNumber(total,2));
                        }
                        // 4. عرض النتائج في `tfoot`

                        $('#row_count').html(formatNumber(rowCount));
                        // // $('#allocations-table_filter').addClass('d-none');
                    }
                });
                function populateFilterOptions(columnIndex, container,name) {
                    const uniqueValues = [];
                    table.column(columnIndex, { search: 'applied' }).data().each(function (value) {
                        const stringValue = value ? String(value).trim() : ''; // تحويل القيمة إلى نص وإزالة الفراغات
                        if (stringValue && uniqueValues.indexOf(stringValue) === -1) {
                            uniqueValues.push(stringValue);
                        }
                    });
                    // ترتيب القيم أبجديًا
                    uniqueValues.sort();
                    // إضافة الخيارات إلى div
                    const checkboxList = $(container);
                    checkboxList.empty();
                    uniqueValues.forEach(value => {
                        checkboxList.append(`
                            <label style="display: block;">
                                <input type="checkbox" value="${value}" class="${name}-checkbox"> ${value}
                            </label>
                        `);
                    });
                }
                function isColumnFiltered(columnIndex) {
                    const filterValue = table.column(columnIndex).search();
                    return filterValue !== ""; // إذا لم يكن فارغًا، الفلترة مفعلة
                }
                // دالة لإعادة بناء الفلاتر بناءً على البيانات الحالية
                function rebuildFilters() {
                    isColumnFiltered(1) ? '' : populateFilterOptions(1, '.checkbox-list-1','employee_name');
                    isColumnFiltered(2) ? '' : populateFilterOptions(2, '.checkbox-list-2','association_field');
                    isColumnFiltered(3) ? '' : populateFilterOptions(3, '.checkbox-list-3','workplace_field');
                    for (let i = 1; i <= 4; i++) {
                        if (isColumnFiltered(i)) {
                            $('#btn-filter-' + i).removeClass('btn-secondary');
                            $('#btn-filter-' + i + ' i').removeClass('fa-brands fa-get-pocket');
                            $('#btn-filter-' + i + ' i').addClass('fa-solid fa-filter');
                            $('#btn-filter-' + i).addClass('btn-success');
                        }else{
                            $('#btn-filter-' + i + ' i').removeClass('fa-solid fa-filter');
                            $('#btn-filter-' + i).removeClass('btn-success');
                            $('#btn-filter-' + i).addClass('btn-secondary');
                            $('#btn-filter-' + i + ' i').addClass('fa-brands fa-get-pocket');
                        }
                    }
                }
                table.on('draw', function() {
                    rebuildFilters();
                });
                // منع إغلاق dropdown عند النقر على input أو label
                $('th  .dropdown-menu .checkbox-list-box').on('click', function (e) {
                    e.stopPropagation(); // منع انتشار الحدث
                });
                // البحث داخل الـ checkboxes
                $('.search-checkbox').on('input', function() {
                    let searchValue = $(this).val().toLowerCase();
                    let tdIndex = $(this).data('index');
                    $('.checkbox-list-' + tdIndex + ' label').each(function() {
                        let labelText = $(this).text().toLowerCase();  // النص داخل الـ label
                        let checkbox = $(this).find('input');  // الـ checkbox داخل الـ label

                        if (labelText.indexOf(searchValue) !== -1) {
                            $(this).show();
                        } else {
                            $(this).hide();
                            if (checkbox.prop('checked')) {
                                checkbox.prop('checked', false);  // إذا كان الـ checkbox محددًا، قم بإلغاء تحديده
                            }
                        }
                    });
                });
                $('.all-checkbox').on('change', function() {
                    let index = $(this).data('index'); // الحصول على الـ index من الـ data-index

                    // التحقق من حالة الـ checkbox "الكل"
                    if ($(this).prop('checked')) {
                        // إذا كانت الـ checkbox "الكل" محددة، تحديد جميع الـ checkboxes الظاهرة فقط
                        $('.checkbox-list-' + index + ' input[type="checkbox"]:visible').prop('checked', true);
                    } else {
                        // إذا كانت الـ checkbox "الكل" غير محددة، إلغاء تحديد جميع الـ checkboxes الظاهرة فقط
                        $('.checkbox-list-' + index + ' input[type="checkbox"]:visible').prop('checked', false);
                    }
                });
                function escapeRegex(value) {
                    return value.replace(/[-\/\\^$*+?.()|[\]{}"'`]/g, '\\$&'); // تشمل الآن علامات الاقتباس المفردة والمزدوجة
                }
                $('.filter-apply-btn-checkbox').on('click', function() {
                    let target = $(this).data('target'); // استرجاع الهدف (العمود)
                    let field = $(this).data('field'); // استرجاع الحقل (اسم المشروع أو أي حقل آخر)

                    // الحصول على القيم المحددة من الـ checkboxes
                    var filterValues = [];
                    // نستخدم الكلاس المناسب بناءً على الحقل (هنا مشروع)
                    $('.' + field + '-checkbox:checked').each(function() {
                        filterValues.push($(this).val()); // إضافة القيمة المحددة
                    });
                    // إذا كانت هناك قيم محددة، نستخدمها في الفلترة
                    if (filterValues.length > 0) {
                        // تحويل القيم إلى تعبير نمطي مع إلغاء حجز الرموز الخاصة
                        var searchExpression = filterValues.map(escapeRegex).join('|');
                        // تطبيق الفلترة على العمود باستخدام القيم المحددة
                        table.column(target).search(searchExpression, true, false).draw(); // Use regex search
                        // استخدام البحث النصي العادي (regex: false)

                    } else {
                        // إذا لم تكن هناك قيم محددة، نعرض جميع البيانات
                        table.column(target).search('').draw();
                    }
                });
                // تطبيق الفلترة عند الضغط على زر "check"
                $('.filter-apply-btn').on('click', function() {
                    let target = $(this).data('target');
                    let field = $(this).data('field');
                    var filterValue = $("input[name="+ field + "]").val();
                    table.column(target).search(filterValue).draw();
                });
                // تطبيق التصفية عند النقر على زر "Apply"
                $('#filter-date-btn').on('click', function () {
                    const fromDate = $('#from_date').val();
                    const toDate = $('#to_date').val();
                    table.ajax.reload(); // إعادة تحميل الجدول مع التواريخ المحدثة
                });
                // تطبيق فلترة السنة عند تغير حقل السنة
                $('#month').on('change', function() {
                    const month = $(this).val();
                    table.ajax.reload();
                });
                // إعادة تحميل الجدول عند النقر على زر "Refresh"
                $(document).on('click', '#refreshData', function() {
                    table.ajax.reload();
                });
                $(document).on('click', '#filterBtnClear', function() {
                    $('.filter-dropdown').slideUp();
                    $('#filterBtn').text('تصفية');
                    $('.filterDropdownMenu input').val('');
                    $('th input[type="checkbox"]').prop('checked', false);
                    table.columns().search('').draw(); // إعادة رسم الجدول بدون فلاتر
                });
                /*
                $(document).on('click', '.edit_row', function () {
                    const id = $(this).data('id'); // الحصول على ID الصف
                    editReceivablesForm(id);
                });
                function editReceivablesForm(id) {
                    $.ajax({
                        url: "{{ route('dashboard.salaries.update', ':id') }}".replace(':id', id),
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        data: {
                            total_salaries: $('input[name="total_salaries_' + id + '"]').val(),
                        },  // البيانات التي تم جمعها من النموذج
                        success: function(response) {
                            table.ajax.reload();
                            alert('تم التعديل بنجاح');
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            alert('هنالك خطأ في الإتصال بالسيرفر.');
                        }
                    });
                }
                */
            });
        </script>
        <script>
            $(document).on('click', '#filterBtn', function() {
                let text = $(this).text();
                if (text != 'تصفية') {
                    $(this).text('تصفية');
                }else{
                    $(this).text('إخفاء التصفية');
                }
                $('.filter-dropdown').slideToggle();
            });
            $(document).ready(function() {
                if (curentTheme == "light") {
                    $('#stickyTableLight').prop('disabled', false); // تشغيل النمط Light
                    $('#stickyTableDark').prop('disabled', true);  // تعطيل النمط Dark
                } else {
                    $('#stickyTableLight').prop('disabled', true);  // تعطيل النمط Light
                    $('#stickyTableDark').prop('disabled', false); // تشغيل النمط Dark
                }
            });
        </script>
        <script>
            $(document).ready(function() {
                let currentRow = 0;
                let currentCol = 0;

                // الحصول على الصفوف من tbody فقط
                const rows = $('#salaries-table tbody tr');

                // إضافة الكلاس للخلايا عند تحميل الصفحة
                highlightCell(currentRow, currentCol);

                // التنقل باستخدام الأسهم
                $(document).on('keydown', function(e) {
                    // تحديث عدد الصفوف والأعمدة المرئية عند كل حركة
                    const totalRows = $('#salaries-table tbody tr:visible').length;
                    const totalCols = $('#salaries-table tbody tr:visible').eq(0).find('td').length;

                    // التحقق من وجود صفوف وأعمدة لتجنب NaN
                    if (totalRows === 0 || totalCols === 0) return;

                    // التنقل باستخدام الأسهم
                    if (e.key === 'ArrowLeft') {
                        if (currentCol < 32) {
                            currentCol = (currentCol + 1) % totalCols;
                        }
                    } else if (e.key === 'ArrowRight') {
                        if (currentCol > 0) {
                            currentCol = (currentCol - 1 + totalCols) % totalCols;
                        }
                    } else if (e.key === 'ArrowDown') {
                        currentRow = (currentRow + 1) % totalRows;
                    } else if (e.key === 'ArrowUp') {
                        // إذا كنت في الصف الأول، لا تفعل شيئاً
                        if (currentRow > 0) {
                            currentRow = (currentRow - 1 + totalRows) % totalRows;
                        }
                    } else {
                        return;
                    }
                    highlightCell(currentRow, currentCol);
                });

                // التحديد عند النقر المزدوج بالماوس
                $('#salaries-table tbody').on('dblclick', 'td', function() {
                    const cell = $(this);
                    currentRow = cell.closest('tr').index();
                    currentCol = cell.index();
                    highlightCell(currentRow, currentCol);
                });

                // دالة لتحديث الخلية النشطة
                function highlightCell(row, col) {
                    // استهداف الصفوف المرئية فقط
                    const visibleRows = $('#salaries-table tbody tr:visible');
                    // التحقق من وجود الصف
                    if (visibleRows.length > row) {
                        // تحديد الصف والخلية المطلوبة
                        const targetRow = visibleRows.eq(row);
                        const targetCell = targetRow.find('td').eq(col);
                        if (targetCell.length) {
                            // إزالة التنسيقات السابقة
                            $('#salaries-table tbody td').removeClass('active');
                            // إضافة التنسيق للخلية المطلوبة
                            targetCell.addClass('active');
                            targetCell.focus();
                        }
                    }
                }


            });

        </script>
    @endpush
</x-front-layout>
