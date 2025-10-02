<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Mail;

class TestVerificationEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:verification-email {email} {code?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test sending a verification email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $code = $this->argument('code') ?? '123456';
        
        $this->info("Testing verification email to: {$email}");
        $this->info("Using code: {$code}");
        
        try {
            Mail::to($email)->send(new VerificationCodeMail($code, $email));
            $this->info("✅ Email sent successfully!");
            $this->info("Check your email inbox or the log file at: storage/logs/laravel.log");
        } catch (\Throwable $e) {
            $this->error("❌ Failed to send email: " . $e->getMessage());
            $this->error("Stack trace: " . $e->getTraceAsString());
        }
    }
}