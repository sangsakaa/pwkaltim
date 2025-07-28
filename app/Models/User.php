<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected static $logAttributes = ['name', 'email', 'role'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'code',
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
    // app/Models/User.php

    public function province()
    {
        return $this->belongsTo(Province::class, 'code', 'code');
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'code', 'code');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'code', 'code');
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class, 'created_by');
    }

    public function approvedPosts()
    {
        return $this->hasMany(Post::class, 'approved_by');
    }

    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('user')
            ->logOnly(['name', 'email']) // kolom yang ingin dicatat
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
