<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Country, Department, City};

class BaseGeoSeeder extends Seeder
{
    public function run(): void
    {
        // Countries
        $co = Country::firstOrCreate(
            ['code' => 'CO'],
            ['name' => 'Colombia', 'abbrev' => 'COL', 'status' => true]
        );

        // Departaments
        $ant = Department::firstOrCreate(
            ['code' => 'ANT', 'id_country' => $co->id],
            ['name' => 'Antioquia', 'abbrev' => 'ANT', 'status' => true]
        );
        $cund = Department::firstOrCreate(
            ['code' => 'CUN', 'id_country' => $co->id],
            ['name' => 'Cundinamarca', 'abbrev' => 'CUN', 'status' => true]
        );

        // Cities
        City::firstOrCreate(
            ['code' => 'MED', 'id_department' => $ant->id],
            ['name' => 'Medellín', 'abbrev' => 'MED', 'status' => true]
        );
        City::firstOrCreate(
            ['code' => 'ENV', 'id_department' => $ant->id],
            ['name' => 'Envigado', 'abbrev' => 'ENV', 'status' => true]
        );
        City::firstOrCreate(
            ['code' => 'BOG', 'id_department' => $cund->id],
            ['name' => 'Bogotá', 'abbrev' => 'BOG', 'status' => true]
        );
    }
}