@if (session()->has($type))
    <div class="col-12 mb-4">
        <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
            @if (is_array(session($type)))
                {{ implode(', ', session($type)) }}
            @else
                {{ session($type) }}
            @endif
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div> <!-- /. col -->
@endif