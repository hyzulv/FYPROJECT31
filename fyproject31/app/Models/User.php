<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'username', 'email', 'password', 'role', 'phone', 'status'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function sendPasswordResetNotification($token)
    {
        $mailer = 'smtp';

        Mail::mailer($mailer)->send('emails.password-reset', [
            'token' => $token,
            'email' => $this->email,
            'user' => $this,
        ], function ($message) {
            $message->to($this->email)
                ->from(config('mail.from.address'), 'MAT ROCK Restaurant')
                ->subject('Reset Your Password');
        });
    }
}
