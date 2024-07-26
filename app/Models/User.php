<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Althinect\FilamentSpatieRolesPermissions\Concerns\HasSuperAdmin;
use App\UppercaseTrait;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory;
    use HasRoles;
    use HasSuperAdmin;
    use Notifiable;
    use SoftDeletes;
    use UppercaseTrait;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public static function boot(): void
    {
        parent::boot();
        static::saved(
            function (User $user): void {
                if (empty($user->password)) {
                    $user->update(['password' => bcrypt('password')]);
                }
            },
        );
        static::updated(
            function (User $user): void {
                if (empty($user->password)) {
                    $user->update(['password' => bcrypt('password')]);
                }
            },
        );
    }

    public function scopeNotAdmin(Builder $query)
    {
        return $query->where(fn ($query) => $query->where('id', '!=', 1));
    }

    public function setUsernameAttribute($value)
    {
        return $this->attributes['username'] = strtolower($value);
    }

    public function scopeCs($query)
    {
        return $query->where(fn ($query) => $query->whereHas('roles', fn ($role) => $role->where('name', 'CS')));
    }

    public function scopeAdv($query)
    {
        return $query->where(fn ($query) => $query->whereHas('roles', fn ($role) => $role->where('name', 'ADV')));
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return !empty($this->password);
    }
}
