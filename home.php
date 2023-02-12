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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
  <script src="https://kit.fontawesome.com/d652a11c76.js" crossorigin="anonymous"></script>

  <script src="https://kit.fontawesome.com/d652a11c76.js" crossorigin="anonymous"></script>

  <title>Gym Membership Management System - Home Page</title>
</head>

<body>
  <header id="header" class="fixed-top">
    <div class="d-flex align-items-center justify-content-around">
      <h1 class="logo"><a href="home.php">Gym Membership Management System</a></h1>
      <nav id="navbar" class="navbar d-flex align-items-center justify-content-center">
        <ul>
          <li class="nav-item">
            <form class="form-inline">
            <input class="form-control mr-sm-2" type="text" placeholder="Member" aria-label="Search" id = "filerInput" onkeyup="tableFilter()">
            <button class="btn btn-outline my-2 my-sm-0" type="submit">Search</button>
          </form>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">
              <button class="btn btn-outline"> 
                <i class="align-self-center fas fa-sign-out" ></i> 
              </button>
            </a>
          </li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
    </div>
  </header><!-- End Header -->


  <br><br><br><br><br>

  <div class="d-flex justify-content-center">
    <button type="button" class="btn" data-toggle="modal" data-target="#exampleModalCenter">
      Add New Membership
      </button>
      <br><br>
  </div>
  
  <section class="d-flex align-items-center">
  
    
    <table class="table table-hover" id="table">
      <thead class="thead-light" style="text-align:center">
        <tr>
          <th scope="col" onclick="tableSort(0)" style="cursor: pointer">#</th>
          <th scope="col" onclick="tableSort(1)" style="cursor: pointer">Firstname</th>
          <th scope="col" onclick="tableSort(2)" style="cursor: pointer">Lastname</th>
          <th scope="col" onclick="tableSort(3)" style="cursor: pointer">Membership</th> <!-- ovo je polje membershipName iz `membership` tabele -->
          <th scope="col" onclick="tableSort(4)" style="cursor: pointer">Duration</th>
          <th scope="col" onclick="tableSortByDate()" style="cursor: pointer">Start Date</th>
          <th scope="col" onclick="tableSort(6)" style="cursor: pointer">Status</th>
          <th scope="col" >Change Date</th>
          <th scope="col" >Cancel</th>
        </tr>
      </thead>
      <tbody style="text-align:center">
        <?php
        $number = 1;
        foreach ($result as $row) {
        ?>
          <tr>
            <td><?php echo $number++; ?></td>
            <td ><?php echo $row->member->firstname; ?></td>
            <td ><?php echo $row->member->lastname; ?></td>
            <td ><?php echo $row->membership->membershipname; ?></td>
            <td ><?php echo $row->membership->duration; ?></td>
            <td ><?php echo $row->startDate->format("j M, Y")  ?></td>
            <td ><?php if ($row->status) echo 'Active';
                else echo 'Inactive'; ?>
            </td>
            <td>
              <button id="editMembership" class="btn fa-regular fa-calendar edit-membership" style="background-color: transparent" data-toggle="modal" data-target="#editModal" title="Edit memberhip" value="<?php echo $row->member->memberid . " " . $row->membership->membershipid  ?>">
              </button>
            </td>
            <td scope="col">
              <button id="cancelMembership" name="cancelMembership" class="btn fa-solid fa-trash cancel-membership" style="background-color: transparent" title="Cancel memberhip" value="<?php echo $row->member->memberid . " " . $row->membership->membershipid  ?>">
              </button>
            </td>
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
  <!-- EDIT MODAL -->
  <div class="modal fade" id="editModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h3>Edit Membership</h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="container edit-form">
            <form action="#" method="post" id="editForm">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="">Member:</label>
                    <input id="memberNameEdit" type="text" class="form-control" readonly />
                  </div>
                  <div class="form-group">
                    <label for="">Member ID:</label>
                    <input id="memberIDEdit" type="text" name="memberIDEdit" class="form-control" readonly />
                  </div>
                  <div class="form-group">
                    <label for="">Membership:</label>
                    <input id="membershipNameEdit" type="text" class="form-control" readonly />
                  </div>
                  <div class="form-group">
                    <label for="">Membership ID:</label>
                    <input id="membershipIDEdit" type="text" name="membershipIDEdit" class="form-control" readonly />
                  </div>
                  <div class="form-group date" data-provide="datepicker">
                    <label for="">Starting date:</label>
                    <div class="input-group date">
                      <input id="editDate" name="editDate" type="text" class="form-control" value="Click to pick a date" data-date-format="MM/DD/YYYY">
                      <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" id="btnAdd" class="btn btn-primary">Save</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
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
  <script src="js/main.js"></script>
  <script type="application/javascript">

    function tableFilter(){
      let input, filter, table, tr, td, i, value;
      input = document.getElementById("filerInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("table");
      tr = table.getElementsByTagName("tr");
      for(i = 1; i < tr.length; i++){
        td = tr[i].getElementsByTagName("td")[2];
        if(td) {
          value = td.textContent || td.innerText;
          if(value.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          }
          else {
            tr[i].style.display = "none";
          }
        }
      }
    }
  </script>
  <script>
    function tableSort(n){
      var table, rows, toggle, i, x, y, toSwitch, dir, switchCnt = 0;
      table = document.getElementById("table");
      toggle = true;
      dir = "asc";
      while(toggle){
        toggle = false;
        rows = table.rows;
        for(i = 1; i < (rows.length - 1); i++){
          toSwitch = false;
          x = rows[i].getElementsByTagName("TD")[n];
          y = rows[i + 1].getElementsByTagName("TD")[n];
          if(dir == "asc"){
            if(x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()){
              toSwitch = true;
              break;
            }
          } else if(dir == "desc"){
            if(x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()){
              toSwitch = true;
              break;
            }
          }
        }
        if(toSwitch){
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            toggle = true;
            switchCnt ++; 
          } else {
            if (switchCnt == 0 && dir == "asc") {
              dir = "desc";
              toggle = true;
            }
          }
      }
    }
  </script>

</body>

</html>