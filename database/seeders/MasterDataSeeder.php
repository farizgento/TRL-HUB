<?php

namespace Database\Seeders;

use App\Models\AreaUnit;
use App\Models\Tool;
use App\Models\ToolCategory;
use App\Models\ToolLocation;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['category_code' => 'CAT-001', 'category_name' => 'Alat Ukur'],
            ['category_code' => 'CAT-002', 'category_name' => 'Peralatan Mekanik'],
        ];

        foreach ($categories as $category) {
            ToolCategory::firstOrCreate(['category_code' => $category['category_code']], $category);
        }

        $locations = [
            ['location_code' => 'LOC-001', 'location_name' => 'Gudang Utama'],
            ['location_code' => 'LOC-002', 'location_name' => 'Workshop'],
        ];

        foreach ($locations as $location) {
            ToolLocation::firstOrCreate(['location_code' => $location['location_code']], $location);
        }

        $areas = [
            ['area_code' => 'AREA-001', 'area_name' => 'Unit A'],
            ['area_code' => 'AREA-002', 'area_name' => 'Unit B'],
        ];

        foreach ($areas as $area) {
            AreaUnit::firstOrCreate(['area_code' => $area['area_code']], $area);
        }

        $category = ToolCategory::where('category_code', 'CAT-001')->first();
        $location = ToolLocation::where('location_code', 'LOC-001')->first();

        Tool::firstOrCreate(
            ['asset_no' => 'AST-001'],
            [
                'barcode' => 'BR-TRL-001',
                'tool_name' => 'Multimeter Digital',
                'category_id' => $category?->id,
                'location_id' => $location?->id,
                'condition_status' => 'baik',
                'availability_status' => 'tersedia',
            ]
        );
    }
}
