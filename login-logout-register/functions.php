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
function createPosts($id, $userId, $content) {
  global $db;
  $stmt = $db->prepare("INSERT INTO posts (id, userId, content) VALUE (?, ?, ?)");
  $stmt->execute(array($id, $userId, $content));
  return $db->lastInsertId();
}
function updatePassword($password, $id) {
  global $db;
  $stmt = $db->prepare("UPDATE users SET password = ? where id = ?");
  $stmt->execute(array($password, $id));
  return $id;
}
function updateThongTinCaNhan($fullname, $phone, $id) {
  global $db;
  $stmt = $db->prepare("UPDATE users SET fullname = ?, phone = ? WHERE id = ?");
  $stmt->execute(array($fullname, $phone, $id));
  return $id;
}
function readCaption() {
  global $db;
  $stmt = $db->query("SELECT users.fullname, posts.content, posts.createdAt FROM users, posts WHERE users.id = posts.id");
  //$stmt->execute(array(strtolower($email)));
  $caption = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $caption;
}
