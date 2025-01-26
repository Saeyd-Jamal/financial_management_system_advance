<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <div class="row align-items-center mb-2">
        <div class="col">
            <h2 class="mb-2 page-title">إنشاء صرف جديد للموظف : <span id="employee_name"></span> </h2>
        </div>
        <div class="col-auto">
            <a href="{{route('dashboard.exchanges.chooseMany')}}" class="btn btn-info">
                الصرف لعدة موظفين
            </a>
        </div>
    </div>
    <div class="row">
        <form action="{{route('dashboard.exchanges.store')}}" method="post" class="col-12">
            @csrf
            @include("dashboard.exchanges._form")
        </form>
    </div>

<div class="modal fade" id="searchEmployee" tabindex="-5" role="dialog" aria-labelledby="searchEmployeeLabel"  data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchEmployeeLabel">البحث عن الموظف</h5>
                <button type="button" class="close d-none" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <a href="{{route('dashboard.exchanges.chooseMany')}}" class="btn btn-info">
                    الصرف لعدة موظفين
                </a>
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
            <div class="modal-footer">
                <a href="{{route('dashboard.exchanges.index')}}" class="btn btn-secondary">
                    العودة للخلف
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const csrf_token = "{{csrf_token()}}";
        const app_link = "{{config('app.url')}}/";
    </script>
    <script>
        $(document).ready(function () {
            $('#searchEmployee').modal('toggle');
        })
    </script>
@endpush

</x-front-layout>
