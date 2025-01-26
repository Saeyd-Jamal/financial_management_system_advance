<x-front-layout>
    <div class="col-12 mb-4">
        <div class="alert alert-danger alert-dismissible fade show" style="display: none;" id="alerts">
        </div>
    </div> <!-- /. col -->
    <form action="{{ route('dashboard.employees.store', $employee->id) }}" id="myForm" method="post" class="col-12 mt-3">
        @csrf
        @include('dashboard.employees._form')
    </form>
</x-front-layout>
