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
        $defaultPath = 'public/images/profile';
        $defaultFile = $defaultPath . '/default.png';

        if (!Storage::exists($defaultPath)) {
            Storage::makeDirectory($defaultPath);
        }

        // Pastikan file default tersedia
        if (!Storage::exists($defaultFile)) {
            Storage::put($defaultFile, file_get_contents(public_path('images/profile/default.png')));
        }
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('image')->default('default.png');
                $table->string('username')->unique();
                $table->string('password');
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
