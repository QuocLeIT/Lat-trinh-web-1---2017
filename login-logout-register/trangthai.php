<?php 
  require_once 'init.php';
  $success = true;
  //&& !empty($_POST['agree-tos']) && $_POST['agree-tos'] == 'on'
  if (!empty($_POST['caption']) ) {
   $caption = $_POST['caption'];
	
    $insertId = createPosts($userID, $userID, $caption);
      //$_SESSION['userId'] = $insertId;
      
      header('Location: index.php');
      exit();
  }
?>
<?php include 'header.php' ?>
<h1>Thêm trạng thái mới</h1>

<form method="POST">
  <div class="form-group">
    <input type="text" height="100px" class="form-control" id="caption" name="caption" placeholder="Bạn đang nghĩ gì?" value="<?php echo isset($_POST['caption']) ? $_POST['caption'] : '' ?>">
  </div>
  
  <button type="submit" class="btn btn-primary">Đăng</button>
</form>
<?php include 'footer.php' ?>