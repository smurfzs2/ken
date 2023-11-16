<!-- <?php
$connect = new PDO("mysql:host=localhost;dbname=ojtDatabase", "root", "arktechdb");
// include('connection.php');

$firstName = '';
$query = "SELECT DISTINCT firstName FROM tbl_khenneth ORDER BY firstName ASC";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{
 $firstName .= '<option value="'.$row['firstName'].'">'.$row['firstName'].'</option>';
}

?>

<html>
 <head>
  <title>Custom Search in jQuery Datatables using PHP Ajax</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  
 </head>
 <body>
  <div class="container box">
   <h3 align="center">Custom Search in jQuery Datatables using PHP Ajax</h3>
   <br />
   <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
     <div class="form-group">
      <select name="filter_gender" id="filter_gender" class="form-control" required>
       <option value="">Select Gender</option>
       <option value="Male">Male</option>
       <option value="Female">Female</option>
      </select>
     </div>
     <div class="form-group">
      <select name="filter_country" id="filter_country" class="form-control" required>
       <option value="">Select Name</option>
       <?php echo $firstName; ?>
      </select>
     </div>
     <div class="form-group" align="center">
      <button type="button" name="filter" id="filter" class="btn btn-info">Filter</button>
     </div>
    </div>
    <div class="col-md-4"></div>
   </div>
   <div class="table-responsive">
    <table id="customer_data" class="table table-bordered table-striped">
     <thead>
      <tr>
       <th width="20%">First Name</th>
       <th width="20%">Second Name</th>
       <th width="15%">Birth Date</th>
       <th width="25%">Address</th>
       <th width="10%">Gender</th>
       <th width="15%">Department Id</th>
      </tr>
     </thead>
    </table>
    <br />
    <br />
    <br />
   </div>
  </div>
 </body>
</html>

<script type="text/javascript" language="javascript" >
 $(document).ready(function(){
  
  fill_datatable();
  
  function fill_datatable(filter_gender = '', filter_country = '')
  {
   var dataTable = $('#customer_data').DataTable({
    "processing" : true,
    "serverSide" : true,
    "order" : [],
    "searching" : false,
    "ajax" : {
     url:"fetch.php",
     type:"POST",
     data:{
      filter_gender:filter_gender, filter_country:filter_country
     }
    }
   });
  }
  
  $('#filter').click(function(){
   var filter_gender = $('#filter_gender').val();
   var filter_country = $('#filter_country').val();
   if(filter_gender != '' && filter_country != '')
   {
    $('#customer_data').DataTable().destroy();
    fill_datatable(filter_gender, filter_country);
   }
   else
   {
    alert('Select Both filter option');
    $('#customer_data').DataTable().destroy();
    fill_datatable();
   }
  });
  
  
 });
 
</script> -->

<?php include 'connection.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/scroller/2.1.0/css/scroller.dataTables.min.css">
    <title>Exercise 8 Quick Table</title>
</head>

<body>

    <div class="container">
    <?php
            // $query = "SELECT * FROM tbl_khenneth INNER JOIN `hr_department` ON tbl_khenneth.departmentId=hr_department.departmentId WHERE departmentName LIKE '%$hr_keyword%' and firstName LIKE '%$fname_keyword%' and lastName LIKE '%$lname_keyword%' and address LIKE '%$address_keyword%' and birthDate LIKE '%$bdate_keyword%' and gender LIKE '%$gender_keyword%' ORDER BY departmentName ASC";
            // $queryRes = $con->query($query);

            $query = "SELECT * FROM `tbl_khenneth` INNER JOIN `hr_department` ON tbl_khenneth.id=hr_department.departmentId WHERE departmentName LIKE '%$hr_keyword%'";
            $queryRes = $con->query($query);
        
                if($res= $queryRes->num_rows > 0)
                {
                    ?>
                        <table id="example" class="table table-hover table-striped table-bordered text-center mb-5">
                            <thead class="bg-dark text-white">
                                <tr>
                                <th scope="col">ID</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Birth Date</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Department</th>
                                <!-- <th scope="col">Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                    <?php

                    $i = 0;
                    while($row = $queryRes->fetch_assoc())
                    {
                        ?>
                            <tr>
                                <th scope="row"><?php echo ++$i; ?></th>
                                <td><?php echo $row["firstName"];?></td>
                                <td><?php echo $row["lastName"];?></td>
                                <td><?php echo $row["address"];?></td>
                                <td><?php echo $row["birthDate"];?></td>
                                <td><?php echo $row["gender"] == 0 ? "Male" : "Female";  ?></td>
                                <td value="<?php echo $row['departmentId'];?>"><?php echo $row['departmentName'];?>
                                <!-- <td> -->
                                         <!-- <a href="khenneth_update.php?id=<?php echo $row["id"];?>" class="btn btn-muted"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <a href="index.php?id=<?php echo $row["id"];?>" class="btn btn-mute"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                                        <!-- <button type="submit" name="deleteBtn" value="<?php echo $row["id"];?>" class="btn btn-danger">Delete</button> -->
                                <!-- </td> -->
                            </tr>
                        <?php 
                    }
                }   
                else
                {            
                    echo '<span class="col-6 text-center">No data found.</span>';
                }

                    ?>
                        </tbody>
                        </table> 
                    <?php
        ?>
    </div>
    </div>


 
 
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/scroller/2.1.0/js/dataTables.scroller.min.js"></script> -->

</body>
</html>