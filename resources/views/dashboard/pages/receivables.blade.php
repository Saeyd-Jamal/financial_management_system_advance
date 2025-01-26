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
                <button class="btn nav-link active" id="pills-table-tab" data-toggle="pill" data-target=".pills-table" type="button" role="tab" aria-controls="pills-home" aria-selected="true">العرض</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn nav-link" id="pills-exchanges-tab" data-toggle="pill" data-target=".pills-exchanges" type="button" role="tab" aria-controls="pills-exchanges" aria-selected="false">صرف المستحقات</button>
            </li>
        </ul>
        @push('scripts')
            <script>
                $(document).ready(function() {
                    $('#pills-table-tab').on('click', function (e) {
                        $('#pills-exchanges-tab').removeClass('active');
                        $(this).addClass('active');
                        $('.pills-table').addClass('show active');
                        $('.pills-exchanges').removeClass('show active');
                    });
                    $('#pills-exchanges-tab').on('click', function (e) {
                        $('#pills-table-tab').removeClass('active');
                        $(this).addClass('active');
                        $('.pills-exchanges').addClass('show active');
                        $('.pills-table').removeClass('show active');
                    });
                });
            </script>
        @endpush
    </x-slot:extra_nav_right>
    <x-slot:extra_nav>
        <div class="d-flex align-items-center justify-content-end tab-content">
            <div class="tab-pane fade show active pills-table" role="tabpanel" aria-labelledby="pills-table-tab">
                <div class="form-group my-0 mx-2">
                    <select name="year" id="year" class="form-control">
                        @for ($year = date('Y'); $year >= 2024; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
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
                            <table id="receivables-table" class="table table-striped table-bordered table-hover sticky" style="width:100%; height: calc(100vh - 168px);">
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
                                                            <i class="fa-brands fa-get-pocket text-white"></i>
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
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td class="text-white text-center" id="row_count">#</td>
                                        <td style="white-space: nowrap;" class="text-right">الإجمالي</td>
                                        <td></td>
                                        <td id="total_3"></td>
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
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
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
                let table = $('#receivables-table').DataTable({
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
                        url: '{{ route("dashboard.receivables.index") }}',
                        type: 'GET',
                        data: function(d) {
                            d.year = $('#year').val();
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false}, // عمود الترقيم التلقائي
                        { data: 'name', name: 'name'  , orderable: false, class: 'sticky'},
                        { data: 'association', name: 'association', orderable: false},
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
                        { data: 'total_receivables', name: 'total_receivables', orderable: false, render: function(data, type, row) {
                            let field = `<x-form.input name="total_receivables_${row.id}" style="width: 100px; padding: 6px 5px;" type="number" value="${data}" step="0.01" min="0" />`;
                            return field;
                        }},
                        { data: 'edit', name: 'edit', orderable: false, searchable: false, render: function(data, type, row) {
                            @can('update','App\\Models\ReceivablesLoans')
                            let link = `<button class="btn btn-sm btn-icon text-primary edit_row"  style="padding: 1px;" data-id=":receivable"><i class="fa-solid fa-edit"></i></button>`.replace(':receivable', data);
                            return link ;
                            @else
                            return '';
                            @endcan
                        }},
                        { data: 'print', name: 'print', orderable: false, searchable: false, render: function (data, type, row) {
                            @can('print','App\\Models\ReceivablesLoans')
                            return `
                                <form method="post" action="{{ route('dashboard.receivables.print', ':receivables' )}}" target="_blank">
                                    @csrf
                                    <input type="hidden" name="year" value=":year">
                                    <button
                                        type="submit"
                                        class="btn btn-icon p-1 text-info w-auto h-auto">
                                        <i class="fa-solid fa-print"></i>
                                    </button>
                                </form>
                                `.replace(':receivables', data).replace(':year', $('#year').val());
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
                        $('#receivables-table tbody tr').each(function() {
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

                        for (let i = 3; i < 16; i++) {
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
                    editReceivablesForm(id);
                });
                function editReceivablesForm(id) {
                    $.ajax({
                        url: "{{ route('dashboard.receivables.update', ':id') }}".replace(':id', id),
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        data: {
                            total_receivables: $('input[name="total_receivables_' + id + '"]').val(),
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
                const rows = $('#receivables-table tbody tr');

                // إضافة الكلاس للخلايا عند تحميل الصفحة
                highlightCell(currentRow, currentCol);

                // التنقل باستخدام الأسهم
                $(document).on('keydown', function(e) {
                    // تحديث عدد الصفوف والأعمدة المرئية عند كل حركة
                    const totalRows = $('#receivables-table tbody tr:visible').length;
                    const totalCols = $('#receivables-table tbody tr:visible').eq(0).find('td').length;

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
                $('#receivables-table tbody').on('dblclick', 'td', function() {
                    const cell = $(this);
                    currentRow = cell.closest('tr').index();
                    currentCol = cell.index();
                    highlightCell(currentRow, currentCol);
                });

                // دالة لتحديث الخلية النشطة
                function highlightCell(row, col) {
                    // استهداف الصفوف المرئية فقط
                    const visibleRows = $('#receivables-table tbody tr:visible');
                    // التحقق من وجود الصف
                    if (visibleRows.length > row) {
                        // تحديد الصف والخلية المطلوبة
                        const targetRow = visibleRows.eq(row);
                        const targetCell = targetRow.find('td').eq(col);
                        if (targetCell.length) {
                            // إزالة التنسيقات السابقة
                            $('#receivables-table tbody td').removeClass('active');
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
