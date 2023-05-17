<?php
require "../config.php";
include "../module/emailValidator.php";
const validator = new emailValidator();
session_start();
if (empty($_GET["email"]) || empty($_GET["password"]) || empty($_GET["username"])) {
  $_SESSION["message"] = array(
    "type" => "danger",
    "message" => "Please fill in all fields",
    "title" => "Sign Up Failed"

  );
  echo "Field Required";
  header("Location: ../signup.php");
  return;
}

if (!filter_var($_GET["email"], FILTER_VALIDATE_EMAIL)) {
  echo "Invalid Email";
  $_SESSION["message"] = array(
    "type" => "danger",
    "message" => "Invalid email format",
    "title" => "Please Check your email is valid"

  );
  header("Location: ../signup.php");
  return;
}
if (empty($_GET["h-captcha-response"])) {
  $_SESSION["message"] = array(
    "type" => "danger",
    "message" => "Captcha is Required.",
    "title" => "Register Failed"

  );
  echo "Captcha Required";
  header("Location: ../signup.php");
  return;
}
// create curl
$CaptchaCurl = curl_init();
curl_setopt($CaptchaCurl, CURLOPT_URL, "https://hcaptcha.com/siteverify");
curl_setopt($CaptchaCurl, CURLOPT_POST, 1);
curl_setopt($CaptchaCurl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($CaptchaCurl, CURLOPT_POSTFIELDS, http_build_query(array('response' => $_GET["h-captcha-response"], 'secret' => hCaptchaSecret)));
$CaptchaResult = curl_exec($CaptchaCurl);
curl_close($CaptchaCurl);
// check captcha
if (!json_decode($CaptchaResult, true)["success"]) {
  $_SESSION["message"] = array(
    "type" => "danger",
    "message" => "Captcha Error.",
    "title" => "Incorrect Captcha."

  );
  echo "Captcha Failed";
  header("Location: ../signup.php");
  return;
}
$res = validator->validate($_GET["email"]);
if (!$res["result"]) {
  $_SESSION["message"] = array(
    "type" => "danger",
    "message" => $res["message"],
    "title" => "Email is not valid"

  );
  header("Location: ../signup.php");
  return;
}
$hspc = htmlspecialchars($_GET["username"], ENT_QUOTES, 'UTF-8');

// SQL
$connect = mysqli_connect(mysql_host, mysql_uname, mysql_pwd, mysql_db);
// check email and username same
$stmt = $connect->prepare("SELECT * FROM da_clients WHERE email = ? AND username = ? AND password=  ?");
// 綁定參數
$stmt->bind_param("sss", $_GET["email"], $_GET["username"], $_GET["password"]);
// 執行查詢
$stmt->execute();
// Check Row Exists
$result = $stmt->get_result();
if ($stmt->error) {
  echo $stmt->error;
  die();
}

if ($result->num_rows > 0) {
  $_SESSION["message"] = array(
    "type" => "danger",
    "message" => "Email or username already exists.",
    "title" => "Cannot Register."

  );
  header("Location: ../signup.php");
  return;
}

// Create User
$stmt = $connect->prepare("INSERT INTO da_clients (username, email, password, activated,uid) VALUES (?, ?, ?, 0," . rand(1, 2147483647) . ")");
$stmt->bind_param("sss", $hspc, $_GET["email"], $_GET["password"]);
$stmt->execute();
if ($stmt->error) {
  echo "Something went wrong";
  $_SESSION["message"] = array(
    "type" => "danger",
    "message" => "Something Went Wrong Please Try Again.",
    "title" => "Cannot Register."

  );
  header("Location: ../signup.php");
  return;
}
$_SESSION["message"] = array(
  "type" => "success",
  "message" => "Account Created",
  "title" => "Congrats!"

);
header("Location: ../login.php");

