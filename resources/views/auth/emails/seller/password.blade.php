{{-- resources/views/emails/password.blade.php --}}
 
Click here to reset your password: <a href="{{ url('seller/password/reset/'.$token) }}">{{ url('seller/password/reset/'.$token) }}</a>