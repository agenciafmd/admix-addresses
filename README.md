# F&MD - Addresses

![Área administrativa](https://github.com/agenciafmd/admix-addresses/raw/master/docs/screenshot.jpg "Área administrativa")

[![Downloads](https://img.shields.io/packagist/dt/agenciafmd/admix-addresses.svg?style=flat-square)](https://packagist.org/packages/agenciafmd/admix-addresses)
[![Licença](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

- Acopla os campos de endereço / mapa na model

## Instalação

```
composer require mixdinternet/admix-addresses:dev-master
```

## Configuração

### Model
Na model `Package.php` acrescente a `Trait` e o `$guarded`

```
use Agenciafmd\Addresses\AddressTrait;
...
class Package extends Model implements AuditableContract
...
    use AddressTrait
...
    protected $guarded = [
        ...'address',...
    ];
```

### View

Na view que será implementada os endereços, adicione

```
@include('agenciafmd/addresses::default')
```

Caso seja necessário a customização, adicione

```
@include('agenciafmd/addresses::default', ['title' => 'Endereço do Ponto de Venda', 'collection' => 'pos'])
```

Acrescente tambem os scripts no `@push('scripts')`
    
```
@push('scripts')
    @include('agenciafmd/addresses::scripts')
@endpush
```

### Validação

Em `Http/Requests/PackageRequest.php` acrescentar

```
public function rules()
{
    return [
        ...
        'address.*.full_street' => 'required|max:150',
        'address.*.zipcode' => 'required|max:150',
        'address.*.street' => 'required|max:150',
        'address.*.number' => 'required|max:150',
        'address.*.complement' => 'nullable|max:150',
        'address.*.neighborhood' => 'required|max:150',
        'address.*.city' => 'required|max:150',
        'address.*.latitude' => 'required|max:150',
        'address.*.longitude' => 'required|max:150',
        ...
    ];
}

public function attributes()
{
    return [
        ...
        'address.*.full_street' => 'endereço completo',
        'address.*.zipcode' => 'cep',
        'address.*.street' => 'endereço',
        'address.*.number' => 'número',
        'address.*.complement' => 'complemento',
        'address.*.neighborhood' => 'bairro',
        'address.*.city' => 'cidade',
        'address.*.state' => 'estado',
        'address.*.latitude' => 'latitude',
        'address.*.longitude' => 'longitude',
        ...
    ];
}
```

### Factories
```
...
$item->addAddress('default', [
    'full_street' => $faker->streetAddress,
    'zipcode' => $faker->postcode,
    'street' => $faker->streetName,
    'number' => $faker->buildingNumber,
    'neighborhood' => $faker->citySuffix,
    'complement' => $faker->citySuffix,
    'city' => $faker->city,
    'state' => $faker->state,
    'latitude' => $faker->latitude($min = -20.8, $max = -20.9),
    'longitude' => $faker->longitude($min = -49.4, $max = -50.3),
]);
...
```

## Uso

Quando for necessário, chame os dados

```
$model->address()->full_street
$model->address()->zipcode
$model->address()->street
$model->address()->number
$model->address()->complement
$model->address()->neighborhood
$model->address()->city
$model->address()->state
$model->address()->latitude
$model->address()->longitude
```

## Segurança

Caso encontre alguma falha de segurança, por favor, envie um email para tarsisio@fmd.ag ao invés de abrir uma issue.

## Creditos

-  [Tarsísio Xavier](https://github.com/TarsisioXavier)

## Licença

Licença MIT. [Clique aqui](LICENSE.md) para mais detalhes.