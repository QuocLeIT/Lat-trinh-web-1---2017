<?php 
function findUserByEmail($email) {
  global $db;
  $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute(array(strtolower($email)));
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  return $user;
}

function findUserById($id) {
  global $db;
  $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
  $stmt->execute(array($id));
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  return $user;
}

function findSPById($id) {
  global $db;
  $stmt = $db->prepare("SELECT * FROM sanpham WHERE id = ?");
  $stmt->execute(array($id));
  $sp = $stmt->fetch(PDO::FETCH_ASSOC);
  return $sp;
}

function createUser($fullname, $email, $password, $phone) {
  global $db;
  $stmt = $db->prepare("INSERT INTO users (email, password, fullname, phone) VALUE (?, ?, ?, ?)");
  $stmt->execute(array($email, $password, $fullname, $phone));
  return $db->lastInsertId();
}

function updateUser($user) {
  global $db;
  $stmt = $db->prepare("UPDATE users SET fullname = ?, phone = ?, hasAvatar = ? WHERE id = ?");
  $stmt->execute(array($user['fullname'], $user['phone'], $user['hasAvatar'], $user['id']));
  return $user;
}

function updateSP($sp) {
  global $db;
  $stmt = $db->prepare("UPDATE sanpham SET TenSP = ?, GiaBan = ?, SoLuongBan = ?, SoLuongTon = ?, XuatXu = ?, idLoai = ?, idNhaSanXuat = ?, content = ?, hasAvatar = ? WHERE id = ?");
  $stmt->execute(array($sp['TenSP'], $sp['GiaBan'], $sp['SoLuongBan'], $sp['SoLuongTon'], $sp['XuatXu'], $sp['idLoai'], $sp['idNhaSanXuat'], $sp['content'], $sp['hasAvatar'], $sp['id']));
  return $user;
}

function updateImageUser($imgFilename) {
  global $db;
  //mở file ảnh để đọc với chế độ đọc binary  
  $fh = fopen($imgFilename, "rb");  
  $imgData = fread($fh, filesize($imgFilename));  
  fclose($fh);
  //chèn nội dung file ảnh vào table imgData  
  //$sql = "INSERT INTO tblImage (imgData) VALUES('" . mysql_real_escape_string($imgData, $conn) . "')";  
  //mysql_query($sql, $conn);  
  $stmt = $db->prepare("UPDATE users SET imgData = ? WHERE id = ?");
  $stmt->execute(array($imgData, $_SESSION['userId']));
  return 1;
}

function updateUserPassword($userId, $hashPassword) {
  global $db;
  $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
  $stmt->execute(array($hashPassword, $userId));
}

function createPost($userId, $content) {
  global $db;
  $stmt = $db->prepare("INSERT INTO posts (userId, content, createdAt) VALUE (?, ?, CURRENT_TIMESTAMP())");
  $stmt->execute(array($userId, $content));
  return $db->lastInsertId();
}

function createPostSP($tensp, $giaban, $soluong, $xuatxu, $loaisp, $nhasanxuat,$content) {
  global $db;
  $stmt = $db->prepare("INSERT INTO sanpham (TenSP, GiaBan, SoLuongBan, SoLuongTon, XuatXu, idLoai, idNhaSanXuat, content, createdAt) 
    VALUE (?, ?, ?, ?, ?, ?, ?, ?,CURRENT_TIMESTAMP())");
  $stmt->execute(array($tensp, $giaban, $soluong, $soluong, $xuatxu, $loaisp, $nhasanxuat,$content));
  return $db->lastInsertId();
}

function createLoai($tenloai) {
  global $db;
  $stmt = $db->prepare("INSERT INTO loaisp (TenLoaiSP) VALUE (?)");
  $stmt->execute(array($tenloai));
  return $db->lastInsertId();
}

function getNewFeeds() {
  global $db;
  $stmt = $db->prepare("SELECT p.id, p.userId, u.fullname as userFullname, u.hasAvatar as userHasAvatar, p.content, p.createdAt FROM posts as p LEFT JOIN users as u ON u.id = p.userId ORDER BY createdAt DESC");
  $stmt->execute();
  $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $posts;
}

function gettopNew() {
  global $db;
  $stmt = $db->prepare("SELECT id, TenSP, SoLuotXem, GiaBan, SoLuongTon, hasAvatar, createdAt FROM sanpham ORDER BY createdAt DESC");
  $stmt->execute();
  $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $posts;
}

function gettopBanChay() {
  global $db;
  $stmt = $db->prepare("SELECT id, TenSP, SoLuotXem, GiaBan, SoLuongTon, hasAvatar, createdAt FROM sanpham ORDER BY SoLuongTon");
  $stmt->execute();
  $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $posts;
}

function gettopLuotXem() {
  global $db;
  $stmt = $db->prepare("SELECT id, TenSP, SoLuotXem, GiaBan, SoLuongTon, hasAvatar, createdAt FROM sanpham ORDER BY SoLuotXem DESC");
  $stmt->execute();
  $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $posts;
}

function getNewFeedsForUserId($userId) {
  global $db;
  $friends = getFriends($userId);
  $friendIds = array();
  foreach ($friends as $friend) {
    $friendIds[] = $friend['id'];
  }
  $friendIds[] = $userId;
  $stmt = $db->prepare("SELECT p.id, p.userId, u.fullname as userFullname, u.hasAvatar as userHasAvatar, p.content, p.createdAt FROM posts as p LEFT JOIN users as u ON u.id = p.userId WHERE p.userId IN (" . implode(',', $friendIds) .  ") ORDER BY createdAt DESC");
  $stmt->execute();
  $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $posts;
}

function resizeImage($filename, $max_width, $max_height)
{
  list($orig_width, $orig_height) = getimagesize($filename);

  $width = $orig_width;
  $height = $orig_height;

  # taller
  if ($height > $max_height) {
    $width = ($max_height / $height) * $width;
    $height = $max_height;
  }

  # wider
  if ($width > $max_width) {
    $height = ($max_width / $width) * $height;
    $width = $max_width;
  }

  $image_p = imagecreatetruecolor($width, $height);

  $image = imagecreatefromjpeg($filename);

  imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);

  return $image_p;
}

function isFollow($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("SELECT * FROM friends WHERE userId1 = ? AND userId2 = ?");
  $stmt->execute(array($userId1, $userId2));
  $user1ToUser2 = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$user1ToUser2) {
    return false;
  }
  $stmt = $db->prepare("SELECT * FROM friends WHERE userId1 = ? AND userId2 = ?");
  $stmt->execute(array($userId2, $userId1));
  $user2ToUser1 = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($user2ToUser1) {
    return false;
  }
  return true;
} 

function getLatestConversations($userId) {
  global $db;
  $stmt = $db->prepare("SELECT userId2 AS id, u.fullname, u.hasAvatar FROM messages AS m LEFT JOIN users AS u ON u.id = m.userId2 WHERE userId1 = ? GROUP BY userId2 ORDER BY createdAt DESC");
  $stmt->execute(array($userId));
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  for ($i = 0; $i < count($result); $i++) {
    $stmt = $db->prepare("SELECT * FROM messages WHERE userId1 = ? AND userId2 = ? ORDER BY createdAt DESC LIMIT 1");
    $stmt->execute(array($userId, $result[$i]['id']));
    $lastMessage = $stmt->fetch(PDO::FETCH_ASSOC);
    $result[$i]['lastMessage'] = $lastMessage;
  }
  return $result;
}



function resetPassword($email, $password) {
  global $db;
  $stmt = $db->prepare("UPDATE users set password = ? where email = ?");
  $stmt->execute(array($password, $email));
  return $db->lastInsertId();
}

function resetPassword2($email, $password) {
  global $db;
  $stmt = $db->prepare("UPDATE users set password = ? where email = ?");
  $stmt->execute(array($password, $email));
}


function getLoaiSP() {
  global $db;
  $stmt = $db->prepare("SELECT id, TenLoaiSP from loaisp order by TenLoaiSP");
  $stmt->execute();
  $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $posts;
}

function createNhaSX($tenloai) {
  global $db;
  $stmt = $db->prepare("INSERT INTO nhasanxuat (TenNhaSX) VALUE (?)");
  $stmt->execute(array($tenloai));
  return $db->lastInsertId();
}

function getNhaSX() {
  global $db;
  $stmt = $db->prepare("SELECT id, TenNhaSX from nhasanxuat order by TenNhaSX");
  $stmt->execute();
  $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $posts;
}