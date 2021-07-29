<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <!-- Dependency for modal -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <title>Notes</title>
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
            <a class="nav-link" aria-current="page" href="notes.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Contact Us</a>
          </li>
        </ul>
        <form action="search_results.php" class="d-flex" method="GET">
          <button class="btn btn-outline-success" name="search" id="search" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  <!-- Navbar Ends -->

  <!-- Form Input Starts -->

  <div class="container my-4">
    <h2>Add Your Notes</h2>
    <form action="/notes/notes.php" method="POST">
      <div class="form-group mt-3">
        <label for="title" class="form-label">Notes Title</label>
        <input type="text" class="form-control" id="title" name="title" maxlength="20" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required>
      </div>
      <div class="form-group mt-3">
        <label for="description" class="form-label">Notes Description</label>
        <textarea class="form-control" name="description" id="description" cols="30" rows="5" maxlength="254" required></textarea>
      </div>
      <div class="mt-3">
        <button type="submit" class="btn btn-success">Add Note</button>
      </div>
    </form>
  </div><br>
  <!-- Form Input Ends -->

  <!-- PHP Starts -->
  <?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Connecting to Database

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "notes";

    // Create connection for database

    $conn = mysqli_connect($servername, $username, $password, $database);

    //Inserting data into database

    $sql = "INSERT INTO `notes` (`Title`, `Description`) VALUES ('$title', '$description')";
    $result = mysqli_query($conn, $sql);

    // data entry alert code
    if ($result) {
      echo '<div class="container alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Success!</strong> Your Note was added!
      </div>';
    } else {
      echo '<div class="container alert alert-danger alert-dismissible fade show" role="alert">
      <strong>ERROR!</strong> Your note was not added!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
  }
  ?>
  <!-- PHP Ends -->
  <script>
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function() {
        $(this).remove();
      });
    }, 2000);
  </script>

  <footer class="site-footer">
    <div class="container my">
      <div class="row">
        <div class="col-lg-8 col-lg-6 col-lg-12 container-4">
          <b>
            <p class="copyright-text my-3">Copyright &copy; 2021 Anuj Panchal</p>
          </b>
        </div>
      </div>
    </div>
  </footer>
</body>

</html>