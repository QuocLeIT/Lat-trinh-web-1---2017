<?php 
  require_once 'init.php';
  $success = true;
  // && !empty($_POST['agree-tos']) && $_POST['agree-tos'] == 'on'
  if (!empty($_POST['fullname']) && !empty($_POST['phone']) ) {  
    $fullname = $_POST['fullname'];
	$phone = $_POST['phone'];
    
	$updateId = updateThongTinCaNhan($fullname, $phone, $userID);
    $_SESSION['userId'] = $updateId;
      // Redirect to home page
    header('Location: index.php');
    exit();
  }
?>
<?php include 'header.php' ?>
<h1>Quản lý thông tin cá nhân</h1>

<form method="POST">
  <div class="form-group">
    <label for="fullname">Họ và tên</label>
    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Điền họ và tên vào đây" value="<?php echo isset($_POST['fullname']) ? $_POST['fullname'] : '' ?>">
  </div>
  <div class="form-group">
    <label for="emphoneail">Số điện thoại</label>
    <input type="text" class="form-control" id="phone" name="phone" placeholder="Điền số điện thoại vào đây" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : '' ?>">
  </div>
  
  <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>
<?php include 'footer.php' ?>