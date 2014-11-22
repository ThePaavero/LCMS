<?php

class UserRoleSeeder extends DatabaseSeeder {

  public function run()
  {
    $roles = [
      [
        'title' => 'Root'
      ],
      [
      	'title' => 'Admin'
      ]
    ];

    foreach ($roles as $role) {
      UserRole::create($role);
    }
  }

}