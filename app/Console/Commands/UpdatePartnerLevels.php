<?php

namespace App\Console\Commands;

use App\Models\Partner;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdatePartnerLevels extends Command
{
    protected $signature = 'partners:update-levels';
    protected $description = 'Update partner levels based on their monthly donation counts';

    public function handle()
    {
        $this->info('Starting to update partner levels...');

        // date du mois en cours
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $partners = Partner::all();

        foreach ($partners as $partner) {
            $donationsCount = $partner->donations()
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();

            if ($donationsCount >= 16) {
                $partner->level = 3;
            } elseif ($donationsCount >= 6) {
                $partner->level = 2;
            } else {
                $partner->level = 1;
            }

            $partner->save();

            $this->info("Partner {$partner->name} updated to level {$partner->level} ({$donationsCount} donations)");
        }

        $this->info('Partner levels updated successfully.');
        return 0;
    }
}
