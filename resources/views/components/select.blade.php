<div class="mt-3">
    <select name="{{ $name }}" {{ $attributes }}>
    {{ $slot }}
</select>

<x-validation-error field="{{ $name }}"/>

</div>

