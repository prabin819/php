<?php
  //connect to the db
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "dbnotes";

  $insert = false;
  $update = false;
  $delete = false;

  //create a connection
  $conn = mysqli_connect($servername,$username,$password,$database); //$database optional but you have to add dbname in every sql command

  //Die (program) if connection fails
  if(!$conn){
    die("Sorry we failed to connect: " . mysqli_connect_error());
  }
  // else{
  //   echo "Connection was successful";
  // }

  if(isset($_GET['delete'])){
    
      $sno = $_GET['delete'];
      $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
      $result = mysqli_query($conn, $sql);

      if($result){
        $delete = true;
      }else{
        echo "The record was not deleted successfully.";
      }
  }

  //echo $_SERVER['REQUEST_METHOD'];
  if($_SERVER['REQUEST_METHOD']== 'POST'){

    if (isset($_POST['snoedit'])){
      $title = $_POST['titleedit'];
      $description = $_POST['descedit'];
      $sno = $_POST['snoedit'];
  
      $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `sno` = '$sno';";
      $result = mysqli_query($conn, $sql);

      if($result){
        $update = true;
      }else{
        echo "The record was not updated successfully.";
      }
    }
    else{
    $title = $_POST['title'];
    $description = $_POST['desc'];

    $sql = "INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, '$title', '$description', current_timestamp());";
    $result = mysqli_query($conn, $sql);

    if($result){
      //echo "The record has been inserted successfully.";
      $insert = true;

    }else{
      echo "The record was not inserted successfully.";
    }
  }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>iNotes - notes taking made easy</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#myTable").DataTable();
        });
    </script>
  </head>
  <body>

  <!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
Edit Modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit note</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="/crud/index.php" method="post">
        <input type="hidden" name="snoedit" id="snoedit">
        <div class="mb-3">
          <label for="titleedit" class="form-label">Note Title</label>
          <input
            type="text"
            class="form-control"
            id="titleedit"
            aria-describedby="emailHelp"
            name="titleedit"
            placeholder="title"
          />
        </div>
        <div class="mb-3">
          <label for="descedit">Note Description</label>
            <textarea
              class="form-control"
              placeholder="note description"
              id="descedit"
              name="descedit"
            ></textarea>
          </div>
          <button type="submit" class="btn btn-primary mt-3">Update Note</button>
        
        </div>
        
      </form>
      </div>
    </div>
  </div>
</div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">iNotes</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
          </ul>
          <form class="d-flex" role="search">
            <input
              class="form-control me-2"
              type="search"
              placeholder="Search"
              aria-label="Search"
            />
            <button class="btn btn-outline-success" type="submit">
              Search
            </button>
          </form>
        </div>
      </div>
    </nav>

    <?php
    if($insert){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> Your note has been created successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
    }
    if($update){
      echo "<div class='alert alert-info alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> Your note has been updated successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
    }
    if($delete){
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> Your note has been deleted successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
    }
    
    ?>


    <div class="container my-4">
      <h2>Add a Note</h2>
      <form action="/crud/index.php" method="post">
        <div class="mb-3">
          <label for="title" class="form-label">Note Title</label>
          <input
            type="text"
            class="form-control"
            id="title"
            aria-describedby="emailHelp"
            name="title"
            placeholder="title"
          />
        </div>
        <div class="mb-3">
          <label for="desc">Note Description</label>
            <textarea
              class="form-control"
              placeholder="note description"
              id="desc"
              name="desc"
            ></textarea>
          </div>
          <button type="submit" class="btn btn-primary mt-3">Add Note</button>
        
        </div>
        
      </form>
    </div>
    <div class="container">
        
        <table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">S.no</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
          $sql = "SELECT * FROM `notes`";
          $result = mysqli_query($conn,$sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            echo "<tr>
                    <th scope='row'>".$sno."</th>
                    <td>".$row['title']."</td>
                    <td>".$row['description']."</td>
                    <td><button class='btn btn-sm btn-primary edit' id=".$row['sno'].">Edit</button> <button class='btn btn-sm btn-primary delete' id=d".$row['sno'].">Delete</button></td>
                  </tr>";
          }
        ?>
        
    
  </tbody>
</table>
    </div>
    <hr>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>
        element.addEventListener("click",(e)=>{
          //console.log("edit",e.target);
          tr=e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          //console.log(title,description);
          titleedit.value = title;
          descedit.value = description;
          snoedit.value = e.target.id;
          $('#editModal').modal('toggle');
          console.log(e.target.id);
    }))

    deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element)=>
        element.addEventListener("click",(e)=>{
          console.log("delete",e.target);
          
          console.log(e.target.id);

          sno = e.target.id.substr(1,);

          if(confirm("Do you really want to delete?")){
            console.log("yes");
            window.location = `/crud/index.php?delete=${sno}`;

            //TODO: create a form and use post request to submit the form
          }
          else{
            console.log("no");
            
          }
          
      
    }))
    </script>
  </body>
</html>
