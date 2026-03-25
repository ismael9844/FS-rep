<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SponsorshipTier;

class SponsorshipTierSeeder extends Seeder
{
    public function run()
    {
        $tiers = [
            [
                'name'          => 'Bronze',
                'price'         => 100.00,
                'duration_days' => 30,
                'features'      => json_encode(['logo_small', 'link']),
            ],
            [
                'name'          => 'Silver',
                'price'         => 250.00,
                'duration_days' => 90,
                'features'      => json_encode(['logo_medium', 'banner']),
            ],
            [
                'name'          => 'Gold',
                'price'         => 500.00,
                'duration_days' => 180,
                'features'      => json_encode(['logo_large', 'popup']),
            ],
        ];

        foreach ($tiers as $tier) {
            SponsorshipTier::updateOrCreate(
                ['name' => $tier['name']],
                $tier
            );
        }
    }
}
