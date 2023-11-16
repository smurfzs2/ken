<?php include 'connection.php'; ?>
<?php
include $_SERVER['DOCUMENT_ROOT']."/version.php";
$path = $_SERVER['DOCUMENT_ROOT']."/".v."/Common Data/";
set_include_path($path);    
include('PHP Modules/mysqliConnection.php');
include('PHP Modules/anthony_retrieveText.php');
include('PHP Modules/gerald_functions.php');
include("PHP Modules/rose_prodfunctions.php");
ini_set("display_errors", "on");
$ctrl = new PMSDatabase;
$tpl = new PMSTemplates;
$pms = new PMSDBController;
$rdr = new Render\PMSTemplates;

$title = "";
PMSTemplates::includeHeader($title);

$tpl->setDataValue("L436");
$tpl->setAttribute("type","button");
$tpl->setAttribute("onclick","location.href=''");
$tpl->addClass("w3-right");
$refreshBtn = $tpl->createButton();

    
$tpl->setDataValue("L437");
$tpl->setAttribute([
     "name"  => "btnFilter",
     "id"    => "btnFilter",
     "type"  => "submit",
     "onclick"  => "modalFilterForm()"
]);
// $tpl->setAttribute("onclick","modalFilterForm()");
$tpl->addClass("w3-right");
$btnFilter = $tpl->createButton();

$tpl->setDisplayId("") # OPTIONAL
    ->setVersion("") # OPTIONAL
    ->setPrevLink($_SERVER['HTTP_REFERER']) # OPTIONAL
    ->setHomeIcon() # OPTIONAL 0 - Default; 1 - w/o home icon
    ->createHeader();

    
    $query = "SELECT * FROM tbl_khenneth";

    $queryData = $con->query($query);
    $resultData = $queryData->fetch_assoc();
    $sqlData=$query;
    $totalRecords=$queryData->num_rows;
?>
<div class='container-fluid'>
    <div class='row w3-padding-top'>  <!-- row 2 -->
        <div class='col-md-12'>
            <!-- TABLE TEMPLATE -->
            <label><?php echo displayText("L41", "utf8", 0, 0, 1)." : ". $totalRecords; ?></label>
            <table id='listTableAjax' class="table table-bordered table-striped table-condensed" style="width:100%;">
				<thead class='w3-indigo' style='text-transform:uppercase;'>
                    <th class='w3-center' style='vertical-align:middle;'>#</th>
                    <th class='w3-center' style='vertical-align:middle;'>DATA 1</th>
                    <th class='w3-center' style='vertical-align:middle;'>DATA 2</th>
                    <th class='w3-center' style='vertical-align:middle;'>DATA 3</th>
                    <th class='w3-center' style='vertical-align:middle;'>DATA 4</th>
                    <th class='w3-center' style='vertical-align:middle;'>DATA 5</th>
                    <th class='w3-center' style='vertical-align:middle;'>DATA 6</th>
                    <!-- <th class='w3-center' style='vertical-align:middle;'>DATA 7</th> -->
				</thead>
				<tbody class='w3-center'>
					
				</tbody>
				<tfoot class='w3-indigo' >
                    <tr>
                        <th class='w3-center' style='vertical-align:middle;'></th>
                        <th class='w3-center' style='vertical-align:middle;'></th>
                        <th class='w3-center' style='vertical-align:middle;'></th>
                        <th class='w3-center' style='vertical-align:middle;'></th>
                        <th class='w3-center' style='vertical-align:middle;'></th>
                        <th class='w3-center' style='vertical-align:middle;'></th>
                        <th class='w3-center' style='vertical-align:middle;'></th>
                        <!-- <th class='w3-center' style='vertical-align:middle;'></th> -->
                    </tr>
				</tfoot>
			</table>
                    </div>
    </div>
</div>
<div id='modal-izi-filter'><span class='izimodal-content-filter'></span></div>  
<?php
PMSTemplates::includeFooter();
?>
<script>
        // AJAX TABLE START HERE

        $(document).ready(function(){ 
            var sqlData = "<?php echo $sqlData; ?>";
            console.log(sqlData);
            var totalRecords = "<?php echo $totalRecords; ?>";
            var dataTable = $('#listTableAjax').DataTable({
                "searching"    : false,   
                "processing"    : true,
                "ordering"      : false,
                "serverSide"    : true,
                "bInfo" 		: false,
                "ajax":{
                    url     :"khenneth_dataAjax.php", // json datasource
                    type    : "post",  // method  , by default get
                    data    : {
                                "totalRecords"   	: totalRecords,
                                "sqlData"     	    : sqlData
                                },
                    error: function(data){  // error handling
                        console.log(data);
                        
                        // $("#idNumber").append('<tbody class="listTableAjax-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        // $("#idNumber").css("display","none");
                        
                    }
                },
                
                language	: {
                            processing	: "<span class='loader'></span>"
                },
                fixedColumns:   {
                        leftColumns: 0
                },
                // responsive		: true,
                scrollY     	: 530,
                scrollX     	: true,
                scrollCollapse	: false,
                scroller    	: {
                    loadingIndicator    : true
                },
                stateSave   	: false
            });

            $("#btnFilter").click(function(){
                //alert('asd');
            });

        });
    
        // AJAX TABLE END HERE
        
</script>
