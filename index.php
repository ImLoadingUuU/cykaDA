<?php
include "./components/head.php";
?>
<?php
$connect = mysqli_connect(mysql_host, mysql_uname, mysql_pwd, mysql_db);
$stmt = $connect->prepare("SELECT * FROM da_website WHERE client_email = ?");
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="page-wrapper">
  <div class="page-header d-print-none">


    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
            SiteNexus
          </div>
          <h2 class="page-title">
            Home
          </h2>

        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
          <div class="btn-list">
            <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
               data-bs-target="#create-website">
              <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                   stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 5l0 14"/>
                <path d="M5 12l14 0"/>
              </svg>
              Create new website
            </a>


          </div>
        </div>
       <?php if($_SESSION["message"]){ ?>
         <div class="alert alert-red">
           <h4 class="alert-title">Something Went Wrong</h4>
           <div class="text-muted"><?php echo $_SESSION["message"]?></div>
         </div>

       <?php }
       $_SESSION["message"] = null
       ?>
    </div>


    </div>
  </div>
  <div class="page-body">
    <div class="container-xl">
      <div class="row row-deck row-cards">
        <div class="col-sm-6 col-lg-3">
          <div class="card">

            <div class="card-body">
              <div class="h1 mb-3"><?php echo $result->num_rows ?>/1</div>
              <div class="d-flex mb-2">
                <div>Free Hosting Websites</div>

              </div>
              <div class="progress progress-sm">
                <div class="progress-bar bg-danger" style="width: <?php echo $result->num_rows * 100 ?>% "
                     role="progressbar" aria-valuenow="<?php echo $result->num_rows ?>"
                     aria-valuemin="0" aria-valuemax="1" aria-label="<?php echo $result->num_rows ?>/1">
                  <span class="visually-hidden">0% Used</span>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card">

            <div class="card-body">
              <div class="h1 mb-3">Free</div>
              <div class="d-flex mb-2">
                <div>Plan</div>

              </div>

            </div>
          </div>

        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card">

            <div class="card-body">
              <div class="h1 mb-3">UK</div>
              <div class="d-flex mb-2">
                <div>Server</div>

              </div>

            </div>
          </div>

        </div>
      </div>
      <br>
      <div class="col-auto">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Websites</h3>
          </div>

          <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
              <thead>
              <tr>

                <th class="w-1">Username. <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm icon-thick" width="24" height="24"
                       viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                       stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M6 15l6 -6l6 6"></path>
                  </svg>
                </th>
                <th>Password</th>
                <th>Location</th>
                <th>Created</th>
                <th>Plan</th>
                <th></th>
              </tr>
              </thead>
              <tbody>
              <?php
              // connect to sql!


              while ($row = mysqli_fetch_array($result)) {

                ?>
                <tr>

                  <td><span class="text-muted"><?php echo $row["username"] ?></span></td>
                  <td><code><?php echo $row["password"] ?></code></td>
                  <td>
                    <span class="flag flag-country-gb"></span>
                    United Kingdom
                  </td>
                  <td>
                    <?php echo $row["date_created"] ?>
                  </td>
                  <td>
                    <span class="badge bg-success me-1"></span> Free
                  </td>

                  <td class="text-end">

                    <a class="btn dropdown-toggle align-text-top button-info" data-bs-boundary="viewport"
                            data-bs-toggle="dropdown" aria-expanded="false" href="https://sitenexus.me:2222">Login to
                      DirectAdmin
                    </a>

                  </td>
                </tr>
                <?php
              }

              ?>


              </tbody>

            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
  <!-- Modal-->
  <div class="modal modal-blur fade" id="create-website" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Website</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" action="./api/createWebsite.php">
          <div class="modal-body">
            <div class="form-selectgroup-boxes row mb-3">
              <div class="col-lg-6">
                <label class="form-selectgroup-item">
                  <input type="radio" value="1" class="form-selectgroup-input" checked="">
                  <span class="form-selectgroup-label d-flex align-items-center p-3">
                    <span class="me-3">
                      <span class="form-selectgroup-check"></span>
                    </span>
                    <span class="form-selectgroup-label-content">
                      <span class="form-selectgroup-title strong mb-1">Free</span>
                      <span class="d-block text-muted">1GB Disk Space,10GB Bandwidth, 256MB RAM</span>
                    </span>
                  </span>
                </label>
              </div>

            </div>
            <div class="row mb-3 align-items-end">

              <div class="col">
                <label class="form-label">Name</label>
                <input id="name" name="username" type="text" class="form-control">
              </div>
            </div>
            <div class="row mb-3 align-items-end">

              <div class="col">
                <label class="form-label">Password</label>
                <input id="password" name="password" type="password" class="form-control">
              </div>
            </div>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal modal-blur fade " role="dialog" id="creating">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-status bg-danger"></div>
        <div class="modal-body text-center py-4">

          <h3>Account was creating</h3>
          <div class="text-muted">Do you really want to remove 84 files? What you've done cannot be undone.</div>
        </div>
        <div class="modal-footer">

          <p>Creating...</p>
          <div class="progress">
            <div class="progress-bar-indeterminate progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                 aria-valuemax="100" aria-label="75% Complete">
            </div>
          </div>


          You cannot stop creating account, even you close tab/browser
        </div>
      </div>
    </div>
  </div>
  <div class="modal modal-blur fade" id="websiteCreated">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-status bg-success"></div>
        <div class="modal-body text-center py-4">
          <!-- Download SVG icon from http://tabler-icons.io/i/circle-check -->
          <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-green icon-lg" width="24" height="24"
               viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
               stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
            <path d="M9 12l2 2l4 -4"/>
          </svg>
          <h3>Website Created</h3>
          <div class="text-muted">Your ordered "Web Hosting" Package "free" has been created</div>
        </div>
        <div class="modal-footer">
          <div class="w-100">
            <div class="row">
              <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                  Done!
                </a></div>
              <div class="col"><a href="#" class="btn btn-success w-100" data-bs-dismiss="modal">
                  OK
                </a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal modal-blur fade" id="websiteFailedToCreate">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-status bg-danger"></div>
        <div class="modal-body text-center py-4">
          <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
          <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24"
               viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
               stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M12 9v2m0 4v.01"/>
            <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"/>
          </svg>
          <h3>Failed to create your website</h3>
          <div class="text-muted" id="errorMessage"></div>
        </div>
        <div class="modal-footer">
          <div class="w-100">
            <div class="row">
              <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                  Ok.
                </a></div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>
<script>

  let createWebsite = async () => {
    let cw = new bootstrap.Modal('#create-website', {})
    await cw.hide()
    let creatingModal = new bootstrap.Modal('#creating', {})
    let wsCreated = new bootstrap.Modal('#websiteCreated', {})
    let errModal = new bootstrap.Modal('#websiteFailedToCreate', {})
    await creatingModal.show();
    let info = {
      name: document.getElementById("name").value,
      password: document.getElementById("password").value
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./api/createWebsite.php")
    xhr.onerror = async function () {
      await creatingModal.hide();
      $("#errorMessage").innerText = "Error: " + xhr.responseText;
      await errModal.show();
    }
    xhr.onload = async function () {

      if (xhr.status !== 200) {

        await creatingModal.hide();
        $("#errorMessage").textContent = "Error: " + xhr.responseText;
        await errModal.show();
      } else {
        await creatingModal.hide();
        await wsCreated.show();
      }


    }
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    xhr.send(`username=${info.name}&password=${info.password}`);
  }
  document.getElementById("createAccountButton").addEventListener("click", createWebsite);
</script>
<?php
include "./components/footer.php";

?>
