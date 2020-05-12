<?php
//action2.php
include 'functions.php';
if (!isLoggedIn()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: login.php');
}
$tulajdonos=$_SESSION['user']['username'];
if(isset($_POST["action"]))
{
  $connect = mysqli_connect("mysql.omega:3306", "szorgalmi", "Projektlabor2020", "szorgalmi");
 if($_POST["action"] == "fetch")
 {
  $query = "SELECT tulajdonos,name FROM tbl_images WHERE tulajdonos='$tulajdonos' ";
  $result = mysqli_query($connect, $query);
  $output = '
   <table class="table table-bordered table-striped">  
    <tr>
     <th width="10%">Feltöltötte:</th>
     <th width="70%">Feladatlap</th>
     
    </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '

    <tr>
     <td>'.$row["tulajdonos"].'</td>
     <td>
      <img src="data:image/jpeg;base64,'.base64_encode($row['name'] ).'
      " height="150" width="150" class="img-thumbnail" />
     </td>
     
    </tr>
   ';
  }
  $output .= '</table>';
  echo $output;
 }

 if($_POST["action"] == "insert")
 {
  $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
  $query = "INSERT INTO tbl_images(name,tulajdonos) VALUES ('$file','$tulajdonos')";
  if(mysqli_query($connect, $query))
  {
   echo 'A kép feltöltve az adatbzisba';
  }
 }

 if($_POST["action"] == "delete")
 {
  $query = "DELETE FROM tbl_images WHERE id = '".$_POST["image_id"]."'";
  if(mysqli_query($connect, $query))
  {
   echo 'A kép törölve!';
  }
 }
}
?>
