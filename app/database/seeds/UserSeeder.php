<?php

class UserSeeder extends DatabaseSeeder {

  public function run()
  {
    $users = [
      [
      	'role' => 1,
        'username' => 'root',
        'password' => Hash::make('root'),
        'email'    => 'root@example.com'
      ],
      [
      	'role' => 2,
        'username' => 'admin',
        'password' => Hash::make('admin'),
        'email'    => 'admin@example.com'
      ]
    ];

    foreach ($users as $user) {
      User::create($user);
    }
  }

}