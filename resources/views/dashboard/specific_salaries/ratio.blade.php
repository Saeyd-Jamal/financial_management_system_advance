<x-front-layout>
    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/custom/stickyTable.css') }}">
    <style>
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
    <div class="row align-items-center mb-2">
        <!-- Bordered table -->
        <div class="col-md-12 my-4">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول رواتب الموظفين النسبة</h2>
                    <p class="card-text">يمكنك تعديل الرواتب الموظفين النسبة من هنا</p>
                </div>
                <div class="col-auto">
                    <span class="btn btn-primary "> عدد الموظفين : {{$employees->count()}}</span>
                </div>
            </div>
            <div class="card shadow">
                <form action="{{route('dashboard.specific_salaries.ratioCreate')}}" method="post">
                    @csrf
                    <div class="card-header">
                        <div class="row">
                            <div class="col d-flex gap-2">
                                <div class="form-group col-md-3">
                                    <x-form.input type="month" min="2024-07" :value="$month" name="month" label="شهر الراتب المطلوب" />
                                </div>
                                <div class="form-group col-md-3">
                                    <x-form.input type="search" name="name" label="اسم الموظف" />
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
                    </div>
                    <div class="card-body">
                        <table id="employees-table" class="table table-bordered table-hover mb-0 sticky" style="display: table; height: 100%;">
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
                                    @foreach ($employees as $employee)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$employee->name}}</td>
                                        <td>{{$employee->workData->workplace}}</td>
                                        <td>
                                            <div class="input-group">
                                                <x-form.input type="number" name="salaries[{{$employee->id}}]" value="{{$employee->specificSalaries()->where('month', $month)->first()->salary ?? 0}}" min="0" class="d-inline" placeholder="0."/>
                                                <span class="input-group-text">₪</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </div>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(document).ready(function(){
            const app_link = "{{config('app.url')}}/";
            $('#month').on('input', function () {
                let month = $('#month').val();
                $.ajax({
                    url:  "{{ route('dashboard.specific_salaries.getRatio') }}",
                    method: "POST",
                    data: {
                        month: month,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        $("tbody").empty();
                        if (response.length != 0) {
                            for (let index = 0; index < response.length; index++) {
                                let specificSalaries = 0;
                                response[index]['specific_salaries'].forEach(element => {
                                    if (element['month'] === month) {
                                        specificSalaries = element['salary'];
                                    }
                                });
                                $("tbody").append(`
                                            <tr>
                                                <td>` + (index + 1)  + `</td>
                                                <td>` + response[index]['name'] + `</td>
                                                <td>` + response[index]['work_data']['workplace'] + `</td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="number" id="salaries[`+ response[index]['id'] +`]" name="salaries[`+ response[index]['id'] +`]" value="` + specificSalaries + `" class="form-control d-inline" min="0" placeholder="0.">
                                                        <span class="input-group-text">₪</span>
                                                    </div>
                                                </td>
                                            </tr>`);
                            }
                        }else{
                            $("tbody").append(
                                '<tr><td colspan="4" class="text-center text-danger">لا يوجد بيانات لعرضها"></td></tr>'
                            );
                        }
                    },
                    error: function (response) {
                        console.error(response);
                    }
                });
            });
            $('#name').on('input', function() {
                let searchTerm = $(this).val().toLowerCase();
                $('#employees-table tbody tr').each(function() {
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
