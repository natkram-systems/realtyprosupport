
MMJ Greenland Dashboard - 2FA Enabled Version

REQUIREMENTS:
- Run: composer require spomky-labs/otphp endroid/qr-code
- Make sure to create a writable folder named 'qrcodes' for saving QR codes

DATABASE:
ALTER TABLE users ADD COLUMN totp_secret VARCHAR(255) NOT NULL;

Login flow:
1. User enters email & password
2. If correct, user is prompted to enter 6-digit TOTP code from authenticator app
3. If TOTP is valid, redirect to dashboard.html
