<?php
// Handle form submission asynchronously
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection details
   $servername = "********";
    $db_user    = "****";
    $db_pass    = "********"; 
    $db_name    = "student_db";

    // Establish connection
    $conn = mysqli_connect($servername, $db_user, $db_pass, $db_name);

    if (!$conn) {
        echo "Database connection failed: " . mysqli_connect_error();
        exit;
    }

    // Collect POST data
    $uname = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $age   = isset($_POST['age']) ? (int)$_POST['age'] : 0;

    // Check if required fields are filled
    if (!empty($uname) && !empty($email) && !empty($phone) && $age > 0) {
        // Use prepared statement to insert data securely
        $stmt = mysqli_prepare($conn, "INSERT INTO students (username, email, phone, age) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssi", $uname, $email, $phone, $age);

        if (mysqli_stmt_execute($stmt)) {
            echo "Success: Record inserted successfully for " . htmlspecialchars($uname);
        } else {
            echo "Error inserting record: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Please fill in all the required fields.";
    }

    mysqli_close($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration to Database</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
        }
        .form-box {
            width: 320px;
            padding: 18px;
            border: 1px solid #aaa;
            border-radius: 5px;
        }
        .field {
            margin-bottom: 12px;
        }
        label {
            display: block;
            margin-bottom: 3px;
            font-weight: bold;
            font-size: 13px;
        }
        input {
            width: 100%;
            padding: 7px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 9px;
            background-color: #2b6cb0;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #1a4971;
        }
        #responseArea {
            margin-top: 15px;
            padding: 10px;
            display: none;
            border-radius: 4px;
            font-size: 14px;
        }
        .success {
            background-color: #e6fffa;
            border: 1px solid #38b2ac;
            color: #234e52;
        }
        .error {
            background-color: #fff5f5;
            border: 1px solid #e53e3e;
            color: #9b2c2c;
        }
    </style>
</head>
<body>

<div class="form-box">
    <h3>Student Details</h3>
    <form id="studentForm">
        <div class="field">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        <div class="field">
            <label>Email ID</label>
            <input type="email" name="email" required>
        </div>
        <div class="field">
            <label>Phone No</label>
            <input type="text" name="phone" required>
        </div>
        <div class="field">
            <label>Age</label>
            <input type="number" name="age" required>
        </div>
        <button type="submit" id="submitBtn">Save Student</button>
    </form>

    <div id="responseArea"></div>
</div>

<script>
document.getElementById('studentForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let btn = document.getElementById('submitBtn');
    let responseBox = document.getElementById('responseArea');
    btn.disabled = true;
    btn.innerText = "Saving...";

    let formData = new FormData(this);

    // Send data asynchronously to the same file
    fetch('student.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(msg => {
        responseBox.style.display = 'block';
        responseBox.innerText = msg;

        if (msg.includes("Success")) {
            responseBox.className = 'success';
            document.getElementById('studentForm').reset();
        } else {
            responseBox.className = 'error';
        }
    })
    .catch(err => {
        responseBox.style.display = 'block';
        responseBox.className = 'error';
        responseBox.innerText = "An error occurred during submission.";
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerText = "Save Student";
    });
});
</script>

</body>
</html>
