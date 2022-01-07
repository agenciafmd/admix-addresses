<?php

namespace Agenciafmd\Addresses\Models;

use Agenciafmd\Addresses\Database\Factories\AddressFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Address extends Model implements AuditableContract
{
    use Auditable, HasFactory;

    protected $guarded = [];

    public function addressable()
    {
        return $this->morphTo();
    }

    protected static function newFactory()
    {
        if (class_exists(\Database\Factories\AddressFactory::class)) {
            return \Database\Factories\AddressFactory::new();
        }

        return AddressFactory::new();
    }
}
