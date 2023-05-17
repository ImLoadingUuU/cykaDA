<?php
require_once "../config.php";
session_start();
$code = $_GET["code"];
if (!$code) {
  $_SESSION["message"] = array(
    "type" => "danger",
    "title" => "Something Went Wrong.",
    "message" => "Invalid Login."

  );
  header("Location: ../login.php");
  return;
}
$params = array(
  "client_id" => gh_cid,
  "client_secret" => gh_secret,
  "code" => $code
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://github.com/login/oauth/access_token");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json"));
$result = curl_exec($ch);
$parsed = json_decode($result, true);
curl_close($ch);


// Get User Info
if (!empty($parsed) && isset($parsed["access_token"])) {
  $accessToken = $parsed["access_token"];
  $curlUD = curl_init();
  curl_setopt($curlUD, CURLOPT_URL, "https://api.github.com/user/emails");
  curl_setopt($curlUD, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curlUD, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $accessToken,
    'Content-Type: application/json',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/113.0'
  ));
  $userInfoResult = curl_exec($curlUD);
  $parsedUserInfo = json_decode($userInfoResult, true);
  curl_close($curlUD);
  foreach ($parsedUserInfo as $email) {
    if ($email["primary"] === true) {
      $primaryEmail = $email["email"];
      break;
    }
  }
  if (!isset($primaryEmail)) {
    $_SESSION["message"] = array(
      "type" => "danger",
      "title" => "Something Went Wrong.",
      "message" => "No Primary Email Exists"

    );
    header("Location: ../login.php");
  }
  // connect mysql
  $connect = mysqli_connect(mysql_host, mysql_uname, mysql_pwd, mysql_db);
  $stmt = $connect->prepare("SELECT * FROM da_clients WHERE email = ?");
  $stmt->bind_param("s", $primaryEmail);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    // Get first row data
    $row = mysqli_fetch_assoc($result);
    echo $row["username"];
    $_SESSION["username"] = $row["username"];
    $_SESSION["email"] = $row["email"];
    $_SESSION["password"] = $row["password"];
    header("Location: ../index.php");
  }  else {
    include "../components/githubAuthRegister.php";
  }
  $stmt->close();

} else {
  $_SESSION["message"] = array(
    "type" => "danger",
    "message" => "GitHub OAuth2 Error",
    "title" => "Something Went Wrong."
  );
  header("Location: ../login.php");
}

