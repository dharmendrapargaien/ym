<?php
namespace App;

use app\Models\Seller;
use app\Models\Buyer;

class PasswordGrantVerifier
{
  public function verify($email, $password)
  {
    //get service for
    $api_type = \Request::segment(2);
    
    switch ($api_type) {

      case 'seller': //if api id for seller
        
        $user = Seller::where(function($query) use($email){
          if(is_numeric($email)){

            $query->wherePhoneNo($email);
          } else { //if api id for buyer

            $query->whereEmail($email);
          }
        })->whereStatus(1)->firstOrFail();
        
        break;
      
      case 'buyer':

        $user = Buyer::where(function($query) use($email){
          if(is_numeric($email)){

            $query->wherePhoneNo($email);
          } else { //if api id for buyer

            $query->whereEmail($email);
          }
        })->whereStatus(1)->firstOrFail();
        break;
      
      default:
          return false;
        break;
    }

    if (\Hash::check($password, $user->password)) {

      return $user->id;
    }
    
    return false;
  }
}
?>
