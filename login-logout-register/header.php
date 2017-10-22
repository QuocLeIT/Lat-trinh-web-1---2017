<!DOCTYPE html>
<html lang="en">
  <head>
    <title>BTCN05</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<style>
    	.tieude{
			 background-color: #bfbfbf;
			}
    </style>
  </head>
  
  <body>
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand tieude" href="#"><b>BTCN05</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse tieude" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php echo ($page == 'index') ? 'active' : '' ?>">
              <a class="nav-link" href="index.php"><b>Trang chủ</b><span class="sr-only">(current)</span></a>
            </li>
            <?php if (!$currentUser) : ?>
            <li class="nav-item <?php echo ($page == 'register') ? 'active' : '' ?>">
              <a class="nav-link" href="register.php"><b>Đăng ký</b></a>
            </li>
            <?php endif; ?>
            <?php if (!$currentUser) : ?>
            <li class="nav-item <?php echo ($page == 'login') ? 'active' : '' ?>">
              <a class="nav-link" href="login.php"><b>Đăng nhập</b></a>
            </li>
            <?php endif; ?>
            <?php if ($currentUser) : ?>
            <li class="nav-item">
              <a class="nav-link" href="trangthai.php"><b>Trạng thái</b></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="thongtincanhan.php">
              	<b><?php echo $currentUser['fullname'] ?></b>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="update.php"><b>Đổi mật khẩu</b></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php"><b>Đăng xuất</b></a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
              <?php if ($currentUser) : ?>
              <!--<a class="nav-link disabled" href="#">
                <b><?php echo $currentUser['fullname'] ?></b>
              </a>-->
              <?php else : ?>
              <a class="nav-link disabled" href="#">
                <b>Khách</b>
              </a>
              <?php endif; ?>
            </li>
          </ul>
        </div>
      </nav>
      <div>
