<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products_import_records', function (Blueprint $table) {
            $table->id();
            $table->boolean('success');
            $table->string('imported_file');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products_import_records');
    }
};
