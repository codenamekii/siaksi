<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
  use HasApiTokens, HasFactory, Notifiable;

  protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'nuptk',
    'phone',
    'avatar',
    'is_active'
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
    'is_active' => 'boolean',
  ];

  // Accessor untuk mendapatkan program_studi_id
  public function getProgramStudiIdAttribute()
  {
    return $this->programStudi?->id;
  }

  public function canAccessPanel(Panel $panel): bool
  {
    if (!$this->is_active) {
      return false;
    }

    if ($panel->getId() === 'gjm') {
      return $this->role === 'gjm';
    }

    if ($panel->getId() === 'ujm') {
      return $this->role === 'ujm';
    }

    return false;
  }

  public function getFilamentPanelUrl(): string
  {
    if ($this->role === 'gjm') {
      return '/gjm';
    } elseif ($this->role === 'ujm') {
      return '/ujm';
    }

    return '/';
  }

  public function isGJM(): bool
  {
    return $this->role === 'gjm';
  }

  public function isUJM(): bool
  {
    return $this->role === 'ujm';
  }

  public function isAsesor(): bool
  {
    return $this->role === 'asesor';
  }

  public function programStudi()
  {
    return $this->hasOne(ProgramStudi::class, 'ujm_id');
  }

  public function berita()
  {
    return $this->hasMany(Berita::class);
  }

  public function dokumen()
  {
    return $this->hasMany(Dokumen::class);
  }
}