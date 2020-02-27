<script>
    function initAddresses() {

        let map = [];
        let markers = [];

        $('.js-map').each(function (index, element) {
            // console.log(element, index);
            let cardBody = $(element).parents('.card-body');

            $($(cardBody.find('.js-full-street'))).on(
                'keydown',
                function (e) {
                    if (e.keyCode === 13) {
                        e.preventDefault();
                        $(cardBody.find('.js-search-address')).trigger('click');
                    }
                },
            );

            map[index] = new google.maps.Map(document.getElementById($(cardBody.find('.js-map')).attr('id')), {
                center: {
                    lat: -20.811766014404466, lng: -49.376224517791
                },
                zoom: 18,
                mapTypeId: 'roadmap',
            });

            let lat = $(cardBody.find('.js-latitude')).val() || -20.811766014404466;
            let lng = $(cardBody.find('.js-longitude')).val() || -49.376224517791;

            if (lat !== '' && lng !== '') {
                // set default marker para não bugar o que já foi cadastrado
                var latlng = new google.maps.LatLng(lat, lng);
                map[index].setZoom(18);
                map[index].setCenter(latlng);
                markers[index] = new google.maps.Marker({
                    map: map[index],
                    draggable: true,
                    title: 'Arraste para o local correto',
                    animation: google.maps.Animation.DROP,
                    position: latlng,
                });
                markers[index].addListener('dragend', function () {
                    geocodePosition(markers[index], cardBody);
                });
                // fim default marker para não bugar o que já foi cadastrado
            }

            $(cardBody.find('.js-search-address')).on('click', function () {

                // remove marcador atual
                markers[index].setMap(null);

                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({'address': $($(cardBody).find('.js-full-street')).val()}, function (results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        map[index].setZoom(18);
                        map[index].setCenter(results[0].geometry.location);

                        markers[index] = new google.maps.Marker({
                            map: map[index],
                            draggable: true,
                            title: 'Arraste para o local correto',
                            animation: google.maps.Animation.DROP,
                            position: results[0].geometry.location,
                        });

                        geocodePosition(markers[index], cardBody);
                        markers[index].addListener('dragend', function () {
                            geocodePosition(markers[index], cardBody);
                        });
                    } else {
                        console.log('Falha no carregamento do mapa: ' + status);
                    }
                });
            });
        });

        function geocodePosition(marker, cardBody) {
            let pos = marker.getPosition();
            let geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                latLng: pos,
            }, function (responses) {
                if (responses && responses.length > 0) {

                    console.log(responses[0]);

                    $(cardBody.find('.js-full-street')).val(responses[0].formatted_address);

                    let storableLocation = {};

                    storableLocation.latitude = pos.lat();
                    storableLocation.longitude = pos.lng();

                    for (let ac = 0; ac < responses[0].address_components.length; ac++) {
                        let component = responses[0].address_components[ac];

                        if (component.types.includes('street_number')) {
                            storableLocation.number = component.long_name;
                        } else if (component.types.includes('route')) {
                            storableLocation.street = component.long_name;
                        } else if (component.types.includes('sublocality')) {
                            storableLocation.neighborhood = component.long_name;
                        } else if (component.types.includes('administrative_area_level_2')) {
                            storableLocation.city = component.long_name;
                        } else if (component.types.includes('administrative_area_level_1')) {
                            storableLocation.state = component.long_name;
                            storableLocation.state_initials = component.short_name;
                        } else if (component.types.includes('postal_code')) {
                            storableLocation.zipcode = component.long_name;
                        } else if (component.types.includes('country')) {
                            storableLocation.country = component.long_name;
                            storableLocation.registered_country_iso_code = component.short_name;
                        }
                    }

                    $(cardBody.find('.js-zipcode')).val(storableLocation.zipcode);
                    $(cardBody.find('.js-street')).val(storableLocation.street);
                    $(cardBody.find('.js-number')).val(storableLocation.number);
                    $(cardBody.find('.js-neighborhood')).val(storableLocation.neighborhood);
                    $(cardBody.find('.js-city')).val(storableLocation.city);
                    $(cardBody.find('.js-state')).val(storableLocation.state);
                    $(cardBody.find('.js-state-initials')).val(storableLocation.state_initials);
                    $(cardBody.find('.js-latitude')).val(storableLocation.latitude);
                    $(cardBody.find('.js-longitude')).val(storableLocation.longitude);

                } else {
                    console.log('Não foi possivel encontrar o endereço para este local');
                }
            });
        }

    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.api_key') }}&libraries=places&callback=initAddresses"
        async defer></script>