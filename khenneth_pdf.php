<?php
require('fpdf/fpdf.php');

$con = mysqli_connect("localhost","root","arktechdb","ojtDatabase");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

// Select data from MySQL database
$select = "SELECT * FROM tbl_khenneth";
$result = $con->query($select);

$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
// $pdf->SetFillColor(255,255,101);


class PDF extends Fpdf
{
    // Page header
    function Header()
    {
        // Arial bold 15
       $this -> SetFont('Arial','',12);
        // Move to the right (for Center Position)
        $this->SetFillColor(102,178,255);
        $this->SetDrawColor(206,206,206);

        // Title
        $this->Cell(20,10,'ID',1,0,'C',true);
        $this->Cell(50,10,'First Name',1,0,'C',true);
        $this->Cell(50,10,'Last Name',1,0,'C',true);
        $this->Cell(50,10,'Birthday',1,0,'C',true);
        $this->Cell(70,10,'Address',1,0,'C',true);
        $this->Cell(40,10,'Gender',1,0,'C',true);
        
        // Line break
       $this -> Ln(10);
    }

    function Footer()
    {
        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        // Select Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Print centered page number
        $this->Cell(0, 10, 'Page '.$this->PageNo(), 0, 0, 'C');
    }

}

    $pdf = new PDF('L','mm','A4');
    $pdf -> AliasNbPages(); // Must for print total no of page
    $pdf -> AddPage();
    $pdf -> SetDrawColor(206,206,206);
    // $pdf -> SetFillColor(255,255,102);
    // $pdf -> SetTextColor(0);

    $i=0;
    while($row = $result->fetch_object()){

    $id = $row->id;
    $firstName = $row->firstName;
    $lastName = $row->lastName;
    $birthDate = $row->birthDate;
    $address = $row->addressData;
    $gender = $row->gender;

    if($id%2 == 0 )
    {
        $pdf -> SetFillColor(255,255,102);
        $pdf->Cell(20,10,$id, 1,0, 'C',true);
        $pdf->Cell(50,10,$firstName, 1,0, 'C',true);
        $pdf->Cell(50,10,$lastName, 1,0, 'C',true);
        $pdf->Cell(50,10,$birthDate, 1,0, 'C',true);
        $pdf->Cell(70,10,$address, 1,0, 'C',true);
        $pdf->Cell(40,10,$gender==0 ? "Male":"Female", 1,0, 'C',true);
        $pdf->Ln();
    }
    else
    {
        $pdf->SetFillColor(178,255,102);
        $pdf->Cell(20,10,$id, 1,0, 'C',true);
        $pdf->Cell(50,10,$firstName, 1,0, 'C',true);
        $pdf->Cell(50,10,$lastName, 1,0, 'C',true);
        $pdf->Cell(50,10,$birthDate, 1,0, 'C',true);
        $pdf->Cell(70,10,$address, 1,0, 'C',true);
        $pdf->Cell(40,10,$gender==0 ? "Male":"Female", 1,0, 'C',true);
        $pdf->Ln();
    }
    
}

$pdf->Output();


?>