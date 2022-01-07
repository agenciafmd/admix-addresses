<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('addressable');

            $table->string('collection');
            $table->string('full_street')
                ->nullable();
            $table->string('street')
                ->nullable();
            $table->string('number')
                ->nullable();
            $table->string('complement')
                ->nullable();
            $table->string('neighborhood')
                ->nullable();
            $table->string('state_initials')
                ->nullable();
            $table->string('state')
                ->nullable();
            $table->string('city')
                ->nullable();
            $table->string('postcode')
                ->nullable();
            $table->string('latitude')
                ->nullable();
            $table->string('longitude')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
