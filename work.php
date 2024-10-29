<?php
define('TITLE', 'Work Order');
define('PAGE', 'work');
include('includes/header.php'); 
include('../dbConnection.php');
session_start();
 if(isset($_SESSION['is_adminlogin'])){
  $aEmail = $_SESSION['aEmail'];
 } else {
  echo "<script> location.href='login.php'; </script>";
 }
?>
<div class="col-sm-9 col-md-10 mt-5">
  <?php 
 $sql = "SELECT * FROM assignwork_tb";
 $result = $conn->query($sql);
 if($result->num_rows > 0){
  echo '<table class="table">
  <thead>
    <tr>
      <th scope="col">Req ID</th>
      <th scope="col">Request Info</th>
      <th scope="col">Name</th>
      <th scope="col">Address</th>
      <th scope="col">City</th>
      <th scope="col">Mobile</th>
      <th scope="col">Technician</th>
      <th scope="col">Assigned Date</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>';
  while($row = $result->fetch_assoc()){
    echo '<tr>
    <th scope="row">'.$row["request_id"].'</th>
    <td>'.$row["request_info"].'</td>
    <td>'.$row["requester_name"].'</td>
    <td>'.$row["requester_add"].'</td>
    <td>'.$row["requester_city"].'</td>
    <td>'.$row["requester_mobile"].'</td>
    <td>'.$row["assign_tech"].'</td>
    <td>'.$row["assign_date"].'</td>
    <td><form action="viewassignwork.php" method="POST" class="d-inline"> <input type="hidden" name="id" value='. $row["request_id"] .'><button type="submit" class="btn btn-warning" name="view" value="View"><i class="far fa-eye"></i></button></form>
    <form action="" method="POST" class="d-inline"><input type="hidden" name="id" value='. $row["request_id"] .'><button type="submit" class="btn btn-secondary" name="delete" value="Delete"><i class="far fa-trash-alt"></i></button></form>
    </td>
    </tr>';
   }
   echo '</tbody> </table>';
  } else {
    echo "0 Result";
  }

  if (isset($_REQUEST['delete'])) {
    $requestId = $_REQUEST['id'];

    // Retrieve the values of request_id and requester_name from assignwork_tb
    $selectQuery = "SELECT request_id, requester_name FROM assignwork_tb WHERE request_id = '$requestId'";
    $result = $conn->query($selectQuery);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $requestId = $row['request_id'];
      $requesterName = $row['requester_name'];

      // Insert the values into the second table
      $insertQuery = "INSERT INTO confirm_tb (request_id,cust_name )
                      VALUES ('$requestId', '$requesterName')";
    
    $deleteQuery = "DELETE FROM assignwork_tb WHERE request_id = {$_REQUEST['id']}";
    if($conn->query($deleteQuery) === TRUE){
      
      echo '<meta http-equiv="refresh" content= "0;URL=?deleted" />';
      } else {
        echo "Unable to Delete Data";
      }
    }
  }
  ?>
</div>
</div>
</div>
<?php
include('includes/footer.php'); 
?>