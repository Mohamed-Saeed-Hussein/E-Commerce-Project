<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VerificationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'email',
        'expires_at',
        'used',
        'attempts',
        'ip_address'
    ];

    protected $casts = [
        'expires_at' => 'datetime:Y-m-d H:i:s',
        'used' => 'boolean',
        'attempts' => 'integer'
    ];

    /**
     * Generate 100 random verification codes
     */
    public static function generateCodes()
    {
        $codes = [];
        for ($i = 0; $i < 100; $i++) {
            $code = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
            $codes[] = [
                'code' => $code,
                'email' => '', // Will be set when used
                'expires_at' => now()->addMinutes(10),
                'used' => false,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        
        // Insert all codes
        self::insert($codes);
    }

    /**
     * Get an available code for an email
     */
    public static function getAvailableCode($email, $ipAddress = null)
    {
        // Clean up expired codes first
        self::where('expires_at', '<', now())->delete();
        
        // Get an unused code
        $code = self::where('used', false)
                   ->where('email', '')
                   ->first();
        
        if ($code) {
            $code->update([
                'email' => $email,
                'expires_at' => now()->addMinutes(10),
                'attempts' => 0,
                'ip_address' => $ipAddress
            ]);
            return $code;
        }
        
        // If no codes available, generate a new one
        return self::create([
            'code' => str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT),
            'email' => $email,
            'expires_at' => now()->addMinutes(10),
            'used' => false,
            'attempts' => 0,
            'ip_address' => $ipAddress
        ]);
    }

    /**
     * Verify a code for an email
     */
    public static function verifyCode($email, $code, $ipAddress = null)
    {
        $verificationCode = self::where('email', $email)
                               ->where('used', false)
                               ->where('expires_at', '>', now())
                               ->first();
        
        if (!$verificationCode) {
            return ['success' => false, 'message' => 'No valid verification code found for this email.'];
        }
        
        // Check if too many attempts
        if ($verificationCode->attempts >= 3) {
            $verificationCode->update(['used' => true]); // Mark as used to prevent further attempts
            return ['success' => false, 'message' => 'Too many failed attempts. Please request a new verification code.'];
        }
        
        // Increment attempts
        $verificationCode->increment('attempts');
        
        if ($verificationCode->code === $code) {
            $verificationCode->update(['used' => true]);
            return ['success' => true, 'message' => 'Code verified successfully.'];
        }
        
        $remainingAttempts = 3 - $verificationCode->attempts;
        return ['success' => false, 'message' => "Invalid verification code. {$remainingAttempts} attempts remaining."];
    }

    /**
     * Check if email has a valid unused code
     */
    public static function hasValidCode($email)
    {
        return self::where('email', $email)
                   ->where('used', false)
                   ->where('expires_at', '>', now())
                   ->exists();
    }

    /**
     * Get the current valid code for an email
     */
    public static function getCurrentCode($email)
    {
        return self::where('email', $email)
                   ->where('used', false)
                   ->where('expires_at', '>', now())
                   ->first();
    }

    /**
     * Check if email is rate limited (too many requests)
     */
    public static function isRateLimited($email, $ipAddress = null)
    {
        // Check for recent requests from same email (max 3 per hour)
        $recentEmailRequests = self::where('email', $email)
                                 ->where('created_at', '>', now()->subHour())
                                 ->count();
        
        if ($recentEmailRequests >= 3) {
            return true;
        }
        
        // Check for recent requests from same IP (max 5 per hour)
        if ($ipAddress) {
            $recentIpRequests = self::where('ip_address', $ipAddress)
                                  ->where('created_at', '>', now()->subHour())
                                  ->count();
            
            if ($recentIpRequests >= 5) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Clean up old verification codes
     */
    public static function cleanup()
    {
        // Delete expired codes older than 1 hour
        self::where('expires_at', '<', now()->subHour())->delete();
        
        // Delete used codes older than 1 day
        self::where('used', true)
            ->where('updated_at', '<', now()->subDay())
            ->delete();
    }
}