<?php
namespace App;

use Illuminate\Support\Facades\Auth;

class PasswordGrantVerifier
{
  public function verify($email, $password)
  {
      
      $credentials['password'] = $password;

      //checking wheather it is a email or password
      if(is_numeric($email)){

        $credentials['phone_no'] = $email;
      } else {

        $credentials['email'] = $email;
      }

      if (Auth::once($credentials)) {

        return Auth::user()->id;
      }
      return false;
  }
}
?>