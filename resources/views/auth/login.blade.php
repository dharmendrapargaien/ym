@extends('layouts.auth')

@section('htmlheader_title')
    Log in
@endsection

@section('content')
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Admin</b>LTE</a>
        </div><!-- /.login-logo -->

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    
    
    <form action="{{ url('/login') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="col-xs-12">
                <label>
                        <input type="radio" name="check_user" class="user-type" value="buyer" checked="true" > B
                        <input type="radio" name="check_user" class="user-type" value="seller" > S
                    </label>
            </div><!-- /.col -->
           
        </div>
        <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email" name="email"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
        </div>
    </form>

    @include('auth.partials.social_login')

    <a href="{{ url('password/reset') }}" class="forgot-password">I forgot my password</a><br>
    <a href="{{ url('register') }}" class="text-center sign-up">Register a new membership</a>

</div><!-- /.login-box-body -->

</div><!-- /.login-box -->

    @include('layouts.partials.scripts_auth')
    <script>
        $(function () {
            
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });

            $('input').on('ifChecked', function(e){
                setLinks(this);
            });

            // if($('.user-type').val() == 'seller'){
                
            //     $('form').attr('action', "{{ url('seller/login')}}" );
            //     $('.social-auth-links').addClass('hide');
            // }
        });

        //set links 
        function setLinks(radioInput) {

            if($(radioInput).hasClass('user-type')) {

                var action = $('form').attr('action');
                if($(radioInput).val() == 'seller'){

                    $('form').attr('action', "{{ url('seller/login')}}" );
                    $('.forgot-password').attr('href', "{{ url('seller/password/reset')}}");
                    $('.sign-up').attr('href', " {{ url('seller/register') }}");
                    $('.social-auth-links').addClass('hide');
                } else {
                    
                    $('form').attr('action', "{{ url('login')}}");
                    $('.forgot-password').attr('href', "{{ url('password/reset')}}");
                    $('.sign-up').attr('href', " {{ url('register') }}");
                    
                    $('.social-auth-links').removeClass('hide');
                }
                console.log($('form').attr('action'));
            }
        }


    </script>
</body>

@endsection
