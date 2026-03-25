<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sponsorship;
use Carbon\Carbon;

class UpdateSponsorshipStatuses extends Command
{
    protected $signature = 'sponsorships:update-statuses';
    protected $description = 'Met à jour le statut des sponsors expirés';

    public function handle()
    {
        $expired = Sponsorship::where('status', 'active')
            ->where('end_at', '<', Carbon::now())
            ->update(['status' => 'expired']);

        $this->info("Mise à jour terminée : $expired sponsor(s) expiré(s).");
    }
}
