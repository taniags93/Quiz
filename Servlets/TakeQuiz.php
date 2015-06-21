<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Session/Session.class.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Dao/QuizDAO.class.php';
  $session = new Session;
  $QuizID = $_GET['QuizID'];
  $QuizDao = new QuizDAO;
  $StudentID = $_SESSION['userid'];
  $Quiz = $QuizDao->ReadOneQuiz($QuizID);
  $TestID = $QuizDao->StartTakingQuiz($StudentID, $QuizID);

?>

<!DOCTYPE HTML>
<html>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript">
      var minIndex;
      var maxIndex;
      var quantity;
      var actualQuestion;

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
              minIndex = obj['MinNumber'];
              quantity = obj['Quantity'];
              maxIndex = minIndex + quantity - 1;
              actualQuestion = minIndex;
              alert(response);
              printQuestion(actualQuestion);
          },
          error: function () {
              alert("error");
          }
        });

        
      });

      function printQuestion(index){
      $.ajax({
          url : 'GetQuestionData.php',
          type : 'GET',
          data : {
            Index: index
          },
          contentType: 'application/json; charset=utf-8',
          success: function (response) {
          	var obj = jQuery.parseJSON(response);
       	 	var div = $("<div></div>");// Elemento que contendra toda la pregunta
       		div.attr("id","question");

       		var b = $("<b></b>"); // elemento uinvocado 1 vez por pregunta,
       		b.html(obj['Title']);
       		div.append(b);
			div.append("<br></br>");
       		// aqui invocar un ajax que te regrese el arreglo de las options de esa pregunta en particular
		
			
       		//COMIENZO DE FOR QUE RECORRERA CADA OPTION
       		var input = $("<input></input>"); // se necesitan crear 4 de estos, segun la respuesta del ajax
       		var label = $("<label></label>");

        	input.attr("type","checkbox");
       		input.attr("name","answers[]");
       		input.val("blabla");
       		label.html("blabla");

       		div.append(input);
       		div.append(label);
       		alert(response);

       		//FIN DE FOR

        	$("#question").replaceWith(div);
      	},
      	error: function () {
              alert("error");
          }
        });
	};

    </script>
  </head>
<body>
  <form method=POST action=EvaluateQuiz.php>
  
    <H2><?= $Quiz->Title ?></H2>
    <input type=hidden name='<?= $QuizID; ?>' value=$QuizID>
    <input type=hidden name='<?= $TestID; ?>' value=$TestID>
    <div id="question">
    </div>

<?php foreach ($Quiz->Questions as $Q ) : ?>
    <B> <?= $Q->Title ?></B><br>
<?php   foreach ($Q->Options as $Option) : ?>
    <input type='checkbox' name='answers[]' value='<?= $Option->OptionID; ?>'><?=$Option->Title?><br>
<?php endforeach; endforeach; ?>
    <input type="submit" name="Submit" value="Submit">
  </form>

</body>
</html>
