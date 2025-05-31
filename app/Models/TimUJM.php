<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimUJM extends Model
{
  use HasFactory;

  protected $table = 'tim_ujm';

  protected $fillable = [
    'program_studi_id',
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

  public function programStudi()
  {
    return $this->belongsTo(ProgramStudi::class);
  }

  // Method untuk reorder
  public function moveOrderUp()
  {
    $swapWith = self::where('program_studi_id', $this->program_studi_id)
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
    $swapWith = self::where('program_studi_id', $this->program_studi_id)
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