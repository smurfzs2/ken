<?php require_once('connection.php'); ?>

<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/scroller/2.1.0/css/scroller.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <title>Exercise 8 - Quick Tables</title>

    <?php
    function getDepartment($con)
    {
        $query = "SELECT * FROM `hr_department` ORDER BY departmentName ASC";
        return $result = mysqli_query($con, $query);
    }

    // for dataTable
    $query = "SELECT * FROM `tbl_khenneth` INNER JOIN `hr_department` ON tbl_khenneth.departmentId=hr_department.departmentId";
    $queryData = $con->query($query);

    $arr_users = [];
    if ($result->num_rows > 0) {
        $arr_users = $result->fetch_all(MYSQLI_ASSOC);
    }


    //delete button
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $deleteQuery = "DELETE FROM tbl_khenneth WHERE id='$id'";
        $deleteQueryRun = mysqli_query($con, $deleteQuery);

        if ($deleteQueryRun) {
            echo "Deleted successfully";
            header("Location: index.php");
        } else {
            echo "Failed to delete";
            header("Location: index.php");
        }
    }

    if (isset($_POST['search'])) {
        //    $departmentName = $_POST['departmentName'];
        $sqlFilter = [];



        if ($_POST['firstName'] != '') {
            $sqlFilter[] = "firstname = '" . $_POST['firstName'] . "'";
        }

        if ($_POST['lastName'] != '') {
            $sqlFilter[] = "lastname = '" . $_POST['lastName'] . "'";
        }

        if ($_POST['addressData'] != '') {
            $sqlFilter[] = "addressData LIKE '" . $_POST['addressData'] . "'";
        }

        if ($_POST['birthDate'] != '') {
            $sqlFilter[] = "birthDate = '" . $_POST['birthDate'] . "'";
        }

        if ($_POST['gender'] != '') {
            $sqlFilter[] = "gender = '" . $_POST['gender'] . "'";
        }

        if ($_POST['departmentName'] != '') {
            $sqlFilter[] = "tbl_khenneth.departmentId = " . $_POST['departmentName'];
        }

        if (count($sqlFilter) > 0) {
            $sqlFilter = implode(' AND ', $sqlFilter);
            $sqlFilter = "WHERE " . $sqlFilter;
        } else {
            $sqlFilter = '';
        }
    }
    // $query = "SELECT * FROM `tbl_khenneth` INNER JOIN `hr_department` ON tbl_khenneth.id=hr_department.departmentId WHERE departmentName LIKE '%$departmentName%'";
    // $result = $con->query($query);    

    $query = "SELECT * FROM tbl_khenneth INNER JOIN hr_department ON tbl_khenneth.departmentId=hr_department.departmentId $sqlFilter";
    $result = $con->query($query);

    $department = [];

    while ($row = $result->fetch_assoc()) {
        $department[$row['departmentId']] = $row['departmentName'];
    }
    $newDepartment = array_unique($department);

    // echo "<pre>
    // ".print_r($newDepartment)."
    // </pre>";

    ?>
</head>

<body>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="" id="formSubmit">
        <div class="mt-2 mb-2 ">
            <div class="card-body rounded p-3 mx-3 " style="background-color: #374A67;">

                <select name="firstName" id="" class="px-3 py-1 rounded" style="width: 140px;" form="formSubmit">
                    <option value="<?php if(isset($_POST['firstName'])){echo $_POST['firstName'];} ?>"><?php echo isset($_POST['firstName']) ? $_POST['firstName'] : '' ?></option>
                    <?php
                        if ($res = $queryData->num_rows > 0) {
                            foreach ($queryData as $row) 
                            {
                                ?>
                                    <option value="<?php echo $row["firstName"]; ?>"><?php echo $row["firstName"]; ?></option>
                                <?php
                            }
                        }
                    ?>
                </select>

                <select name="lastName" id="" class="px-3 py-1 rounded" style="width: 140px;" form="formSubmit">

                    <option value="<?php if(isset($_POST['lastName'])){echo $_POST['lastName'];} ?>"><?php echo isset($_POST['lastName']) ? $_POST['lastName'] : '' ?></option>
                    <?php
                        if ($res = $queryData->num_rows > 0) 
                        {
                            foreach ($queryData as $row) 
                            {
                                ?>
                                    <option value="<?php echo $row["lastName"]; ?>"><?php echo $row["lastName"]; ?></option>
                                <?php
                            }
                        }
                    ?>
                </select>

                <select name="addressData" id="" class="px-3 py-1 rounded" style="width: 140px;" form="formSubmit">
                    <option value="<?php if(isset($_POST['addressData'])){echo $_POST['addressData'];} ?>"><?php echo isset($_POST['addressData']) ? $_POST['addressData'] : '' ?></option>
                    <?php
                    if ($res = $queryData->num_rows > 0) {
                        foreach ($queryData as $row) 
                        {
                            ?>
                                <option value="<?php echo $row["addressData"]; ?>"><?php echo $row["addressData"]; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>

                <select name="birthDate" id="" class="px-3 py-1 rounded" style="width: 140px;" form="formSubmit">
                    <option value="<?php if(isset($_POST['birthDate'])){echo $_POST['birthDate'];} ?>"><?php echo isset($_POST['birthDate']) ? $_POST['birthDate'] : '' ?></option>
                    <?php
                        if ($res = $queryData->num_rows > 0) 
                        {
                            foreach ($queryData as $row) 
                            {
                                ?>
                                    <option value="<?php echo date("F d, Y", strtotime($row['birthDate'])); ?>"><?php echo date("F d, Y", strtotime($row['birthDate'])); ?></option>
                                <?php
                            }
                        }
                    ?>
                </select>

                <select class="p-1 px-3 rounded" name="gender" style="width: 140px;" form="formSubmit">
                    <option value="" disabled selected hidden>
                        <?php
                        if (isset($_POST['gender'])) 
                        {
                            echo $_POST['gender'] == 0 ? 'Male' : 'Female';
                        } 
                        else 
                        {
                            echo "Gender";
                        }
                        ?>
                    </option>

                    <option value="0">Male</option>
                    <option value="1">Female</option>
                </select>

                <select name="departmentName" id="" class="p-1 rounded" style="width: 140px;" form="formSubmit">
                    <option value="<?php echo $newDepartment[$_POST['departmentName']]; ?>" disabled selected hidden>

                    </option>
                    <?php
                        foreach ($newDepartment as $key => $value) 
                        {
                            $selected = "";
                            if ($_POST['departmentName'] == $key) $selected = "selected";

                            echo "<option value='" . $key . "' $selected>" . $value . "</option>";
                        }
                    ?>

                </select>

                <button type="submit" name="search" class="btn btn-dark px-3 py-1"><i class="fa fa-search"></i> Search</button>
                <a href="khenneth_add.php" class="btn px-3 py-1 classBtn" style="float: right;"><i class="fa fa-plus"></i> Add New</a>
            </div>
        </div>
    </form>



    <table id="tblUser" class="table-bordered table table-condensed table-striped">

        <thead class="text-center">
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Birthday</th>
            <th>Address</th>
            <th>Gender</th>
            <th>Department Name</th>
            <th>Actions</th>
        </thead>

        <tbody style="text-align: center">

        </tbody>
    </table>
</body>


<style>
    .classBtn:hover {
        background-color: #fff;
        color: #374A67;
    }

    .classBtn {
        background-color: #374A67;
        color: #fff;
    }
    .box{
        background-color: #374A67;
    }
   
</style>
<!-- links to charts -->
<div class="mx-3 mt-3 px-5 py-1 rounded box" >
    <span class="text-white">Download:</span>
    <a href="khenneth_csv.php" class="btn m-1 border classBtn">CSV</a>
    <a href="khenneth_pdf.php" class="btn m-1 border classBtn">PDF</a>

    <div style="float:right;">

        <span class="text-white">Charts:</span>
        <a href="khenneth_clusteredChart.php" class="btn border m-1 classBtn">Clustered </a>
        <a href="khenneth_barChart.php" class="btn border m-1 classBtn">Bar </a>
        <a href="khenneth_piechart.php" class="btn border m-1 classBtn">Pie </a>
    </div>

</div>


<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/scroller/2.1.0/js/dataTables.scroller.min.js"></script>

<script>
    jQuery(document).ready(function($) {
        $('#tblUser').DataTable({
            // "bPaginate": false,
            "bLengthChange": false,
            "searching": true,
            "paging": false,
            "info": false,
            "sDom": "lrti",

            "ajax": {
                url: "indexAjax.php", // json datasource
                type: "POST", // method  , by default get
                data: {
                    "query": "<?php echo $query; ?>",
                },
                error: function(data) { // error handling
                    console.log(data);
                    // $(".table-error").html("");
                    // $("#tblUser").append('<tbody class="table-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    // $("#table_processing").css("display","none");

                }
            },

            paging: true,
            deferRender: true,
            scrollY: 350,
            scrollCollapse: true,
            scroller: true,
            buttons: ['createState', 'savedStates']
        });

        {}
    });
</script>