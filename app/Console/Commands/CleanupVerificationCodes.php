<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VerificationCode;

class CleanupVerificationCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verification:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up expired and old verification codes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting verification codes cleanup...');
        
        // Get counts before cleanup
        $expiredCount = VerificationCode::where('expires_at', '<', now()->subHour())->count();
        $usedCount = VerificationCode::where('used', true)
            ->where('updated_at', '<', now()->subDay())
            ->count();
        
        // Perform cleanup
        VerificationCode::cleanup();
        
        $this->info("Cleaned up {$expiredCount} expired codes and {$usedCount} old used codes.");
        $this->info('Verification codes cleanup completed successfully.');
        
        return 0;
    }
}
