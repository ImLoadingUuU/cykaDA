<?php
session_start();
  $_SESSION["username"] = null;
  $_SESSION["password"] = null;
  $_SESSION["email"] = null;
  $_SESSION["message"] = array(
    "type" => "success",
    "message" => "Logout Success",
    "title" => "Logout Success"
  );
  header("Location: ../login.php");

