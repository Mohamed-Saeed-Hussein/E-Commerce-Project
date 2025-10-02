<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VerificationCode;

class CheckVerificationCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verification:check {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check verification codes in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        if ($email) {
            $this->info("Checking verification codes for: {$email}");
            $codes = VerificationCode::where('email', $email)->get();
        } else {
            $this->info("Checking all verification codes:");
            $codes = VerificationCode::all();
        }
        
        if ($codes->isEmpty()) {
            $this->warn('No verification codes found.');
            return;
        }
        
        $headers = ['ID', 'Code', 'Email', 'Expires At', 'Used', 'Created At'];
        $rows = [];
        
        foreach ($codes as $code) {
            $rows[] = [
                $code->id,
                $code->code,
                $code->email ?: 'Available',
                $code->expires_at->format('Y-m-d H:i:s'),
                $code->used ? 'Yes' : 'No',
                $code->created_at->format('Y-m-d H:i:s')
            ];
        }
        
        $this->table($headers, $rows);
        
        $total = $codes->count();
        $used = $codes->where('used', true)->count();
        $available = $codes->where('used', false)->where('email', '')->count();
        $assigned = $codes->where('used', false)->where('email', '!=', '')->count();
        
        $this->info("\nSummary:");
        $this->line("Total codes: {$total}");
        $this->line("Used codes: {$used}");
        $this->line("Available codes: {$available}");
        $this->line("Assigned codes: {$assigned}");
    }
}