<?php
require_once 'init.php';

if (!$currentUser) {
  header('Location: index.php');
  exit();
}

if(isset($_POST['fullname']) || isset($_POST['price']))
{
	$err="Thiếu thông tin";
	$kt=false;
}
else
{
	/*if(!is_numeric($$_POST['price']))
	{
		$err="Số nhập vào không phải là sô";
		$kt=false;
	}
	*/
}

$success = true;
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	$fullname = $_POST['fullname'];
	$matour = $_POST['matour'];
  $price = $_POST['price'];
  $songay = $_POST['songay'];
  $socho = $_POST['socho'];
  $danhgiadiem = $_POST['danhgiadiem'];
	
	$target_dir ='img/imgBook/';
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
			//updateImageBook($target_file);
			$resuert = AddTour($fullname, $matour, $target_file, $price, $songay, $socho, $danhgiadiem);
			if ($resuert == 1)
				echo "Bạn đã upload file thành công";
			else
				echo "File bạn vừa upload gặp sự cố";
			         
        }  else {
            echo "File bạn vừa upload gặp sự cố";
        }
    }
    header('Location: index.php');
    exit();
}

?>
<?php include 'header.php' ?>
<h1>Thêm tour du lịch mới mới</h1>
<?php if (!$success) : ?>
<div class="alert alert-danger" role="alert">
  Nội dung không được rỗng và dài quá 1024 ký tự!
</div>
<?php endif; ?>
<form method="POST"  name="newad" enctype="multipart/form-data" action="">

  <div class="form-group">
    <label for="fullname">Tên tour: </label>
    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Tên tour du lịch" 
  </div>

  <div class="form-group">
    <label for="matour">Mã tour: </label>
    <input type="text" class="form-control" id="matour" name="matour" placeholder="Mã tour" 
  </div>

  <div class="form-group">
    <label for="price">Giá: </label>
    <input type="text" class="form-control" id="price" name="price" placeholder="Điền giá tour"
  </div>

  <div class="form-group">
    <label for="songay">Số ngày: </label>
    <input type="text" class="form-control" id="songay" name="songay" placeholder="Số ngày"
  </div>

  <div class="form-group">
    <label for="socho">Số chổ còn: </label>
    <input type="text" class="form-control" id="socho" name="socho" placeholder="Số chổ còn"
  </div>

  <div class="form-group">
    <label for="danhgiadiem">Đánh giá điểm: </label>
    <input type="text" class="form-control" id="danhgiadiem" name="danhgiadiem" placeholder="Đánh giá điểm"
  </div>

  <!--
  <div class="form-group">
  	<label for="content">Mô tả: </label>
    <textarea class="form-control" id="content" name="content" rows="3" placeholder="Mô tả của sách"></textarea>
  </div>
-->

  <div class="form-group">
    <label for="phone">Hình ảnh đại diện</label>
  	<br />
    <input type="file" name="fileUpload"  id="fileUpload" >
  </div>

  <button type="submit" class="btn btn-primary">Đăng</button>
</form>
<?php include 'footer.php' ?>