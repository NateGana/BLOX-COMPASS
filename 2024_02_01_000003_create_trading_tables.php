<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trading_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('post_type')->index();
            $table->string('offered');
            $table->string('wanted');
            $table->text('description')->nullable();
            $table->string('status')->default('open')->index();
            $table->timestamps();
        });

        Schema::create('wfl_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->json('offer');
            $table->json('receive');
            $table->unsignedBigInteger('offer_total');
            $table->unsignedBigInteger('receive_total');
            $table->timestamps();
        });

        Schema::create('wfl_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wfl_post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('vote');
            $table->timestamps();
            $table->unique(['wfl_post_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wfl_votes');
        Schema::dropIfExists('wfl_posts');
        Schema::dropIfExists('trading_posts');
    }
};
