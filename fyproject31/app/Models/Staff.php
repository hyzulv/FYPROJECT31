<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class Staff extends Authenticatable implements MustVerifyEmailContract
{
    use MustVerifyEmail, Notifiable;

    protected $fillable = ['name', 'username', 'email', 'password', 'phone', 'status', 'email_verified_at'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function sendEmailVerificationNotification()
    {
        $url = URL::temporarySignedRoute(
            'staff.verification.verify',
            now()->addMinutes(60),
            ['id' => $this->getKey(), 'hash' => sha1($this->getEmailForVerification())]
        );

        Mail::mailer('staff_smtp')->send('emails.staff-verify', [
            'url' => $url,
            'user' => $this,
        ], function ($message) {
            $message->to($this->email)
                ->subject('Verify Your Email - Mat Rock Restaurant');
        });
    }

    public function sendPasswordResetNotification($token)
    {
        Mail::mailer('staff_smtp')->send('emails.password-reset', [
            'token' => $token,
            'email' => $this->email,
            'user' => $this,
        ], function ($message) {
            $message->to($this->email)
                ->subject('Reset Your Password');
        });
    }
}
