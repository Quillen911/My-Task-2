<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Bag_User_id');
            $table->decimal('price', 8, 2);
            $table->decimal('cargo_price', 8, 2);
            $table->decimal('discount', 8, 2)->nullable();
            $table->decimal('campaing_price', 8, 2);
            $table->string('campaign_info');
            $table->string('status');
            $table->timestamps();

            $table->foreign('Bag_User_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
