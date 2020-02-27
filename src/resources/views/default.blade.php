@php
    $title = ($title) ?? 'Endereço';
    $collection = ($collection) ?? 'default'
@endphp

<div class="card-header bg-gray-lightest">
    <h3 class="card-title">{{ $title }}</h3>
</div>

<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group  ">
                <label for="{{ $collection }}-full-street">
                    Preencha com o endereço completo e escolha uma das opções
                </label>
                <div class="input-group ">
                    <input id="{{ $collection }}-full-street" required="true" autocomplete="off"
                           class="js-full-street form-control"
                           name="address[{{ $collection }}][full_street]" type="text"
                           value="{{ optional($model)->address($collection)->full_street ?? null }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary js-search-address" type="button">
                            Procurar endereço
                        </button>
                    </div>
                    <div class="invalid-tooltip">
                        O campo preencha com o endereço completo e escolha uma das opções é obrigatório
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div id="{{ $collection }}-map" style="width: 100%; height: 705px;" class="js-map d-block"></div>
            </div>
        </div>
        <div class="col-md-6">
            {{ Form::bsAddressText('CEP', $collection, 'zipcode', optional($model)->address($collection)->zipcode ?? '', ['class' => 'js-zipcode mask-zipcode', 'required' => true]) }}
            {{ Form::bsAddressText('Endereço', $collection, 'street', optional($model)->address($collection)->street ?? '', ['class' => 'js-street', 'required' => true]) }}
            {{ Form::bsAddressText('Número', $collection, 'number', optional($model)->address($collection)->number ?? '', ['class' => 'js-number', 'required' => true]) }}
            {{ Form::bsAddressText('Complemento', $collection, 'complement', optional($model)->address($collection)->complement ?? '', ['class' => 'js-complement', 'required' => false]) }}
            {{ Form::bsAddressText('Bairro', $collection, 'neighborhood', optional($model)->address($collection)->neighborhood ?? '', ['class' => 'js-neighborhood', 'required' => true]) }}
            {{ Form::bsAddressText('Cidade', $collection, 'city', optional($model)->address($collection)->city ?? '', ['class' => 'js-city', 'required' => true]) }}
            {{ Form::bsAddressText('Estado', $collection, 'state', optional($model)->address($collection)->state ?? '', ['class' => 'js-state', 'required' => true]) }}
            {{ Form::bsAddressText('Estado (Sigla) ', $collection, 'state_initials', optional($model)->address($collection)->state_initials ?? '', ['class' => 'js-state-initials', 'required' => true]) }}
            {{ Form::bsAddressText('Latitude', $collection, 'latitude', optional($model)->address($collection)->latitude ?? '', ['class' => 'js-latitude', 'required' => true]) }}
            {{ Form::bsAddressText('Longitude', $collection, 'longitude', optional($model)->address($collection)->longitude ?? '', ['class' => 'js-longitude', 'required' => true]) }}
        </div>
    </div>
</div>
