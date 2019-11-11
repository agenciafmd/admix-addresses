@php
  $name = ($name) ?? 'default';
@endphp

<div class="card-header">
  <strong>Endereço</strong>
</div>
<div class="card-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group  ">
        <label for="address[default][full_street]">
          Preencha com o endereço completo e escolha uma das opções
        </label>
        <div class="input-group ">
          <input id="fullStreet" required="" autocomplete="off" class="form-control" name="address[default][full_street]" type="text" value="{{ optional($model)->address($name)->full_street ?? null }}">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary search-address" type="button">Procurar endereço</button>
          </div>
          <div class="invalid-tooltip">
            O campo preencha com o endereço completo e escolha uma
            das opções é obrigatório
          </div>
        </div>
      </div>
      <div class="form-group">
        <div id="map" style="width: 100%; height: 705px;" class="d-block"></div>
      </div>
    </div>
    <div class="col-md-6">
      {{ Form::bsText('CEP', "address[{$name}][zipcode]", optional($model)->address($name)->zipcode ?? '', ['required' => true, 'class' => 'mask-zipcode']) }}
      {{ Form::bsText('Endereço', "address[{$name}][street]", optional($model)->address($name)->street ?? '', ['required' => true]) }}
      {{ Form::bsText('Número', "address[{$name}][number]", optional($model)->address($name)->number ?? '', ['required' => true]) }}
      {{ Form::bsText('Complemento', "address[{$name}][complement]", optional($model)->address($name)->complement ?? '', ['required' => false]) }}
      {{ Form::bsText('Bairro', "address[{$name}][neighborhood]", optional($model)->address($name)->neighborhood ?? '', ['required' => true]) }}
      {{ Form::bsText('Cidade', "address[{$name}][city]", optional($model)->address($name)->city ?? '', ['required' => true]) }}
      {{ Form::bsText('Estado', "address[{$name}][state]", optional($model)->address($name)->state ?? '', ['required' => true]) }}
      {{ Form::bsText('Estado (Sigla) ', "address[{$name}][state_initials]", optional($model)->address($name)->state_initials ?? '', ['required' => true]) }}
      {{ Form::bsText('Latitude', "address[{$name}][latitude]", optional($model)->address($name)->latitude ?? '', ['required' => true]) }}
      {{ Form::bsText('Longitude', "address[{$name}][longitude]", optional($model)->address($name)->longitude ?? '', ['required' => true]) }}
    </div>
  </div>
</div>

@push('scripts')
  <script>
    var markers = [];
    var map;

    function initAutocomplete() {
      $('input[name="address[default][full_street]"]').on(
          'keydown',
          function (e) {
            if (e.keyCode === 13) {
              e.preventDefault();
              $('.search-address').trigger('click');
            }
          },
      );

      map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: -20.811766014404466, lng: -49.376224517791 },
        zoom: 18,
        mapTypeId: 'roadmap',
      });

      let lat = $('input[name="address[default][latitude]"]').val();
      let lng = $('input[name="address[default][longitude]"]').val();

      if (lat !== '' && lng !== '') {
        // set default marker para não bugar o que já foi cadastrado
        var latlng = new google.maps.LatLng(lat, lng);
        map.setCenter(latlng);
        markers.push(new google.maps.Marker({
          map: map,
          draggable: true,
          position: latlng,
        }));

        markers.forEach(function (marker) {
          new google.maps.event.addListener(marker, 'dragend', function () {
            geocodePosition(marker);
          });
        });
        // fim default marker para não bugar o que já foi cadastrado
      }

      $('.search-address').on('click', function () {
        showAddress($('input[name="address[default][full_street]"]').val());
      });
    }

    function showAddress(address) {
      markers.forEach(function (marker) {
        marker.setMap(null);
      });
      markers = [];

      var geocoder = new google.maps.Geocoder();
      geocoder.geocode({ 'address': address }, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
          map.setCenter(results[0].geometry.location);
          map.setZoom(18);

          markers.push(new google.maps.Marker({
            map: map,
            draggable: true,
            title: 'Arraste para o local correto',
            position: results[0].geometry.location,
          }));

          markers.forEach(function (marker) {
            geocodePosition(marker);
            new google.maps.event.addListener(marker, 'dragend', function () {
              geocodePosition(marker);
            });
          });

        } else {
          alert('Falha no carregamento do mapa: ' + status);
        }
      });
    }

    function fillAddress(location) {
      $('input[name="address[default][zipcode]"]').val(location.zipcode);
      $('input[name="address[default][street]"]').val(location.street);
      $('input[name="address[default][number]"]').val(location.number);
      $('input[name="address[default][neighborhood]"]').val(location.neighborhood);
      $('input[name="address[default][city]"]').val(location.city);
      $('input[name="address[default][state]"]').val(location.state);
      $('input[name="address[default][state_initials]"]').val(location.state_initials);
      $('input[name="address[default][latitude]"]').val(location.latitude);
      $('input[name="address[default][longitude]"]').val(location.longitude);
    }

    function geocodePosition(marker) {
      let pos = marker.getPosition();
      let geocoder = new google.maps.Geocoder();
      geocoder.geocode({
        latLng: pos,
      }, function (responses) {
        if (responses && responses.length > 0) {

          $('input[name="address[default][full_street]"]')
              .val(responses[0].formatted_address);

          let storableLocation = {};

          storableLocation.latitude = pos.lat();
          storableLocation.longitude = pos.lng();

          for (let ac = 0; ac < responses[0].address_components.length; ac++) {
            let component = responses[0].address_components[ac];

            if (component.types.includes('street_number')) {
              storableLocation.number = component.long_name;
            }
            else if (component.types.includes('route')) {
              storableLocation.street = component.long_name;
            }
            else if (component.types.includes('sublocality')) {
              storableLocation.neighborhood = component.long_name;
            }
            else if (component.types.includes('locality')) {
              storableLocation.city = component.long_name;
            }
            else if (component.types.includes('administrative_area_level_1')) {
              storableLocation.state = component.long_name;
              storableLocation.state_initials = component.short_name;
            }
            else if (component.types.includes('postal_code')) {
              storableLocation.zipcode = component.long_name;
            }
            else if (component.types.includes('country')) {
              storableLocation.country = component.long_name;
              storableLocation.registered_country_iso_code = component.short_name;
            }
          }

          fillAddress(storableLocation);
        } else {
          console.log('Não foi possivel encontrar o endereço para este local');
        }
      });
    }

  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.api_key') }}&libraries=places&callback=initAutocomplete" async defer></script>
@endpush