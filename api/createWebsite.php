<?php
require_once "../config.php";
require_once "../module/emailValidator.php";
session_start();
if (!isset($_SESSION["email"]) ?? !isset($_SESSION["password"])) {

  $_SESSION["message"] = "Not Logged in";
  header("Location: ../index.php");
  return;
}
if (empty($_POST["username"]) || empty($_POST["password"])) {

  $_SESSION["message"] = "Username and password cannot be empty";
  header("Location: ../index.php");;
  return;
}
$connect = mysqli_connect(mysql_host, mysql_uname, mysql_pwd, mysql_db);

// check username and password match
$stmt = $connect->prepare("SELECT * FROM da_clients WHERE email = ? AND password = ?");

// 綁定參數
$stmt->bind_param("ss", $_SESSION["email"], $_SESSION["password"]);


// 執行查詢
$stmt->execute();

// 獲取查詢結果
$result = $stmt->get_result();

if ($result->num_rows == 0) {
  $_SESSION["message"] = "DB 403 Login Required";
  header("Location: ../index.php");
  return;
}
$ch = curl_init();
$params = array(
  "action" => "create",
  "add" => "Submit",
  "email" => $_SESSION["email"],
  "passwd" => $_POST["password"],
  "passwd2" => $_POST["password"],
  "username" => $_POST["username"],
  "package" => "Free",
  "ip" => "135.148.226.33"
);
$qs = http_build_query($params);
$authHeader = array();
$authHeader[] = "Authorization: Basic " . base64_encode(da_uname . ":" . da_pwd);
curl_setopt($ch, CURLOPT_URL, "https://" . da_host . "/CMD_API_ACCOUNT_USER");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $qs);
curL_setopt($ch, CURLOPT_HTTPHEADER, $authHeader);
$result = curl_exec($ch);
// parse query
$parsed = null;
parse_str($result, $parsed);
if (curl_error($ch)) {

  $_SESSION["message"] = "Something went wrong while creating account";
  header("Location: ../index.php");
  return;
}
if ($parsed["error"]) {

  $_SESSION["message"] = "Something went wrong while create website - " . $parsed["details"];
  header("Location: ../index.php");
  return;
}
$nt = date("Y-m-d H:i:s");
$stmt = $connect->prepare("INSERT INTO da_website (username, password, suspended,date_created, client_email,uid) VALUES (?, ?, '0', \" " . date("Y-m-d H:i:s") . "\", ?," . rand(1, 2147483647) . ")");
$stmt->bind_param("sss", $_POST["username"], $_POST["password"], $_SESSION["email"],);
$stmt->execute();
header("Location: ../index.php");
