<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        for ($i = 1; $i <= 100; $i ++) {
            $account = Account::create([
                'code' => rand(10000000, 99999999),
                'email' => 'creator'. $i . '@rabiloo.com',
                'password' => bcrypt('12345678'),
                'userable_type' => 'Creator'
            ]);

            $account->accountProfile()->create([
                'first_name' => 'Nguyễn Viết',
                'last_name' => 'Account '. $i,
                'image' => '',
                'description' => 'Chào mừng bạn đến với thế giới của chúng ta',
                'remark' => 'Mãi mãi yêu các bạn',
            ]);

            DB::table('model_has_roles')->insert(
                [
                    'role_id' => 3,
                    'model_type' => 'App\Models\Account',
                    'model_id' => $account->id,
                ]
            );
        }

        for ($i = 1; $i <= 50; $i ++) {
            $account = Account::create([
                'code' => rand(10000000, 99999999),
                'email' => 'user'. $i . '@rabiloo.com',
                'password' => bcrypt('12345678'),
                'userable_type' => 'Reader'
            ]);

            $account->accountProfile()->create([
                'first_name' => 'Nguyễn Viết',
                'last_name' => 'User '. $i,
                'description' => 'Chào mừng bạn đến với thế giới của chúng ta',
                'remark' => 'Mãi mãi yêu các bạn',
                'image' => ''
            ]);

            DB::table('model_has_roles')->insert(
                [
                    'role_id' => 4,
                    'model_type' => 'App\Models\Account',
                    'model_id' => $account->id,
                ]
            );
        }
    }
}
