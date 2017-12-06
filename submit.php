<?php
header('Content-Type: application/json');
$name = $email = $message = $nameErr = $emailErr = $messageErr = '';
$subject = $_POST['subject'];
$ip = $_SERVER['REMOTE_ADDR'];

if (empty($_POST['name'])) {
    $nameErr = '<p class="error">Name is required</p>';
} else {
    $name = $_POST['name'];
}

if (empty($_POST['email'])) {
    $emailErr = '<p class="error">Email is required</p>';
} elseif (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
    $emailErr = '<p class="error">Email is invalid</p>';
} else {
    $email = $_POST['email'];
}

if (empty($_POST['message'])) {
    $messageErr = '<p class="error">Message is required</p>';
} else {
    $message = $_POST['message'];
}

if ($nameErr === '' && $emailErr === '' && messageErr === '') {
    $hostname = 'db711614191.db.1and1.com';
    $username = 'dbo711614191';
    $password = '';
    $dbname = 'db711614191';
    $port = '3306';
    
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname;port=$port", $username, $password);
    
    $stmt = $conn->prepare("INSERT INTO submissions (name, email, subject, ip)
    VALUES(:name, :email, :subject, :ip)");
    
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":subject", $subject);
    $stmt->bindParam(":ip", $ip);
    
    $stmt->execute();
    
    $conn = $stmt = null;
    
    require 'PHPMailer-6.0.2/src/PHPMailer.php';
    
    $mail = new PHPMailer\PHPMailer\PHPMailer;
    $mail->Host = 'auth.smtp.1and1.co.uk';
    $mail->setFrom("$email", "$name");
    $mail->addAddress('elliot@elliotcallaghan.co.uk');
    $mail->isHTML(true);
    $mail->Subject = "$subject";
    $mail->Body = "<body style='white-space: pre-wrap;'>$message</body>";
    $mail->send();
} else {
    $errors = ['nameErr' => "$nameErr", 'emailErr' => "$emailErr", 'messageErr' => "$messageErr"];
    echo json_encode($errors);
}
?>
