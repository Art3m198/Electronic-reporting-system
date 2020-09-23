<?php 
	require 'db.php';
	$data = $_POST;
	
	if ( isset($data['signup']) )
	{		
			$errors = array();
		if ( R::count('users', "email = ?", array($data['email'])) > 0)
		{
			$errors[] = 'A user with this Email already exists!';
		}
				if ( empty($errors) )
		{
	
      $user = R::dispense('users');
      $user->right = "0";
			$user->lastname = $data['lastname'];
			$user->firstname = $data['firstname'];
			$user->group = $data['group'];
			$user->email = $data['email'];
			$user->password = $data['password'];
			$user->password = password_hash($data['password'], PASSWORD_DEFAULT); 
			$user->photo = "upload/profile/newuser/image.png";
      R::store($user);
      $_POST = NULL;
			header('Location: login.php?reg=1');
			exit();
			}else
		{
			echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>';
		}
	}

	if ( isset($data['login']) )
	{
		$user = R::findOne('users', 'email = ?', array($data['email']));
		if ( $user )
		{
		
			if ( password_verify($data['password'], $user->password) )
			{
			
				$_SESSION['logged_user'] = $user;
			}else
			{
				$errors[] = 'Invalid password!';
			}

		}else
		{
			$errors[] = 'The user with this username was not found!';
		}
		
		if ( ! empty($errors) )
		{
			echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>';
		}

	}
?>
<?php if ( isset ($_SESSION['logged_user']) ) : 
header('Location: index.php');?>
<?php else : ?>
<!DOCTYPE html>
<html lang="en">
	<head>
<title>Report system</title>
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
<body>
	<script type="text/javascript" src="js/plugins/bootstrap-notify.min.js"></script>
    <script type="text/javascript" src="js/plugins/sweetalert.min.js"></script>
	<?php
	if($_GET['reg']){
    ?><script type="text/javascript">
setTimeout(function () { 
swal({
  title: "Done!",
  text: "Your account is registered. Thank you!",
  type: "success",
  confirmButtonText: "OK"
},
function(isConfirm){
  if (isConfirm) {
    window.location.href = "login.php";
  }
}); }, 1);
    </script> <?php
} unset($_GET);?>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>Report system</h1>
      </div>	
        <div class="login-box"> 
    <form class="login-form" action="" method="POST">		
    <h5 class="login-head"> <p class="semibold-text mb-2">SIGN IN |<a href="" data-toggle="flip"> REGISTRATION </a></p></h5>
                            <div class="form-group">
                                       <label class="control-label">USERNAME</label>
                                        <input id="login-username" autocomplete="off" type="email" class="form-control" name="email" value="" placeholder="email" required>                                        
                                    </div>
                            <div class="form-group">
                                        <label class="control-label">PASSWORD</label>
                                        <input id="login-password" autocomplete="off" type="password" class="form-control" name="password" placeholder="password" required>
                            </div>
		            <div class="form-group btn-container">
            <button type="submit" name="login" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
          </div>
		  </form>
		          <form class="forget-form" id = "reg" action="" method="POST" >
             <h5 class="login-head"> <p class="semibold-text mb-0"><a href="" data-toggle="flip">SIGN IN </a> | REGISTRATION </p></h5>
								<div class="form-group ">
                                    <label class="control-label">Last Name</label>
                               
                                        <input type="text" id="1" autocomplete="off" class="form-control" name="lastname" placeholder="Last Name" required onkeyup="return check(this);">
                                    
                                </div>
                                <div class="form-group">
                                     <label class="control-label">First Name</label>
                                   
                                        <input type="text" id="2" autocomplete="off" class="form-control" name="firstname" placeholder="First Name"required onkeyup="return check(this);" >
                                  
                                </div>
								                                <div class="form-group">
                                    <label class="control-label">Group</label>
                                    
                                        <input type="text" id="3" autocomplete="off" class="form-control" name="group" placeholder="Group" required >
                                    
                                </div>
								<div class="form-group">
                                     <label class="control-label">Email</label>
                                    
                                        <input type="email" autocomplete="off" class="form-control" name="email" placeholder="Email Address" required>
                                    
                                </div>
                                <div class="form-group">
                                     <label class="control-label">Password</label>
                                   
                                        <input type="password" autocomplete="off" class="form-control" name="password" placeholder="Password" required>
                                    
                                </div>
								
								                                <div class="form-group">
                                    <!-- Button -->                         
                                    <div class="form-group btn-container">
                                    <div class="signup">
                                      <button type="submit" name="signup" id="signup"class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>Register</button>
                                    </div>
                                    </div>
                                </div>
          <div class="form-group mt-3">
            <p class="semibold-text mb-0"><a href="" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
          </div>
        </form>
		      </div>
	 </section>
	    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
    </script>
	<script type="text/javascript"> 
function check(input) { 
    var value = input.value; 
    var rep = /[^' 'A-Za-z]/;  
    if (rep.test(value)) { 
        value = value.replace(rep, ''); 
        input.value = value; 
    } 
} 
</script>
<script type="text/javascript">
		$("#1,#2,#3").on('keyup', function(e) {
    var arr = $(this).val().split('.');
    var result = '';
    for (var x = 0; x < arr.length; x++) {
        result += arr[x].replace(/^\s+/, '').charAt(0).toUpperCase() + arr[x].replace(/^\s+/, '').slice(1) + '. ';
    }
    $(this).val(result.substring(0, result.length - 2));
});
</script>
<script>
$(document).ready(function() {
  $('#signup').click(function() {
    $(".signup").css("display", "none");
  });
});
</script>
</body>
</html>
<?php endif; ?>