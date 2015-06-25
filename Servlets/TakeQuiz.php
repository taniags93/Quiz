<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Session/Session.class.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Dao/QuizDAO.class.php';
  $session = new Session;
  $QuizID = $_GET['QuizID'];
  $QuizDao = new QuizDAO;
  $StudentID = $_SESSION['userid'];
  $Quiz = $QuizDao->ReadOneQuiz($QuizID);
  $TestID = $QuizDao->StartTakingQuiz($StudentID, $QuizID);
  $Duration = $QuizDao->getQuizDuration($QuizID);
?>

<!DOCTYPE HTML>
<style>
body, html {
    height: 100%;
    background-repeat: no-repeat;
    background-image: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));
}

form {
	background: rgb(240,248,255);
	border-radius: 20px ;
}

H2,td {
	text-align: center;

}

div {
	margin-left: 2cm;
	font-size:100%;

}
#qid {
  padding: 10px 15px;
  -moz-border-radius: 50px;
  -webkit-border-radius: 50px;
  border-radius: 20px;
}
label {
	font-weight: 300;
}
#demo{
	float:right;
}
</style>
<html>
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <style type="text/css">
      label {margin-right:20px;}
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="js/jspatch.js"></script>
	<script type="text/javascript" src="js/jquery.pietimer.js"></script>

    <script type="text/javascript">
      var minIndex;
      var maxIndex;
      var quantity;
      var actualQuestion;
      var beforeQuestion;
      var num;
      var quizDuration;

      $(document).ready(function () {
        $.ajax({
          url : 'GetQuizData.php',
          type : 'GET',
          data : {
            QuizID : "<?php echo $QuizID; ?>"
          },
          contentType: 'application/json; charset=utf-8',
          success: function (response) {
              var obj = jQuery.parseJSON(response);
              num = 1;
              minIndex = parseInt(obj['MinNumber']);
              quantity = parseInt(obj['Quantity']);
              maxIndex = parseInt(minIndex) + parseInt(quantity) - 1;
              actualQuestion = minIndex;
              printQuestion(actualQuestion);
              var div = $("<div></div>");// Elemento que contendra los botones
              div.attr("id","buttons");
              div.attr("style", "margin-left: 0px;");
              var i;
              for (i = minIndex; i <= maxIndex; i++)
              {
              		var bu = $("<a></a>");
              		bu.attr("class","btn btn-info");
              		bu.attr("id", "btn"+i);
              		bu.attr("style","width: 40px");
              		bu.attr("href","#");
              		bu.attr("onclick","saveAnswers("+i+");return false;");
              		bu.html(num);
              		num++;
					div.append(bu);
              }
              $("#botones").replaceWith(div);
              startTimer();
          },
          error: function () {
          }
        });
      });

	  function startTimer(){

		$('#demo').pietimer({
			seconds: "<?=$Duration;?>",
			color: 'rgb(240,248,255)',
			height: 90,
			width: 90,
					is_reversed: true
		},
		function(){
			saveAnswers(actualQuestion);
			document.forms["myform"].submit();
		});

		$('#demo').pietimer('start');

	  };
      function printQuestion(index){
      	actualQuestion = index;
        $.ajax({
          url : 'GetQuestionData.php',
          type : 'GET',
          data : {
            Index: index,
            QuizID : "<?=$QuizID; ?>",
            TestID : "<?=$TestID; ?>"
          },
          contentType: 'application/json; charset=utf-8',
          success: function (response) {

            var obj = jQuery.parseJSON(response);
            var div = $("<div></div>");// Elemento que contendra toda la pregunta
            div.attr("id","question");
            $('div#qid').html(actualQuestion-minIndex+1);
            $('div#pregunta').html(obj['Title']);

            // aqui invocar un ajax que te regrese el arreglo de las options de esa pregunta en particular
            $.each(obj['Options'],function(){
              var input = $("<input></input>");
              var label = $("<label></label>");
              input.attr("class","css-checkbox");
              input.attr("type","checkbox");
              input.attr("name","answers[]");
              input.attr("id",this["OptionID"]);
              input.attr("checked", this["Selected"]);
              label.attr("class","css-label");
              label.html(this["Title"]);
              label.attr("for",this["OptionID"]);
              div.append(input);
              div.append(label);
              div.append($("<BR>"));
            });

            $("#question").replaceWith(div);
            nextButton();
          },
          error: function () {
          alert("error");
          }
        });
      }

	  function nextButton(){
	  	if(actualQuestion == maxIndex){
          $("#sub").removeAttr('hidden');
          $("#next").attr('hidden','');
        }
        if(actualQuestion < maxIndex){
          $("#next").removeAttr('hidden');
          $("#sub").attr('hidden','');
        }
	  }

	  function nextQuestion(){
      	actualQuestion++;
        if(actualQuestion > maxIndex){
          return false; // no action taken
        }
        saveAnswers(actualQuestion);
      }

      function saveAnswers(index){
		    actualQuestion = index;
		if (beforeQuestion == null)
			beforeQuestion = minIndex;
      	var selected = [];
      	$('#question input:checked').each(function(){
      		selected.push($(this).attr('id'));
      	});
      	if (selected.length > 0)
      	{
      		var btn = document.getElementById("btn"+beforeQuestion);
      		btn.className = 'btn btn-primary';
      	}
    	$.ajax({
    		url: 'storeAnswers.php',
        	type: 'POST',
            data:
            {
            	'answers[]': selected,
            	 'TestID' : "<?=$TestID; ?>",
             	 'QuestionID' : beforeQuestion
         	},
        });
        printQuestion(actualQuestion);
        beforeQuestion = actualQuestion;
        return false;
      }

    </script>
  </head>
<body>
	<div class="modal-dialog">
		<div align="center" style="margin-left: 0px;"><img src="images/title-sm.png">
		<span id="demo" style="height: 130px;"></span></div>
  		<form id="myform" method=POST action=EvaluateQuiz.php style="max-width: 1200px; margin-left : auto; margin-right : auto; margin-top: 10px; height: 400px;">
			</br>
			<div class="modal-header" style="margin-left: 0px;">
            		<h3><div style="margin-left: 0px;" class="label label-info" id="qid"></div></h3>
            		<h3><div id="pregunta" style="margin-left: 0cm;"></div></h3>
       	 	</div>
    		<input type=hidden name='QuizID' value='<?=$QuizID;?>'>
    		<input type=hidden name='TestID' value='<?=$TestID;?>'>
    		</br>
    		</br>
    		<div id="question">
    		</div>
    		</br>
    		<div align="right" style="margin-right: 40px;" id="next">
    			<a href="#" id="nextbutton" onclick="nextQuestion()" class="btn btn-lg btn-info"><span class="glyphicon glyphicon-chevron-right"></span> </a>
    		</div>
    		<div align="right" style="margin-right: 40px;" id="sub" hidden>
    			<input class="btn btn-info" style="width: 150px" id="submitBtn" type="submit" name="Submit" onclick="saveAnswers()" value="End Test" >
    		</div>
  		</form>
    	</br>
  		<div align="center" style="margin-left: 0px;"><div id="botones">
	    </div></div>
	</div>
</body>
</html>
