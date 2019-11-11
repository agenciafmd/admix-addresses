<?php

namespace Agenciafmd\Addresses;

use Agenciafmd\Addresses\Address;

trait Addressable
{
    public static function bootAddressable()
    {
        static::saved(function ($model) {
            $data = request()->all();

            if (isset($data['address']) && is_array($data['address'])) {
                foreach ($data['address'] as $collection => $address) {
                    $model->addAddress($collection, $address);
                }// foreach
            }// if
        });
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function address($collection = 'default', $filters = [])
    {
        return $this->addresses()->where('collection', $collection)->first();
    }

    private function addAddress($collection, $address)
    {
        $this->addresses()->updateOrCreate(['collection' => $collection], $address + ['collection' => $collection]);
    }
}
