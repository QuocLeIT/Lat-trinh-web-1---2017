<?php 
require_once 'init.php';
$success = true;
// && !empty($_POST['agree-tos']) && $_POST['agree-tos'] == 'on'
  if (!empty($_POST['passwordOld']) && !empty($_POST['passwordNew']) && !empty($_POST['passwordAgain']) ) { 
  
   $user = findUserById($userID); 
	  if ($user) {
		if (password_verify($_POST['passwordOld'], $user['password'])) {
		  	$success = true;
			
			$passNew = password_hash($_POST['passwordNew'], PASSWORD_DEFAULT);
			$passAgain = password_hash($_POST['passwordAgain'], PASSWORD_DEFAULT);
			
			$updateId = updatePassword($passNew, $userID);
			//$_SESSION['userId'] = $updateId;
			  // Redirect to home page
			header('Location: index.php');
			exit();
		} else {
		  $success = false;
		}      
	  } else {
		$success = false;
	  }

  }
?>
<?php include 'header.php' ?>
<h1>Đổi mật khẩu</h1>
 
<form method="POST">
  <div class="form-group">
    <label for="passwordOld">Mật khẩu củ</label>
    <input type="password" class="form-control" id="passwordOld" name="passwordOld" placeholder="Điền mật khẩu cũ vào đây">
  </div>
  
   <div class="form-group">
    <label for="passwordNew">Mật khẩu mới</label>
    <input type="password" class="form-control" id="passwordNew" name="passwordNew" placeholder="Điền mật khẩu mới vào đây">
  </div>
  
   <div class="form-group">
    <label for="passwordAgain">Nhập lại mật khẩu mới</label>
    <input type="password" class="form-control" id="passwordAgain" name="passwordAgain" placeholder="Điền mật khẩu mới vào đây lần nữa">
  </div>
  
  <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
</form>
<?php include 'footer.php' ?>