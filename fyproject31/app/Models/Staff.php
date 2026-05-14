<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class Staff extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'username', 'email', 'password', 'phone', 'status'];

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
