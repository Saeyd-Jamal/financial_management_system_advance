@props([
    'type' => 'number',
    'value' => '',
    'name',
])
<style>
    input{
        text-align: center;
        padding: 4px 6px !important;
        height: auto !important;
        border: none !important;
        border-radius: 0 !important;
    }
</style>

<input
    type="{{$type}}"
    id="{{$name}}"
    name="{{$name}}"
    step="0.01"
    min="0"
    value="{{old($name, $value)}}"
    {{$attributes->class([
        'form-control',
        'entry',
        'is-invalid' => $errors->has($name)
    ])}}
/>

{{-- Validation --}}
@error($name)
    <div class="invalid-feedback">
        {{$message}}
    </div>
@enderror
