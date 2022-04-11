<?php
$insert = false;
$update = false;
$delete = false;
// Connecting to Database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

$conn = mysqli_connect($servername, $username, $password, $database);
// Die if connection was not successful
if (!$conn) {
  die("Sorry we failed to connect: " . mysqli_connect_error());
}
// Delete record
if (isset($_GET['delete'])) {
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `notes` WHERE `Sr.` = $sno";
  $result = mysqli_query($conn, $sql);
}
//Update Record
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['snoEdit'])) {
    $sno = $_POST['snoEdit'];
    $title = $_POST['titleEdit'];
    $description = $_POST['descriptionEdit'];

    $sql = "UPDATE `notes` SET `Title` = '$title' , `Description` = '$description' WHERE `notes`.`Sr.` = $sno";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $update = true;
    } else {
      echo '<div class="container alert alert-danger alert-dismissible fade show" role="alert">
    <strong>ERROR!</strong> Your note was not added!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
  }
}
?>
<!-- PHP ENDS -->

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

  <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

  <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

  <!-- Dependency for modal👇👇 -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <title>Search Results</title>
</head>

<body>

  <!-- Navbar Starts -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand">Notes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="/notes/notes.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Contact Us</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Navbar Ends -->
  <!-- Datatables start-->
  <div class="container my-4">
    <table class="table table-dark table-striped table-hover table-bordered my-4" id="myTable">
      <thead>
        <tr style="text-align:center">
          <th class="bg-success" scope="col">Sr.</th>
          <th class="bg-success" scope="col">Title</th>
          <th class="bg-success" scope="col">Description</th>
          <th class="bg-success" scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Displying Data in table -->
        <div class="container my-4">
          <?php
          $sql = "SELECT * FROM `notes`";
          $result = mysqli_query($conn, $sql);
          $sno = 0;
          while ($row = mysqli_fetch_assoc($result)) {
            $sno = $sno + 1;
            echo "<tr style='text-align:center'>
            <th >" . $sno . "</th>
            <td>" . $row['Title'] . "</td>
            <td>" . $row['Description'] . "</td>
            <td>
            <button class='edit btn btn-sm btn-primary' id=" . $row['Sr.'] . ">Edit</button>
            <button class='delete btn btn-sm btn-secondary' id=d" . $row['Sr.'] . ">Delete</button></td>
            </tr>";
          }
          ?>
        </div>
      </tbody>
    </table>
  </div>

  <!--Edit button Part Starts -->
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("Edit");
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        $("#editModal").modal('toggle');
      })
    })
    // Edit button Part Ends
    // Delete button Part Starts
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        sno = e.target.id.substr(1, );
        if (confirm("Do you want to Delete")) {
          window.location = `/notes/search_results.php?delete=${sno}`;
        } else {
          console.log("No");
        }
      })
    })
    // Delete button Part Ends
  </script>
  <!-- Datatables JavaScript Part Ends -->

  <!-- Edit Modal Part Start -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Notes</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/notes/notes.php" method="POST">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group mt-3">
              <label for="titleEdit" class="form-label">Notes Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" maxlength="20" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required>
            </div>
            <div class="form-group mt-3">
              <label for="descriptionEdit" class="form-label">Notes Description</label>
              <textarea class="form-control" name="descriptionEdit" id="descriptionEdit" cols="30" rows="5" maxlength="254" required></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Edit Modal Part Ends -->

  <?php
  if ($delete) {
    echo '<div class="container alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Your note was Deleted!</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> 
    </div>';
  }
  if ($update) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has was updated.
    <button type='button' class='btn-close' data-dismiss='alert' aria-label='Close'>
    </div>";
  }
  ?>
  <!-- Foorter Part -->
  <footer class="site-footer">
    <div class="container my-4">
      <div class="row">
        <div class="col-md-8 col-sm-6 col-xs-12 container-3">
          <b>
            <p class="copyright-text my-3">Copyright &copy; 2021 Anuj Panchal</p>
          </b>
        </div>
      </div>
    </div>
  </footer>
</body>

</html>