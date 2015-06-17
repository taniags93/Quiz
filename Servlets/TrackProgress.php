<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Dao/QuizDAO.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Session/Session.class.php';

$session = new Session;
$QuizDao = new QuizDAO;

$StudentID = $_SESSION['userid'];
$QuizID = $_GET['QuizID'];

$TranscriptData = $QuizDao->getTranscriptByStudentIDAndQuizID($StudentID, $QuizID);

$Attempts = array_keys($TranscriptData);
$Scores = array_values($TranscriptData);

for($i = 0;$i < count($Scores); $i++)
{
    $Chart[$i] = array((string)$Attempts[$i], intval($Scores[$i] * 100));
}
$JSONChart = json_encode($Chart);
?>
<!DOCTYPE HTML>
<html>
  <head>
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
          width: 800,
          height: 600,
          vAxis: {title: "Attempt #" , direction:-1},
          hAxis: {title: "Score %"}
        };
      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
    </script>
  </head>

  <body>
    <div id="chart_div"></div>
  </body>
</html>
