<?php
// Backend logic handles async POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uname = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $age   = isset($_POST['age']) ? trim($_POST['age']) : '';

    // 1. Calculate total characters in username
    $name_length = strlen($uname);

    // 2. Current year with two random digits appended
    $two_random = rand(10, 99);
    $year_code  = date('Y') . $two_random;

    // 3. Extract parts from user data to make a strong password
    // (uppercase first letters, symbols, digits from phone, age, and year)
    $clean_name = ucfirst(strtolower(substr($uname, 0, 3)));
    
    // Grab first character of email domain and username part
    $email_prefix = strtoupper(substr($email, 0, 1));
    
    // Last 3 digits of phone number
    $phone_slice = substr($phone, -3);

    // Special characters for strength
    $symbols = ['@', '#', '$', '!', '&'];
    $rand_symbol = $symbols[rand(0, count($symbols) - 1)];

    // Build the final combined password
    // Pattern: NamePart + Symbol + EmailChar + PhonePart + Age + YearWithDigits + CharCount
    $strong_password = $clean_name . $rand_symbol . $email_prefix . $phone_slice . "_" . $age . $year_code . $name_length;

    // Send back plain text to AJAX
    echo $strong_password;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration & Password Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        .container {
            width: 320px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .form-group {
            margin-bottom: 12px;
        }
        label {
            display: block;
            margin-bottom: 4px;
            font-size: 14px;
        }
        input {
            width: 100%;
            padding: 6px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 8px;
            background-color: #2b6cb0;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2c5282;
        }
        #resultBox {
            margin-top: 15px;
            padding: 10px;
            background-color: #e6fffa;
            border: 1px solid #38b2ac;
            color: #234e52;
            display: none;
            word-break: break-all;
        }
    </style>
</head>
<body>

<div class="container">
    <h3>User Details</h3>
    <form id="detailsForm">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Email ID</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Phone No</label>
            <input type="text" name="phone" required>
        </div>
        <div class="form-group">
            <label>Age</label>
            <input type="number" name="age" required>
        </div>
        <button type="submit">Generate Password</button>
    </form>

    <div id="resultBox"></div>
</div>

<script>
// Async submission using Fetch API
document.getElementById('detailsForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch('index.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        let resultDiv = document.getElementById('resultBox');
        resultDiv.style.display = 'block';
        resultDiv.innerHTML = "<strong>Generated Password:</strong><br>" + data;
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
</script>

</body>
</html>