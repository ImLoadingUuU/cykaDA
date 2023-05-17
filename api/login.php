<?php
require "../config.php";
session_start();
if(empty($_GET["email"]) || empty($_GET["password"])) {
  $_SESSION["message"] = array(
    "type" => "danger",
    "message" => "Please fill in all fields",
    "title" => "Login Failed"

  );
  header("location: ../login.php");
  return;
}
// mysql
$connect = mysqli_connect(mysql_host, mysql_uname, mysql_pwd, mysql_db,mysql_port);
if (mysqli_connect_errno()) {
  $_SESSION["message"] = array(
    "type" => "danger",
    "message" => "Cannot Connect To Database",
    "title" => "Login Failed"

  );
  header("location: ../login.php");
  return;
} else {
  echo "SQL Work";
}
// check username and password match
$stmt = $connect->prepare("SELECT * FROM da_clients WHERE email = ? AND password = ?");
// 綁定參數
$stmt->bind_param("ss", $_GET["email"], $_GET["password"]);
// 執行查詢
$stmt->execute();
// 獲取查詢結果
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  $row = mysqli_fetch_assoc($result);
  $_SESSION["username"] = $row["username"];
  $_SESSION["email"] = $row["email"];
  $_SESSION["password"] = $row["password"];
  header("Location: ../index.php");
} else {
  $_SESSION["message"] = array(
    "type" => "danger",
    "message" => "Invalid username or password",
    "title" => "Login Failed"

  );
  header("Location: ../login.php");
  return;
}




?>
