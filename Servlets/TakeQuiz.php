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
              minIndex = parseInt(obj['MinNumber']);
              quantity = parseInt(obj['Quantity']);
              maxIndex = parseInt(minIndex) + parseInt(quantity) - 1;
              actualQuestion = minIndex;
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
            Index: index,
            QuizID : "<?php echo $QuizID; ?>"
          },
          contentType: 'application/json; charset=utf-8',
          success: function (response) {

            var obj = jQuery.parseJSON(response);
            var div = $("<div></div>");// Elemento que contendra toda la pregunta
            div.attr("id","question");
            var b = $("<b></b>"); // elemento uinvocado 1 vez por pregunta,
            b.html(obj['Title']);
            div.append(b);
            div.append("<br/>");
            // aqui invocar un ajax que te regrese el arreglo de las options de esa pregunta en particular
        
            $.each(obj['Options'],function(){
              var input = $("<input></input>");
              var label = $("<label></label>");
              input.attr("type","checkbox");
              input.attr("name","answers[]");
              input.attr("id",this["OptionID"]);
              label.html(this["Title"]);
              label.attr("for",this["OptionID"]);
              div.append(input);
              div.append(label);
              div.append($("<BR>"));
            });

            $("#question").replaceWith(div);
          },
          error: function () {
          alert("error");
          }
        });
      }

      function nextQuestion(){
        actualQuestion++;
        if(actualQuestion > maxIndex){
          return false; // no action taken
        }
        if(actualQuestion == maxIndex){
          $("#submitBtn").removeAttr('hidden');
          $("#nextbutton").attr('hidden','');
        }
        printQuestion(actualQuestion);
        return false;
      }

    </script>
  </head>
<body>
  <form method=POST action=EvaluateQuiz.php>
  
    <H2><?= $Quiz->Title ?></H2>
    <input type=hidden name='<?= $QuizID; ?>' value=$QuizID>
    <input type=hidden name='<?= $TestID; ?>' value=$TestID>
    <input type="button" id="nextbutton" onclick="nextQuestion()" value = "Next question"/>
    <div id="question">
    </div>
    <input id="submitBtn" type="submit" name="Submit" value="Submit" hidden>
  </form>

</body>
</html>
