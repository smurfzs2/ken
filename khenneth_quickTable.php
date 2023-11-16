<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/scroller/2.1.0/css/scroller.dataTables.min.css">
    <title>Exercise 8 - Quick Tables</title>
    <?php
    require_once('connection.php');
    
    $query = "SELECT * FROM `tbl_khenneth` INNER JOIN `hr_department` ON tbl_khenneth.departmentId=hr_department.departmentId";
    $result = $con->query($query);
    $arr_users = [];
    if ($result->num_rows > 0) {
        $arr_users = $result->fetch_all(MYSQLI_ASSOC);
    }
    ?>


</head>

<table id="tblUser" class="display nowrap" style="width:100%" style="text-align: center">
    <thead >
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Birthday</th>
        <th>Address</th>
        <th>Gender</th>
        <th>departmentId</th>
    </thead>
    <tbody style="text-align: center">
        <?php if(!empty($arr_users)) { ?>
            <?php foreach($arr_users as $user) { ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['firstName']; ?></td>
                    <td><?php echo $user['lastName']; ?></td>
                    <td><?php echo date("F d, Y", strtotime($user['birthDate'])) ; ?></td>
                    <td><?php echo $user['addressData']; ?></td>
                    <td><?php echo $user['gender']== '0'? "Male":"Female"; ?></td>
                    <td value="<?= $user['departmentId'];?>"><?= $user['departmentName'];?></td>        
                </tr>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/scroller/2.1.0/js/dataTables.scroller.min.js"></script>

<script>
jQuery(document).ready(function($) {
    $('#tblUser').DataTable({
        "bLengthChange": false,
        "searching": false,
        "paging": false,
        "info": false,
        "sDom": "lfrti",

        paging: true,
        deferRender:    true,
        scrollY:        360,
        scrollCollapse: true,
        scroller:       true,
        stateSave: true,
        
        buttons:['createState', 'savedStates']
    });

} );
</script>

 
    