<?php

include('database_connection.php');

$column = array('firstName', 'lastName', 'birthdate', 'City', 'PostalCode', 'Country');

$query = "
SELECT * FROM tbl_customer 
";

if(isset($_POST['filter_gender'], $_POST['filter_country']) && $_POST['filter_gender'] != '' && $_POST['filter_country'] != '')
{
 $query .= '
 WHERE Gender = "'.$_POST['filter_gender'].'" AND Country = "'.$_POST['filter_country'].'" 
 ';
}

if(isset($_POST['order']))
{
 $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
 $query .= 'ORDER BY CustomerID DESC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);

$statement->execute();

$number_filter_row = $statement->rowCount();

$statement = $connect->prepare($query . $query1);

$statement->execute();

$result = $statement->fetchAll();



$data = array();

foreach($result as $row)
{
 $sub_array = array();
 $sub_array[] = $row['CustomerName'];
 $sub_array[] = $row['Gender'];
 $sub_array[] = $row['Address'];
 $sub_array[] = $row['City'];
 $sub_array[] = $row['PostalCode'];
 $sub_array[] = $row['Country'];
 $data[] = $sub_array;
}

function count_all_data($connect)
{
 $query = "SELECT * FROM tbl_customer";
 $statement = $connect->prepare($query);
 $statement->execute();
 return $statement->rowCount();
}

$output = array(
 "draw"       =>  intval($_POST["draw"]),
 "recordsTotal"   =>  count_all_data($connect),
 "recordsFiltered"  =>  $number_filter_row,
 "data"       =>  $data
);

echo json_encode($output);

?>

<?php
         
        
         if(!empty($arr_users)) { ?>
             <?php 
              $i = 0;
                 foreach($arr_users as $user) { ?>
                 <tr>
                     <td><?php echo  ++$i; ?></td>
                     <td><?php echo $user['firstName']; ?></td>
                     <td><?php echo $user['lastName']; ?></td>
                     <td><?php echo date("F d, Y", strtotime($user['birthDate'])) ; ?></td>
                     <td><?php echo $user['addressData']; ?></td>
                     <td><?php echo $user['gender']== '0'? "Male":"Female"; ?></td>
                     <td value="<?= $user['departmentId'];?>"><?= $user['departmentName'];?></td>        
                     <td>
                         <a href="khenneth_update.php?id=<?php echo $user["id"];?>" class="btn"><i class="fa fa-pencil-square-o"></i></a>
                         <a href="index.php?id=<?php echo $user["id"];?>" class="btn"><i class="fa fa-trash"></i></a>
                         <!-- <button type="submit" name="deleteBtn" value="<?php echo $user["id"];?>" class="btn" id="myBtn">Delete</button> -->
                     </td>        
                 </tr>
             <?php } ?>
         <?php } ?>



         <script>
// jQuery(document).ready(function($) {

    
 
//     $('#tblUser').DataTable({
//         "serverSide"    : false,
//         "bLengthChange": false,
//         // "searching": true,
//         "paging": false,
//         "info": false,
//         "sDom": "lrti",

//         searching: true,
//         paging: true,
//         deferRender:    true,
//         scrollY:        360,
//         scrollCollapse: true,
//         scroller:       true,
//         stateSave: true,
//         buttons:['createState', 'savedStates'],

//         initComplete: function () {
//                 // Apply the search
//                 this.api()
//                     .columns()
//                     .every(function () {
//                         var that = this;
     
//                         $('input', this.footer()).on('keyup change clear', function () {
//                             if (that.search() !== this.value) {
//                                 that.search(this.value).draw();
//                             }
//                         });
//                     });
//        },
//     });
  
// });
   

</script>