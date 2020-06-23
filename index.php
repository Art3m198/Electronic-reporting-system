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
$right = $_SESSION['logged_user']->right;
$photo = $_SESSION['logged_user']->photo;
if ($right == 1) { $right1 = 'Admin';}
$date = date("d.m.Y H:i");
	
	if ( isset($data['send']) )
	{		
$folder = 'upload/' . $id; // DIR
mkdir($folder);	
$temp = explode(".", $_FILES["file"]["name"]);
$newfilename = round(microtime(true)) . '.' . end($temp);
$path = $folder. "/" .$newfilename;
move_uploaded_file($_FILES["file"]["tmp_name"], $path);
			$rep = R::dispense('reports');
      $rep->idreport = $id;
      $rep->lastname = $lastname;
      $rep->firstname = $firstname;
			$rep->group = $group;
			$rep->date = $date;
      $rep->name = $data['name'];
      $rep->disc = $data['disc'];
			$rep->file = $path;
			$rep->estimation = "";
			$rep->signature = "";
      R::store($rep);
      $_POST = NULL;
			header('Location: index.php?up=1');
			exit;
  }
  
  if ( isset($data['delete']) )
	{
  $delid = $data ['deletecopy'];
  $sql = R::exec("DELETE FROM reports WHERE id = $delid"); 
  header('Location: index.php');
  exit;
	}
?>

<?php if ( isset ($_SESSION['logged_user']) and $right == 0) : ?>
<body class="app sidebar-mini">
	<?php
	if($_GET['up']){
    ?><script type="text/javascript">
setTimeout(function () { 
swal({
  title: "Done!",
  text: "You uploaded the file successfully",
  type: "success",
  confirmButtonText: "OK"
},
function(isConfirm){
  if (isConfirm) {
    window.location.href = "index.php";
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
	    <li><a class="app-menu__item active" href="index.php"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Reports</span></a></li>
      <?php 
      if ($right == 1) { 
        echo '<li><a class="app-menu__item" href="index.php"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Admin panel</span></a></li>';
                      } 
      ?>
        <li><a class="app-menu__item" href="settings.php"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Settings</span></a></li><br>
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
                  <h2 class="page-header"><i class="fa"></i>Upload a report</h2>
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
                  <label class="control-label col-md-3">Name</label>
                  <div class="col-md-8">
                    <input class="form-control" id="1" type="text" name = "name" placeholder="Report name, example 'Home work № 1'" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-3">Discipline</label>
                  <div class="col-md-8">
                    <input class="form-control" id="2" type="text" name = "disc" placeholder="" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-md-3">Report file <br> (PDF, DOC, DOCX, ZIP, RAR)</label>
                  <div class="col-md-8">
                    <input id= "file1" class="form-control" name= "file" type="file" required>
					<input type="hidden" id ="file2" class="form-control" name= "file" >
                  </div>
                </div>
                <div class="send">
				 <button class="btn btn-primary" name = "send" id="send" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Send</button>
                </div>
              </form>
        </div>
			    </div>
              </div>
            </section>
          </div>
        </div>
	<?php 
$result2 = R::getAll( "SELECT * FROM reports WHERE idreport = '$id' AND estimation != '' ORDER BY date DESC" );
	?>
        <div class="col-md-12">
          <div class="tile">
              <div class="row mb-4">
                <div class="col-6">
                  <h2 class="page-header"><i class="fa"></i>Verified reports</h2>
                </div>
              </div>
			  <div class="tile-body">
              <div class="table-responsive">
				<table class="table table-hover table-bordered" id="Table2">
		<thead>
			<tr>
				<th>Date</th>	
				<th>Name</th>
        <th>Discipline</th>
				<th>File</th>
				<th>Estimation</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach( $result2 as $info2 ) {
			?>
			   <td><?php echo $info2 ['date']; ?></td>
			   <td><?php echo $info2 ['name']; ?></td>   
         <td><?php echo $info2 ['disc']; ?></td>   
			   <td><a href="<?php echo $info2 ['file']; ?>" target="_blank"><button class="btn btn-success col-md-12" type="button">Download</button></a></td>
			   <td><?php echo $info2 ['estimation']; ?></td>  			   
			   </tr>
			<?php } ?>
		</tbody>
			</table>
              </div>
          </div>
        </div>
      </div>
              <?php 
$result = R::getAll( "SELECT * FROM reports WHERE idreport = '$id' AND estimation = '' ORDER BY date DESC" );
	?>
        <div class="col-md-12">
          <div class="tile">
              <div class="row mb-4">
                <div class="col-6">
                  <h2 class="page-header"><i class="fa"></i>Unverified reports</h2>
                </div>
              </div>
			  <div class="tile-body">
              <div class="table-responsive">
				<table class="table table-hover table-bordered" id="Table">
		<thead>
			<tr>
				<th>Date</th>	
				<th>Name</th>
        <th>Discipline</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach( $result as $info ) {
			?>
			   <td><?php echo $info ['date']; ?></td>
			   <td><?php echo $info['name']; ?></td>   
         <td><?php echo $info ['disc']; ?></td>   
			   <td><form class="form-horizontal" action="" method="post"><a href="<?php echo $info ['file']; ?>" target="_blank"><button class="btn btn-success col-md-12" type="button">Download</button></a><input type="hidden" class="form-control" name= "deletecopy" readonly value="<?php echo $info ['id']; ?>"> <button class="col-md-12 btn btn-danger" name = "delete" type="submit">Delete</button></form></td>  			   
			   </tr>
			<?php } ?>
		</tbody>
			</table>
              </div>
          </div>
        </div>
  </div>
</div>
    </main>
</body>
<?php else : 
   ?>
<?php endif; ?>

<?php if ( isset ($_SESSION['logged_user']) and $right == 1) : ?>
<body class="app sidebar-mini">
	<?php
	if($_GET['up']){
    ?><script type="text/javascript">
setTimeout(function () { 
swal({
  title: "Done!",
  text: "You uploaded the file successfully",
  type: "success",
  confirmButtonText: "OK"
},
function(isConfirm){
  if (isConfirm) {
    window.location.href = "index.php";
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
		  <p class="app-sidebar__user-designation"><?php echo $right1;?></p>
        </div>
      </div>
      <ul class="app-menu">
      <?php 
      if ($right == 1) { 
        echo '<li><a class="app-menu__item active" href="index.php"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Admin panel</span></a></li>';
                      } 
      ?>
      <li><a class="app-menu__item" href="settings.php"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Settings</span></a></li>
        <br>
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
      <?php 
$result = R::getAll( "SELECT * FROM reports ORDER BY date DESC" );
	?>
        <div class="col-md-12">
          <div class="tile">
              <div class="row mb-4">
                <div class="col-6">
                  <h2 class="page-header"><i class="fa"></i>Reports</h2>
                </div>
              </div>
			  <div class="tile-body">
              <div class="table-responsive">
				<table class="table table-hover table-bordered" id="Table">
		<thead>
			<tr>
        <th>Id</th>
				<th>Date</th>	
        <th>Name</th>
        <th>Group</th>
        <th>Discipline</th>
        <th>Title</th>
				<th>File</th>
        <th>Estimation</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach( $result as $info ) {
			?>
      		<tr id="<?php echo $info ['id']; ?>">
			   <td><?php echo $info ['id']; ?></td>
			   <td><?php echo $info ['date']; ?></td>
         <td><?php echo $info['lastname'] ." ". $info['firstname'];?></td>  
         <td><?php echo $info['group']; ?></td>   
         <td><?php echo $info ['disc']; ?></td>  
			   <td><?php echo $info['name']; ?></td>   
         <td><a href="<?php echo $info ['file']; ?>" target="_blank"><button class="btn btn-success col-md-12" type="button">Download</button></a></td>
         <td><?php echo $info ['estimation']; ?></td>  
			   </tr>
			<?php } ?>
		</tbody>
			</table>
              </div>
          </div>
        </div>
  </div>

	  </div>
    </main>
</body>
<?php else : 
header("Location: login.php");?>
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
<script>
$(document).ready(function() {
  $('#send').click(function() {
    $(".send").css("display", "none");
  });
});
</script>
</html>