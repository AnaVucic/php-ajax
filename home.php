<?php

require 'db_connection.php';
require 'model/user.php';

require 'model/membership.php';
require 'model/member.php';

require 'model/member_membership.php';

session_start();

if (!isset($_SESSION['UserID'])) {
  header('Location: index.php');
  exit();
}

$result = MemberMembership::getAll($conn);
if (!$result) {
  echo "An error occured while reading the database!";
  die();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <!-- <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
  <link href="assets/css/style.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>Gym Membership Management System - Home Page</title>
</head>

<body>
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">
      <h1 class="logo"><a href="home.php">Gym Membership Management System</a></h1>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="">Home</a></li>
          <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li>

          <li><a class="getstarted scrollto">Get Started</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->


  <br><br><br><br>

  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
    Add New Membership
  </button>

  <section class="d-flex align-items-center">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Firstname</th>
          <th scope="col">Lastname</th>
          <th scope="col">Membership</th> <!-- ovo je polje membershipName iz `membership` tabele -->
          <th scope="col">Duration</th>
          <th scope="col">Start Date</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      <tbody>


        <?php
        $number = 1;
        foreach ($result as $row) {

        ?>
          <tr>
            <td><?php echo $number++; ?></td>
            <td><?php echo $row->member->firstname; ?></td>
            <td><?php echo $row->member->lastname; ?></td>
            <td><?php echo $row->membership->membershipname; ?></td>
            <td><?php echo $row->membership->duration; ?></td>
            <td><?php echo $row->startDate->format("j M, Y")  ?></td>
            <td><?php if ($row->status) echo 'Active';
                else echo 'Inactive'; ?></td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>

  </section>

  <!-- MODAL ADD -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Adding New Membership</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container add-form">
            <form action="#" method="post" id="addForm">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="">Member:</label>
                    <select name="member" id="member" class="form-control">
                      <option value="" selected disabled>Select a member</option>
                      <?php
                      $members = Member::getAll($conn);
                      if ($members != null) {
                        foreach ($members as $member) {
                          echo "<option value=\"" . $member->memberid . "\"> " . $member->firstname . " " . $member->lastname . " </option>";
                        }
                      }

                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="">Membership Type:</label>
                    <select name="membership" id="membership" class="form-control">
                      <option value="" selected disabled>Select a membership type</option>
                      <?php
                      $memberships = Membership::getAll($conn);
                      if ($memberships != null) {
                        foreach ($memberships as $membership) {
                          echo "<option value=\"" . $membership->membershipid . "\"> " . $membership->membershipname . ", " . $membership->duration . ", " . $membership->fee . ",00 </option>";
                        }
                      }

                      ?>
                    </select>
                  </div>
                  <div class="form-group date" data-provide="datepicker">
                    <label for="">Starting date:</label>
                    <div class="input-group date">
                      <input id="myDate" name="date" type="text" class="form-control" value="Click to pick a date" data-date-format="MM/DD/YYYY">
                      <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" id="btnAdd" class="btn btn-primary">Add</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

        </div>
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="mt-auto">
    <div class="row">
      <div class="col text-center">
        <span class="text-muted">Gym Membership Management System</span>
      </div>
    </div>
  </footer>
  <!-- SCRIPTS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script>
    $(document).ready(function() {
      console.log("Page is ready!");
      const now = new Date();
    });

    $("#addForm").submit(function() {
      console.log("nesto");
      event.preventDefault();
      const $form = $(this);

      // const $fromspan = $form.find("span");
      // console.log($fromspan);
      // var value = $("#myDate").datepicker("getDate");
      // console.log(value);

      const $input = $form.find("input, select");
      // $input.add(value);
      // console.log($input);
      const serializedData = $form.serialize();
      console.log(serializedData);

      $input.prop('disabled', true);

      request = $.ajax({
        url: 'handler/add.php',
        type: 'post',
        data: serializedData
      });

      request.done(function(response) {
        console.log(response);
        if (response == "Success") {
          console.log("Added new membership");
          location.reload(true);
        } else {
          console.log("Membership not added " + response);
        }
        console.log(response);
      });

      request.fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error occurred: " + textStatus, errorThrown);
      });
    });
  </script>

</body>

</html>