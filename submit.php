<?php
$name = $email = $subject = $message = "";
$ip = $_SERVER['REMOTE_ADDR'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["name"]);
  $email = test_input($_POST["email"]);
  //$subject = test_input($_POST["subject"]);
  //$message = test_input($_POST["message"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$hostname = "db711614191.db.1and1.com";
$username = "dbo711614191";
$password = "Trappist-1";
$dbname = "db711614191";

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO submissions (name, email, ip) 
    VALUES (:name, :email, :ip)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':ip', $ip);

    // insert a row
    $name = $name;
    $email = $email;
    $ip = $ip;
    $stmt->execute();

    echo "New records created successfully";
}

catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = $stmt = null;
?>