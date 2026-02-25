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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('users')->onDelete('set null');
            $table->string('unit_name');
            $table->string('customer_name');
            $table->decimal('rent_amount', 10, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
            $table->enum('status', ['draft', 'active','expired','terminated'])->default('draft');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
