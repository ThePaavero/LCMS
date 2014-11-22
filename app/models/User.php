<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

  protected $table  = "user";
  protected $hidden = ["password"];
<<<<<<< HEAD
  protected $fillable = ['username', 'email', 'role', 'password'];
=======
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f

  public function getAuthIdentifier()
  {
    return $this->getKey();
  }

  public function getAuthPassword()
  {
    return $this->password;
  }

  public function getRememberToken()
  {
    return $this->remember_token;
  }

  public function setRememberToken($value)
  {
    $this->remember_token = $value;
  }

  public function getRememberTokenName()
  {
    return "remember_token";
  }

  public function getReminderEmail()
  {
    return $this->email;
  }

}
