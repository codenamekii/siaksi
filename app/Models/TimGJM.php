<?php

// 1. Update app/Models/TimGJM.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimGJM extends Model
{
  use HasFactory;

  protected $table = 'tim_gjm';

  protected $fillable = [
    'fakultas_id',
    'nama',
    'jabatan',
    'nuptk',
    'email',
    'telepon',
    'foto',
    'urutan',
    'is_active'
  ];

  protected $casts = [
    'is_active' => 'boolean',
  ];

  public function fakultas()
  {
    return $this->belongsTo(Fakultas::class);
  }

  // Method untuk reorder
  public function moveOrderUp()
  {
    $swapWith = self::where('fakultas_id', $this->fakultas_id)
      ->where('urutan', '<', $this->urutan)
      ->orderBy('urutan', 'desc')
      ->first();

    if ($swapWith) {
      $tempOrder = $this->urutan;
      $this->urutan = $swapWith->urutan;
      $swapWith->urutan = $tempOrder;

      $this->save();
      $swapWith->save();
    }
  }

  public function moveOrderDown()
  {
    $swapWith = self::where('fakultas_id', $this->fakultas_id)
      ->where('urutan', '>', $this->urutan)
      ->orderBy('urutan', 'asc')
      ->first();

    if ($swapWith) {
      $tempOrder = $this->urutan;
      $this->urutan = $swapWith->urutan;
      $swapWith->urutan = $tempOrder;

      $this->save();
      $swapWith->save();
    }
  }
}
