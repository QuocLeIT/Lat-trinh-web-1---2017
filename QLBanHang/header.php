<!DOCTYPE html>

<html lang="en">
  <head>
    <title>ĐỦ THỨ SHOP</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="assets/css/css.css">

    <!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

  </head>
  <body>
    <div class="container tieude">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php"><h3><b>ĐỦ THỨ SHOP</b></h3></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">

            <div class="">
                <input id="txtSearchPro" name="searchPro" type="text" class="form-control" placeholder="Search">
            </div>

            <div><button type="submit" class="btn btn-primary">
              Tìm kiếm
            </button></div>       

<!--
            <li class="nav-item <?php echo ($page == 'index') ? 'active' : '' ?>">
              <a class="nav-link" href="index.php">Trang chủ<span class="sr-only">(current)</span></a>
            </li>
-->
            <div class="dropdown">
              <button class="dropbtn">
                    <a class="nav-link <?php echo ($page == 'Loai') ? 'active' : '' ?>" href="#">
                      Loại
                    </a>
              </button>
              <div class="dropdown-content">
                <?php foreach ($currentLoaiSP as $posts) : ?>                                               
                  <a href="#"><?php echo $posts['TenLoaiSP'] ?>  </a>                                                              
                <?php endforeach; ?>   
              </div>
            </div> 

            <div class="dropdown">
              <button class="dropbtn">
                    <a class="nav-link <?php echo ($page == 'Loai') ? 'active' : '' ?>" href="#">
                      Nhà sản xuất
                    </a>
              </button>
              <div class="dropdown-content">
                <?php foreach ($currentNhaSX as $posts) : ?>                                               
                  <a href="#"><?php echo $posts['TenNhaSX'] ?>  </a>                                                              
                <?php endforeach; ?>   
              </div>
            </div> 

            <?php if (!$currentUser) : ?>
            <li class="nav-item <?php echo ($page == 'register') ? 'active' : '' ?>">
              <a class="nav-link" href="register.php">Đăng ký</a>
            </li>
            <?php endif; ?>
            <?php if (!$currentUser) : ?>
            <li class="nav-item <?php echo ($page == 'login') ? 'active' : '' ?>">
              <a class="nav-link" href="login.php">Đăng nhập</a>
            </li>
            <?php endif; ?>
            <?php if ($currentUser) : ?>

              <li class="nav-item ">
                <a class="nav-link <?php echo ($page == 'post') ? 'active' : '' ?>" href="#">
                   <i class="glyphicon glyphicon-shopping-cart"></i>
                 Giỏ hàng
                </a>
              </li>

            <?php if ($currentUser['admin'] == 1) : ?>
              <li class="nav-item">
                <a class="nav-link <?php echo ($page == 'post') ? 'active' : '' ?>" href="post.php">
                  Đăng sản phẩm
                </a>
              </li>

              <div class="dropdown">
                <button class="dropbtn">
                    <a class="nav-link <?php echo ($page == 'profile') ? 'active' : '' ?>" href="#">
                      Admin
                    </a>
                </button>
                <div class="dropdown-content">
                  <a href="DonHang.php">Hóa đơn hàng</a>
                  <a href="#">DS sản phẩm</a>
                  <a href="Loai.php">DS loại sản phẩm</a>
                  <a href="NhaSX.php">DS nhà sản xuất</a>
                </div>
              </div> 

            <?php endif; ?>
           
            
            <li class="nav-item">
              <div class="dropdown">
                <button class="dropbtn">
                    <a class="nav-link <?php echo ($page == 'profile') ? 'active' : '' ?>" href="#">
                      <?php echo $currentUser['fullname'] ?>
                    </a>
                </button>
                <div class="dropdown-content">
                  <a href="profile.php">Thông tin cá nhân</a>
                  <a href="#">Lịch sử mua hàng </a>
                  <a href="change-password.php">Đổi mật khẩu</a>           
                  <a href="logout.php">Đăng xuất</a>
                
                </div>
              </div>            
            </li>
          
            <?php else : ?>
            
            <?php endif; ?>
          </ul>
        </div>
      </nav>
      <div>
