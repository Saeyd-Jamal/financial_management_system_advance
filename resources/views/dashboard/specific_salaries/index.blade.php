<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/custom/stickyTable.css') }}">

        <style>
            table{
                height: 100% !important;
            }
            thead
            {
                background: #383848 !important;
            }
            th
            {
                /* color: #1E1E1E !important; */
                padding: 12px 33px !important;
            }
            td{
                padding: 3px 15px !important;
                /* color: #1E1E1E !important; */
            }
            input{
                /* padding: 0px 11px !important; */
            }
            table.sticky thead {
                top: 73px;
            }
        </style>
    @endpush
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="btn nav-link active" id="pills-private-tab" data-bs-toggle="pill" data-bs-target="#pills-private" type="button" role="tab" aria-controls="pills-home" aria-selected="true">خاص</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="btn nav-link" id="pills-riyadh-tab" data-bs-toggle="pill" data-bs-target="#pills-riyadh" type="button" role="tab" aria-controls="pills-riyadh" aria-selected="false">رياض</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="btn nav-link" id="pills-fasle-tab" data-bs-toggle="pill" data-bs-target="#pills-fasle" type="button" role="tab" aria-controls="pills-fasle" aria-selected="false">فصلي</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="btn nav-link" id="pills-interim-tab" data-bs-toggle="pill" data-bs-target="#pills-interim" type="button" role="tab" aria-controls="pills-interim" aria-selected="false">مؤقت</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="btn nav-link" id="pills-daily-tab" data-bs-toggle="pill" data-bs-target="#pills-daily" type="button" role="tab" aria-controls="pills-daily" aria-selected="false">يومي</button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-private" role="tabpanel" aria-labelledby="pills-private-tab">
            <div class="row align-items-center mb-2">
                <!-- Bordered table -->
                <div class="col-md-12 my-4">
                    <div class="row align-items-center mb-2">
                        <div class="col">
                            <h2 class="mb-2 page-title">جدول رواتب الموظفين الخاص</h2>
                            <p class="card-text">يمكنك تعديل الرواتب الموظفين الخاص من هنا</p>
                        </div>
                        <div class="col-auto">
                            <span class="btn btn-primary "> عدد الموظفين : {{$employees_private->count()}}</span>
                        </div>
                    </div>
                    <div class="card shadow">
                        <form action="{{route('dashboard.specific_salaries.privateCreate')}}" method="post">
                            @csrf
                        <div class="card-body">
                            <table class="table table-bordered table-hover mb-0 mt-2 sticky" id="table-private" style="display: table;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم الموظف</th>
                                        <th>مكان العمل</th>
                                        <th>الراتب</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group col-md-4">
                                                    <x-form.input type="search" name="name-private" class="name-search" data-table='private' label="اسم الموظف" />
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                @can('create', 'App\\Models\SpecificSalary')
                                                    <button class="btn btn-info mb-2" type="submit">
                                                        <i class="fe fe-download"></i>
                                                        <span>حفظ الرواتب</span>
                                                    </button>
                                                @endcan
                                            </div>
                                        </div>
                                        @foreach ($employees_private as $employee)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$employee->name}}</td>
                                            <td>{{$employee->workData->workplace}}</td>
                                            <td>
                                                <div class="input-group">
                                                    <x-form.input required type="number" value="{{$employee->specificSalaries()->where('month', $month)->first()->salary ?? 0}}" min="0" name="salaries[{{$employee->id}}]" placeholder="1000" class="d-inline" />
                                                    <span class="input-group-text">₪</span>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-riyadh" role="tabpanel" aria-labelledby="pills-riyadh-tab">
            <div class="row align-items-center mb-2">
                <!-- Bordered table -->
                <div class="col-md-12 my-4">
                    <div class="row align-items-center mb-2">
                        <div class="col">
                            <h2 class="mb-2 page-title">جدول رواتب لموظفين الرياض</h2>
                            <p class="card-text">يمكنك تعديل الرواتب الموظفين الرياض من هنا</p>
                        </div>
                        <div class="col-auto">
                            <span class="btn btn-primary "> عدد الموظفين : {{$employees_riyadh->count()}}</span>
                        </div>
                    </div>
                    <div class="card shadow">
                        <form action="{{route('dashboard.specific_salaries.riyadhCreate')}}" method="post">
                            @csrf
                        <div class="card-body">
                            <table class="table table-bordered table-hover mb-0 mt-2 sticky" id="table-riyadh" style="display: table;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم الموظف</th>
                                        <th>مكان العمل</th>
                                        <th>الراتب</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group col-md-4">
                                                    <x-form.input type="search" name="name-riyadh" class="name-search" data-table='riyadh' label="اسم الموظف" />
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                @can('create', 'App\\Models\SpecificSalary')
                                                <button class="btn btn-info mb-2" type="submit">
                                                    <i class="fe fe-download"></i>
                                                    <span>حفظ الرواتب</span>
                                                </button>
                                                @endcan
                                            </div>
                                        </div>
                                        @foreach ($employees_riyadh as $employee)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$employee->name}}</td>
                                            <td>{{$employee->workData->workplace}}</td>
                                            <td>
                                                <div class="input-group">
                                                    <x-form.input required type="number" value="{{$employee->specificSalaries()->where('month', $month)->first()->salary ?? 0}}" min="0" name="salaries[{{$employee->id}}]" placeholder="1000" class="d-inline" />
                                                    <span class="input-group-text">₪</span>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-fasle" role="tabpanel" aria-labelledby="pills-fasle-tab">
            <div class="row align-items-center mb-2">
                <!-- Bordered table -->
                <div class="col-md-12 my-4">
                    <div class="row align-items-center mb-2">
                        <div class="col">
                            <h2 class="mb-2 page-title">جدول رواتب الموظفين الفصلي</h2>
                            <p class="card-text">يمكنك تعديل الرواتب الموظفين الفصلي من هنا</p>
                        </div>
                        <div class="col-auto">
                            <span class="btn btn-primary"> عدد الموظفين : {{$employees_fasle->count()}}</span>
                        </div>
                    </div>
                    <div class="card shadow">
                        <form action="{{route('dashboard.specific_salaries.fasleCreate')}}" method="post">
                            @csrf
                        <div class="card-body">
                            <table class="table table-bordered table-hover mb-0 mt-2 sticky" id="table-fasle" style="display: table;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم الموظف</th>
                                        <th>مكان العمل</th>
                                        <th>الراتب</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group col-md-4">
                                                    <x-form.input type="search" name="name-fasle" class="name-search" data-table='fasle' label="اسم الموظف" />
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                @can('create', 'App\\Models\SpecificSalary')
                                                <button class="btn btn-info mb-2" type="submit">
                                                    <i class="fe fe-download"></i>
                                                    <span>حفظ الرواتب</span>
                                                </button>
                                                @endcan
                                            </div>
                                        </div>
                                        @foreach ($employees_fasle as $employee)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$employee->name}}</td>
                                            <td>{{$employee->workData->workplace}}</td>
                                            <td>
                                                <div class="input-group">
                                                    <x-form.input required type="number" value="{{$employee->specificSalaries()->where('month', $month)->first()->salary ?? 0}}" min="0" name="salaries[{{$employee->id}}]" placeholder="1000" class="d-inline" />
                                                    <span class="input-group-text">₪</span>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-interim" role="tabpanel" aria-labelledby="pills-interim-tab">
            <div class="row align-items-center mb-2">
                <!-- Bordered table -->
                <div class="col-md-12 my-4">
                    <div class="row align-items-center mb-2">
                        <div class="col">
                            <h2 class="mb-2 page-title">جدول رواتب الموظفين المؤقتين</h2>
                            <p class="card-text">يمكنك تعديل الرواتب الموظفين المؤقتين من هنا</p>
                        </div>
                        <div class="col-auto">
                            <span class="btn btn-primary "> عدد الموظفين : {{$employees_interim->count()}}</span>
                        </div>
                    </div>
                    <div class="card shadow">
                        <form action="{{route('dashboard.specific_salaries.interimCreate')}}" method="post">
                            @csrf
                        <div class="card-body">
                            <table class="table table-bordered table-hover mb-0 mt-2 sticky" id="table-interim" style="display: table;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم الموظف</th>
                                        <th>مكان العمل</th>
                                        <th>الراتب</th>
                                    </tr>
                                </thead>
                                <tbody>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group col-md-4">
                                                    <x-form.input type="search" name="name-interim" class="name-search" data-table='interim' label="اسم الموظف" />
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                @can('create', 'App\\Models\SpecificSalary')
                                                <button class="btn btn-info mb-2" type="submit">
                                                    <i class="fe fe-download"></i>
                                                    <span>حفظ الرواتب</span>
                                                </button>
                                                @endcan
                                            </div>
                                        </div>
                                        @foreach ($employees_interim as $employee)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$employee->name}}</td>
                                            <td>{{$employee->workData->workplace}}</td>
                                            <td>
                                                <div class="input-group">
                                                    <x-form.input required type="number" value="{{$employee->specificSalaries()->where('month', $month)->first()->salary ?? 0}}" min="0" name="salaries[{{$employee->id}}]" placeholder="1000" class="d-inline" />
                                                    <span class="input-group-text">₪</span>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-daily" role="tabpanel" aria-labelledby="pills-daily-tab">
            <div class="row align-items-center mb-2">
                <!-- Bordered table -->
                <div class="col-md-12 my-4">
                    <div class="row align-items-center mb-2">
                        <div class="col">
                            <h2 class="mb-2 page-title">جدول رواتب الموظفين اليومين</h2>
                            <p class="card-text">يمكنك تعديل الرواتب الموظفين اليومين من هنا</p>
                        </div>
                        <div class="col-auto">
                            <span class="btn btn-primary "> عدد الموظفين : {{$employees_daily->count()}}</span>

                        </div>
                    </div>
                    <div class="card shadow">
                        <form action="{{route('dashboard.specific_salaries.dailyCreate')}}" method="post">
                            @csrf
                        <div class="card-body">
                            <table class="sticky table table-bordered table-hover mb-0 mt-2" style="box-sizing: border-box; display: table" id="table-daily" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم الموظف</th>
                                        <th>مكان العمل</th>
                                        <th>عدد الأيام</th>
                                        <th>تكلفة اليوم</th>
                                        <th>الراتب</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group col-md-4">
                                                    <x-form.input type="search" name="name-daily" class="name-search" data-table='daily' label="اسم الموظف" />
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                @can('create', 'App\\Models\SpecificSalary')
                                                <button class="btn btn-info mb-2" type="submit">
                                                    <i class="fe fe-download"></i>
                                                    <span>حفظ الرواتب</span>
                                                </button>
                                                @endcan
                                            </div>
                                        </div>
                                        @foreach ($employees_daily as $employee)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$employee->name}}</td>
                                            <td>{{$employee->workData->workplace}}</td>
                                            <td>
                                                <x-form.input type="number" class="d-inline daily_fields" data-id="{{$employee->id}}" name="number_of_days[{{$employee->id}}]"  data-name="number_of_days" value="{{$employee->specificSalaries()->where('month', $month)->first()->number_of_days ?? 0}}" min="0" placeholder="0."/>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <x-form.input required type="number" data-id="{{$employee->id}}" data-name="today_price" value="{{$employee->specificSalaries()->where('month', $month)->first()->today_price ?? 0}}" min="0" name="today_price[{{$employee->id}}]" placeholder="1000" class="d-inline daily_fields" min="0" />
                                                    <span class="input-group-text">₪</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" id="{{$employee->id}}" name="salaries[{{$employee->id}}]" value="{{$employee->specificSalaries()->where('month', $month)->first()->salary ?? 0}}" class="form-control d-inline daily_fields" data-name="salaries" data-id="{{$employee->id}}" min="0" placeholder="0." readonly>
                                                    <span class="input-group-text">₪</span>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            @push('scripts')
            <script src="{{ asset('js/custom/dailyEmployee.js') }}"></script>
            @endpush
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function(){
                // table-private , data-table="private"
                $('.name-search').on('input', function () {
                    let searchTerm = $(this).val().toLowerCase();
                    let table = $(this).data('table');
                    $('#table-'+table +' tbody tr').each(function() {
                        let employeeName = $(this).find('td').eq(1).text().toLowerCase(); // البحث في العمود الأول
                        if (employeeName.indexOf(searchTerm) === -1) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });
                });
            });
        </script>
    @endpush
</x-front-layout>
