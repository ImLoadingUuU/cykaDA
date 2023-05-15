<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta17
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
  <title>CykaDA - GitHub Registeration.</title>
  <!-- CSS files -->
  <link href="../dist/css/tabler.min.css?1674944402" rel="stylesheet"/>
  <link href="../dist/css/tabler-flags.min.css?1674944402" rel="stylesheet"/>
  <link href="../dist/css/tabler-payments.min.css?1674944402" rel="stylesheet"/>
  <link href="../dist/css/tabler-vendors.min.css?1674944402" rel="stylesheet"/>
  <link href="../dist/css/demo.min.css?1674944402" rel="stylesheet"/>
  <style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
      --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
      font-feature-settings: "cv03", "cv04", "cv11";
    }
  </style>
</head>
<body class=" d-flex flex-column">
<script src="../dist/js/demo-theme.min.js?1674944402"></script>
<div class="page page-center">
  <div class="container container-tight py-4">

    <form class="card card-md" action="../api/signup.php" method="get" autocomplete="off" novalidate>
      <div class="card-body text-center">
        <div class="mb-4">
          <h2 class="card-title">Not Registered</h2>
          <p class="text-muted">Please enter your password to unlock your account</p>
        </div>
        <div class="mb-4">
          <span class="avatar avatar-xl mb-3" style="background-image: url(../assets/github-mark.png)"></span>
          <h3>GitHub</h3>
          <p>Register an account using CykaDA</p>
        </div>
        <div class="mb-4">
          <input type="text" name="username" class="form-control"  placeholder="Username">
          <hr>
          <input type="text" name="email" class="form-control" hidden placeholder="Email&hellip;" value="<?php echo $primaryEmail ?? "undefined" ?>">
          <input type="password"  name="password" class="form-control" placeholder="Password&hellip;">
        </div>
        <div>
          <a href="#" class="btn btn-primary w-100">
            <!-- Download SVG icon from http://tabler-icons.io/i/lock-open -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                 stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M5 11m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"/>
              <path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
              <path d="M8 11v-5a4 4 0 0 1 8 0"/>
            </svg>
            Register
          </a>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Libs JS -->
<!-- Tabler Core -->
<script src="../dist/js/tabler.min.js?1674944402" defer></script>
<script src="../dist/js/demo.min.js?1674944402" defer></script>
</body>
</html>
