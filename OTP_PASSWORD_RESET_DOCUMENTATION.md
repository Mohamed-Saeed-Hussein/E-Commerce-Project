# OTP Password Reset Flow Documentation

## Overview
This document describes the comprehensive OTP (One-Time Password) based password reset flow implemented in the Style Haven Laravel application. The system provides a secure, user-friendly way for users to reset their passwords using 6-digit verification codes sent via email.

## Flow Steps

### 1. Password Reset Initiation
- **Route**: `GET /recover/initiate`
- **View**: `resources/views/auth/recover/initiate.blade.php`
- **Purpose**: User enters their email address to initiate password reset

### 2. Email Verification & OTP Generation
- **Route**: `POST /recover/initiate`
- **Process**:
  - Validates email format and existence in database
  - Checks rate limiting (max 3 requests per email per hour, max 5 per IP per hour)
  - Generates 6-digit random OTP code
  - Sets 10-minute expiration time
  - Stores code in database with IP tracking
  - Sends email with verification code
  - Redirects to OTP entry page

### 3. OTP Code Entry
- **Route**: `GET /recover/code`
- **View**: `resources/views/auth/recover/code.blade.php`
- **Features**:
  - Auto-focus on code input
  - Auto-submit when 6 digits entered
  - Paste support for OTP codes
  - Resend functionality with 60-second cooldown
  - Debug mode shows code in development

### 4. OTP Verification
- **Route**: `POST /recover/code`
- **Process**:
  - Validates code format and email
  - Checks code against database
  - Tracks failed attempts (max 3 attempts per code)
  - Returns detailed error messages
  - Redirects to password reset on success

### 5. Password Reset
- **Route**: `GET /recover/reset`
- **View**: `resources/views/auth/recover/reset.blade.php`
- **Features**:
  - Pre-filled email (read-only)
  - New password input with confirmation
  - Password strength validation

### 6. Password Update
- **Route**: `POST /recover/reset`
- **Process**:
  - Validates password requirements
  - Updates user password in database
  - Clears all verification codes for email
  - Redirects to login with success message

## Security Features

### Rate Limiting
- **Email-based**: Maximum 3 password reset requests per email per hour
- **IP-based**: Maximum 5 password reset requests per IP address per hour
- **Resend protection**: 5-minute cooldown between resend requests

### Attempt Tracking
- **Failed attempts**: Maximum 3 attempts per verification code
- **Auto-lockout**: Code becomes invalid after 3 failed attempts
- **IP tracking**: All requests tracked with IP addresses

### Code Security
- **Expiration**: 10-minute validity period
- **One-time use**: Codes become invalid after successful use
- **Random generation**: Cryptographically secure 6-digit codes
- **Cleanup**: Automatic cleanup of expired and old codes

## Database Schema

### verification_codes Table
```sql
- id (primary key)
- code (string, 6 digits)
- email (string, user email)
- expires_at (datetime, expiration time)
- used (boolean, whether code was used)
- attempts (integer, failed attempt count)
- ip_address (string, request IP address)
- created_at (timestamp)
- updated_at (timestamp)
```

## Models

### VerificationCode Model
Key methods:
- `getAvailableCode($email, $ipAddress)` - Get/create verification code
- `verifyCode($email, $code, $ipAddress)` - Verify code with attempt tracking
- `isRateLimited($email, $ipAddress)` - Check rate limiting
- `hasValidCode($email)` - Check if email has valid unused code
- `cleanup()` - Clean up expired and old codes

## Email Template

### VerificationCodeMail
- **Template**: `resources/views/emails/verification_code.blade.php`
- **Features**:
  - Clean, professional design
  - Large, easy-to-read code display
  - Clear expiration notice
  - Security warning for unsolicited emails

## Console Commands

### Cleanup Command
```bash
php artisan verification:cleanup
```
- Removes expired codes older than 1 hour
- Removes used codes older than 1 day
- Provides cleanup statistics

## Error Handling

### User-Friendly Messages
- Invalid email: "We're sorry. We weren't able to identify you given the information provided."
- Rate limited: "Too many password reset requests. Please wait before trying again."
- Invalid code: "Invalid verification code. X attempts remaining."
- Too many attempts: "Too many failed attempts. Please request a new verification code."
- Email send failure: "Failed to send verification email. Please try again."

### Debug Mode
- In development mode, verification codes are logged to `storage/logs/laravel.log`
- Debug endpoint available at `/debug/verification-code/{email}` (development only)

## UI/UX Features

### Enhanced User Experience
- **Auto-submit**: Form submits automatically when 6 digits are entered
- **Paste support**: Users can paste OTP codes from email/SMS
- **Loading states**: Visual feedback during form submission
- **Resend timer**: 60-second countdown before resend is available
- **Auto-focus**: Code input is focused on page load
- **Input validation**: Only numeric input allowed

### Responsive Design
- Mobile-friendly interface
- Dark mode support
- Accessible form controls
- Clear visual hierarchy

## Testing

### Development Testing
1. Enable debug mode in `.env`
2. Check logs for verification codes
3. Use debug endpoint for code retrieval
4. Test rate limiting by making multiple requests

### Production Considerations
- Ensure email service is properly configured
- Set up scheduled cleanup task
- Monitor rate limiting effectiveness
- Test email delivery across different providers

## Maintenance

### Regular Tasks
- Run cleanup command daily: `php artisan verification:cleanup`
- Monitor failed email deliveries
- Review rate limiting logs
- Update email templates as needed

### Monitoring
- Track verification code usage patterns
- Monitor failed attempt rates
- Check email delivery success rates
- Review security logs for suspicious activity

## Security Best Practices

1. **Never log verification codes in production**
2. **Use HTTPS for all password reset flows**
3. **Implement proper session management**
4. **Regular security audits of the flow**
5. **Monitor for brute force attempts**
6. **Keep verification code expiration short**
7. **Implement proper error handling without information leakage**

## Future Enhancements

### Potential Improvements
- SMS backup verification
- CAPTCHA integration for rate limiting
- Account lockout after multiple failed resets
- Email notification when password is reset
- Two-factor authentication integration
- Audit logging for security events

## Troubleshooting

### Common Issues
1. **Email not received**: Check spam folder, verify email configuration
2. **Code expired**: Request new code, check system time
3. **Rate limited**: Wait for cooldown period
4. **Invalid code**: Check for typos, ensure code is fresh
5. **Database errors**: Check migration status, verify table structure

### Debug Steps
1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify database connection and table structure
3. Test email configuration with `php artisan tinker`
4. Check rate limiting with database queries
5. Verify file permissions and Laravel configuration
