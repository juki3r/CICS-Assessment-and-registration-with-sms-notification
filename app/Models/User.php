<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'fullname',
        'address',
        'age',
        'is_new_register',
        'role',
        'phone_number',
        'email',
        'password',
        'image',
        'phone_verified',
        'otp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function adminNotifications()
    {
        return $this->hasMany(AdminNotification::class);
    }

    public function examResult()
    {
        return $this->hasOne(\App\Models\ExamResult::class);
    }

    public function examResults()
    {
        return $this->hasMany(ExamResult::class, 'user_id'); // or 'student_id' if that's your column
    }

    protected static function booted()
    {
        static::saved(function ($user) {
            if (!$user->examResult && $user->course) {
                $user->examResult()->create([
                    'exam' => null,
                    'interview' => null,
                    'gwa' => null,
                    'skill_test' => null,
                    'remarks' => null,
                    'course' => $user->course,
                ]);
            }
        });
    }
}
