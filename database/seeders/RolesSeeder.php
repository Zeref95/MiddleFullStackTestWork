<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    private array $roles = [
        Role::ROLE_ADMIN => 'Administrator',
        Role::ROLE_USER => 'User',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $slug => $roleName) {
            $DBRole = Role::firstOrNew([
                'slug' => $slug,
            ]);
            $DBRole->name = $roleName;
            $DBRole->save();
        }
    }
}
