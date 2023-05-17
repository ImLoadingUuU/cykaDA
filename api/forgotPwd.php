<?php
session_start();
require_once "../config.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';
// 实例化PHPMailer对象
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host       = smtpHost;
$mail->SMTPAuth   = true;
$mail->Username   = smtpUsername;
$mail->Password   = smtpPassword;
$mail->SMTPSecure = smtpSecure;
$mail->Port       = smtpPort;

if (!isset($_GET["email"])) {
  echo "Missing Mail";
  $_SESSION["message"] = "Missing E-mail";
  header("Location: ../forgot.php");
  return;
}
// Create SQL Connection
$connect = mysqli_connect(mysql_host, mysql_uname, mysql_pwd, mysql_db);
if (isset($_GET["code"])) {
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
  $mail->setFrom(smtpUsername, 'SiteNexus Team');
  $mail->addAddress($to);
  $mail->isHTML(true);
  $mail->Body = $message;
  $mail->Subject = $subject;
  if(!$mail->send()){

    $_SESSION["message"] = "Mailer Error: " . $mail->ErrorInfo;
    header("Location: ../forgot.php");
    return;
  }
  $_SESSION["message"] = "Recovery Code Sent";
  header("Location: ../forgot.php");
} else {
  $_SESSION["message"] = "Error";
  header("Location: ../forgot.php");
}

