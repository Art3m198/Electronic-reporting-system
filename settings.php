<!DOCTYPE html>
<html lang="en">
  <head>
<title>Report system</title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
<?php 
require 'db.php';
$data = $_POST;
$id = $_SESSION['logged_user']->id;
$lastname = $_SESSION['logged_user']->lastname;
$firstname = $_SESSION['logged_user']->firstname;
$group = $_SESSION['logged_user']->group;
$email = $_SESSION['logged_user']->email;
$right = $_SESSION['logged_user']->right;
$photo = $_SESSION['logged_user']->photo;
if ($right == 1) { $right1 = 'Admin';}
	
	if ( isset($data['send']) )
	{		
    $newlastname = $data['lastname'];
    $newfirstname = $data['firstname'];
    $newemail = $data['email'];
    $newpassword = password_hash($data['password'], PASSWORD_DEFAULT); 
    if ($newlastname !== "") { $_SESSION['logged_user']->lastname = $newlastname ; R::exec("UPDATE users SET lastname = '$newlastname' WHERE id = $id"); }
    if ($newfirstname !== "") { $_SESSION['logged_user']->firstname = $newfirstname ; R::exec("UPDATE users SET firstname = '$newfirstname' WHERE id = $id"); }
    if ($newemail !== "") { $_SESSION['logged_user']->email = $newemail; R::exec("UPDATE users SET email = '$newemail' WHERE id = $id"); }
    if ($password !== "") { $_SESSION['logged_user']->password = $newpassword ; R::exec("UPDATE users SET password = '$newpassword' WHERE id = $id"); }
    if ($file !== "") { $folder = 'upload/profile/' . $id; // DIR
    mkdir($folder);	
    $temp = explode(".", $_FILES["file"]["name"]);
    $newfilename = $id . '.' . png;
    $path = $folder. "/" .$newfilename;
    move_uploaded_file($_FILES["file"]["tmp_name"], $path);
    $photo = "upload/profile/" . $id . "/" . $id . ".png";
    $_SESSION['logged_user']->photo = $photo; 
    R::exec("UPDATE users SET photo = '$photo' WHERE id = $id");                 
                      }
    $_POST = NULL;
    header('Location: settings.php?up=1');
			exit;
  }
?>

<?php if ( isset ($_SESSION['logged_user']) ) : ?>
<body class="app sidebar-mini">
	<?php
	if($_GET['up']){
    ?><script type="text/javascript">
setTimeout(function () { 
swal({
  title: "Done!",
  text: "Your profile is updated successfully",
  type: "success",
  confirmButtonText: "OK"
},
function(isConfirm){
  if (isConfirm) {
    window.location.href = "settings.php";
  }
}); }, 1);
    </script> <?php
} unset($_GET);?>
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="index.php">Reports</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="settings.php"><i class="fa fa-cog fa-lg"></i> Settings</a></li>
            <li><a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><a href = "settings.php"><img class="app-sidebar__user-avatar" src="<?php echo $photo ?>" width="48" height="48" alt="User Image"></a>
        <div>
          <p class="app-sidebar__user-name"><?php echo $_SESSION['logged_user']->lastname;?>  </p>
		  <p class="app-sidebar__user-name"><?php echo $_SESSION['logged_user']->firstname;?> </p>
		  <p class="app-sidebar__user-designation"><?php if ($right == 1) {echo $right1;} else {echo 'Group: '. $_SESSION['logged_user']->group;}?></p>
        </div>
      </div>
      <ul class="app-menu">
      <?php 
      if ($right == 0) { 
        echo '<li><a class="app-menu__item" href="index.php"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Reports</span></a></li>';
                      } 
      ?>
      <?php 
      if ($right == 1) { 
        echo '<li><a class="app-menu__item" href="index.php"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Admin panel</span></a></li>';
                      } 
      ?>
        <li><a class="app-menu__item  active" href="settings.php"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Settings</span></a></li><br>
		<a class="app-menu__item" href="logout.php"><i class="app-menu__icon fa fa-sign-out"></i><span class="app-menu__label">Logout</span></a>
      </ul>
    </aside>
    <main class="app-content">
	      <div class="app-title">
        <div>
          <h1><i class=""></i> Welcome, <?php echo $_SESSION['logged_user']->lastname;?> <?php echo $_SESSION['logged_user']->firstname;?></h1>
          <p><?php if ($right == 1) {echo $right1;} else {echo 'Group: '. $_SESSION['logged_user']->group;}?></p>
        </div>
      </div>
<div class="row">
	  	  <div class="col-md-12">
          <div class="tile">
            <section class="dash">
              <div class="row mb-4">
                <div class="col-6">
                  <h2 class="page-header"><i class="fa"></i>Settings</h2>
                </div>
                <div class="col-6">
                  <h5 class="text-right"><?php echo date("d/m/Y");?></h5>
                </div>
              </div>
              <div class="row">
                <div class="tile-body col-md-12">
				 <div class="col-md-6">
              <form class="form-horizontal" action="" enctype="multipart/form-data" method="post" id="form" name="form">
                <div class="form-group row">
                  <label class="control-label col-md-3">Lastname</label>
                  <div class="col-md-8">
                    <input class="form-control" readonly type="text" name = "lastnameold" value="<?php echo $lastname; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-3">New lastname</label>
                  <div class="col-md-8">
                    <input class="form-control" id="1" type="text" name = "lastname">
                  </div>
                </div><hr>
                <div class="form-group row">
                  <label class="control-label col-md-3">Firstname</label>
                  <div class="col-md-8">
                    <input class="form-control" readonly type="text" name = "firstnameold" value="<?php echo $firstname; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-3">New firstname</label>
                  <div class="col-md-8">
                    <input class="form-control" id="2" type="text" name = "firstname" >
                  </div>
                </div><hr>
                <div class="form-group row">
                  <label class="control-label col-md-3">Email</label>
                  <div class="col-md-8">
                    <input class="form-control" readonly type="email" name = "emailold" value="<?php echo $email; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-3">New email</label>
                  <div class="col-md-8">
                    <input class="form-control" id="4" type="email" name = "email">
                  </div>
                </div><hr>
                <div class="form-group row">
                  <label class="control-label col-md-3">Photo <br> </label>
                  <div class="col-md-8">
                    <input id= "file1" class="form-control" name= "file" type="file">
					<input type="hidden" id ="file2" class="form-control" name= "file" >
                  </div>
                </div><hr>
                <div class="form-group row">
                  <label class="control-label col-md-3">Password</label>
                  <div class="col-md-8">
                    <input class="form-control" type="text" name = "password">
                  </div>
                </div>
                <div class="send">
				 <button class="btn btn-primary" name = "send" id="send" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>
                </div>
              </form>
        </div>
			    </div>
              </div>
            </section>
          </div>
        </div>
</div>
    </main>
</body>

<?php else : 
header('Location: login.php');?>
<?php endif; ?>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
	<script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript" src="js/plugins/select2.min.js"></script>
	<script src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
		<script type="text/javascript" src="js/plugins/bootstrap-notify.min.js"></script>
    <script type="text/javascript" src="js/plugins/sweetalert.min.js"></script>
	<script type="text/javascript" src="dist/jquery.tabledit.js"></script>
	<script type="text/javascript" src="custom_table_edit.js"></script>
    <script type="text/javascript">
      $('#sl').on('click', function(){
      	$('#tl').loadingBtn();
      	$('#tb').loadingBtn({ text : "Signing In"});
      });
      
      $('#el').on('click', function(){
      	$('#tl').loadingBtnComplete();
      	$('#tb').loadingBtnComplete({ html : "Sign In"});
      });
      
      $('#demoDate').datepicker({
      	format: "dd/mm/yyyy",
      	autoclose: true,
      	todayHighlight: true
      });
      
      $('#demoSelect').select2();
    </script>
		
    <script type="text/javascript">$('#Table').DataTable({"order": [],});</script>
    <script type="text/javascript">$('#Table2').DataTable({"order": [],});</script>
	<script type="text/javascript"> 
document.getElementById('file1').onchange = function () {
    document.getElementById('file2').value = document.getElementById('file1').value.replace(/.*[\\\/]/, "");
}
	</script>
  <script type="text/javascript">
		$("#1,#2").on('keyup', function(e) {
    var arr = $(this).val().split('.');
    var result = '';
    for (var x = 0; x < arr.length; x++) {
        result += arr[x].replace(/^\s+/, '').charAt(0).toUpperCase() + arr[x].replace(/^\s+/, '').slice(1) + '. ';
    }
    $(this).val(result.substring(0, result.length - 2));
});
</script>
</html>