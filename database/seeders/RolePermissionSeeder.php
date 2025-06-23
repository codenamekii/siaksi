<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
  public function run()
  {
    // Reset cached roles and permissions
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    // Create roles
    $this->command->info('Creating roles...');

    $roles = ['super_admin', 'admin', 'asesor'];

    foreach ($roles as $roleName) {
      Role::firstOrCreate([
        'name' => $roleName,
        'guard_name' => 'web'
      ]);
      $this->command->info("✓ Role created: {$roleName}");
    }

    // Create permissions
    $this->command->info("\nCreating permissions...");

    $permissions = [
      // GJM/Super Admin permissions
      'manage_fakultas',
      'manage_all_users',
      'manage_all_dokumen',
      'manage_berita',
      'manage_jadwal_ami',
      'manage_akreditasi',
      'view_all_reports',

      // UJM/Admin permissions  
      'manage_prodi_users',
      'manage_prodi_dokumen',
      'manage_prodi_data',
      'manage_galeri',
      'manage_laporan',
      'toggle_document_visibility',

      // Asesor permissions
      'view_public_dokumen',
      'view_fakultas_dokumen',
      'view_prodi_dokumen',
      'view_additional_info',
    ];

    foreach ($permissions as $permissionName) {
      Permission::firstOrCreate([
        'name' => $permissionName,
        'guard_name' => 'web'
      ]);
    }
    $this->command->info("✓ Permissions created");

    // Assign permissions to roles
    $this->command->info("\nAssigning permissions to roles...");

    // Super Admin gets all permissions
    $superAdmin = Role::findByName('super_admin');
    $superAdmin->givePermissionTo(Permission::all());
    $this->command->info("✓ All permissions assigned to super_admin");

    // Admin/UJM permissions
    $admin = Role::findByName('admin');
    $admin->givePermissionTo([
      'manage_prodi_users',
      'manage_prodi_dokumen',
      'manage_prodi_data',
      'manage_galeri',
      'manage_laporan',
      'toggle_document_visibility',
      'view_prodi_dokumen'
    ]);
    $this->command->info("✓ Permissions assigned to admin");

    // Asesor permissions
    $asesor = Role::findByName('asesor');
    $asesor->givePermissionTo([
      'view_public_dokumen',
      'view_fakultas_dokumen',
      'view_prodi_dokumen',
      'view_additional_info'
    ]);
    $this->command->info("✓ Permissions assigned to asesor");

    // Assign roles to existing users
    $this->assignRolesToUsers();

    $this->command->info("\n✅ Role and permission setup completed!");
  }

  protected function assignRolesToUsers()
  {
    $this->command->info("\nAssigning roles to users...");

    // GJM users (super_admin)
    $gjmEmails = [
      'gjm@fakultas.ac.id',
      'admin.gjm@fakultas.ac.id'
    ];

    foreach ($gjmEmails as $email) {
      $user = User::where('email', $email)->first();
      if ($user && !$user->hasAnyRole()) {
        $user->assignRole('super_admin');
        $this->command->info("✓ Assigned super_admin to: {$email}");
      }
    }

    // UJM users (admin)
    $ujmUsers = User::where('email', 'like', 'ujm%')->get();
    foreach ($ujmUsers as $user) {
      if (!$user->hasAnyRole()) {
        $user->assignRole('admin');
        $this->command->info("✓ Assigned admin to: {$user->email}");
      }
    }

    // Asesor users
    $asesorUsers = User::where('email', 'like', 'asesor%')->get();
    foreach ($asesorUsers as $user) {
      if (!$user->hasAnyRole()) {
        $user->assignRole('asesor');
        $this->command->info("✓ Assigned asesor to: {$user->email}");
      }
    }

    // Show summary
    $this->command->info("\n📊 User Role Summary:");
    $this->command->info("Super Admin: " . User::role('super_admin')->count());
    $this->command->info("Admin (UJM): " . User::role('admin')->count());
    $this->command->info("Asesor: " . User::role('asesor')->count());

    $noRole = User::doesntHave('roles')->count();
    if ($noRole > 0) {
      $this->command->warn("Users without role: " . $noRole);

      // List users without roles
      $usersWithoutRole = User::doesntHave('roles')->get();
      foreach ($usersWithoutRole as $user) {
        $this->command->warn("  - {$user->email}");
      }
    }
  }
}
