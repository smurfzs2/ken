<?php include 'connection.php'; ?>
<?php
include $_SERVER['DOCUMENT_ROOT']."/version.php";
$path = $_SERVER['DOCUMENT_ROOT']."/".v."/Common Data/";
set_include_path($path);    
// include('PHP Modules/mysqliConnection.php');
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

    
    $sql = "SELECT * FROM `tbl_khenneth` INNER JOIN `hr_department` ON tbl_khenneth.departmentId=hr_department.departmentId ORDER BY id ASC";
    $queryData = $con->query($sql);
    $resultData = $queryData->fetch_assoc();
    $sqlData=$sql;
    $totalRecords=$queryData->num_rows;
?>
<div class='container-fluid' >
<div class="input-group" style="float:right;">
        <!-- <input type="text" class="search form-control"  id="searchByName" placeholder="Search..."> -->
        <div class="input-group-append">
            <button  type="button" class="btn btn-primary mx-3" name="filter" id="filter" onclick="modalFilterForm();">Filter</button>
        </div>
       
    </div>
    <div class='row w3-padding-top'>  <!-- row 2 -->
        <div class='col-md-12'>
            <!-- TABLE TEMPLATE -->
            <label><?php echo displayText("L41", "utf8", 0, 0, 1)." : ". $totalRecords; ?></label>
            <table id='listTableAjax' class="table table-bordered table-striped table-condensed" style="width:100%;">
				<thead class='w3-indigo' style='text-transform:uppercase;'>
                    <th class='w3-center' style='vertical-align:middle;'>#</th>
                    <th class='w3-center' style='vertical-align:middle;'>First Name</th>
                    <th class='w3-center' style='vertical-align:middle;'>Last Name</th>
                    <th class='w3-center' style='vertical-align:middle;'>Birthday</th>
                    <th class='w3-center' style='vertical-align:middle;'>Address</th>
                    <th class='w3-center' style='vertical-align:middle;'>Gender</th>
                    <th class='w3-center' style='vertical-align:middle;'>Department Name</th>
                    <!-- <th class='w3-center' style='vertical-align:middle;'>ACTION</th> -->
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

         //MODAL FILTER FORM START HERE------------------------------------------------------------------
         function modalFilterForm()
        {
                $("#modal-izi-filter").iziModal({
                    title                   : '<i class="fa fa-filter"></i> <?php echo displayText("L437","utf8",0,0,1);?>',
                    headerColor             : '#1F4788',
                    subtitle                : '<b><?php //echo strtoupper(date('F d, Y'));?></b>',
                    width                   : 400,
                    fullscreen              : false,
                    transitionIn            : 'comingIn',
                    transitionOut           : 'comingOut',
                    padding                 : 20,
                    radius                  : 0,
                    top                     : 100,
                    restoreDefaultContent   : true,
                    closeOnEscape           : true,
                    closeButton             : true,
                    overlayClose            : false,
                    onOpening               : function(modal){
                                                modal.startLoading();
                                                // alert(assignedTo);
                                                $.ajax({
                                                    url         : 'khenneth_dataFilter.php',
                                                    type        : 'POST',
                                                    data        : {
                                                      
                                                        firstName           :'<?php echo $firstName;?>',
                                                        LastName        :'<?php echo $LastName;?>',
                                                        addressData        :'<?php echo $addressData;?>',
                                                        birthDate          :'<?php echo $birthDate;?>',
                                                        gender         :'<?php echo $gender;?>',
                                                        departmentName     :'<?php echo $departmentName;?>',
                                                        // dateTimeLog     :'<?php echo $dateTimeLog;?>',

                                                                
                                                    },
                                                    success     : function(data){
                                                                    $( ".izimodal-content-filter" ).html(data);
                                                                    modal.stopLoading();
                                                    }
                                                });
                                            },
                    onClosed: function(modal){
                    $("#modal-izi-filter").iziModal("destroy");
                                } 
                });

                $("#modal-izi-filter").iziModal("open");
        }
        //MODAL FILTER FORM END HERE------------------------------------------------------------------
        
</script>
