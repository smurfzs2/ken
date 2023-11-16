
<?php  require_once('connection.php'); 

$requestData= $_REQUEST;
$sqlData = isset($requestData['query']) ? $requestData['query'] : "";

$data = array();
$num=0;

$sql= $sqlData;
$queryData = $con->query($sql) or die ($con->error);

    
if($queryData AND $queryData->num_rows > 0)
{
    while($resultData = $queryData->fetch_assoc())
    {
        $id = $resultData['id'];
        $firstName = $resultData['firstName'];
        $lastName = $resultData['lastName'];
        $birthDate = date("F d, Y", strtotime($resultData['birthDate']));
        $address = $resultData['addressData'];
        $gender = $resultData['gender'] == 0 ? "Male":"Female";
        $departmentId = $resultData['departmentName']; 

        $button="";
        $button.= "<a class='edit' href='khenneth_update.php?id=" . $resultData['id'] . "' name='update'><i class='fa fa-edit text-primary btn p-2' style='font-size: 18px;'></i></a>";
        $button.= "<a class='edit' href='index.php?id=" . $resultData['id'] . "' name='delete'><i class='delete fa fa-trash text-danger btn p-2'></i></a>";

        $nestedData = Array();
        // $nestedData[] = $num+=1; 
        $nestedData[] = $id; 
        $nestedData[] = $firstName; 
        $nestedData[] = $lastName; 
        $nestedData[] = $birthDate; 
        $nestedData[] = $address; 
        $nestedData[] = $gender; 
        $nestedData[] = $departmentId; 
        $nestedData[] = $button; 

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

