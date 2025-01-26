<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <div class="row align-items-center mb-2">
        <div class="col">
            <h2 class="mb-2 page-title">إنشاء صرف لعدة موظفين</h2>
            <p class="mb-3">إختيار الموظفين المراد الصرف لهم أولا</p>
        </div>
    </div>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/multi-select.css') }}">
        <style>
            .ms-container {
                display: flex;
                justify-content: space-between;
                flex-direction: row;
                gap: 20px;
                width: 100%;
            }

            .ms-container:after {
                content: '';
                display: none;
            }

            .ms-list {
                direction: ltr;
            }

            .custom-header {
                padding: 10px;
                background-color: #f8f9fa;
                font-weight: bold;
                border-bottom: 1px solid #ddd;
            }

            .custom-header button {
                margin-left: 10px;
            }

            .custom-footer {
                background-color: #e9ecef;
                padding: 5px;
                font-size: 14px;
                text-align: center;
            }
        </style>
    @endpush
    <form action="{{route('exchanges.many')}}" method="post" class="col-12">
    <div class="row">
        @csrf
        <div class="form-group my-2 col-12">
            <select id='employees-select' multiple='multiple' name='employees_select[]'
                style="display: none">
                @foreach ($employees as $employee)
                    <option value='{{ $employee->id }}'>{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row justify-content-end align-items-center mb-2">
        <button type="submit" class="btn btn-primary mx-2">
            إختيار
        </button>
    </div>
    </form>
    @push('scripts')
        <script>
            const csrf_token = "{{csrf_token()}}";
            const app_link = "{{config('app.url')}}/";
        </script>
        <script src="{{ asset('js/jquery.quicksearch.min.js') }}"></script>
        <script src="{{ asset('js/jquery.multi-select.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#employees-select').multiSelect({
                    selectableHeader: `
                        <div class="custom-header d-flex justify-content-between align-items-center">
                            <span>الموظفون غير المحددين</span>
                            <input type="text" class="search-input" id="selectable-search" autocomplete="off" placeholder="بحث...">
                            <button type="button" id="select-all" class="btn btn-success btn-sm">تحديد الكل</button>
                        </div>
                    `,
                        selectionHeader: `
                        <div class="custom-header d-flex justify-content-between align-items-center">
                            <span>الموظفون المحددون</span>
                            <input type="text" class="search-input" id="selection-search" autocomplete="off" placeholder="بحث...">
                            <button type="button" id="deselect-all" class="btn btn-danger btn-sm">إلغاء تحديد الكل</button>
                        </div>
                    `,
                    selectableFooter: "<div class='custom-footer'>إجمالي غير المحددين: <span id='selectable-count'>0</span></div>",
                    selectionFooter: "<div class='custom-footer'>إجمالي المحددين: <span id='selection-count'>0</span></div>",
                    afterInit: function(ms) {
                        let that = this;

                        // البحث في العناصر غير المحددة فقط
                        let $selectableSearch = $('#selectable-search');
                        $selectableSearch.on('keyup', function() {
                            let searchValue = $(this).val().toLowerCase();

                            // إعادة ضبط العرض لجميع العناصر
                            $('.ms-elem-selectable').css('display', 'block');
                            $('.ms-elem-selectable.ms-selected').css('display', 'none');

                            // إخفاء العناصر التي لا تطابق البحث
                            $('.ms-elem-selectable').filter(function() {
                                return !$(this).text().toLowerCase().includes(searchValue);
                            }).css('display', 'none');
                        });

                        // البحث في العناصر المحددة فقط
                        let $selectionSearch = $('#selection-search');
                        $selectionSearch.on('keyup', function() {
                            let searchValue = $(this).val().toLowerCase();

                            // إعادة ضبط العرض لجميع العناصر
                            $('.ms-elem-selection.ms-selected').css('display', 'block');


                            // إخفاء العناصر التي لا تطابق البحث
                            $('.ms-elem-selection.ms-selected').filter(function() {
                                return !$(this).text().toLowerCase().includes(searchValue);
                            }).css('display', 'none');
                        });
                    },
                    afterSelect: function() {
                        $('#selectable-search').trigger('keyup');
                        $('#selection-search').trigger('keyup');
                        updateCounts();
                    },
                    afterDeselect: function() {
                        $('#selectable-search').trigger('keyup');
                        $('#selection-search').trigger('keyup');
                        updateCounts();
                    },
                });
                // زر تحديد الكل
                $(document).on('click', '#select-all', function() {
                    $('#employees-select').multiSelect('select_all');
                });

                // زر إلغاء تحديد الكل
                $(document).on('click', '#deselect-all', function() {
                    $('#employees-select').multiSelect('deselect_all');
                });

                // تحديث العدادات عند التحميل
                updateCounts();

                // دالة لتحديث العدادات
                function updateCounts() {
                    // عد العناصر في القائمة غير المحددة
                    $('#selectable-count').text($('.ms-selectable li:not(.ms-selected)').length);

                    // عد العناصر في القائمة المحددة
                    $('#selection-count').text($('.ms-selection li.ms-selected').length);
                }
            });
        </script>
    @endpush
</x-front-layout>
