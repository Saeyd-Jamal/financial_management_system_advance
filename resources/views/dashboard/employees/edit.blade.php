<x-front-layout>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="alert alert-danger alert-dismissible fade show" style="display: none;" id="alerts">
            </div>
        </div> <!-- /. col -->
        <div class="col-12 mb-4">
            <div class="alert alert-success alert-dismissible fade show" style="display: none;" id="alert-success">
            </div>
        </div> <!-- /. col -->
    </div>
    <form action="{{route('dashboard.employees.update',$employee->id)}}" enctype="multipart/form-data"  id="myForm" method="post" class="col-12  mt-3">
        @csrf
        @method('PUT')
        @include("dashboard.employees._form")
    </form>
</x-front-layout>
