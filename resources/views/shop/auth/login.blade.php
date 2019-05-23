<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="/loginResource/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/loginResource/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/loginResource/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/loginResource/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/loginResource/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="/loginResource/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/loginResource/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/loginResource/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="/loginResource/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/loginResource/css/util.css">
	<link rel="stylesheet" type="text/css" href="/loginResource/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('/loginResource/images/bg.jpg');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					Account Login
				</span>
				<div class="flash-message">
					@foreach (['danger', 'warning', 'success', 'info'] as $msg)
						@if(Session::has('alert-' . $msg))
						<p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
						@endif
					@endforeach
					@if( Session::has( 'success' ))
						<p class="alert alert-success">{{ Session::get( 'success' ) }}</p>
					@elseif( Session::has( 'warning' ))
						<p class="alert alert-warning">{{ Session::get( 'warning' ) }}</p>
						 <!-- here to 'withWarning()' -->
					@endif
				</div>
				<form class="login100-form validate-form p-b-33 p-t-5" action="/login" method="post">
                    {{ csrf_field() }}
					<div class="wrap-input100 validate-input" data-validate = "Enter Email">
						<input class="input100" type="email" name="email" placeholder="Email">
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>
                    
                    <div class="row">
                        <div class="col-12 text-center my-2">
                            <p>Don't have account? <a href="/register" style="color:blue">Register</a></p>
                        </div>
                    </div>

					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn">
							Login
						</button>
                    </div>
                    

				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="/loginResource/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="/loginResource/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="/loginResource/vendor/bootstrap/js/popper.js"></script>
	<script src="/loginResource/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="/loginResource/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="/loginResource/vendor/daterangepicker/moment.min.js"></script>
	<script src="/loginResource/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="/loginResource/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="/loginResource/js/main.js"></script>

</body>
</html>