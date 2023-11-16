
<?php 

include 'connection.php';

$query = (isset($_POST['sql'])) ? $_POST['sql'] : "";
$result = $db->query($query);
    if ($result->num_rows> 0)
    {
        $firstName            => $result['firstName'],
        $lastName             => $result['lastName'],
        $birthday             => $result['birthday'],
        $address              => $result['address'],
        $gender               => $result['gender'],
        $departmentId         => $result['departmentId']

    } 
    
    $json_data = array
    (
        "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
        "recordsTotal"    => intval( $totalData ),  // total number of records
        "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
        
        "data"            => $data   // total data array
        
    );

    echo json_encode($json_data);  // send data as json format

?>

