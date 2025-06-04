<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixMiddleware extends Command
{
  protected $signature = 'fix:middleware';
  protected $description = 'Check and fix middleware issues';

  public function handle()
  {
    $this->info('Checking middleware configuration...');

    // Path ke file middleware
    $middlewarePath = app_path('Http/Middleware/RedirectIfNotAsesor.php');

    if (!File::exists($middlewarePath)) {
      $this->error('❌ RedirectIfNotAsesor.php not found!');
      $this->info('Creating it now...');

      $content = <<<PHP
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotAsesor
{
    public function handle(Request \$request, Closure \$next): Response
    {
        if (auth()->check() && auth()->user()->role === 'asesor') {
            return \$next(\$request);
        }

        abort(403, 'Unauthorized access.');
    }
}

PHP;

      File::put($middlewarePath, $content);
      $this->info('✅ Created RedirectIfNotAsesor.php');
    } else {
      $this->info('✅ RedirectIfNotAsesor.php exists');
    }

    // Cek apakah alias middleware sudah didaftarkan di Kernel.php
    $kernelPath = app_path('Http/Kernel.php');

    if (!File::exists($kernelPath)) {
      $this->error('❌ Kernel.php not found!');
      return;
    }

    $kernelContent = File::get($kernelPath);

    if (strpos($kernelContent, "'asesor' =>") === false) {
      $this->error('❌ Middleware alias not found in Kernel.php');
      $this->info('Tambahkan ini secara manual ke \$middlewareAliases:');
      $this->line("'asesor' => \App\Http\Middleware\RedirectIfNotAsesor::class,");
    } else {
      $this->info('✅ Middleware alias ditemukan di Kernel.php');
    }

    // Bersihkan cache
    $this->info("\nClearing cache...");
    $this->call('cache:clear');
    $this->call('config:clear');
    $this->call('route:clear');
    $this->call('view:clear');
    $this->call('optimize:clear');

    $this->info("\n✅ Middleware check completed!");
    $this->info("Coba akses ulang /asesor/dashboard.");
  }
}