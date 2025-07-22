<?php
$conn = new mysqli("localhost", "root", "", "info");

// Insert data if submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $family = $_POST['family_members'];
    $pid = $_POST['personal_id'];
    $maid = $_POST['maid_characteristics'];

    $stmt = $conn->prepare("INSERT INTO user_info (name, age, family_members, personal_id, maid_characteristics, status) VALUES (?, ?, ?, ?, ?, 0)");
    //status is represent if the application is active or not, default is 0 (inactive)
    $stmt->bind_param("siiss", $name, $age, $family, $pid, $maid);
    $stmt->execute();
}

// Fetch data always in case user clicks "view applications"
$result = $conn->query("SELECT * FROM user_info");
$showTable = isset($_GET['view']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Maid Recruitment Application</title>
    <style>
        body {
            font-family:'Arial Narrow', Arial, sans-serif;
            background: #f2e6faff;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 40px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #3f2d50ff;
        }
        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 35px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        textarea {
            resize: vertical;
        }
        .full {
            grid-column: span 2;
        }
        button, input[type="submit"] {
            background-color: #a281bfff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;  /*Make buttons full width*/
        }
        button:hover, input[type="submit"]:hover {
            background-color: #8c66adff;
        }
        .center {
            text-align: center;
            margin-top: 15px;
        }
        .success {
            text-align: center;
            color: green;
            margin-bottom: 15px;
        }
    </style>
    <script>
        function toggleStatus(id) {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function () {
                document.getElementById("status-" + id).innerText = this.responseText;
            }
            xhttp.open("GET", "toggle.php?id=" + id, true);
            xhttp.send();
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Maid Recruitment Application</h2>

    <?php if (isset($_GET['success'])): ?>
        <p class="success">Application submitted successfully!</p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="number" name="age" placeholder="Age" required>
        <input type="number" name="family_members" placeholder="Number of Family Members" required>
        <input type="text" name="personal_id" placeholder="Personal ID" required>
        <textarea name="maid_characteristics" placeholder="Preferred Maid Characteristics" rows="3" required></textarea>
        <input type="submit" value="Submit Application">
    </form>

    <div class="center">
        <a href="Application.php"><button class="btn">View Submitted Applications</button></a>
    </div>
</div>

</body>
</html>