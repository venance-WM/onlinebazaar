<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('region_id')->constrained()->onDelete('cascade');
            $table->foreignId('district_id')->constrained()->onDelete('cascade');
            $table->foreignId('ward_id')->constrained()->onDelete('cascade');
            $table->foreignId('street_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('zone');
            $table->enum('business_type', ['seller', 'service']);
            $table->string('business_name');
            $table->string('trading_name');
            $table->string('sector_of_shop');
            $table->string('whatsapp_number')->nullable();
            
            // Adding latitude and longitude fields
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            // hizi kwaajiri ya kutunza picha za duka
            $table->string('shop_image_one', 2048)->nullable();
            $table->string('shop_image_two', 2048)->nullable();
            $table->string('shop_image_three', 2048)->nullable();
            
            $table->softDeletes();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller_details');
    }
}
