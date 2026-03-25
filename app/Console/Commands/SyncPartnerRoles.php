<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Partner;

class SyncPartnerRoles extends Command
{
    protected $signature = 'partners:sync-roles';
    protected $description = 'Copie le role de User dans la colonne role de Partner';

    public function handle()
    {
        Partner::with('user')->chunk(100, function($partners) {
            foreach ($partners as $partner) {
                if ($partner->user) {
                    $partner->role = $partner->user->role;
                    $partner->saveQuietly();
                }
            }
        });

        $this->info('✅ Tous les roles ont été synchronisés.');
    }
}
