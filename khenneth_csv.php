<?php
include('connection.php');

$query = $con->query(" SELECT * FROM tbl_khenneth ");

if($query->num_rows > 0)
{
    $delimiter = ",";
    $filename = "data_" . date('Y-m-d') . ".csv";

    $open = fopen('php://memory', 'w');

    $header = array('ID', 'First Name', 'Last Name', 'Address', 'Birth Date', 'Gender');
    fputcsv($open,  $header, $delimiter);

    while($row = $query->fetch_assoc())
    {
        $gender = ($row['gender'] == 0)? "Male":"Female";

        $lineData = array($row['id'], $row['firstName'], $row['lastName'], $row['address'], $row['birthDate'], $gender);
        fputcsv($open,  $lineData, $delimiter);
    }

    fseek($open, 0);

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'" ;');

    fpassthru($open);

}
exit();

?>