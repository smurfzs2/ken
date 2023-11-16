<?php
include 'connection.php';
include $_SERVER['DOCUMENT_ROOT']."/version.php";
$path = $_SERVER['DOCUMENT_ROOT']."/".v."/Common Data/";
set_include_path($path);    
include('Templates/mysqliConnection.php');
ini_set("display_errors", "on");


    $query = "SELECT * FROM `tbl_khenneth` INNER JOIN `hr_department` ON tbl_khenneth.id=hr_department.departmentId ";
    $queryRes = $con->query($query);

if(isset($_POST['filterBtn']))
{
    $firstName = $_POST['firstName'];
    $LastName = $_POST['LastName'];
    $addressData = $_POST['addressData'];
    $birthDate = $_POST['birthDate'];
    $gender = $_POST['gender'];
    $departmentName = $_POST['departmentName'];


}
// WHERE firstName LIKE '%$firstName%' and lastName LIKE '%$lastName%' and addressData LIKE '%$addressData%' and birthDate LIKE '%$birthDate%' and gender LIKE '%$gender%' and departmentName LIKE '%$departmentName%'
?>

<form action="" method="POST">
    <label for="">First Name:</label>
    <select name="firstName" id="" class="form-control" style="margin-bottom: 7px;">
        <option value="" > 
            <?php
                if($res= $queryRes->num_rows > 0)
                {
                    foreach($queryRes as $row)
                    {
                        ?>
                            <option value="<?php echo $row["firstName"]; ?>"><?php echo $row["firstName"]; ?></option>
                        <?php
                    }
                }
            ?>
        </option>
    </select>

    <label class="mt-5">Last Name:</label>
    <select name="lastName" id="" class="form-control" style="margin-bottom: 7px;">
        <option value=""> 
            <?php
                if($res= $queryRes->num_rows > 0)
                {
                    foreach($queryRes as $row)
                    {
                        ?>
                            <option value="<?php echo $row["lastName"]; ?>"><?php echo $row["lastName"]; ?></option>
                        <?php
                    }
                }
            ?>
        </option>
    </select>

    <label class="mt-5">Address:</label>
    <select name="addressData" id="" class="form-control" style="margin-bottom: 7px;">
        <option value=""> 
            <?php
                if($res= $queryRes->num_rows > 0)
                {
                    foreach($queryRes as $row)
                    {
                        ?>
                            <option value="<?php echo $row["addressData"]; ?>"><?php echo $row["addressData"]; ?></option>
                        <?php
                    }
                }
            ?>
        </option>
    </select>

    <label class="mt-5">Birthday:</label>
    <select name="birthDate" id="" class="form-control" style="margin-bottom: 7px;">
        <option value=""> 
            <?php
                if($res= $queryRes->num_rows > 0)
                {
                    foreach($queryRes as $row)
                    {
                        ?>
                            <option value="<?php echo date("F d, Y", strtotime($row['birthDate'])); ?>"><?php echo date("F d, Y", strtotime($row['birthDate'])); ?></option>
                        <?php
                    }
                }
            ?>
        </option>
    </select>

    <label class="mt-5">Gender:</label>
    <select name="gender" id="" class="form-control" style="margin-bottom: 7px;">
        <option value=""> 
            <?php
                if(isset($_POST['gender']))
                {
                    echo $_POST['gender'] ? 'Male' : 'Female';
                }
                else
                {
                    echo " ";
                }
            ?>
        </option>

        <option value="0">Male</option>
        <option value="1">Female</option>
    </select>

    <label class="mt-5">Department:</label>
    <select name="departmentName" id="" class="form-control" style="margin-bottom: 7px;">
        <option value=""> 
            <?php
                if($res= $queryRes->num_rows > 0)
                {
                    foreach($queryRes as $row)
                    {
                        ?>
                            <option value="<?php echo $row["departmentName"]; ?>"><?php echo $row["departmentName"]; ?></option>
                        <?php
                    }
                }
            ?>
        </option>
    </select>

    <button type="submit" name="filterBtn" style="width: 100%; background-color: #374A67; color: #fff; border:none; height: 40px; border-radius: 5px;">Filter</button>
</form>