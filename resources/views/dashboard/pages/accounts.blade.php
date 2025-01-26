<x-front-layout>
    @push('styles')
    <link rel="stylesheet" href="{{asset('css/datatable/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{ asset('css/custom/funFixedView.css') }}">
    @endpush
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول حسابات الموظفين</h2>
                    <p class="card-text">هنا يتم عرض بيانات حسابات الموظفين في البنوك.</p>
                </div>
                <div class="col-auto">
                    @can('create', 'App\\Models\Account')
                    <a type="button" class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#addItem">
                        <i class="fa-solid fa-plus f-16"></i>
                    </a>
                    @endcan
                </div>
            </div>
            <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <style>
                                thead
                                {
                                    background: #383848 !important;
                                    color: #fff !important;
                                    margin-top: 20px; 
                                }
                                th
                                {
                                    color: #fff !important;
                                    padding: 12px 33px !important;
                                }
                                td{
                                    padding: 3px 15px !important;
                                    text-align: center;
                                    /* color: #1E1E1E !important; */
                                }
                            </style>
                            <!-- table -->
                            <table class="table  table-bordered  table-hover datatables" id="dataTable-1" style="display: table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم الموظف</th>
                                        <th>البنك - الفرع</th>
                                        <th>رقم الحساب</th>
                                        <th>؟الأساسي</th>
                                        <th>الحدث</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($accounts as $account)
                                    <tr id="row_{{$account->id}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$account->employee->name}}</td>
                                        <td>{{$account->bank->name . " - " . $account->bank->branch}}</td>
                                        <td>{{$account->account_number}}</td>
                                        @if ($account->default == 1)
                                            <td>الأساسي</td>
                                        @else
                                            <td>---</td>
                                        @endif
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @can('update', 'App\\Models\Bank')
                                                    <button type="button" class="dropdown-item editItem" style="margin: 0.5rem -0.75rem; text-align: right;" data-id="{{$account->id}}">
                                                        <i class="ti ti-pencil me-1"></i>تعديل
                                                    </button>                                                    
                                                    @endcan
                                                    @can('delete', 'App\\Models\Bank')
                                                    <button type="button" class="dropdown-item delItem" style="margin: 0.5rem -0.75rem; text-align: right;" data-id="{{$account->id}}">
                                                        <i class="ti ti-trash me-1"></i>حذف
                                                    </button> 
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
                </div> <!-- simple table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->




    @can('create', 'App\\Models\Bank')
    <div class="modal fade" id="addItem" tabindex="-1" role="dialog" aria-labelledby="addItemLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addItemLabel">إضافة بنك جديد</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('dashboard.accounts.store')}}" method="post" class="col-12">
                        @csrf
                        <div class="row">
                            <div class="form-group p-3 col-12">
                                <label for="gender">رقم الموظف</label>
                                <div class="input-group mb-3">
                                    <x-form.input name="employee_id" placeholder="0" readonly  />
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#searchEmployee">
                                            <i class="fa-solid fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group p-3 col-12">
                                <label for="bank_id">البنك - الفرع</label>
                                <select class="form-select" id="bank_id" name="bank_id" required>
                                    <option selected>عرض القيم المتوفرة</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{$bank['id']}}">{{$bank['name'] . " - " . $bank['branch'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group p-3 col-6">
                                <x-form.input maxlength="9" label="رقم الحساب" name="account_number" placeholder="4000000" required/>
                            </div>
                            <div class="form-group p-3 col-6">
                                <label for="default">الإفتراضي</label>
                                <select class="form-select" id="default" name="default" required>
                                    <option  value="1" >نعم</option>
                                    <option value="0" selected>لا</option>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">
                                    اضافة
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endcan
    @can('update', 'App\\Models\Bank')
    <div class="modal fade" id="editItem" tabindex="-1" role="dialog" aria-labelledby="editItemLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemLabel">تعديل النسبة الحالية</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dashboard.accounts.update', 'id') }}" method="post" class="col-12">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id_edit">
                        <div class="row">
                            <div class="form-group p-3 col-12">
                                <label for="gender">رقم الموظف</label>
                                <div class="input-group mb-3">
                                    <x-form.input name="employee_id" id="employee_id_edit" placeholder="0" readonly  />
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchEmployee">
                                            <i class="fa-solid fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group p-3 col-12">
                                <label for="bank_id">البنك - الفرع</label>
                                <select class="form-select" id="bank_id_edit" name="bank_id" required>
                                    <option selected>عرض القيم المتوفرة</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{$bank['id']}}">{{$bank['name'] . " - " . $bank['branch'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group p-3 col-6">
                                <x-form.input maxlength="9" id="account_number_edit" label="رقم الحساب" name="account_number" placeholder="4000000" required/>
                            </div>
                            <div class="form-group p-3 col-6">
                                <label for="default">الإفتراضي</label>
                                <select class="form-select" id="default_edit" name="default" required>
                                    <option  value="1" >نعم</option>
                                    <option value="0" selected>لا</option>
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">
                                    تعديل
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endcan

    <div class="modal fade" id="searchEmployee" tabindex="-2" role="dialog" aria-labelledby="searchEmployeeLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchEmployeeLabel">البحث عن الموظفين</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="row mt-3">
                            <div class="form-group col-md-6">
                                <x-form.input name="employee_id_search" label="رقم الهوية" type="number" class="employee_fields_search"
                                    placeholder="إملا رقم هوية الموظف"  />
                            </div>
                            <div class="form-group col-md-6">
                                <x-form.input name="employee_name_search" label="إسم الموظف" type="text" class="employee_fields_search"
                                    placeholder="إملا إسم الموظف" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">رقم الموظف</th>
                                    <th scope="col">رقم الهوية</th>
                                    <th scope="col">الإسم</th>
                                    <th scope="col">تاريخ الميلاد</th>
                                </tr>
                            </thead>
                            <tbody id="table_employee">
                                <tr>
                                    <td colspan='4'>يرجى تعبئة البيانات</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
    <script src="{{asset('js/plugins/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        const csrf_token = "{{csrf_token()}}";
        const app_link = "{{config('app.url')}}/";
    </script>
    <script src="{{ asset('js/custom/getEmployee.js') }}"></script>
    <script>
        $('#dataTable-1').DataTable(
        {
            autoWidth: true,
            "lengthMenu": [
            [-1],
            ["جميع"]
            ]
        });
    </script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.editItem', function () { // تفويض الحدث
                let id = $(this).data('id'); // التأكد من data-id                    
                $.ajax({
                    url: `{{ route('dashboard.accounts.edit', ':id') }}`.replace(':id', id),
                    method: 'GET',
                    success: function (response) {
                        $('#id_edit').val(response.id);
                        $('#employee_id_edit').val(response.employee_id);
                        $('#bank_id_edit').val(response.bank_id);
                        $('#account_number_edit').val(response.account_number);
                        $('#default_edit').val(response.default);
                        $('#editItem').modal('show');
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
            $(document).on('click', '.delItem', function () { // تفويض الحدث
                let id = $(this).data('id'); // التأكد من data-id
                if(confirm('هل تريد حذف هذا العنصر؟')){
                    $.ajax({
                        url: `{{ route('dashboard.accounts.destroy', ':id') }}`.replace(':id', id),
                        method: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            alert('تم حذف العنصر بنجاح');
                            $('#row_'+id).remove();
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                }
            });
        });

    </script>
    @endpush
</x-front-layout>
