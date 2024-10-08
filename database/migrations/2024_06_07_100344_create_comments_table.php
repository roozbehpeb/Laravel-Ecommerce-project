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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->foreignId('parent_id')->nullable()->constrained('comments');
            $table->foreignId('author_id')->constrained('users');

            $table->unsignedBigInteger('commentable_id');
            $table->string('commentable_type');

            $table->tinyInteger('seen')->default(0)->comment('0=>not seen,1=>seen');
            $table->tinyInteger('approve')->default(0)->comment('0=>not approve,1=>approve');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
