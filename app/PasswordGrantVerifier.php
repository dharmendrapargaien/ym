<?php
namespace App;

use Illuminate\Support\Facades\Auth;

class PasswordGrantVerifier
{
  public function verify($email, $password)
  {
      $credentials = [
        'email'    => $email,
        'password' => $password,
      ];

      if (Auth::once($credentials)) {

        return Auth::user()->id;
      }
      return false;
  }
}
?>