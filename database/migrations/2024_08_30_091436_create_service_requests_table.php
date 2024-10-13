<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
    $table->unsignedBigInteger('admin_id')->nullable();
    $table->unsignedBigInteger('agent_id');
    $table->unsignedBigInteger('service_id')->nullable(); 
    $table->enum('action', ['add', 'update', 'delete']);
    $table->enum('status', ['pending', 'approved', 'declined'])->default('pending');
    $table->json('service_data'); // Storing service data in JSON format
    $table->timestamps();
    
    $table->foreign('admin_id')->references('id')->on('users');
    $table->foreign('agent_id')->references('id')->on('users');
    $table->foreign('service_id')->references('id')->on('services'); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_requests');
    }
}
