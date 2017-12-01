<?php 
require_once 'init.php';

if ($currentUser) {
  $listLoaiSP = getLoaiSP();
}

if (!empty($_POST['tenloai'])) {
    $tenloai = $_POST['tenloai'];

    $insertId = createLoai($tenloai);
      
      // Redirect to home page
      header('Location: Loai.php');
      exit();
  }

?>

<?php include 'header.php' ?>

<h1>Loại sản phẩm</h1>

<form method="POST">
  <div class="form-group">
    <label for="tenloai">Tên loại</label>
    <input type="text" class="form-control" id="tenloai" name="tenloai" placeholder="Điền tên loại sản phẩm" value="<?php echo isset($_POST['tenloai']) ? $_POST['tenloai'] : '' ?>">
  </div>
  
  <button type="submit" class="btn btn-primary">Thêm</button>
</form>

<br />

<table class="table table-hover">
    <thead>
        <tr class="">
                        <th class="">Mã loại</th>
                        <th class="">Tên loại sản phẩm</th>          
        </tr>
    </thead>
    <tbody>
    <?php if ($listLoaiSP) : ?>
  		<?php foreach ($listLoaiSP as $posts) : ?>                                     
            <tr>
                <td>
                    <?php echo $posts['id'] ?>
                </td>

                <td>
                    <?php echo $posts['TenLoaiSP'] ?>                               
                </tr>                    
        <?php endforeach; ?>                    
    <?php endif ?>
    </tbody>
</table>
        

<?php include 'footer.php' ?>