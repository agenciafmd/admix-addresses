@php
    $formControl = 'form-control';

    if(strpos(request()->route()->getName(), 'show') !== false) {
        $formControl = 'form-control-plaintext';
        $attributes['disabled'] = true;
    }

    $attributes['class'] = $formControl . ' ' . ($errors->admix->has("address.{$collection}.{$name}") ? 'is-invalid ' : '') . (($attributes['class']) ?? '');
@endphp

<div class="form-group">
    {{ Form::label($label, null, ['for' => Str::slug($collection . ' '. $name)]) }}
    {{ Form::text("address[$collection][$name]", $value, $attributes) }}

    <div class="invalid-feedback">
        @if($errors->admix->has("address.{$collection}.{$name}"))
            {{ ucfirst($errors->admix->first("address.{$collection}.{$name}")) }}
        @else
            o campo {{ strtolower($label) }} é obrigatório
        @endif
    </div>

    @if($helper)
        <small id="{{ $name }}Help" class="pl-0 mt-1 form-text col text-muted">
            {{ str_limit($helper, 60, '') }}
        </small>
    @endif
</div>