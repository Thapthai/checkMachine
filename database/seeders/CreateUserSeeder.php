<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            // [
            //     'name' => 'admin',
            //     'username' => 'admin',
            //     'is_admin' => '1',
            //     'email' => 'admin@admin.com',
            //     'password' => bcrypt('123456'),
            // ],
            // [
            //     'name' => 'user',
            //     'username' => 'username',
            //     'is_admin' => '0',
            //     'email' => 'username@username.com',
            //     'password' => bcrypt('123456'),
            // ],

            // PK user - Head
            [
                'name' => 'pkhead1',
                'username' => 'pkhead1',
                'is_admin' => '1',
                'email' => 'pkhead1@username.com',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'pkhead2',
                'username' => 'pkhead2',
                'is_admin' => '1',
                'email' => 'pkhead2@username.com',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'pkhead3',
                'username' => 'pkhead3',
                'is_admin' => '1',
                'email' => 'pkhead3@username.com',
                'password' => bcrypt('123456'),
            ], [
                'name' => 'pkhead4',
                'username' => 'pkhead4',
                'is_admin' => '1',
                'email' => 'pkhead4@username.com',
                'password' => bcrypt('123456'),
            ], [
                'name' => 'pkhead5',
                'username' => 'pkhead5',
                'is_admin' => '1',
                'email' => 'pkhead5@username.com',
                'password' => bcrypt('123456'),
            ],

            // PK user - Check
            [
                'name' => 'pkcheck1',
                'username' => 'pkcheck1',
                'is_admin' => '0',
                'email' => 'pkcheck1@username.com',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'pkcheck2',
                'username' => 'pkcheck2',
                'is_admin' => '0',
                'email' => 'pkcheck2@username.com',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'pkcheck3',
                'username' => 'pkcheck3',
                'is_admin' => '0',
                'email' => 'pkcheck3@username.com',
                'password' => bcrypt('123456'),
            ], [
                'name' => 'pkcheck4',
                'username' => 'pkcheck4',
                'is_admin' => '0',
                'email' => 'pkcheck4@username.com',
                'password' => bcrypt('123456'),
            ], [
                'name' => 'pkcheck5',
                'username' => 'pkcheck5',
                'is_admin' => '0',
                'email' => 'pkcheck5@username.com',
                'password' => bcrypt('123456'),
            ],

            // PF user - Head
            [
                'name' => 'pfhead1',
                'username' => 'pfhead1',
                'is_admin' => '1',
                'email' => 'pfhead1@username.com',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'pfhead2',
                'username' => 'pfhead2',
                'is_admin' => '1',
                'email' => 'pfhead2@username.com',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'pfhead3',
                'username' => 'pfhead3',
                'is_admin' => '1',
                'email' => 'pfhead3@username.com',
                'password' => bcrypt('123456'),
            ], [
                'name' => 'pfhead4',
                'username' => 'pfhead4',
                'is_admin' => '1',
                'email' => 'pfhead4@username.com',
                'password' => bcrypt('123456'),
            ], [
                'name' => 'pfhead5',
                'username' => 'pfhead5',
                'is_admin' => '1',
                'email' => 'pfhead5@username.com',
                'password' => bcrypt('123456'),
            ],

            // PF user - check
            [
                'name' => 'pfcheck1',
                'username' => 'pfcheck1',
                'is_admin' => '0',
                'email' => 'pfcheck1@username.com',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'pfcheck2',
                'username' => 'pfcheck2',
                'is_admin' => '0',
                'email' => 'pfcheck2@username.com',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'pfcheck3',
                'username' => 'pfcheck3',
                'is_admin' => '0',
                'email' => 'pfcheck3@username.com',
                'password' => bcrypt('123456'),
            ], [
                'name' => 'pfcheck4',
                'username' => 'pfcheck4',
                'is_admin' => '0',
                'email' => 'pfcheck4@username.com',
                'password' => bcrypt('123456'),
            ], [
                'name' => 'pfcheck5',
                'username' => 'pfcheck5',
                'is_admin' => '0',
                'email' => 'pfcheck5@username.com',
                'password' => bcrypt('123456'),
            ],

            // RTE user - Head
            [
                'name' => 'rtehead1',
                'username' => 'rtehead1',
                'is_admin' => '1',
                'email' => 'rtehead1@username.com',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'rtehead2',
                'username' => 'rtehead2',
                'is_admin' => '1',
                'email' => 'rtehead2@username.com',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'rtehead3',
                'username' => 'rtehead3',
                'is_admin' => '1',
                'email' => 'rtehead3@username.com',
                'password' => bcrypt('123456'),
            ], [
                'name' => 'rtehead4',
                'username' => 'rtehead4',
                'is_admin' => '1',
                'email' => 'rtehead4@username.com',
                'password' => bcrypt('123456'),
            ], [
                'name' => 'rtehead5',
                'username' => 'rtehead5',
                'is_admin' => '1',
                'email' => 'rtehead5@username.com',
                'password' => bcrypt('123456'),
            ],

            // RTE user - check
            [
                'name' => 'rtecheck1',
                'username' => 'rtecheck1',
                'is_admin' => '0',
                'email' => 'rtecheck1@username.com',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'rtecheck2',
                'username' => 'rtecheck2',
                'is_admin' => '0',
                'email' => 'rtecheck2@username.com',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'rtecheck3',
                'username' => 'rtecheck3',
                'is_admin' => '0',
                'email' => 'rtecheck3@username.com',
                'password' => bcrypt('123456'),
            ], [
                'name' => 'rtecheck4',
                'username' => 'rtecheck4',
                'is_admin' => '0',
                'email' => 'rtecheck4@username.com',
                'password' => bcrypt('123456'),
            ], [
                'name' => 'rtecheck5',
                'username' => 'rtecheck5',
                'is_admin' => '0',
                'email' => 'rtecheck5@username.com',
                'password' => bcrypt('123456'),
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
