<?php

class ErrorModule
{
  public function signin($error){
    $_SESSION["message"] = $error;
    header("Location: ../login.php");
  }
  public function signUpError($error){
    $_SESSION["message"] = $error;
    header("Location: ../signup.php");
  }
}
