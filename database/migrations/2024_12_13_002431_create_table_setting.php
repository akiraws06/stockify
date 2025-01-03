<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $defaultPath = 'public/images/setting';
        $defaultFile = $defaultPath . '/logo.png';

        // Buat direktori jika belum ada
        if (!Storage::exists($defaultPath)) {
            Storage::makeDirectory($defaultPath);
        }

        // Pastikan file default tersedia
        if (!Storage::exists($defaultFile)) {
            Storage::put($defaultFile, file_get_contents(public_path('images/setting/logo.png'))); // File logo default
        }

        // Membuat tabel setting
        Schema::create('setting', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->default('images/setting/logo.png');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting');
    }
};
