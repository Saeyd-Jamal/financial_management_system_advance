
    @push('styles')
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="{{asset('css/datatable/jquery.dataTables.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/datatable/dataTables.bootstrap4.css')}}">
        <link rel="stylesheet" href="{{asset('css/datatable/dataTables.dataTables.css')}}">
        <link rel="stylesheet" href="{{asset('css/datatable/buttons.dataTables.css')}}">
        <link id="stickyTableLight" rel="stylesheet" href="{{ asset('css/stickyTable.css') }}">
        <link id="stickyTableDark" rel="stylesheet" href="{{ asset('css/stickyTableDark.css') }}" disabled>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datatableIndex.css') }}">
    @endpush
    <x-slot:extra_nav>
        <li class="nav-item d-flex align-items-center justify-content-center mx-2">
            <button type="button" class="btn" id="refreshData"><span class="fe fe-refresh-ccw fe-16 text-white"></span></button>
        </li>
    </x-slot:extra_nav>
    <div class="row shadow rounded mb-2 mx-0">
        <div class="col-md-12 d-flex justify-content-between align-items-center p-1">
            <div>
                <h2 class="m-0 p-0">صرف لعدة موظفين</h2>
            </div>
            <div class="d-flex align-items-end justify-content-end">
                <div class="form-group my-0 mx-2">
                    <label for="type_exchange">نوع الصرف</label>
                    <select name="type_exchange" id="type_exchange" class="form-select">
                        <option value="">تحديد نوع الصرف</option>
                        <option value="receivables_discount">خصم من المستحقات ش</option>
                        <option value="receivables_addition">اضافة للمستحقات ش</option>
                        <option value="savings_discount">خصم من الإدخارات $</option>
                        <option value="savings_addition">اضافة للإدخارات $</option>
                        <option value="savings_loan">قرض إدخار $</option>
                        <option value="shekel_loan">قرض لجنة ش</option>
                        <option value="association_loan">قرض جمعية ش</option>
                    </select>
                </div>
                <div class="form-group my-0 mx-2">
                    <x-form.input name="amont" min="0" label="قيمة الصرف" step="0.01" id="amont" type="amont" type="number" />
                </div>
                <div class="form-group my-0">
                    <button class="btn btn-primary" type="button" id="applyExchange">
                        تطبيق <i class="fe fe-arrow-right fe-16"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="padding: 0 2px;">
            <div class="card">
                <div class="card-body table-container p-0">
                    <table id="exchanges-table" class="table table-striped table-bordered table-hover sticky" style="width:100%; height: 100%; display: table;">
                        <thead>
                            <tr>
                                <th class="text-white text-center">#</th>
                                <th class="sticky" style="right: 0px;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>الموظف</span>
                                        <div class="filter-dropdown ml-4">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-filter" id="btn-filter-1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa-brands fa-get-pocket text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="name_filter">
                                                    <!-- إضافة checkboxes بدلاً من select -->
                                                    <div class="searchable-checkbox">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <input type="search" class="form-control search-checkbox" data-index="1" placeholder="ابحث...">
                                                            <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="1" data-field="name">
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
                                <th>الجمعية</th>
                                <th>الإجمالي</th>
                                <th>مبلغ الصرف</th>
                                <th>المتبقي</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- DataTables JS -->
        <script src="{{asset('js/datatable/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('js/datatable/dataTables.js')}}"></script>
        <script src="{{asset('js/datatable/dataTables.buttons.js')}}"></script>
        <script src="{{asset('js/datatable/buttons.dataTables.js')}}"></script>
        <script src="{{asset('js/datatable/jszip.min.js')}}"></script>
        <script src="{{asset('js/datatable/pdfmake.min.js')}}"></script>
        <script src="{{asset('js/datatable/vfs_fonts.js')}}"></script>
        <script src="{{asset('js/datatable/buttons.html5.min.js')}}"></script>
        <script src="{{asset('js/datatable/buttons.print.min.js')}}"></script>
        <script src="{{asset('js/jquery.validate.min.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                let employees_select = {!! json_encode($employees_select) !!};
                let formatNumber = (number,min = 0) => {
                    // التحقق إذا كانت القيمة فارغة أو غير صالحة كرقم
                    if (number === null || number === undefined || isNaN(number)) {
                        return ''; // إرجاع قيمة فارغة إذا كان الرقم غير صالح
                    }
                    return new Intl.NumberFormat('en-US', { minimumFractionDigits: min, maximumFractionDigits: 2 }).format(number);
                };
                const table = $('#exchanges-table').DataTable({
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
                        url: '{{ route("exchanges.getMany") }}',
                        data: function (d) {
                            d.employees_select = employees_select;
                            d.amont = $('#amont').val();
                            d.type_exchange = $('#type_exchange').val();
                            // إضافة تواريخ التصفية إلى الطلب المرسل
                            d.from_date = $('#from_date').val();
                            d.to_date = $('#to_date').val();
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, class: 'text-center'}, // عمود الترقيم التلقائي
                        { data: 'name', name: 'name'  , orderable: false, class: 'sticky'},
                        { data: 'association', name: 'association', orderable: false},
                        { data: 'total', name: 'total', orderable: false, render: function(data, type, row) {
                            return `<span id='total_${row.id}'> ${formatNumber(data,2)} </span>`;
                        }},
                        { data: 'amont', name: 'amont', orderable: false, render: function(data, type, row) {
                            let inp = `
                                <input type="number" name="amont[${row.id}]" data-id="${row.id}" id="amont_${row.id}" class="form-control amont" style="width: 100px; padding: 2px 15px;" value="${data}" min="0" max="${row.total}" step="0.01" required>
                                <input type="hidden" name="exchange_id[]" value="${row.id}">
                            `;
                            return inp;
                        }},
                        { data: 'remaining', name: 'remaining', orderable: false, render: function(data, type, row) {
                            return `<span id='remaining_${row.id}'> ${formatNumber(data,2)} </span>`;
                        }},
                        { data: 'delete', name: 'delete', orderable: false, searchable: false, render: function (data, type, row) {
                            @can('delete','App\\Models\Employee')
                            return `
                                <button
                                    type="button"
                                    class="btn btn-icon p-1 text-danger delete_row"
                                    data-id="${data}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>`;
                            @else
                            return '';
                            @endcan
                        }}
                    ],
                    columnDefs: [
                        { targets: 0, searchable: false, orderable: false } // تعطيل الفرز والبحث على عمود الترقيم
                    ],
                    drawCallback: function(settings) {
                        // تطبيق التنسيق على خلايا العمود المحدد
                        $('#exchanges-table tbody tr').each(function() {
                            $(this).find('td').eq(2).css('right', '0px');
                        });
                    },
                });
                // نسخ وظيفة الزر إلى الزر المخصص
                $('#excel-export').on('click', function () {
                    table.button('.buttons-excel').trigger(); // استدعاء وظيفة الزر الأصلي
                });
                $('#print-btn').on('click', function () {
                    table.button('.buttons-print').trigger(); // استدعاء وظيفة الطباعة الأصلية
                });
                $('#exchanges-table_filter').addClass('d-none');
                // جلب الداتا في checkbox
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
                    isColumnFiltered(1) ? '' : populateFilterOptions(1, '.checkbox-list-1','name');
                    for (let i = 1; i <= 2; i++) {
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
                // // تطبيق الفلترة عند الضغط على زر "check"
                $('.filter-apply-btn').on('click', function() {
                    let target = $(this).data('target');
                    let field = $(this).data('field');
                    var filterValue = $("input[name="+ field + "]").val();
                    table.column(target).search(filterValue).draw();
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
                        // دمج القيم باستخدام OR (|) كما هو متوقع في البحث
                        var searchExpression = filterValues.join('|');
                        // تطبيق الفلترة على العمود باستخدام القيم المحددة
                        table.column(target).search(searchExpression, true, false).draw(); // Use regex search
                    } else {
                        // إذا لم تكن هناك قيم محددة، نعرض جميع البيانات
                        table.column(target).search('').draw();
                    }
                });
                // تطبيق التصفية عند النقر على زر "Apply"
                $('#filter-date-btn').on('click', function () {
                    const fromDate = $('#from_date').val();
                    const toDate = $('#to_date').val();
                    table.ajax.reload(); // إعادة تحميل الجدول مع التواريخ المحدثة
                });
                $('#applyExchange').on('click', function () {
                    const type_exchange = $('#type_exchange').val();
                    const amont = $('#amont').val();
                    table.ajax.reload(); // إعادة تحميل الجدول مع التواريخ المحدثة
                });
                // تفويض حدث الحذف على الأزرار الديناميكية
                $(document).on('click', '.delete_row', function () {
                    const id = $(this).data('id'); // الحصول على ID الصف
                    if (confirm('هل أنت متأكد من حذف العنصر؟')) {
                        deleteRow(id); // استدعاء وظيفة الحذف
                    }
                });
                // وظيفة الحذف
                function deleteRow(id) {
                    employees_select = employees_select.filter(employee => employee !== id.toString());
                    table.ajax.reload();
                }
                $(document).on('blur', '.amont', function () {
                    let id = $(this).data('id'); // الحصول على ID الصف
                    let amont = $(this).val();
                    updateAmont(id, amont);
                });
                function updateAmont(id, amont) {
                    // amont_${row.id}
                    let type_exchange = $('#type_exchange').val();
                    if(type_exchange == 'receivables_discount' || type_exchange == 'receivables_addition' || type_exchange == 'savings_discount' || type_exchange == 'savings_addition'){
                        let totalText = $('#total_' + id).text().trim().replace(/,/g, '');
                        let total = parseFloat(totalText) || 0;
                        let amontNew = parseFloat(amont,2) || 0;
                        let newRemaining = total - amontNew;
                        $('#remaining_' + id).text(formatNumber(newRemaining, 2));
                    }
                }
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
            });
        </script>
        <script>
            $(document).ready(function() {
                $(document).on('click', '#filterBtn', function() {
                    let text = $(this).text();
                    if (text != 'تصفية') {
                        $(this).text('تصفية');
                    }else{
                        $(this).text('إخفاء التصفية');
                    }
                    $('.filter-dropdown').slideToggle();
                });
            });
        </script>
    @endpush
