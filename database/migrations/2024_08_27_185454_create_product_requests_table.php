<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable(); // Nullable for 'add' action
            $table->enum('action', ['add', 'update', 'delete']);
            $table->json('data'); // Store the product data or changes
            $table->enum('status', ['pending', 'approved', 'declined'])->default('pending');
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('admin_id')->nullable(); // Nullable because admin might not have acted yet
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_requests');
    }
}
