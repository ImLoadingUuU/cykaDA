
# CykaDA
🤓Do Not use on Production Environment🤓
<hr>

## Feature never added

- Admin Panel (Use PhpMyAdmin as Alternative)

## Feature Planned

- [ ] GDPS Auto Installer
- [ ] Email Auth
- [x] Forget Password

A Billing System for a small business.
## Usage Policy
You can use this on your service, by the way. Please credit this GitHub repo.
## Config File
```php
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$mail = new PHPMailer(true);
//Load Composer's autoloader
require 'vendor/autoload.php';
const mysql_host = "host";
const mysql_port = "3306";
const mysql_db = "";
const mysql_uname = "";
const mysql_pwd = "";

const da_host = "server";
const da_uname = "username";
const da_pwd = "password";

const gh_cid = "";
const gh_secret = "";

const host = "localhost";
$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'user@example.com';                     //SMTP username
$mail->Password   = 'secret';                               //SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
$mail->Port       = 465;

```
