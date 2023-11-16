<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Add New</title>
</head>
<body>

<?php
    if(isset($_POST['submitBtn']))
    {
        $firstName = mysqli_real_escape_string($con, $_POST['firstName']);
        $lastName = mysqli_real_escape_string($con, $_POST['lastName']);
        $birthDate = mysqli_real_escape_string($con, $_POST['birthDate']);
        $addressData = mysqli_real_escape_string($con, $_POST['addressData']);
        $gender = mysqli_real_escape_string($con, $_POST['gender']);
        $departmentName = mysqli_real_escape_string($con, $_POST['departmentName']);
    
        $query = "INSERT INTO tbl_khenneth (firstName, lastName, birthDate, addressData, gender, departmentId) 
        VALUES ('$firstName', '$lastName', '$birthDate', '$addressData', '$gender', '$departmentName')";
        $query_res =$con->query($query);
    
        if($query_res)
        {
            header("Location: index.php");
        }else {
            header("Location:  index.php");
        }
    }
?>

    <form action="#" method="POST" enctype="multipart/form-data">
        <div class="container  mt-1">
            <div class="card p-5 border-0 align-items-center m-0">
                <div class=" card-body border rounded p-3 w-50 ">
                    <h3 class="text-center mb-4">Add Info</h3>
                        <div class="mb-2">
                            <div class="mb-1">
                                <label>First Name</label>
                            </div>
                        <input type="text" class="form-control" name="firstName" required>
                    </div>

                    <div class="mb-2">
                        <div class="mb-1">
                            <label>Last Name</label>
                        </div>
                        <input type="text" class="form-control" name="lastName" required>
                    </div>

                    <div class="mb-2">
                        <div class="mb-1">
                            <label>Birth Date</label>
                        </div>
                        <input type="date" class="form-control" name="birthDate" required>
                    </div>

                    <div class="mb-2">
                        <div class="mb-1">
                            <label>Address</label>
                        </div>
                        <textarea name="addressData" id="" cols="30" rows="2" class="form-control" required></textarea>
                    </div>
                    <div class="mb-2">
                        <div>
                            <label>Department</label>
                        </div>
                        <select name="departmentName" id="" class=" form-control" required>
                            <option value=""></option>
                            <option value="1">Accounting</option>
                            <option value="2">Engineering</option>
                            <option value="3">HR</option>
                            <option value="4">IT</option>
                            <option value="5">Purchasing</option>
                            <option value="6">Production</option>
                            <option value="7">IMPEX</option>
                            <option value="8">PPIC</option>
                            <option value="9">Sales</option>
                            <option value="10">RPD</option>
                            <option value="11">Logistics</option>
                            <option value="12">FVI</option>
                            <option value="13">QC</option>
                            <option value="14">Utility</option>
                            <option value="15">Security</option>
                            <option value="16">QA</option>
                            <option value="17">Top Management</option>
                            <option value="18">DCC</option>
                        </select>
                    </div>

                    <div class="mt-1 p-1">
                        <span>Gender</span>
                        <div class="px-2 mr-3">
                            <input type="radio" name="gender" class="" value="0"  id="male" required>
                            <label for="male">Male</label>

                            <div>
                                <input type="radio" name="gender"  value="1" id="female" required>
                                <label for="female">Female</label>
                            </div>
                            
                        </div>
                        
                       
                        
                    </div>

                    <div class="mt-3">
                        <input type="submit" name="submitBtn" class="btn btn-success w-100 mt-3 mb-4">
                        <!-- <button type="submit" name="submitBtn" class="btn btn-success w-100 mt-3 mb-4">Submit</button> -->
                    </div>
                </div>
 
            </div>
            
        </div>
        
    </form>
</body>
</html>