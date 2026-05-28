<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Eliminar usuarios existentes (opcional, comenta si no quieres borrar)
        DB::table('users')->delete();

        // Insertar usuarios
        DB::table('users')->insert([
            [
                'name' => 'Administrador',
                'email' => 'admin@farmacia.com',
                'password' => Hash::make('12345678'),
                'rol' => 'administrador',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Encargado Inventario',
                'email' => 'inventario@farmacia.com',
                'password' => Hash::make('12345678'),
                'rol' => 'encargado_inventario',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vendedor',
                'email' => 'vendedor@farmacia.com',
                'password' => Hash::make('12345678'),
                'rol' => 'vendedor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('✅ Usuarios creados correctamente:');
        $this->command->info('   admin@farmacia.com / 12345678 (administrador)');
        $this->command->info('   inventario@farmacia.com / 12345678 (encargado_inventario)');
        $this->command->info('   vendedor@farmacia.com / 12345678 (vendedor)');
    }
}