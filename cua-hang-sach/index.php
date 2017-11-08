<?php 
require_once 'init.php';

if ($currentUser) {
  $newFeeds = getBooks();
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
      
      <h4 class="card-title"><?php echo $post['TenSach'] ?></h4>
      <?php
  	//$image1 = $newImage
  		  echo '<img src="data:image/jpeg;base64,'.base64_encode( $post['imgDaTa'] ).'" height="150px" width="150px"/>';
  	   ?>
      <p class="card-text">
      <small>Giá bán: <?php echo $post['GiaBan'] ?></small>
      <small><p><?php echo $post['MoTa'] ?></p></small>
      </p>
    </div>
  </div>
<?php endforeach; ?>
</div>

<?php else: ?>
Bạn chưa đăng nhập
<?php endif ?>
<?php include 'footer.php' ?>