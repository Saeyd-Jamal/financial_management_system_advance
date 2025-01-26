<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <div class="row">
        <form action="{{route('exchanges.manyStore')}}" method="post" class="col-12">
            @csrf
            @include("dashboard.exchanges._formMany",['employees_select' => $employees_select])
        </form>
    </div>
@push('scripts')
    <script>
        const csrf_token = "{{csrf_token()}}";
        const app_link = "{{config('app.url')}}/";
    </script>
    <script>
        // $(document).ready(function () {
        //     $('#searchEmployee').modal('toggle');
        // })
    </script>
@endpush

</x-front-layout>
