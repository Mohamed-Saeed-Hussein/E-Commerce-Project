<!doctype html>
<html>
  <body style="font-family: Arial, Helvetica, sans-serif; color:#111;">
    <h2>Reset your password</h2>
    <p>Hello {{ $user->name ?? $user->email }},</p>
    <p>You requested to reset your password. Click the button below to choose a new one. This link will expire in 30 minutes.</p>
    <p>
      <a href="{{ $resetUrl }}" style="background:#ef4444;color:white;padding:10px 14px;border-radius:6px;text-decoration:none;display:inline-block">Reset Password</a>
    </p>
    <p>Or copy and paste this link into your browser:</p>
    <p><a href="{{ $resetUrl }}">{{ $resetUrl }}</a></p>
    <p>If you didn't request this, you can safely ignore this email.</p>
  </body>
  </html>


