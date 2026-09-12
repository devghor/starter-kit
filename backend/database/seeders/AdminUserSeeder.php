<?php

namespace Database\Seeders;

use App\Enums\Settings\PermissionEnum;
use App\Models\Settings\Company;
use App\Models\Settings\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'sa@app.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_super_admin' => 1,
            ]
        );

        $c = Company::firstOrCreate(
            ['code' => 'INTELLYGO'],
            [
                'name' => 'Intellygo',
                'short_name' => 'ig',
                'address' => '',
                'plan' => 'basic',
            ]
        );

        $user->companies()->syncWithoutDetaching([$c->id]);

        setPermissionsTeamId($c->id);

        $role = Role::firstOrCreate(['name' => 'SUPER_ADMIN', 'company_id' => $c->id, 'guard_name' => 'sanctum']);

        $role->givePermissionTo(array_column(PermissionEnum::cases(), 'value'));

        $user->assignRole($role);
    }
}
