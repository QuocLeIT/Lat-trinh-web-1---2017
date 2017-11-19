<?php
require_once 'init.php';

if (!$currentUser) {
  header('Location: index.php');
  exit();
}

$fullname = $currentUser['fullname'];
$phone = $currentUser['phone'];
$success = true;

// Kiểm tra người dùng có nhập tên
if (isset($_POST['fullname'])) {
  if (strlen($_POST['fullname']) > 0) {
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $currentUser['fullname'] = $fullname;
    $currentUser['phone'] = $phone;
    updateUser($currentUser);
  } else {
    $success = false;
  }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $target_dir ='img/';
    $target_file = $target_dir . basename($_FILES['fileUpload']['name']);
    $typeFile = pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION);
    $typeFileAllow = array('png','jpg','jpeg', 'gif');
    if(!in_array(strtolower($typeFile), $typeFileAllow)){
        $error = "File bạn vừa chọn hệ thống không hỗ trợ, bạn vui lòng chọn hình ảnh";
    }
    
	$image=$_FILES['fileUpload']['name'];
	if ($image)
	{
		$size=filesize($_FILES['fileUpload']['tmp_name']);
		if($size > 5242880){
        	echo '<h1>Vượt quá dung lượng 5MB cho phép!</h1>';
				$errors=1;
    	}
	}
    
    if(empty($error)){
        if(move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)){
			updateImageUser($target_file);
            echo "Bạn đã upload file thành công";
        }  else {
            echo "File bạn vừa upload gặp sự cố";
        }
    }
}


?>
<?php include 'header.php' ?>
<h1>Quản lý thông tin cá nhân</h1>
<?php if (!$success) : ?>
<div class="alert alert-danger" role="alert">
  Vui lòng nhập đầy đủ thông tin!
</div>
<?php endif; ?>
<form method="POST" name="newad" enctype="multipart/form-data" action="">
  <div class="form-group">
    <label for="fullname">Họ và tên</label>
    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Điền họ và tên vào đây" value="<?php echo $fullname ?>">
  </div>
  <div class="form-group">
    <label for="phone">Số điện thoại</label>
    <input type="text" class="form-control" id="phone" name="phone" placeholder="Điền số điện thoại vào đây" value="<?php echo $phone ?>">
  </div>
  
  
  <div class="form-group">
    <label for="phone">Hình ảnh đại diện</label>
  	<br />
    <input type="file" name="fileUpload"  id="fileUpload" >
   <!-- <tr><td><input name="Submit" type="submit" value="Upload image">--> 
  
  </div>
  <button type="submit" class="btn btn-primary" name="submit">Cập nhật</button>
</form>
<?php include 'footer.php' ?>