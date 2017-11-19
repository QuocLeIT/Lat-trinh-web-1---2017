<?php 
require_once 'init.php';
$success = true;
$gui = 0;
if (!empty($_POST['email'])) { 
   $user = findUserByEmail($_POST['email']);
   if ($user) {
    //goi thu vien
    require_once 'smtpmail/class.SMTP.php';
    require_once 'smtpmail/class.PHPMailer.php'; 
    $title = 'KHOI PHUC MAT KHAU BTCN09';
    //$link = 'http"//localhost:8080/BTCN09/reset-password.php?code=' + RandomString();
    $content = 'Click vào link sau để khôi phục mật khẩu: http://localhost:8080/private-message/reset-password.php?code=' . RandomString();
    //$content = 'Click vào link sau để khôi phục mật khẩu: http://localhost:8888/BTCN09/reset-password.php?code=' . RandomString();
    $nTo = $user['fullname'];
    $mTo = $_POST['email'];
    $diachicc = 'lebinh1991@gmail.com';
    //test gui mail
    $mail = sendMail($title, $content, $nTo, $mTo,$diachicc='');
    if($mail==1)
    {
      $gui = 1;
      $mailresetpass = $_POST['email'];
    }
    else $gui = -1;
   }
   else{
     $gui = -1;
     $success = false;
   }
}


?>
<?php include 'header.php' ?>
<h1>Quên mật khẩu</h1>
<?php if (!$success) : ?>
  <div class="alert alert-danger" role="alert">
    Email và mật khẩu không hợp lệ vui lòng đăng nhập lại!
  </div>
<?php endif; ?>

<?php if($gui==1) : ?>
  <div class="alert alert-success" role="alert">
    <?php echo 'Mail của bạn đã được gửi đi hãy kiếm tra hộp thư đến để xem kết quả. '; ?>
  </div>   
<?php endif; ?>
<?php if($gui==-1) : ?>
  <div class="alert alert-danger" role="alert">
    <?php echo 'Mail khong ton tai'; ?>
  </div>   
<?php endif; ?>

<?php if($gui==0) : ?>
<form method="POST">
  <div class="form-group">
    <label for="email">Địa chỉ email</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="Điền email vào đây" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
  </div>
  
  <button type="submit" class="btn btn-primary">Quên mật khẩu</button>
</form>
<?php endif; ?>


<?php include 'footer.php' ?>
