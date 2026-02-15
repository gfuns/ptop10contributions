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
        Schema::create('member_loans', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("user_id")->unsigned();
            $table->integer("member_id")->unsigned();
            $table->integer("guarantor_id")->unsigned();
            $table->string("application_id")->nullable();
            $table->string("card_number");
            $table->double("amount", 12, 2);
            $table->double("weekly_repayment", 12, 2);
            $table->integer("tenure")->default(60);
            $table->enum("approval_status", ["pending", "approved", "denied"])->default("pending");
            $table->date("first_payment")->nullable();
            $table->enum("first_payment_status", ["pending", "paid"])->default("pending");
            $table->date("second_payment")->nullable();
            $table->enum("second_payment_status", ["pending", "paid"])->default("pending");
            $table->date("third_payment")->nullable();
            $table->enum("third_payment_status", ["pending", "paid"])->default("pending");
            $table->date("fourth_payment")->nullable();
            $table->enum("fourth_payment_status", ["pending", "paid"])->default("pending");
            $table->date("fifth_payment")->nullable();
            $table->enum("fifth_payment_status", ["pending", "paid"])->default("pending");
            $table->date("sixth_payment")->nullable();
            $table->enum("sixth_payment_status", ["pending", "paid"])->default("pending");
            $table->date("seventh_payment")->nullable();
            $table->enum("seventh_payment_status", ["pending", "paid"])->default("pending");
            $table->date("eigth_payment")->nullable();
            $table->enum("eigth_payment_status", ["pending", "paid"])->default("pending");
            $table->date("disbursement_date")->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('guarantor_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_loans');
    }
};
