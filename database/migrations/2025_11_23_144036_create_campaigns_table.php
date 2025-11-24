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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('bikes_count')->nullable();
            $table->string('file')->nullable();
            $table->enum('file_type', ['video', 'image'])->nullable();

            $table->integer('media_duration')->comment('In seconds')->nullable();
            $table->string('campaign_duration')->nullable();

            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->decimal('price', 10, 2)->nullable();

            $table->enum('status', ['live', 'finished', 'scheduled', 'stopped'])->default('scheduled')->nullable();
            $table->enum('approval_status', ['accepted', 'rejected', 'pending'])->default('pending')->nullable();

            $table->integer('views_count')->default('0')->nullable();
            $table->integer('progress')->default('0')->nullable();

            $table->string('notes')->nullable();

            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

            $table->unsignedBigInteger('region_id')->nullable();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
