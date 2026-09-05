<?php

include "questions.php";

?>

<!DOCTYPE html>

<html>

<head>

    <title>Sports Quiz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            padding: 40px 16px;
            display: flex;
            justify-content: center;
        }

        .quiz-container {
            background-color: #ffffff;
            max-width: 650px;
            width: 100%;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.08), 0 2px 4px -1px rgba(0, 0, 0, 0.04);
        }

        h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e5e7eb;
        }

        .question-box {
            margin-bottom: 24px;
        }

        h3 {
            font-size: 1.05rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 12px;
        }

        label.option-label {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            margin-bottom: 8px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.15s ease, border-color 0.15s ease;
            font-size: 0.95rem;
        }

        label.option-label:hover {
            background-color: #f9fafb;
            border-color: #d1d5db;
        }

        input[type="radio"] {
            accent-color: #2563eb;
            cursor: pointer;
            width: 16px;
            height: 16px;
        }

        button[type="submit"] {
            background-color: #2563eb;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.15s ease;
        }

        button[type="submit"]:hover {
            background-color: #1d4ed8;
        }
    </style>

</head>

<body>

    <div class="quiz-container">

        <h1>Cricket & Football Quiz</h1>

        <form action="Result.php" method="POST">

            <?php

            foreach ($questions as $number => $question) {

            ?>

                <div class="question-box">

                    <h3>
                        <?php echo $number . ". " . $question["question"]; ?>
                    </h3>

                    <?php

                    foreach ($question["options"] as $key => $option) {

                    ?>

                        <label class="option-label">

                            <input
                                type="radio"
                                name="answers[<?php echo $number; ?>]"
                                value="<?php echo $key; ?>"
                            >

                            <?php echo $key . ". " . $option; ?>

                        </label>

                    <?php

                    }

                    ?>

                </div>

            <?php

            }

            ?>

            <button type="submit">
                Submit Quiz
            </button>

        </form>

    </div>

</body>

</html>