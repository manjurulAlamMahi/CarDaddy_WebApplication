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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('model');
            $table->string('submodel')->nullable();
            $table->unsignedBigInteger('make');
            $table->unsignedBigInteger('category');
            $table->year('year');
            $table->decimal('price', 10, 2);
            $table->integer('mileage')->unsigned();
            $table->unsignedBigInteger('color');
            $table->enum('condition', ['new', 'used'])->default('used');
            $table->unsignedBigInteger('body_type');
            $table->unsignedBigInteger('transmission');
            $table->unsignedBigInteger('size');
            $table->unsignedInteger('doors');
            $table->unsignedBigInteger('exterior_color');
            $table->unsignedBigInteger('interior_color');
            $table->unsignedBigInteger('drivetrain');
            $table->unsignedBigInteger('cylinder');
            $table->unsignedBigInteger('mpg');
            $table->unsignedBigInteger('fuel_type');
            $table->text('description')->nullable();
            $table->text('features')->nullable();
            $table->text('history')->nullable();
            $table->text('warrenty')->nullable();
            $table->string('video_link_01')->nullable();
            $table->string('video_link_02')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('verified')->default(0)->comment('0 = pending, 1 = verified');
            $table->boolean('approved')->default(0)->comment('0 = pending, 1 = approved');
            $table->boolean('featured')->default(0)->comment('0 = no, 1 = yes');
            $table->boolean('sold')->default(0)->comment('0 = no, 1 = yes');
            $table->unsignedBigInteger('sold_by')->nullable();
            $table->timestamp('sold_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
