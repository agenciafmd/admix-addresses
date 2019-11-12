<?php

namespace Agenciafmd\Addresses;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Address extends Model implements AuditableContract
{
    use Auditable;

    protected $guarded = [];

    public function addressable()
    {
        return $this->morphTo();
    }
}
