<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="style/style.css">

    <title>Exercise 8 - Quick Tables</title>
    
    
    
    <?php
    require_once('connection.php');
    

    //datatable
    $query = "SELECT * FROM `tbl_khenneth` INNER JOIN `hr_department` ON tbl_khenneth.departmentId=hr_department.departmentId";
    $result = $con->query($query);
    $arr_users = [];
    if ($result->num_rows > 0) {
        $arr_users = $result->fetch_all(MYSQLI_ASSOC);
    }

    // filter
    if(isset($_POST['search']))
        {
           
            $firstName = $_POST['firstName'];  
            $lastName = $_POST['lastName'];  
            $birthday = $_POST['birthday'];     
            $address = $_POST['address'];
            $gender = $_POST['gender'];
            $department = $_POST['department'];     


            $query = "SELECT * FROM `tbl_khenneth` INNER JOIN `hr_department` ON tbl_khenneth.departmentId=hr_department.departmentId WHERE ";

           
            if($firstName !="")
            {
                 $query .= " firstName LIKE '$firstName' AND ";
            }

            if($lastName !="")
            {
                $query .=  " lastName LIKE '$lastName' AND ";
            }

            if($birthday !="")
            {
                $query .= " birthday LIKE '$birthday' AND ";
            }

           if($address !="")
           {
                $query .= " address LIKE '$address' AND ";
           }

           if($gender !="")
           {
                $query .= " gender LIKE '$gender' AND ";
           }

           if($department !="")
           {
                $query .= " departmentName LIKE '$department' AND ";
           }

            $query = substr($query, 0, -4);

            
          
            $search_result = filterTable($query);
            
        }
        else 
        {
            $query = "SELECT * FROM `tbl_khenneth` INNER JOIN `hr_department` ON tbl_khenneth.departmentId=hr_department.departmentId";;
            $search_result = filterTable($query);

        }

        function getData($con)
        {
            $query = "SELECT * FROM `tbl_khenneth` INNER JOIN `hr_department` ON tbl_khenneth.departmentId=hr_department.departmentId";
            return $result = mysqli_query($con, $query);
        }

        function getDepartment($con)
        {
            $query = "SELECT * FROM `hr_department` ORDER BY departmentName ASC" ;
            return $result = mysqli_query($con, $query);
        }

        if(isset($_GET['id']))
        {
        $id = $_GET['id'];
        $deleteQuery = "DELETE FROM tbl_jeramay WHERE id='$id'";
        $deleteQueryRun = mysqli_query($db, $deleteQuery);

        if($deleteQueryRun)
        {
            echo "Deleted successfully";
            header("Location: jera_quickTable.php");
        }else
        {
            echo "Failed to delete";
            header("Location: jera_quickTable.php");
        }
        }
    
        // function to connect and execute the query
        function filterTable($query)
        {
            $connect = mysqli_connect("localhost", "root", "arktechdb", "ojtDatabase");
            $filter_Result = mysqli_query($connect, $query);
            return $filter_Result;
        }
    ?>


</head>
<body>

    <!-- add, pdf, csv -->  
    <div style="float: right">
        <h5><a href="jera_generateCSV.php" target="_blank" rel="noopener noreferrer" class="csv" ><i class="btn btn-info fas fa-file"></i> CSV</a></h5>
        </div>
        <div style="float: right">
            <h5><a href="jera_generatePDF.php" target="_blank" rel="noopener noreferrer" class="pdf" ><i class="btn btn-info fas fa-print"></i> PDF</a></h5>
        </div>
        <div style="float: right">
            <h5><a href="jera_inputForm.php" class="add" ><i class="fas fa-add"></i> Add</a></h5>  
        </div>
    </div>

    <!-- filter -->
    <div>
    <form action="jera_quickTable.php" method="POST" id="formSubmit"></form>
        <ul class="nav">
            <li>
                <input type="search" class="form-control rounded" placeholder="First Name" name="firstName" value="<?php if(isset($_POST['firstName'])){echo $_POST['firstName'];} ?>" form="formSubmit"/>
                                
            </li>
            <li>
                <input type="search" class="form-control rounded" placeholder="Last Name" name="lastName" value="<?php if(isset($_POST['lastName'])){echo $_POST['lastName'];} ?>"  form="formSubmit"/>
                
            </li>
            <li>
                <input type="search" class="form-control rounded" placeholder="Address" name="address"  value="<?php if(isset($_POST['address'])){echo $_POST['address'];} ?>" form="formSubmit"/>
                
            </li>
            <li>
                <input type="date" class="form-control rounded" placeholder="Birthday" name="birthday"  value="<?php if(isset($_POST['birthday'])){echo $_POST['birthday'];} ?>" form="formSubmit"/>
                
            </li>
            <li>
                <select class="form-control rounded" style=" width:100%;" name="gender" form="formSubmit">
                    <option value="" disabled selected hidden>
                        <?php 
                            if(isset($_POST['gender']))
                            {
                                echo $_POST['gender'] ? 'Female': 'Male';
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
            </li>
            <li>
                <select class="form-control rounded" style=" width:100%;" name="department" form="formSubmit">                            
                    <option value="" disabled selected hidden>
                    <?php 
                        if(isset($_POST['department']))
                        {
                            echo $_POST['department'] ;
                        } 
                        else
                        {
                            echo "Department";
                        }
                    ?>
                    </option>
                    <?php
                        $department = getDepartment($db);
                        
                        if(mysqli_num_rows($department)> 0)
                        {
                            foreach($department as $item)
                            {
                                ?>
                                <option> <?= $item['departmentName'];?></option>
                                <?php
                            }
                        }
                    ?>
                </select>    
            </li>
            <li>
                <button type="submit"  class="btn btn-outline-primary" name="search" form="formSubmit">Go!</button>
            </li>
        </ul>  
    </div>

    <!-- table -->
    <table id="tblUser" style="text-align: left">
        <thead >
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Birthday</th>
            <th>Address</th>
            <th>Gender</th>
            <th>Department</th>
            <th>Actions</th>
        </thead>
    </table>


    <!-- graph -->
    <div style="margin-top: 3%;">
       View in graph: 
            <a href="jera_barGraph.php" target="_blank" rel="noopener noreferrer" class="csv"  >Bar</a>
            <a href="jera_pieChart.php" target="_blank" rel="noopener noreferrer" class="csv" >Pie</a>
            <a href="jera_clusteredChart.php" target="_blank" rel="noopener noreferrer" class="csv" >Clustered</a>
    </div>
        
    

</body> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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
                url     :"dataSource.php", // json datasource
                type    : "POST",  // method  , by default get
                data    : {"query"   	    : "<?php echo $query;?>",},
                error: function(data){  // error handling
                    console.log(data);
                    // $(".table-error").html("");
                    // $("#tblUser").append('<tbody class="table-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    // $("#table_processing").css("display","none");
                    
                }  
            },

        paging: true,
        deferRender:    true,
        scrollY:        350,
        scrollCollapse: true,
        scroller:       true,
        buttons:['createState', 'savedStates']
    });

    {}
} );
</script>