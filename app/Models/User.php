<?php

// Lokasi file: app/Models/User.php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\RoutesNotifications;
use Illuminate\Notifications\HasDatabaseNotifications;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\HasName;
use Filament\Models\Contracts\HasAvatar;
use App\Models\Berita;

class User extends Authenticatable implements FilamentUser, HasName, HasAvatar
{
    use HasApiTokens, HasFactory, HasRoles;

    // Explicitly use notification traits
    use RoutesNotifications, HasDatabaseNotifications;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'role', 'nuptk', 'phone', 'fakultas_id', 'program_studi_id', 'is_active'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    /**
     * Get the fakultas that the user belongs to.
     */
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

    /**
     * Get the program studi that the user belongs to.
     */
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    /**
     * Get berita created by this user
     */
    public function berita()
    {
        return $this->hasMany(Berita::class);
    }

    /**
     * Get dokumen created by this user
     */
    public function dokumen()
    {
        return $this->hasMany(Dokumen::class);
    }

    /**
     * Check if user is GJM (Gugus Jaminan Mutu)
     */
    public function isGJM(): bool
    {
        return $this->role === 'gjm';
    }

    /**
     * Check if user is UJM (Unit Jaminan Mutu)
     */
    public function isUJM(): bool
    {
        return $this->role === 'ujm';
    }

    /**
     * Check if user is Asesor
     */
    public function isAsesor(): bool
    {
        return $this->role === 'asesor';
    }

    /**
     * Check if user has specific role
     */
    public function hasRole($role): bool
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }

        return $this->role === $role;
    }

    /**
     * Determine if the user can access the Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if (!$this->is_active) {
            return false;
        }

        return match ($panel->getId()) {
            'admin' => $this->isSuperAdmin(),
            'gjm' => $this->isGJM(),
            'ujm' => $this->isUJM(),
            'asesor' => $this->isAsesor(),
            default => false,
        };
    }

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->email === 'admin@siaksi.com' || $this->role === 'admin';
    }

    /**
     * Get the user's name for Filament
     */
    public function getFilamentName(): string
    {
        return $this->name;
    }

    /**
     * Get the user's avatar URL for Filament
     */
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include GJM users.
     */
    public function scopeGjm($query)
    {
        return $query->where('role', 'gjm');
    }

    /**
     * Scope a query to only include UJM users.
     */
    public function scopeUjm($query)
    {
        return $query->where('role', 'ujm');
    }

    /**
     * Scope a query to only include Asesor users.
     */
    public function scopeAsesor($query)
    {
        return $query->where('role', 'asesor');
    }

    /**
     * Get readable role name
     */
    public function getRoleNameAttribute(): string
    {
        return match ($this->role) {
            'gjm' => 'Gugus Jaminan Mutu',
            'ujm' => 'Unit Jaminan Mutu',
            'asesor' => 'Asesor',
            'admin' => 'Administrator',
            default => 'Unknown',
        };
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin()
    {
        $this->update(['last_login_at' => now()]);
    }

    /**
     * Check if user can manage specific fakultas
     */
    public function canManageFakultas($fakultasId): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if ($this->isGJM() && $this->fakultas_id == $fakultasId) {
            return true;
        }

        return false;
    }

    /**
     * Check if user can manage specific program studi
     */
    public function canManageProdi($prodiId): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if ($this->isGJM()) {
            $prodi = ProgramStudi::find($prodiId);
            return $prodi && $prodi->fakultas_id == $this->fakultas_id;
        }

        if ($this->isUJM() && $this->program_studi_id == $prodiId) {
            return true;
        }

        return false;
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }
}
