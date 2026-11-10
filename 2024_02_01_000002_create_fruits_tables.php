<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fruits', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('rarity')->index();
            $table->string('type')->index();
            $table->unsignedBigInteger('beli_price')->nullable();
            $table->unsignedBigInteger('robux_price')->nullable();
            $table->text('description')->nullable();
            $table->string('demand')->default('Unknown');
            $table->unsignedBigInteger('value')->default(0);
            $table->string('data_status')->default('demo');
            $table->string('source')->nullable();
            $table->timestamps();
        });

        Schema::create('fruit_value_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fruit_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('value');
            $table->date('recorded_at')->index();
            $table->timestamps();
        });

        Schema::create('value_suggestions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fruit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('suggested_value');
            $table->string('demand');
            $table->text('explanation');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('value_suggestions');
        Schema::dropIfExists('fruit_value_history');
        Schema::dropIfExists('fruits');
    }
};
