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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->string('other_title')->nullable();
            $table->string('fullname');
            $table->string('position')->nullable();
            $table->string('organization');
            $table->string('country');
            $table->string('phone');
            $table->string('email');
            $table->string('dietary_requirement');
            $table->string('conference_type');
            $table->string('paper_title')->nullable();
            $table->string('payment_method');
            $table->string('register_type'); // <--- thêm vào đây
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};