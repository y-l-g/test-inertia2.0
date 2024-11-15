<?php

namespace Database\Seeders;

use App\Enum\PermissionsEnum;
use App\Enum\RolesEnum;
use App\Models\Feature;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{


    public function run(): void
    {
        $manageFeaturesPermission = Permission::create(['name' => PermissionsEnum::ManageFeatures]);
        $manageUsersPermission = Permission::create(['name' => PermissionsEnum::ManageUsers]);
        $manageCommentsPermission = Permission::create(['name' => PermissionsEnum::ManageComments]);
        $managePostsPermission = Permission::create(['name' => PermissionsEnum::ManagePosts]);
        $upVoteDownVote = Permission::create(['name' => PermissionsEnum::UpVoteDownVote]);

        Role::create(['name' => RolesEnum::User])
            ->syncPermissions($upVoteDownVote);
        Role::create(['name' => RolesEnum::Commenter])
            ->syncPermissions($upVoteDownVote, $manageCommentsPermission);
        Role::create(['name' => RolesEnum::Admin])
            ->syncPermissions([
                $manageFeaturesPermission,
                $manageUsersPermission,
                $manageCommentsPermission,
                $managePostsPermission,
                $upVoteDownVote,
            ]);

        User::factory()->create([
            'name' => 'User User',
            'email' => 'user@example.com',
        ])->assignRole(RolesEnum::User);
        User::factory()->create([
            'name' => 'Commenter User',
            'email' => 'commenter@example.com',
        ])->assignRole(RolesEnum::Commenter);
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ])->assignRole(RolesEnum::Admin);

        Feature::factory(100)->create();
    }
}
