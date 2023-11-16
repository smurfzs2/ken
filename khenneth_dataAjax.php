<?php include 'connection.php'; ?>
<?php
include $_SERVER['DOCUMENT_ROOT']."/version.php";
$path = $_SERVER['DOCUMENT_ROOT']."/".v."/Common Data/";
set_include_path($path);    
// include('Templates/mysqliConnection.php');
// include('PHP Modules/anthony_wholeNumber.php');
// include('PHP Modules/anthony_retrieveText.php');
// include('PHP Modules/gerald_functions.php');
// include('PHP Modules/rose_prodfunctions.php');
ini_set("display_errors", "on");

// $id= $_GET['employeeId'];

$requestData= $_REQUEST;
$sqlData = isset($requestData['sqlData']) ? $requestData['sqlData'] : "";
//$exportExcelData = isset($requestData['exportExcelData']) ? $requestData['exportExcelData'] : "";
$totalRecords = (isset($requestData['totalRecords'])) ? $requestData['totalRecords'] : 0;
$totalFiltered = $totalRecords;
$totalData = $totalFiltered;

$data = array();

$sql= $sqlData;
$sql.=" LIMIT ".$requestData['start']." ,".$requestData['length']."  ";
$counter = $requestData['start'];
$queryData = $con->query($sql) or die ($con->error);
// $row = $employee->fetch_assoc();
$num=0;
    
if($queryData AND $queryData->num_rows > 0)
{
    while($resultData1 = $queryData->fetch_assoc())
    {  
        
       $firstName = $resultData1['firstName'];
       $lastName = $resultData1['lastName'];
       $birthDate = date("F d, Y", strtotime($resultData1['birthDate']));
	   // ------------------------ The Problem Is Found Here --------------------
       $address = $resultData1['addressData'];
       $gender = $resultData1['gender'] == 0 ? "Male":"Female";
       $departmentId = $resultData1['departmentName']; 
       
        //$button ="<button class='btn btn-primary ' name='edit' onclick=\"modalEditForm(".$row['employeeId'].")\">Edit</button> <button class='btn btn-danger' name='delete' onclick=\"modalDeleteForm(".$row['employeeId'].")\">Delete</button>";
     
        $nestedData = Array();

        $nestedData[] = $num+=1; 
        $nestedData[] = $firstName; 
        $nestedData[] = $lastName; 
        $nestedData[] = $birthDate; 
        $nestedData[] = $address; 
        $nestedData[] = $gender; 
        $nestedData[] = $departmentId; 
        // $nestedData[] = ''; 

        $data[] = $nestedData;
    }
}
   
    

$json_data = array(
    "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
    "recordsTotal"    => intval( $totalData ),  // total number of records
    "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format

?>
