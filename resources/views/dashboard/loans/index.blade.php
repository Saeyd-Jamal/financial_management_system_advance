<x-front-layout>
    @push('styles')
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="{{asset('css/datatable/jquery.dataTables.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/datatable/dataTables.bootstrap4.css')}}">
        <link rel="stylesheet" href="{{asset('css/datatable/dataTables.dataTables.css')}}">
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
            td:not(.sticky){
                text-align: center !important;
            }

        </style>
    @endpush
    <x-slot:extra_nav_right>
        <ul class="nav nav-pills col-4" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="btn nav-link active view-loan" id="pills-savings-tab" data-toggle="pill" data-field="savings_loan" data-total_field="total_savings_loan" data-target=".pills-table" type="button" role="tab" aria-controls="pills-table" aria-selected="true">قرض الإدخار</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn nav-link view-loan" id="pills-association-tab" data-toggle="pill" data-field="association_loan" data-total_field="total_association_loan" data-target=".pills-table" type="button" role="tab" aria-controls="pills-table" aria-selected="true">قرض الجمعية</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn nav-link view-loan" id="pills-shekel-tab" data-toggle="pill"data-field="shekel_loan" data-total_field="total_shekel_loan"  data-target=".pills-table" type="button" role="tab" aria-controls="pills-table" aria-selected="true">قرض اللجنة</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn nav-link" id="pills-exchanges-tab" data-toggle="pill" data-target=".pills-exchanges" type="button" role="tab" aria-controls="pills-exchanges" aria-selected="false">صرف القروض</button>
            </li>
        </ul>
        @push('scripts')
            <script>
                $(document).ready(function() {
                    $('.view-loan').on('click', function (e) {
                        $id = $(this).attr('id');
                        $filed = $(this).data('field');
                        $('.view-loan').removeClass('active');
                        $('#pills-exchanges-tab').removeClass('active');
                        $('#' + $id).addClass('active');
                        $('.tab-pane').removeClass('show active');
                        $('#pills-table , .pills-loan').addClass('show active');
                        $('#field').val($filed);
                        $('#total_field').val($(this).data('total_field'));
                    });
                    $('#pills-exchanges-tab').on('click', function (e) {
                        $('.view-loan').removeClass('active');
                        $(this).addClass('active');
                        $('.tab-pane').removeClass('show active');
                        $('#pills-exchanges').addClass('show active');
                    });
                });
            </script>
        @endpush
    </x-slot:extra_nav_right>
    <x-slot:extra_nav>
        <div class="d-flex align-items-center justify-content-end tab-content">
            <div class="tab-pane fade show active pills-loan " role="tabpanel" aria-labelledby="pills-table-tab">
                <div class="form-group my-0 mx-2">
                    <select name="year" id="year" class="form-control">
                        @for ($yearNow = date('Y'); $yearNow >= 2024; $yearNow--)
                            <option value="{{ $yearNow }}">{{ $yearNow }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="tab-pane fade pills-exchanges" role="tabpanel" aria-labelledby="pills-exchanges-tab">
                @can('create', 'App\\Models\Exchange')
                <a href="{{ route('dashboard.exchanges.create') }}" class="btn btn-success text-white">
                    <i class="fa-solid fa-plus"></i> إضافة صرف جديد
                </a>
                @endcan
            </div>
        </div>
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
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active pills-table" id="pills-table" role="tabpanel" aria-labelledby="pills-table-tab">
                        <div class="card-body table-container p-0">
                            <table id="loans-table" class="table table-striped table-bordered table-hover sticky" style="width:100%; height: calc(100vh - 168px);">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-white text-center">#</th>
                                        <th class="sticky" style="right: 0px; white-space: nowrap;">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span>الاسم</span>
                                                <div class="filter-dropdown ml-4">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary btn-filter" id="btn-filter-2" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa-brands fa-get-pocket text-white"></i>
                                                        </button>
                                                        <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="employee_name_filter">
                                                            <!-- إضافة checkboxes بدلاً من select -->
                                                            <div class="searchable-checkbox">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <input type="search" class="form-control search-checkbox" data-index="2" placeholder="ابحث...">
                                                                    <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="2" data-field="employee_name">
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
                                                <span>الجمعية</span>
                                                <div class="filter-dropdown ml-4">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary btn-filter" id="btn-filter-3" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa-brands fa-get-pocket text-white"></i>
                                                        </button>
                                                        <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="association_filter">
                                                            <!-- إضافة checkboxes بدلاً من select -->
                                                            <div class="searchable-checkbox">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <input type="search" class="form-control search-checkbox" data-index="3" placeholder="ابحث...">
                                                                    <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="3" data-field="association_field">
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
                                        <th>الإجمالي للسنة</th>
                                        <th>الإجمالي</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td class="text-white text-center" id="row_count">#</td>
                                        <td style="white-space: nowrap;" class="text-left">الإجمالي</td>
                                        <td></td>
                                        <td id="total_4"></td>
                                        <td id="total_5"></td>
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
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    {{-- الصرف --}}
                    <div class="tab-pane fade pills-exchanges" id="pills-exchanges" role="tabpanel" aria-labelledby="pills-exchanges-tab">
                        <div class="card-body">
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
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @can('print', 'App\\Models\Exchange')
                                                    <form action="{{route('dashboard.exchanges.print',$exchange->id)}}" method="post" target="_blank">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item" style="margin: 0.5rem -0.75rem; text-align: right;">
                                                            <i class="fa-solid fa-print"></i>طباعة
                                                        </button>
                                                    </form>
                                                    @endcan
                                                    @can('delete', 'App\\Models\Exchange')
                                                    <form action="{{route('dashboard.exchanges.destroy',$exchange->id)}}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="dropdown-item" style="margin: 0.5rem -0.75rem; text-align: right;">
                                                            <i class="ti ti-trash me-1"></i>حذف
                                                        </button>
                                                    </form>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Fullscreen modal -->
    <div class="modal fade modal-full" id="editLoan" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered w-100" role="document" style="max-width: 95%;">
            <button aria-label="" type="button" class="btn btn-close px-2" data-bs-dismiss="modal">
                <span>×</span>
            </button>
            <div class="modal-content">
                <div class="modal-body text-center p-0">
                    <form id="editForm">
                        @include('dashboard.loans.editModal')
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- small modal -->

    <input type="hidden" name="field" id="field" value="savings_loan">
    <input type="hidden" name="total_field" id="total_field" value="total_savings_loan">

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
                let year = "{{ $year }}";
                let currentMonth = "{{ $lastMonth }}";
                let nextLastMonth = "{{ $nextLastMonth }}";
                let lastMonthAccreditations = "{{ $lastMonthAccreditations }}";
                let formatNumber = (number,min = 0) => {
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
                let table = $('#loans-table').DataTable({
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
                        url: '{{ route("dashboard.loans.index") }}',
                        type: 'GET',
                        data: function(d) {
                            d.year = $('#year').val();
                            d.field = $('#field').val();
                            d.total_field = $('#total_field').val();
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                        }
                    },
                    columns: [
                        { data: 'edit', name: 'edit', orderable: false, searchable: false, render: function(data, type, row) {
                            @can('update','App\\Models\Loan')
                                let link = `<button class="btn btn-sm btn-icon text-primary edit_row"  style="padding: 1px;" data-id=":loan"><i class="fa-solid fa-edit"></i></button>`.replace(':loan', data);
                                return link ;
                            @else
                                return '';
                            @endcan
                        }},
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false}, // عمود الترقيم التلقائي
                        { data: 'name', name: 'name'  , orderable: false, class: 'sticky'},
                        { data: 'association', name: 'association', orderable: false},
                        { data: 'previous_balance', name: 'previous_balance', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month1', name: 'month1', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month2', name: 'month2', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month3', name: 'month3', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month4', name: 'month4', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month5', name: 'month5', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month6', name: 'month6', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month7', name: 'month7', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month8', name: 'month8', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month9', name: 'month9', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month10', name: 'month10', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month11', name: 'month11', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'month12', name: 'month12', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'total_year', name: 'total_year', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'total', name: 'total', orderable: false, render: function(data, type, row) {
                            return  formatNumber(data,2);
                        }},
                        { data: 'print', name: 'print', orderable: false, searchable: false, render: function (data, type, row) {
                            @can('print','App\\Models\Loan')
                            return `
                                <form method="post" action="{{ route('dashboard.loans.print', ':loans' )}}" target="_blank">
                                    @csrf
                                    <input type="hidden" name="field" value="${$('#field').val()}">
                                    <input type="hidden" name="total_field" value="${$('#total_field').val()}">
                                    <input type="hidden" name="previous_balance" value="${row.previous_balance}">
                                    <button
                                        type="submit"
                                        class="btn btn-icon p-1 text-info">
                                        <i class="fa-solid fa-print"></i>
                                    </button>
                                </form>
                                `.replace(':loans', data);
                            @else
                            return '';
                            @endcan
                        }},
                    ],
                    columnDefs: [
                        { targets: 1, searchable: false, orderable: false } // تعطيل الفرز والبحث على عمود الترقيم
                    ],
                    drawCallback: function(settings) {
                        // تطبيق التنسيق على خلايا العمود المحدد
                        $('#loans-table tbody tr').each(function() {
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

                        for (let i = 4; i < 19; i++) {
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
                    isColumnFiltered(2) ? '' : populateFilterOptions(2, '.checkbox-list-2','employee_name');
                    isColumnFiltered(3) ? '' : populateFilterOptions(3, '.checkbox-list-3','association_field');
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
                $('.view-loan').on('click', function() {
                    let field = $(this).data('field');
                    let total_field = $(this).data('total_field');
                    table.ajax.reload();
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
                $(document).on('click', '#filterBtnClear', function() {
                    $('.filter-dropdown').slideUp();
                    $('#filterBtn').text('تصفية');
                    $('.filterDropdownMenu input').val('');
                    $('th input[type="checkbox"]').prop('checked', false);
                    table.columns().search('').draw(); // إعادة رسم الجدول بدون فلاتر
                });
                $(document).on('click', '.edit_row', function () {
                    const id = $(this).data('id'); // الحصول على ID الصف
                    editLoanForm(id);
                });
                let loan = {
                    id : '',
                    name : '',
                    totals : [],
                    totals_old : [],
                    totals_last : [],
                    loans : [],
                };
                let loanFinal = {
                    total_savings_loan : 0,
                    total_association_loan : 0,
                    total_shekel_loan : 0,
                }
                let name_loan = {
                    'savings_loan' : 'قرض الإدخار',
                    'association_loan' : 'قرض الجمعية',
                    'shekel_loan' : 'قرض اللجنة',
                };
                function editLoanForm(id) {
                    $.ajax({
                        url: '{{ route("dashboard.loans.getData") }}',
                        method: 'POST',
                        data: {
                            id: id,
                            year: $('#year').val(),
                            nextLastMonth: nextLastMonth,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            response = response.employee;
                            loan.id = response.id;
                            loan.name = response.name;
                            loan.totals = response.totals;
                            loan.totals_old = response.totals;
                            loan.totals_last = response.totals_last;
                            loan.loans = response.loans;
                            $('#employee_name').text(loan.name);
                            $('#association_loan_total').val(parseFloat(loan.totals.total_association_loan).toFixed(2));
                            $('#savings_loan_total').val(parseFloat(loan.totals.total_savings_loan).toFixed(2));
                            $('#shekel_loan_total').val(parseFloat(loan.totals.total_shekel_loan).toFixed(2));
                        }
                    });
                    $.ajax({
                        url: '{{ route("dashboard.loans.edit", ":id") }}'.replace(':id', id),
                        method: 'GET',
                        success: function (response) {
                            let data = response;
                            console.log(data);
                            $('#loans_tbody').empty();
                            $.each(name_loan, function(key, value) {
                                $('#loans_tbody').append(`
                                    <tr id="${key}_row">
                                        <td class="text-left">${value}</td>
                                    </tr>
                                `);
                                let staticloan = data.find(loan => loan.month === "0000-00");
                                let staticVal = 0;
                                if(staticloan){
                                    staticVal = staticloan[key];
                                    if(staticVal == -1.00){
                                        staticVal = '';
                                    }
                                }else{
                                    staticVal = '';
                                }
                                $('#' + key + '_row').append(`
                                    <td>
                                        <x-form.input  month="0000-00" data-field="${key}" name="${key}-0000" value="${staticVal}" class="const" />
                                    </td>
                                `);
                                for (let i = 1; i <= 12; i++) {
                                    if(i<10){
                                        i = '0'+i;
                                    }
                                    let  monthToFind = year + "-" + i;
                                    let foundloan = data.find(loan => loan.month === monthToFind);
                                    let val = 0;
                                    if(foundloan){
                                        val = foundloan[key];
                                    }else{
                                        val = '0.00';
                                    }
                                    $('#' + key + '_row').append(`
                                        <td>
                                            <x-form.input value="${val}"  employee_id="${id}" field="${key}" month="${i}" name="${key}-${i}" />
                                        </td>
                                    `);
                                    if(currentMonth != '12'){
                                        if (i <= currentMonth) {
                                            $("#" + key + "-" + i).attr('disabled', true);  // تعطيل الحقل إذا كان الشهر الحالي أكبر من الشهر المحدد
                                        }
                                    }
                                }
                            });
                            $('#editLoan').modal('show');
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            alert('هنالك خطأ في الإتصال بالسيرفر.');
                        },
                    })
                }
                $(document).on('click', '#update', function () {
                    let formData = $('#editForm').serialize(); // جمع بيانات النموذج في سلسلة بيانات
                    let association_loan_total = parseFloat(loanFinal.total_association_loan) || 0;
                    let savings_loan_total = parseFloat(loanFinal.total_savings_loan) || 0;
                    let shekel_loan_total = parseFloat(loanFinal.total_shekel_loan) || 0;
                    if(association_loan_total < 0 || savings_loan_total < 0 || shekel_loan_total < 0){
                        alert('لا يمكن أن يكون إجمالي القروض أقل من الصفر يرجى التدقيق لخصم القروض');
                        return;
                    }
                    $.ajax({
                        url: "{{ route('dashboard.loans.update', ':id') }}".replace(':id', loan.id),
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            year: year
                        },
                        data: formData,  // البيانات التي تم جمعها من النموذج
                        success: function(response) {
                            $('#editLoan').modal('hide');
                            table.ajax.reload();
                            alert('تم التعديل بنجاح');
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            alert('هنالك خطأ في الإتصال بالسيرفر.');
                        }
                    });
                });
                $(document).on('input', '.const', function () {
                    let field = $(this).data('field');
                    let value = $(this).val();
                    // let total = 0;
                    // if(field == "savings_loan"){
                    //     total = loan.totals.total_savings_loan;
                    // }
                    // if(field == "association_loan"){
                    //     total = loan.totals.total_association_loan;
                    // }
                    // if(field == "shekel_loan"){
                    //     total = loan.totals.total_shekel_loan;
                    // }
                    for (let i = 1; i <= 12; i++) {
                        i = i < 10 ? '0' + i : i;
                        if(currentMonth != '12'){
                            if (i > currentMonth) {
                                let fieldId = '#' + field + '-' + i;
                                $(fieldId).val(value);
                            }
                        }else{
                            let fieldId = '#' + field + '-' + i;
                            $(fieldId).val(value);
                        }
                    }
                });
                $('#association_loan_total_span').text('');
                $('#savings_loan_total_span').text('');
                $('#shekel_loan_total_span').text('');
                $(document).on('input', 'input[field="association_loan"], #association_loan-0000', function () {
                    let total = 0 ;
                    $('input[field="association_loan"]:not([disabled])').each(function() {
                        if ($(this).attr('month') !== '0000-00') {
                            let data = loan.loans;
                            let loanMonth = data.find(loan => loan.month == ( year + '-' + $(this).attr('month')));
                            if(loanMonth){
                                let association_loan = (parseFloat(loanMonth.association_loan) || 0) - (parseFloat($(this).val()) || 0);
                                if((loanMonth.association_loan != $(this).val())){
                                    total += parseFloat(association_loan) || 0;
                                }else{
                                    // total += parseFloat($(this).val()) || 0;
                                }
                            }else{
                                total -= parseFloat($(this).val()) || 0;
                            }
                        }
                    });
                    let totalFinal = parseFloat(loan.totals_old.total_association_loan) + total;
                    loanFinal.total_association_loan = totalFinal;
                    $('#association_loan_total_span').text(totalFinal.toFixed(2));
                });
                $(document).on('input', 'input[field="savings_loan"], #savings_loan-0000', function () {
                    let total = 0 ;
                    $('input[field="savings_loan"]:not([disabled])').each(function() {
                        if ($(this).attr('month') !== '0000-00') {
                            let data = loan.loans;
                            let loanMonth = data.find(loan => loan.month == ( year + '-' + $(this).attr('month')));
                            if(loanMonth){
                                let savings_loan = (parseFloat(loanMonth.savings_loan) || 0) - (parseFloat($(this).val()) || 0);
                                if((loanMonth.savings_loan != $(this).val())){
                                    total += parseFloat(savings_loan) || 0;
                                }else{
                                    // total += parseFloat($(this).val()) || 0;
                                }
                            }else{
                                total -= parseFloat($(this).val()) || 0;
                            }
                        }
                        
                    });
                    let totalFinal = (parseFloat(loan.totals_old.total_savings_loan) + total);
                    loanFinal.total_savings_loan = totalFinal;
                    $('#savings_loan_total_span').text(totalFinal.toFixed(2));
                });
                $(document).on('input', 'input[field="shekel_loan"], #shekel_loan-0000', function () {
                    let total = 0;
                    $('input[field="shekel_loan"]:not([disabled])').each(function() {
                        if ($(this).attr('month') !== '0000-00') {
                            let data = loan.loans;
                            let loanMonth = data.find(loan => loan.month == ( year + '-' + $(this).attr('month')));
                            if(loanMonth){
                                let shekel_loan = (parseFloat(loanMonth.shekel_loan) || 0) - (parseFloat($(this).val()) || 0);
                                if((loanMonth.shekel_loan != $(this).val())){
                                    total += parseFloat(shekel_loan) || 0;
                                }else{
                                    // total += parseFloat($(this).val()) || 0;
                                }
                            }else{
                                total -= parseFloat($(this).val()) || 0;
                            }
                        }
                    });
                    let totalFinal = parseFloat(loan.totals_old.total_shekel_loan) + total;
                    $('#shekel_loan_total').val(totalFinal.toFixed(2));
                    loanFinal.total_shekel_loan = totalFinal;
                    $('#shekel_loan_total_span').text(totalFinal.toFixed(2));
                });
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
                const rows = $('#loans-table tbody tr');

                // إضافة الكلاس للخلايا عند تحميل الصفحة
                highlightCell(currentRow, currentCol);

                // التنقل باستخدام الأسهم
                $(document).on('keydown', function(e) {
                    // تحديث عدد الصفوف والأعمدة المرئية عند كل حركة
                    const totalRows = $('#loans-table tbody tr:visible').length;
                    const totalCols = $('#loans-table tbody tr:visible').eq(0).find('td').length;

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
                $('#loans-table tbody').on('dblclick', 'td', function() {
                    const cell = $(this);
                    currentRow = cell.closest('tr').index();
                    currentCol = cell.index();
                    highlightCell(currentRow, currentCol);
                });

                // دالة لتحديث الخلية النشطة
                function highlightCell(row, col) {
                    // استهداف الصفوف المرئية فقط
                    const visibleRows = $('#loans-table tbody tr:visible');
                    // التحقق من وجود الصف
                    if (visibleRows.length > row) {
                        // تحديد الصف والخلية المطلوبة
                        const targetRow = visibleRows.eq(row);
                        const targetCell = targetRow.find('td').eq(col);
                        if (targetCell.length) {
                            // إزالة التنسيقات السابقة
                            $('#loans-table tbody td').removeClass('active');
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
