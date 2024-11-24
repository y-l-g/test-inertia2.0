<?php

use App\Models\Feature;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('upvotes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Feature::class)
                ->cascadeOnDelete();
            $table->foreignIdFor(User::class)
                ->cascadeOnDelete();
            $table->boolean('upvote');
            $table->unique(['feature_id', 'user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upvotes');
    }
};
