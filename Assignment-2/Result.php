<?php

include "questions.php";


$answers = $_POST["answers"] ?? [];



$correct = 0;
$wrong = 0;
$unanswered = 0;



foreach ($questions as $number => $question) {

   
    $userAnswer = $answers[$number] ?? "";



    $userAnswer = trim($userAnswer);

    $userAnswer = htmlspecialchars(
        $userAnswer,
        ENT_QUOTES,
        "UTF-8"
    );



    if ($userAnswer === "") {

        $unanswered++;

        continue;
    }



    if (!isset($question["options"][$userAnswer])) {

        $wrong++;

        continue;
    }



    if ($userAnswer === $question["answer"]) {

        $correct++;

    } else {

        $wrong++;
    }

}



$totalQuestions = count($questions);


$score = ($correct / $totalQuestions) * 100;

?>

<!DOCTYPE html>

<html>

<head>

    <title>Quiz Result</title>

</head>

<body>


<h1>Quiz Result</h1>


<h2>
    Your Score:
    <?php echo $score; ?>%
</h2>


<p>
    Correct Answers:
    <?php echo $correct; ?>
</p>


<p>
    Wrong Answers:
    <?php echo $wrong; ?>
</p>


<p>
    Unanswered:
    <?php echo $unanswered; ?>
</p>


<p>
    Total Questions:
    <?php echo $totalQuestions; ?>
</p>


<br>


<a href="index.php">
    Try Again
</a>


</body>

</html>
