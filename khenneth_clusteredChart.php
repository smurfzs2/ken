<?php
include "connection.php";


$query = "SELECT departmentName, gender, COUNT(CASE WHEN gender = '0' then 1 ELSE NULL END) AS male, COUNT(CASE WHEN gender = '1' then 1 ELSE NULL END) AS female FROM hr_department INNER JOIN tbl_khenneth ON hr_department.departmentId=tbl_khenneth.departmentId GROUP BY departmentName";
$result= mysqli_query($con,$query);


// $gender = isset($row['gender']) ? '0':'1';

$chartData = array();
if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()) {
      $chartData[] = ['departmentName' => $row['departmentName'], 'male' => (int)$row['male'], 'female' => (int)$row['female'] ];
    }
} else {
    echo "No results found";
}



?>



<!-- HTML -->
<title>Clustered Chart</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

<h1 class="mx-5 my-3">Clustered Chart
<button type="button" class="btn btnBack mx-5 my-3" style="float: right;" onclick="history.back();">BACK</button>
</h1>

<div id="chartdiv"></div>

<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 500px;
}
.btnBack{
  /* background-color: #374A67; */
  color: #cdd1de;
  border: 1px solid #cdd1de;
}
.btnBack:hover{
  border: 1px solid #374A67;

}
</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<!-- Chart code -->
<script>
am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv");


// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);


// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(am5xy.XYChart.new(root, {
  panX: false,
  panY: false,
  wheelX: "panX",
  wheelY: "zoomX",
  layout: root.verticalLayout
}));


// Add legend
// https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
var legend = chart.children.push(am5.Legend.new(root, {
  centerX: am5.p50,
  x: am5.p50
}));

var data = <?php echo json_encode($chartData) ?>;


// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xRenderer = am5xy.AxisRendererX.new(root, {
  cellStartLocation: 0.1,
  cellEndLocation: 1
});

var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
    
  categoryField: "departmentName",
  renderer: xRenderer,
  tooltip: am5.Tooltip.new(root, {})
}));

xRenderer.grid.template.setAll({
  location: 1
})

// X axis data
xAxis.data.setAll(<?php echo json_encode($chartData) ?>);

var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  min: 0,
  renderer: am5xy.AxisRendererY.new(root, {
    strokeOpacity: 1
  })
}));


// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
function makeSeries(name, fieldName, stacked) {
  var series = chart.series.push(am5xy.ColumnSeries.new(root, {
    stacked: stacked,
    name: name,
    xAxis: xAxis,
    yAxis: yAxis,
    valueYField: fieldName,
    categoryXField: "departmentName"
  }));

  series.columns.template.setAll({
    tooltipText: "{name}, {categoryX}:{valueY}",
    width: am5.percent(90),
    tooltipY: am5.percent(10)
  });
  series.data.setAll(data);

  // Make stuff animate on load
  // https://www.amcharts.com/docs/v5/concepts/animations/
  series.appear();

  series.bullets.push(function() {
    return am5.Bullet.new(root, {
      locationY: 0.5,
      sprite: am5.Label.new(root, {
        text: "{valueY}",
        fill: root.interfaceColors.get("alternativeText"),
        centerY: am5.percent(50),
        centerX: am5.percent(50),
        populateText: true
      })
    });
  });

  legend.data.push(series);
}

makeSeries("Male", "male",  true);
makeSeries("Female", "female", false);
// makeSeries("Total", 0);






// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
chart.appear(1000, 100);

}); // end am5.ready()
</script>



