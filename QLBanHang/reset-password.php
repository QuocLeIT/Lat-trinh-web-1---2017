<?php 
require_once 'init.php';

$success = true;

if (!empty($mailresetpass) && !empty($_POST['password'])) {  
  $user = findUserByEmail($mailresetpass);
  if ($user) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    resetPassword2($mailresetpass, $password);
    // Redirect to home page
    header('Location: login.php');  
    exit();
  } else {
    echo 'Loi!!!';
    $success = false;
  }
}
?>
<?php include 'header.php' ?>
<h1>Cài đặt mật khẩu mới</h1>
 <h3> email: <?php echo $mailresetpass; ?> </h3>
  <?php if (!$success) : ?>

  <div class="alert alert-danger" role="alert">
    Email và mật khẩu không hợp lệ vui lòng đăng nhập lại!
  </div>
  <?php endif; ?>
<form method="POST">
  <div class="form-group">
    <label for="password">Mật khẩu</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Điền mật khẩu vào đây">
  </div>
  <button type="submit" class="btn btn-primary">Cài lại mật khẩu</button>
</form>

<?php include 'footer.php' ?>