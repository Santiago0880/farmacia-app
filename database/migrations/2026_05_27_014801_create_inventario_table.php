<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('codigo', 20)->unique();
            $table->string('nombre', 100);
            $table->decimal('precio', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('categoria', 50);
            $table->string('presentacion', 50);
            $table->string('laboratorio', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};