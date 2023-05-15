<?php
require "../config.php";
session_start();
$code = $_GET["code"];
if(!$code) {
  echo "No code";
  return;
}
$params = array(
  "client_id" => gh_cid,
  "client_secret" => gh_secret,
  "code" => $code
);
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,"https://github.com/login/oauth/access_token");
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curL_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($params));
curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept: application/json"));
curl_exec($ch);
$parsed = json_decode($ch);
$_SESSION["access-token-gh"] = $parsed["access_token"];
curl_close($ch);
header("Location: ../index.php");

