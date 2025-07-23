
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_scores";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$sql = "SELECT * FROM predictions ORDER BY timestamp DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Prediction Records</title>
    <style>
        body { font-family: Arial; padding: 20px; background-color: #f4f4f4; }
        table { width: 100%%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #003366; color: white; }
        tr:nth-child(even) { background-color: #e9e9e9; }
        h2 { color: #003366; }
    </style>
</head>
<body>
    <h2>All Student Score Predictions</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Hours Studied</th>
            <th>Previous Score</th>
            <th>Attendance</th>
            <th>Parental Involvement</th>
            <th>Predicted Score</th>
            <th>Timestamp</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row["id"]}</td>
                    <td>{$row["name"]}</td>
                    <td>{$row["gender"]}</td>
                    <td>{$row["hours_studied"]}</td>
                    <td>{$row["previous_score"]}</td>
                    <td>{$row["attendance"]}</td>
                    <td>{$row["parental_involvement"]}</td>
                    <td>{$row["predicted_score"]}</td>
                    <td>{$row["timestamp"]}</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No records found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
