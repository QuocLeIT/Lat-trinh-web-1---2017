<?php
require_once 'init.php';

if (!$currentUser) {
  header('Location: index.php');
  exit();
}

$success = true;

if (isset($_POST['content']) && isset($_POST['tensp']) && isset($_POST['giaban']) && isset($_POST['soluong'])  && isset($_POST['xuatxu'])  && isset($_POST['loaisp'])  && isset($_POST['nhasx'])) {
  $content = $_POST['content'];
  $len = strlen($content);

  if ($len == 0 || $len > 1024) {
    $success = false;
  } else {
    $id = createPostSP($_POST['tensp'], $_POST['giaban'], $_POST['soluong'], $_POST['xuatxu'],$_POST['loaisp'],$_POST['nhasx'], $content);


  if(isset($_FILES['avatar']))
  {

      $fileName = $_FILES['avatar']['name'];
      $fileSize = $_FILES['avatar']['size'];
      $fileTemp = $_FILES['avatar']['tmp_name'];
      $fileSave = 'uploads/sanpham/' . $id . '.jpg';
      // userid.jpg
      $result = move_uploaded_file($fileTemp, $fileSave);
      if (!$result) {
        $success = false;       
      } else {
        $newImage = resizeImage($fileSave, 250, 250);
        imagejpeg($newImage, $fileSave);
        $currentSP = findSPById($id);
        $currentSP['hasAvatar'] = 1;
        updateSP($currentSP);
      }
  }

    header('Location: post.php');
    exit();
  }
}
?>

<?php include 'header.php' ?>

<style type="text/css">
  
  .bodypost{
    width: 500px;
}
</style>


<h1>Thêm sản phẩm mới</h1>
<?php if (!$success) : ?>
<div class="alert alert-danger" role="alert">
  Nội dung không được rỗng và dài quá 1024 ký tự!
</div>
<?php endif; ?>
<div class="bodypost">
<form method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <label for="tensp">Tên sản phẩm</label>
    <input type="text" class="form-control" id="tensp" name="tensp" placeholder="Điền tên sản phẩm" value="<?php echo isset($_POST['tensp']) ? $_POST['tensp'] : '' ?>">
  </div>
  <div class="form-group">
    <label for="giaban">Giá bán</label>
    <input type="text" class="form-control" id="giaban" name="giaban" placeholder="Điền giá bán" value="<?php echo isset($_POST['giaban']) ? $_POST['giaban'] : '' ?>">
  </div>
  <div class="form-group">
    <label for="soluong">Số lượng</label>
    <input type="number" class="form-control" id="soluong" name="soluong" placeholder="Điền số lượng bán" value="<?php echo isset($_POST['soluong']) ? $_POST['soluong'] : '' ?>">
  </div>
  <div class="form-group">
    <label for="xuatxu">Xuất xứ</label>
    <input type="text" class="form-control" id="xuatxu" name="xuatxu" placeholder="Điền xuất xứ" value="<?php echo isset($_POST['xuatxu']) ? $_POST['xuatxu'] : '' ?>">
  </div>
<div class="form-group">
    <label for="loaisp">Loại sản phẩm</label>
    <input type="text" class="form-control" id="loaisp" name="loaisp" placeholder="Điền loại sản phẩm" value="<?php echo isset($_POST['loaisp']) ? $_POST['loaisp'] : '' ?>">
  </div>
  <div class="form-group">
    <label for="nhasx">Nhà sản xuất</label>
    <input type="text" class="form-control" id="nhasx" name="nhasx" placeholder="Điền nhà sản xuất" value="<?php echo isset($_POST['nhasx']) ? $_POST['nhasx'] : '' ?>">
  </div>

  <div class="form-group">
     <label for="content">Mô tả</label>
    <textarea class="form-control" id="content" name="content" rows="3" placeholder="Điền mô tả"></textarea>
  </div>

  <div class="form-group">
    <label for="avatar">Hình ảnh</label>
    <input type="file" class="form-control-file" id="avatar" name="avatar">
  </div>

  <button type="submit" class="btn btn-primary">Đăng</button>
</form>
<div>
<?php include 'footer.php' ?>