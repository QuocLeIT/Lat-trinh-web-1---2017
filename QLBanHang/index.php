<?php 
require_once 'init.php';

if ($currentUser) {
  // $newFeeds = getNewFeeds();
 
}
?>
<?php include 'header.php' ?>
<h1>Trang chủ</h1>
<?php if ($currentUser) : ?>
<p>Chào mừng <?php echo $currentUser['fullname'] ?> đã trở lại.</p>

<?php else: ?>
Bạn chưa đăng nhập
<?php endif ?>
<?php include 'footer.php' ?>