<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tipoff\Fees\Models\Fee;
use Tipoff\Locations\Models\Location;

class CreateLocationFeesTable extends Migration
{
    public function up()
    {
        Schema::create('location_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(app('location'))->unique();	// NOTE - unique() added -- there should be exactly one record per location!
            $table->foreignIdFor(app('fee'), 'booking_fee_id')->nullable(); // Multiple types of fees cannot be charged to a booking. We currently use a per participant fee on bookings.
            $table->foreignIdFor(app('fee'), 'product_fee_id')->nullable();
            $table->foreignIdFor(app('user'), 'creator_id');
            $table->foreignIdFor(app('user'), 'updater_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('location_fees');
    }
}
