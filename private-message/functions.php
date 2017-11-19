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

function createUser($fullname, $email, $password) {
  global $db;
  $stmt = $db->prepare("INSERT INTO users (email, password, fullname) VALUE (?, ?, ?)");
  $stmt->execute(array($email, $password, $fullname));
  return $db->lastInsertId();
}

function updateUser($user) {
  global $db;
  $stmt = $db->prepare("UPDATE users SET fullname = ?, phone = ?, hasAvatar = ? WHERE id = ?");
  $stmt->execute(array($user['fullname'], $user['phone'], $user['hasAvatar'], $user['id']));
  return $user;
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

function getNewFeeds() {
  global $db;
  $stmt = $db->prepare("SELECT p.id, p.userId, u.fullname as userFullname, u.hasAvatar as userHasAvatar, p.content, p.createdAt FROM posts as p LEFT JOIN users as u ON u.id = p.userId ORDER BY createdAt DESC");
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

function getFriends($userId) {
  global $db;
  $stmt = $db->prepare("SELECT * FROM friends WHERE userId1 = ? OR userId2 = ?");
  $stmt->execute(array($userId, $userId));
  $followings = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $friends = array();
  for ($i = 0; $i < count($followings); $i++) {
    $row1 = $followings[$i];
    if ($userId == $row1['userId1']) {
      $userId2 = $row1['userId2'];
      for ($j = 0; $j < count($followings); $j++) {
        $row2 = $followings[$j];
        if ($userId == $row2['userId2'] && $userId2 == $row2['userId1']) {
          $friends[] = findUserById($userId2);
        }
      }
    }
  }
  return $friends;
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

function unfriend($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("DELETE FROM friends WHERE userId1 = ? AND userId2 = ?");
  $stmt->execute(array($userId1, $userId2));
  $stmt = $db->prepare("DELETE FROM friends WHERE userId1 = ? AND userId2 = ?");
  $stmt->execute(array($userId2, $userId1));
}

function sendFriendRequest($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("INSERT INTO friends(userId1, userId2) VALUES(?, ?)");
  $stmt->execute(array($userId1, $userId2));
}

function acceptFriendRequest($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("INSERT INTO friends(userId1, userId2) VALUES(?, ?)");
  $stmt->execute(array($userId1, $userId2));
}

function rejectFriendRequest($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("DELETE FROM friends WHERE userId1 = ? AND userId2 = ?");
  $stmt->execute(array($userId2, $userId1));
}

function cancelFriendRequest($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("DELETE FROM friends WHERE userId1 = ? AND userId2 = ?");
  $stmt->execute(array($userId1, $userId2));
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

function getMessagesWithUserId($userId1, $userId2) {
  global $db;
  $stmt = $db->prepare("SELECT * FROM messages WHERE userId1 = ? AND userId2 = ? ORDER BY createdAt");
  $stmt->execute(array($userId1, $userId2));
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function sendMessage($userId1, $userId2, $content) {
  global $db;
  $stmt = $db->prepare("INSERT INTO messages (userId1, userId2, content, type, createdAt) VALUE (?, ?, ?, ?, CURRENT_TIMESTAMP())");
  $stmt->execute(array($userId1, $userId2, $content, 0));
  $id = $db->lastInsertId();
  $stmt = $db->prepare("SELECT * FROM messages WHERE id = ?");
  $stmt->execute(array($id));
  $newMessage = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt = $db->prepare("INSERT INTO messages (userId2, userId1, content, type, createdAt) VALUE (?, ?, ?, ?, ?)");
  $stmt->execute(array($userId1, $userId2, $content, 1, $newMessage['createdAt']));
}

function RandomString()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 10; $i++) {
        $randstring = $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}

//gui mail khong dinh kem file
function sendMail($title, $content, $nTo, $mTo,$diachicc=''){
    
    $nFrom = 'BTCN09';
    $mFrom = 'lebinh21071991@gmail.com';  //dia chi email cua ban 
    $mPass = '21071996';       //mat khau email cua ban
    $mail             = new PHPMailer();
    $body             = $content;
    $mail->IsSMTP(); 
    $mail->CharSet   = "utf-8";
    $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
    $mail->SMTPAuth   = true;                    // enable SMTP authentication
    $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
    $mail->Host       = "smtp.gmail.com";        
    $mail->Port       = 465;
    $mail->Username   = $mFrom;  // GMAIL username
    $mail->Password   = $mPass;               // GMAIL password
    $mail->SetFrom($mFrom, $nFrom);
    //chuyen chuoi thanh mang
    $ccmail = explode(',', $diachicc);
    $ccmail = array_filter($ccmail);
    if(!empty($ccmail)){
        foreach ($ccmail as $k => $v) {
            $mail->AddCC($v);
        }
    }
    $mail->Subject    = $title;
    $mail->MsgHTML($body);
    $address = $mTo;
    $mail->AddAddress($address, $nTo);
    $mail->AddReplyTo('lebinh21071991@gmail.com', 'LeQuocBinh');
    if(!$mail->Send()) {
        return 0;
    } else {
        return 1;
    }
}

//gui mail dinh kem file
function sendMailAttachment($title, $content, $nTo, $mTo,$diachicc='',$file,$filename){
    $nFrom = 'Freetuts.net';
    $mFrom = 'xxxx@gmail.com';  //dia chi email cua ban 
    $mPass = 'passlamatkhua';       //mat khau email cua ban
    $mail             = new PHPMailer();
    $body             = $content;
    $mail->IsSMTP(); 
    $mail->CharSet   = "utf-8";
    $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
    $mail->SMTPAuth   = true;                    // enable SMTP authentication
    $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
    $mail->Host       = "smtp.gmail.com";        
    $mail->Port       = 465;
    $mail->Username   = $mFrom;  // GMAIL username
    $mail->Password   = $mPass;               // GMAIL password
    $mail->SetFrom($mFrom, $nFrom);
    //chuyen chuoi thanh mang
    $ccmail = explode(',', $diachicc);
    $ccmail = array_filter($ccmail);
    if(!empty($ccmail)){
        foreach ($ccmail as $k => $v) {
            $mail->AddCC($v);
        }
    }
    $mail->Subject    = $title;
    $mail->MsgHTML($body);
    $address = $mTo;
    $mail->AddAddress($address, $nTo);
    $mail->AddReplyTo('info@freetuts.net', 'Freetuts.net');
    $mail->AddAttachment($file,$filename);
    if(!$mail->Send()) {
        return 0;
    } else {
        return 1;
    }
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