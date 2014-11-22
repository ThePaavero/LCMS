<?php

class UserSeeder extends DatabaseSeeder {

  public function run()
  {
    $users = [
      [
<<<<<<< HEAD
      	'role' => 1,
        'username' => 'root',
        'password' => Hash::make('root'),
        'email'    => 'root@example.com'
      ],
      [
      	'role' => 2,
=======
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
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