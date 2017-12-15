<?php 
require_once 'init.php';
 $topNew = gettopNew();
 $topBanChay = gettopBanChay();
 $topLuotXem = gettopLuotXem();





?>
<?php include 'header.php' ?>
<h1>Trang chủ</h1>

<?php $i = 1 ?>
<h3>Top 10 sản phẩm mới nhất</h3>
<?php foreach ($topNew as $post) : ?>
<div class="card col-md-3" style="margin-bottom: 10px;">
<div class="card" style="margin-bottom: 10px;">
  <div class="card-body">
    <h4 class="card-title">
      <div class="row">
        <div class="col">
          <?php if ($post['hasAvatar']) : ?>
          <img class="avatar" src="uploads/sanpham/<?php echo $post['id'] ?>.jpg">
          <?php else : ?>
          <img class="avatar" src="no-avatar.jpg">
          <?php endif; ?>
        </div>
        <div class="col-11">
          <?php echo $post['TenSP'] ?>         
        </div>
    </h4>
    <div class="col-11">
        Giá: <?php echo $post['GiaBan'] ?>
    </div>
    <div class="col-11">
          Số lượng <?php echo $post['SoLuongTon'] ?>
    </div>
  
    <p class="card-text">
	    <small>Lượt xem <?php echo $post['SoLuotXem'] ?></small>
	    <br>
	    <small>Đăng lúc: <?php echo $post['createdAt'] ?></small>
    </p>

	<?php if ($currentUser) : ?>
	<!--<p>Chào mừng <?php echo $currentUser['fullname'] ?> đã trở lại.</p>-->
		<button type="submit" class="btn btn-primary">Mua</button>
	    <a href="post.php" class="btn btn-primary" role="button">
	        Chi tiết
	    </a>
	<?php else: ?>
	
	<?php endif ?>
    
  </div>
</div>
</div>
<?php $i = $i + 1 ?>
<?php endforeach; ?>

<?php $i = 1 ?>
<h3>Top 10 sản phẩm bán chạy</h3>
<?php foreach ($topBanChay as $post) : ?>
<div class="card col-md-3" style="margin-bottom: 10px;">
<div class="card" style="margin-bottom: 10px;">
  <div class="card-body">
    <h4 class="card-title">
      <div class="row">
        <div class="col">
          <?php if ($post['hasAvatar']) : ?>
          <img class="avatar" src="uploads/sanpham/<?php echo $post['id'] ?>.jpg">
          <?php else : ?>
          <img class="avatar" src="no-avatar.jpg">
          <?php endif; ?>
        </div>
        <div class="col-11">
          <?php echo $post['TenSP'] ?>         
        </div>
    </h4>
    <div class="col-11">
        Giá: <?php echo $post['GiaBan'] ?>
    </div>
    <div class="col-11">
          Số lượng <?php echo $post['SoLuongTon'] ?>
    </div>
  
    <p class="card-text">
	    <small>Lượt xem <?php echo $post['SoLuotXem'] ?></small>
	    <br>
	    <small>Đăng lúc: <?php echo $post['createdAt'] ?></small>
    </p>

   <?php if ($currentUser) : ?>
	<!--<p>Chào mừng <?php echo $currentUser['fullname'] ?> đã trở lại.</p>-->
		<button type="submit" class="btn btn-primary">Mua</button>
	    <a href="post.php" class="btn btn-primary" role="button">
	        Chi tiết
	    </a>
	<?php else: ?>
	
	<?php endif ?>
  </div>
</div>
</div>
<?php $i = $i + 1 ?>
<?php endforeach; ?>

<?php $i = 1 ?>
<h3>Top 10 sản phẩm nhiều lượt xem nhất</h3>
<?php foreach ($topLuotXem as $post) : ?>
<div class="card col-md-3" style="margin-bottom: 10px;">
<div class="card" style="margin-bottom: 10px;">
  <div class="card-body">
    <h4 class="card-title">
      <div class="row">
        <div class="col">
          <?php if ($post['hasAvatar']) : ?>
          <img class="avatar" src="uploads/sanpham/<?php echo $post['id'] ?>.jpg">
          <?php else : ?>
          <img class="avatar" src="no-avatar.jpg">
          <?php endif; ?>
        </div>
        <div class="col-11">
          <?php echo $post['TenSP'] ?>         
        </div>
    </h4>
    <div class="col-11">
        Giá: <?php echo $post['GiaBan'] ?>
    </div>
    <div class="col-11">
          Số lượng <?php echo $post['SoLuongTon'] ?>
    </div>
  
    <p class="card-text">
	    <small>Lượt xem <?php echo $post['SoLuotXem'] ?></small>
	    <br>
	    <small>Đăng lúc: <?php echo $post['createdAt'] ?></small>
    </p>
    
    <?php if ($currentUser) : ?>
	<!--<p>Chào mừng <?php echo $currentUser['fullname'] ?> đã trở lại.</p>-->
		<button type="submit" class="btn btn-primary">Mua</button>
	    <a href="post.php" class="btn btn-primary" role="button">
	        Chi tiết
	    </a>
	<?php else: ?>
	
	<?php endif ?>
  </div>
</div>
</div>
<?php $i = $i + 1 ?>
<?php endforeach; ?>

<?php include 'footer.php' ?>