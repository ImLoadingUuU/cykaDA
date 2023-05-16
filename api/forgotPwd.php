<?php
session_start();
require ("../config.php");
if (!isset($_GET["email"])) {
  echo "Missing Mail";
  $_SESSION["message"] = "Missing E-mail";
  header("Location: ../forgotP.php");
  return;
}
// Create SQL Connection
$connect = mysqli_connect(mysql_host, mysql_uname, mysql_pwd, mysql_db);
if ($_GET["code"]) {
  if($_GET["password"]) {
    echo "Password Not Changed - Missing Password Parameter";
    $_SESSION["message"] = "Missing Password Parameter";
    header("Location: ../forgot.php");
  }
 // Check Code
  $stmt = $connect->prepare("SELECT * FROM da_clients WHERE email = ? AND recover_code = ?");
  $stmt->bind_param("ss", $_GET["email"], $_GET["code"]);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0 ) {
    // modify password
    $stmt = $connect->prepare("UPDATE da_clients SET password = ? WHERE email = ? AND recover_code = null");
    $stmt->bind_param("ss", $_GET["password"], $_GET["email"]);
    $stmt->execute();
    if ($stmt->error) {
      echo $stmt->error;
      die();
    }
    header("Location: ../login.php");
  } else {
    echo "Recover Error - Code Not Found";
    $_SESSION["message"] = "Code Not Found";
    header("Location: ../forgot.php");
    return;
  }
}

// check email and username same
$stmt = $connect->prepare("SELECT * FROM da_clients WHERE email = ?");
// 綁定參數
$stmt->bind_param("s", $_GET["email"]);
// 執行查詢
$stmt->execute();
// Check Row Exists
$result = $stmt->get_result();
if ($stmt->error) {
  echo $stmt->error;
  die();
}
if ($result->num_rows > 0) {
  $row = mysqli_fetch_assoc($result);
  $code = rand(1000000000,2147483647);
  $stmt = $connect->prepare("UPDATE da_clients SET recover_code = ? WHERE email = ?");
  $stmt->bind_param("ss", $code, $_GET["email"]);
  $stmt->execute();
  if ($stmt->error) {
    echo $stmt->error;
    die();
  }
  $to = $_GET["email"];
  $subject = "Password Recovery";
  $message = "Your Recovery Code is " . $code;
  $headers = "From: SiteNexus Team";
  mail($to, $subject, $message, $headers);
  $_SESSION["message"] = "Recovery Code Sent";
  header("Location: ../forgot.php");
} else {
  $_SESSION["message"] = "Error";
  header("Location: ../forgot.php");
}

