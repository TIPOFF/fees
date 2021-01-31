<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesTable extends Migration
{
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->index();
            $table->string('name')->unique(); // Internal reference name
            $table->string('title'); // Shows in book online checkout flow.

            // Type. Can only be one of the following, amount or percent. Restraints needed to keep the other zero.
            $table->unsignedInteger('amount')->nullable(); // In cents.
            $table->unsignedDecimal('percent', 5, 2)->nullable(); // Allows option to use a percentage fee per booking

            // Application. Definitions include: 'order', 'each' (each one of the products or bookings in orders), 'product', 'booking', 'participant'
            $table->string('applies_to')->default('order');

            $table->boolean('is_taxed')->default(false); // Allows taxes to be applied to fees and not just the net booking amount.
            $table->foreignId('creator_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fees');
    }
}
