<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TestAsesorLogin extends Command
{
  protected $signature = 'test:asesor-login {email?}';
  protected $description = 'Test asesor login and check permissions';

  public function handle()
  {
    $email = $this->argument('email') ?? 'asesor1@universitas.ac.id';

    $this->info("Testing login for: {$email}");
    $this->newLine();

    // Find user
    $user = User::where('email', $email)->first();

    if (!$user) {
      $this->error("User not found with email: {$email}");
      return;
    }

    // Display user info
    $this->info("User found:");
    $this->table(
      ['Field', 'Value'],
      [
        ['ID', $user->id],
        ['Name', $user->name],
        ['Email', $user->email],
        ['Role', $user->role],
        ['Is Active', $user->is_active ? 'Yes' : 'No'],
        ['Created At', $user->created_at],
      ]
    );

    // Test password
    $this->newLine();
    $this->info("Testing password 'password123'...");
    if (Hash::check('password123', $user->password)) {
      $this->info("✅ Password is correct!");
    } else {
      $this->error("❌ Password is incorrect!");
    }

    // Test role check methods
    $this->newLine();
    $this->info("Testing role check methods:");
    $this->line("isAsesor(): " . ($user->isAsesor() ? '✅ true' : '❌ false'));
    $this->line("isGJM(): " . ($user->isGJM() ? '❌ false' : '✅ true'));
    $this->line("isUJM(): " . ($user->isUJM() ? '❌ false' : '✅ true'));

    // Test manual login
    $this->newLine();
    $this->info("Testing manual login...");
    Auth::login($user);

    if (Auth::check()) {
      $this->info("✅ Login successful!");
      $this->line("Current user: " . Auth::user()->name);
      $this->line("Current role: " . Auth::user()->role);

      // Test middleware logic
      $this->newLine();
      $this->info("Testing middleware logic:");

      if (Auth::user()->role === 'asesor') {
        $this->info("✅ User role is 'asesor' - should be able to access asesor dashboard");
      } else {
        $this->error("❌ User role is not 'asesor' - will get 403 error");
      }

      if (Auth::user()->is_active) {
        $this->info("✅ User is active");
      } else {
        $this->error("❌ User is not active - will be logged out");
      }

      // Logout
      Auth::logout();
      $this->line("Logged out.");
    } else {
      $this->error("❌ Login failed!");
    }

    // Show all asesor users
    $this->newLine();
    $this->info("All asesor users in database:");
    $asesorUsers = User::where('role', 'asesor')->get(['id', 'name', 'email', 'is_active']);
    $this->table(
      ['ID', 'Name', 'Email', 'Active'],
      $asesorUsers->map(function ($user) {
        return [
          $user->id,
          $user->name,
          $user->email,
          $user->is_active ? 'Yes' : 'No'
        ];
      })
    );

    // Create new asesor if needed
    if ($this->confirm('Do you want to create a new test asesor user?')) {
      $testUser = User::create([
        'name' => 'Test Asesor',
        'email' => 'test.asesor@universitas.ac.id',
        'password' => Hash::make('password123'),
        'role' => 'asesor',
        'is_active' => true,
        'nuptk' => '199001011990011001',
        'phone' => '081234567899'
      ]);

      $this->info("✅ Created test asesor user:");
      $this->line("Email: test.asesor@universitas.ac.id");
      $this->line("Password: password123");
    }
  }
}