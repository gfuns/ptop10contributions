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
        Schema::create('members', function (Blueprint $table) {
            $table->increments("id");
            $table->string('card_number')->nullable();
            $table->string('last_name');
            $table->string('other_names');
            $table->string('email')->unique();
            $table->text('photograph');
            $table->string('phone_number')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->text('contact_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
