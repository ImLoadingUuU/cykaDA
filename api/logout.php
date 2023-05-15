<?php
 $_SESSION["username"] = null;
  $_SESSION["password"] = null;
  $_SESSION["email"] = null;
  $_SESSION["message"] = "You has been logged out.";
  header("Location: ../login.php");

