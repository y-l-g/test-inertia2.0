<?php

namespace Database\Seeders;

use App\Enum\PermissionsEnum;
use App\Enum\RolesEnum;
use App\Models\Comment;
use App\Models\Feature;
use App\Models\Upvote;
use App\Models\User;
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

        $user = User::factory()->create([
            'name' => 'User User',
            'email' => 'user@example.com',
        ])->assignRole(RolesEnum::User);
        $commenter = User::factory()->create([
            'name' => 'Commenter User',
            'email' => 'commenter@example.com',
        ])->assignRole(RolesEnum::Commenter);
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ])->assignRole(RolesEnum::Admin);

        Feature::factory(50)
            ->has(Comment::factory(50)
                ->sequence(
                    ['user_id' => $commenter->id],
                    ['user_id' => $admin->id]
                ))
            ->has(Upvote::factory(3)
                ->sequence(
                    ['user_id' => $user->id],
                    ['user_id' => $commenter->id],
                    ['user_id' => $admin->id]
                ))

            ->create([
                'user_id' => $admin
            ]);
    }
}
