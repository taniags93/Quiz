<style>
body, html {
    height: 100%;
    background-repeat: no-repeat;
    background-image: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));
    font-family: "Helvetica Neue", Helvetica;
}

form {
	background: rgb(240,248,255);
	border-radius: 20px ;
}

H2,td {
	text-align: center;
}
#score{
	font-family: "Helvetica Neue", Helvetica;
	font-size:34px;
}
#chart_div {
  padding: 10px 15px;
  -moz-border-radius: 50px;
  -webkit-border-radius: 50px;
  border-radius: 20px;
}
</style>
<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Dao/QuizDAO.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Session/Session.class.php';

$session = new Session;
$QuizDao = new QuizDAO;

$StudentID = $_SESSION['userid'];
$QuizID = $_GET['QuizID'];

$TranscriptData = $QuizDao->GetTranscriptByStudentIDAndQuizID($StudentID, $QuizID);

$Titles = array_keys($TranscriptData);
$Scores = array_values($TranscriptData);
for($i = 0;$i < count($Scores); $i++)
{
    $Chart[$i] = array((string)$Titles[$i], intval($Scores[$i]));
}
$JSONChart = json_encode($Chart);
?>
<!DOCTYPE HTML>
<html>

  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">
    google.load('visualization', '1', {'packages':['corechart']});
    google.setOnLoadCallback(drawChart);

    function drawChart() {
     var data = new google.visualization.DataTable();
        data.addColumn("string", "Attempt");
        data.addColumn("number", "Score");

        data.addRows(<?php echo $JSONChart ?>);

      var options = {
          title: 'My Course Progress',
          is3D: 'true',
          width: 900,
          height: 500,
          vAxis: {title: "Test Name" , direction:-1},
          hAxis: {title: "Score %" , viewWindow:{ max:100, min:0 } }
        };
      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
    </script>
  </head>

  <body>
  		<div class="modal-dialog">
			<div align="right"><a class="btn btn-info" style="width: 100px"
				href=Welcome.php>Home</a></div>
			<div align="center"><img src="images/title-sm.png"></div>
		</div>
		<div align="center"><div id="chart_div"></div></div>

  </body>
</html>
