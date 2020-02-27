<?php

namespace Agenciafmd\Addresses;

trait AddressTrait
{
    public static function bootAddressTrait()
    {
        static::saved(function ($model) {
            $data = request()->all();

            if (isset($data['address']) && is_array($data['address'])) {
                foreach ($data['address'] as $collection => $address) {
                    $model->addAddress($collection, $address);
                }
            }
        });
    }

    public function address($collection = 'default', $filters = [])
    {
        return $this->addresses()
            ->where('collection', $collection)
            ->first();
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function addAddress($collection, $address)
    {
        $this->addresses()
            ->updateOrCreate(['collection' => $collection], $address + ['collection' => $collection]);
    }
}
