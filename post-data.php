<?php

$servername = "localhost";
$dbname = "Weather";
$username = "XXXX";
$password = "XXX";

$temperature = $humidity = $pressure = $lux = $mq135 = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if not exists
$sql = "CREATE TABLE IF NOT EXISTS Cathy (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    temperature FLOAT(10, 2) NOT NULL,
    humidity FLOAT(10, 2) NOT NULL,
    pressure FLOAT(10, 2) NOT NULL,
    lux INT(6) NOT NULL,
    mq135 INT(6) NOT NULL,
    reading_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === FALSE) {
    echo "Error creating table: " . $conn->error;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $temperature = test_input($_POST["temperature"]);
    $humidity = test_input($_POST["humidity"]);
    $pressure = test_input($_POST["pressure"]);
    $lux = test_input($_POST["lux"]);
    $mq135 = test_input($_POST["mq135"]);

    $sql = "INSERT INTO Cathy (temperature, humidity, pressure, lux, mq135)
    VALUES ('" . $temperature . "', '" . $humidity . "', '" . $pressure . "', '" . $lux . "', '" . $mq135 . "')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$conn->close();

?>
