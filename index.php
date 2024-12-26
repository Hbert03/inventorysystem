<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LDN | INVENTORY SYSTEM</title>
  <link rel="icon" href="dist/img/depedldn.png">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body class="hold-transition login-page" >
>
	<div class="login-box" >
	<div class="card" style="margin-top:-4em">
	<div class="card-header text-center">
    <h5><b>INVENTORY MANAGEMENT SYSTEM</b></h5>
</div>
		<div class="login-logo">
			<img src="dist/img/DEPEDLOGO.png" class="disabled" width="60%;" height="60%;" alt="User Image">
		</div>
		<!-- /.login-logo -->
			<div class="card-body login-card-body">
				<form method="post" action="login_function.php">
					<div class="input-group mb-2">
					  <input type="text" class="form-control" id="uname" name="uname" value="<?php if (isset($_POST['uname'])) echo $_POST['uname']; ?>" placeholder="Username"  placeholder="Username">
					 	 <div class="input-group-append">
						<div class="input-group-text">
						  <span class="fas fa-envelope"></span>
						</div>
					  </div>
					</div>
				
					<div class="input-group mb-2">
					  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
					  <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-eye" id="togglePassword"></span>
        </div>
      </div> 
					</div>
					<div class="row">
						<div class="col-sm-12 mb-2 text-center">
							<button type="submit"  id="loginbut" name="loginbut" class="btn btn-primary btn-block btn-sm">Sign In</button>
						</div>
					</div>
				</form>
			</div>
	</div>
	</div>
</body>




<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<?php
if(isset($_SESSION['login']) && $_SESSION['login'] != '')
{
  ?>
  <script>
    toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
    };
    toastr.<?php echo $_SESSION['login_code']; ?>("<?php echo $_SESSION['login']; ?>");
  </script>

<?php
  unset($_SESSION['login']);
}
?>
<script>
  function togglePassword() {
    var passwordInput = document.getElementById('password');
    var eyeIcon = document.getElementById('togglePassword');

    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      eyeIcon.classList.remove('fa-eye');
      eyeIcon.classList.add('fa-eye-slash');
    } else {
      passwordInput.type = 'password';
      eyeIcon.classList.remove('fa-eye-slash');
      eyeIcon.classList.add('fa-eye');
    }
  }


  document.getElementById('togglePassword').addEventListener('click', function () {
    togglePassword();
  });
</script>
</body>
</html>