<?php 
require_once 'init.php';

if ($currentUser) {
  $newFeeds = getTours();
}
?>

<?php include 'header.php' ?>
<h1>Trang chủ</h1>
<?php if ($currentUser) : ?>
<p>Chào mừng <?php echo $currentUser['fullname'] ?> đã trở lại.</p>

<div class="row">
<?php foreach ($newFeeds as $post) : ?>
  <div class="card col-md-3" style="margin-bottom: 10px;">
    <div class="card-body">
      
      <h4 class="card-title"><?php echo $post['TenTour'] ?></h4>
      <?php
  	// TenTour, MaTour, imgDaTa, Gia, Diem, SoNgay, SoCho
  		  echo '<img src="data:image/jpeg;base64,'.base64_encode( $post['imgDaTa'] ).'" height="150px" width="150px"/>';
  	   ?>
      <p class="card-text">
      <small>Mã tour: <?php echo $post['MaTour'] ?></small>
      <br/>
      <small>Giá: <?php echo $post['Gia'] ?></small>
      <br/>
      <small>Số ngày: <?php echo $post['SoNgay'] ?></small>
      <br/>
      <small>Số chổ: <?php echo $post['SoCho'] ?></small>
      <br/>
      <small>Điểm: <?php echo $post['Diem'] ?></small>
    
      </p>
    </div>
  </div>
<?php endforeach; ?>
</div>

<?php else: ?>
Bạn chưa đăng nhập
<?php endif ?>
<?php include 'footer.php' ?>