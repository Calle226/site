<!doctype html>
<html>
<head>
    <title></title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' type='text/css' href='style.css'>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
</head>
<body>
<?php
    $ip = $_SERVER['REMOTE_ADDR'];
    $name = $email = $message = '';
    $subject = $_POST['subject'];
    
    if (empty($_POST['name'])) {
    } else {
        $name = $_POST['name'];
    }

    if (empty($_POST['email'])) {
    } elseif (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
    } else {
        $email = $_POST['email'];
    }

    if (empty($_POST['message'])) {
    } else {
        $message = $_POST['message'];
    }

    $hostname = 'db711614191.db.1and1.com';
    $username = 'dbo711614191';
    $password = '';
    $dbname = 'db711614191';
    $port = '3306';

    $conn = new PDO("mysql:host=$hostname;dbname=$dbname;port=$port", $username, $password);

    $stmt = $conn->prepare("INSERT INTO submissions (name, email, ip)
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
    $mail->send()
?>
</body>
</html>
