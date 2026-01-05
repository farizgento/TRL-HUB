<?php

namespace Database\Seeders;

use App\Models\AreaUnit;
use App\Models\Tool;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // ---- AREA ----
        $areas = [
            ['name' => 'Unit A', 'unit' => 'Area 1'],
            ['name' => 'Unit B', 'unit' => 'Area 2'],
        ];

        foreach ($areas as $area) {
            AreaUnit::firstOrCreate(['name' => $area['name']], $area);
        }

        $unitA = AreaUnit::where('name', 'Unit A')->first();
        $unitB = AreaUnit::where('name', 'Unit B')->first();

        // ---- TOOLS ----
        $tools = [
            [
                'nomer_asset'        => 'AST-001',
                'barcode'            => 'BR-TRL-001',
                'name'               => 'Multimeter Digital',
                'current_location_id'=> $unitA?->id,
                'condition'          => 'baik',
                'current_status'     => 'tersedia',
                'notes'              => 'Tool awal untuk unit A',
            ],
            [
                'nomer_asset'        => 'AST-002',
                'barcode'            => 'BR-TRL-002',
                'name'               => 'Obeng Set',
                'current_location_id'=> $unitA?->id,
                'condition'          => 'baik',
                'current_status'     => 'tersedia',
                'notes'              => null,
            ],
            [
                'nomer_asset'        => 'AST-003',
                'barcode'            => 'BR-TRL-003',
                'name'               => 'Tang Kombinasi',
                'current_location_id'=> $unitA?->id,
                'condition'          => 'baik',
                'current_status'     => 'tersedia',
                'notes'              => null,
            ],
        ];

        foreach ($tools as $tool) {
            Tool::firstOrCreate(
                ['nomer_asset' => $tool['nomer_asset']],
                $tool
            );
        }
    }
}
