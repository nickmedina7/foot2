<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeders::class);  // Nombre correcto de la clase
        $this->call(ProductoSeeder::class);  // Nombre correcto de la clase
    }
}
