<?php
// INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'demo2', 'bnvbnbnvhnvhmhmhmhm', current_timestamp());
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

$insert = false;
$update = false;
$delete = false;

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Sorry connection is not established: " . mysqli_connect_error());
}
if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `notes` WHERE `sno` = $sno ";
    $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //var_dump($_POST);
    if (isset($_POST['snoEdit'])) {
        // Update record
        $sno = $_POST["snoEdit"];
        $title = $_POST['titleEdit'];
        $description = $_POST['descriptionEdit'];

        $result = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = $sno";

        $result = mysqli_query($conn, $result);
        if ($result) {
            $update = true;
        } else {
            // Handle update error
        }
    } else {
        $title = $_POST['title'];
        $description = $_POST['description'];

        $sql = "INSERT INTO `notes` (`title`, `description`, `tstamp`) VALUES ('$title', '$description', current_timestamp())";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            $insert = true;
        } else {
            echo 'Data insert not successful because of this error ---> ' . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" class="css">

    <!-- DataTables JavaScript -->
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

   <style>
      body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        background-color: #f9f9f9;
      }

      /* Navbar style */
      .navbar {
        background-color: #333;
      }

      .navbar-brand {
        font-size: 24px;
        font-weight: bold;
        color: white;
        padding: 10px 20px;
      }

      .navbar-nav .nav-link {
        color: white;
        margin-right: 10px;
      }

      /* Add Note form style */
      .container.my-4 {
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 20px;
        background-color: white;
      }

      /* Table style */
      .container {
        background-color: white;
        padding: 20px;
      }

      .table {
        border: 1px solid #ccc;
        border-radius: 10px;
      }

      /* Modal style */
      .modal-content {
        background-color: white;
      }

      /* Success alert style */
      .alert.alert-success {
        background-color: #d4edda;
        color: #155724;
      }

      /* Button style */
      .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
      }

      /* Hover style for buttons */
      .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
      }
    </style>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>

    <title>CRUD Application!</title>

</head>

<body>

    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
        EditModal
    </button> -->

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModal">Edit Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/CRUD/index.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="mb-3">
                            <label for="title">Note Title</label>
                            <input type="text" class="form-control" name="titleEdit" id="titleEdit" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="desc">Note Description</label>
                            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Note</button>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">i.Notes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Contact Us</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Bootstrap ALERT -->
    <?php
    if ($insert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success</strong> Your notes have been inserted successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>

    <?php
    if ($update) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success</strong> Your notes have been updated successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>

    <?php
    if ($delete) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success</strong> Your notes have been deleted successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>

    <!-- Bootstrap FORM -->
    <div class="container my-4">
        <h2>Add a Note</h2>
        <form action="/CRUD/index.php" method="post">
            <div class="mb-3">
                <label for="title">Note Title</label>
                <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="desc">Note Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>

    <!-- Bootstrap TABLE -->
    <div class="container">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!--  Php -->
                <?php
                $sql = "SELECT * FROM `notes` ";
                $result = mysqli_query($conn, $sql);
                $sno = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $sno = $sno + 1;
                    echo "<tr>
                        <th scope='row'>" . $sno . "</th>
                        <td>" . $row['title'] . "</td>
                        <td>" . $row['description'] . "</td>
                        <td>
                            <button class='edit btn btn-sm btn-primary' id=" . $row['sno'] . ">Edit</button>
                            <button class='delete btn btn-sm btn-primary' id=d" . $row['sno'] . ">Delete</button>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <hr>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->

    <!-- Edit button functionality -->
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                description = tr.getElementsByTagName("td")[1].innerText;
                console.log(title, description);
                document.getElementById('titleEdit').value = title;
                document.getElementById('descriptionEdit').value = description;
                snoEdit.value = e.target.id;
                console.log(e.target.id);
                $('#editModal').modal('toggle');
            })
        })

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {  
            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                description = tr.getElementsByTagName("td")[1].innerText;
                console.log(title, description);
                sno = e.target.id.substr(1,);
                if (confirm("Are you sure you want to delete this note?")) {
                    console.log("yes");
                    window.location = `/CRUD/index.php?delete=${sno}`;
                } else {
                    console.log("no");
                }
            })
        })
    </script>

</body>

</html>
