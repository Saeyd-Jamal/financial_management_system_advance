<x-front-layout>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول البنوك</h2>
                    <p class="card-text">هنا يتم عرض بيانات البنوك المتعامل معها.</p>
                </div>
                <div class="col-auto">
                    @can('create', 'App\\Models\Bank')
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
                            <!-- table -->
                            <table class="table  table-bordered  table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>مكان الفرع</th>
                                        <th>رقم الفرع</th>
                                        <th>الحدث</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($banks as $bank)
                                    <tr id="row_{{$bank->id}}">
                                        <td>{{$bank->id}}</td>
                                        <td>{{$bank->name}}</td>
                                        <td>{{$bank->branch}}</td>
                                        <td>{{$bank->branch_number}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @can('update', 'App\\Models\Bank')
                                                    <button type="button" class="dropdown-item editItem" style="margin: 0.5rem -0.75rem; text-align: right;" data-id="{{$bank->id}}">
                                                        <i class="ti ti-pencil me-1"></i>تعديل
                                                    </button>                                                    
                                                    @endcan
                                                    @can('delete', 'App\\Models\Bank')
                                                    <button type="button" class="dropdown-item delItem" style="margin: 0.5rem -0.75rem; text-align: right;" data-id="{{$bank->id}}">
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
                    <form action="{{route('dashboard.banks.store')}}" method="post" class="col-12">
                        @csrf
                        <div class="row">
                            <div class="form-group p-3 col-12">
                                <x-form.input label="إسم البنوك"  name="name" placeholder="فلسطين ....." required/>
                            </div>
                            <div class="form-group p-3 col-12">
                                <x-form.input label="مكان الفرع"  name="branch" placeholder="دير البلح ..." required/>
                            </div>
                            <div class="form-group p-3 col-12">
                                <x-form.input type="number" min="0" label="رقم الفرع" name="branch_number" placeholder="500." required/>
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
                    <form action="{{ route('dashboard.banks.update', 'id') }}" method="post" class="col-12">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id_edit">
                        <div class="row">
                            <div class="form-group p-3 col-12">
                                <x-form.input label="إسم البنوك" name="name" id="name_edit" placeholder="فلسطين ....." required/>
                            </div>
                            <div class="form-group p-3 col-12">
                                <x-form.input label="مكان الفرع"  name="branch" id="branch_edit" placeholder="دير البلح ..." required/>
                            </div>
                            <div class="form-group p-3 col-12">
                                <x-form.input type="number" min="0" label="رقم الفرع" name="branch_number" id="branch_number_edit" placeholder="500." required/>
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

    @push('scripts')
        <script>
            const csrf_token = "{{csrf_token()}}";
            $(document).ready(function () {
                $(document).on('click', '.editItem', function () { // تفويض الحدث
                    let id = $(this).data('id'); // التأكد من data-id                    
                    $.ajax({
                        url: `{{ route('dashboard.banks.edit', ':id') }}`.replace(':id', id),
                        method: 'GET',
                        success: function (response) {
                            $('#id_edit').val(response.id);
                            $('#name_edit').val(response.name);
                            $('#branch_edit').val(response.branch);
                            $('#branch_number_edit').val(response.branch_number);
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
                            url: `{{ route('dashboard.banks.destroy', ':id') }}`.replace(':id', id),
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
