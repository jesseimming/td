<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "td";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['question_number'])) {
    $_SESSION['question_number'] = 0;
    $_SESSION['correct_answers'] = 0;
    $_SESSION['answers'] = [];
    $_SESSION['start_time'] = time();
    $_SESSION['time_taken'] = [];
}

$sql = "SELECT id, question, image, option1, option2, goedeantwoord, feedback FROM traffic_questions";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $conn->error;
    exit;
}

if ($result->num_rows > 0) {
    $questions = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "No questions available.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save_score'])) {
        $user_id = $_SESSION['user_id']; 
        $correct_answers = $_SESSION['correct_answers'];
        $stmt = $conn->prepare("INSERT INTO user_scores (user_id, score) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $correct_answers);
        $stmt->execute();
        $stmt->close();
        echo "Score saved successfully!";
    } elseif (isset($_POST['restart_test'])) {
        $_SESSION['question_number'] = 0;
        $_SESSION['correct_answers'] = 0;
        $_SESSION['answers'] = [];
        $_SESSION['start_time'] = time();
        $_SESSION['time_taken'] = [];
    } else {
        $current_question = $questions[$_SESSION['question_number']];
        $selected_answer = $_POST['answer'] ?? null;

        if (isset($_SESSION['start_time'])) {
            $current_time = time();
            $question_time = $current_time - $_SESSION['start_time'];
            $_SESSION['time_taken'][$_SESSION['question_number']] = $question_time;
        }
        $_SESSION['start_time'] = time();

        if (isset($_POST['next'])) {
            if ($selected_answer !== null) {
                $_SESSION['answers'][$_SESSION['question_number']] = $selected_answer;
                if ($selected_answer == $current_question['goedeantwoord']) {
                    $_SESSION['correct_answers']++;
                }
            }
            $_SESSION['question_number']++;
        } elseif (isset($_POST['previous'])) {
            $_SESSION['question_number']--;
        }
    }
}

if ($_SESSION['question_number'] < count($questions) && $_SESSION['question_number'] >= 0) {
    $question = $questions[$_SESSION['question_number']];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traffic Quiz</title>
</head>
<body>
    <div>
        <p>Question <?php echo $_SESSION['question_number'] + 1; ?>/<?php echo count($questions); ?></p>
        <?php if ($question['image']): ?>
            <img src="<?php echo htmlspecialchars($question['image']); ?>" alt="Question Image"><br>
        <?php endif; ?>
        <form id="quizForm" method="POST">
            <label><?php echo htmlspecialchars($question['question']); ?></label><br>
            <input type="radio" name="answer" value="<?php echo htmlspecialchars($question['option1']); ?>" required> <?php echo htmlspecialchars($question['option1']); ?><br>
            <input type="radio" name="answer" value="<?php echo htmlspecialchars($question['option2']); ?>"> <?php echo htmlspecialchars($question['option2']); ?><br>
            <button type="submit" name="previous" <?php if ($_SESSION['question_number'] == 0) echo 'disabled'; ?>>Previous</button>
            <button type="submit" name="next">Next</button>
        </form>
    </div>
</body>
</html>
<?php
} else {
    echo "<h2>Quiz finished! You got " . $_SESSION['correct_answers'] . " out of " . count($questions) . " correct.</h2>";

    echo "<form method='POST'>";
    echo "<button type='submit' name='save_score'>Save Score</button>";
    echo "<button type='submit' name='restart_test'>Restart Test</button>";
    echo "</form>";

    echo "<h3>Review your answers:</h3>";
    foreach ($questions as $index => $question) {
        $user_answer = $_SESSION['answers'][$index] ?? null;
        $correct_answer = $question['goedeantwoord'];
        $feedback = $question['feedback'];
        $question_image = $question['image'];

        echo "<div>";
        if ($question_image) {
            echo "<img src='" . htmlspecialchars($question_image) . "' alt='Question Image'><br>";
        }
        echo "<p><strong>Question:</strong> " . htmlspecialchars($question['question']) . "</p>";
        echo "<p><strong>Your answer:</strong> <span style='color:" . ($user_answer == $correct_answer ? "green" : "red") . ";'>" . htmlspecialchars($user_answer) . "</span></p>";
        echo "<p><strong>Correct answer:</strong> <span style='color:green;'>" . htmlspecialchars($correct_answer) . "</span></p>";
        echo "<p><strong>Feedback:</strong> " . htmlspecialchars($feedback) . "</p>";
        echo "<p><strong>Time taken:</strong> " . $_SESSION['time_taken'][$index] . " seconds</p>";
        echo "</div><hr>";
    }

    $total_time = array_sum($_SESSION['time_taken']);
    echo "<h3>Total time taken: $total_time seconds</h3>";

}

$conn->close();
?>
