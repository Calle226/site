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
    
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    if (empty($_POST['name'])) {
        echo 'Name is required';
    } else {
        $name = $_POST['name'];
    }

    if (empty($_POST['email'])) {
        echo 'Email is required';
    } elseif (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
        echo 'Invalid email';
    } else {
        $email = $_POST['email'];
    }

    if (empty($_POST['message'])) {
        echo 'Message is required';
    } else {
        $message = $_POST['message'];
    }

    $hostname = "db711614191.db.1and1.com";
    $username = "dbo711614191";
    $password = "";
    $dbname = "db711614191";
    $port = "3306";

    try {
        $conn = new PDO("mysql:host=$hostname;dbname=$dbname;port=$port", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO submissions (name, email, ip)
        VALUES(:name, :email, :ip)");

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":ip", $ip);

        $stmt->execute();
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    
    $conn = $stmt = null;
    
    require 'PHPMailer-master/PHPMailer-master/src/Exception.php';
    require 'PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/PHPMailer-master/src/SMTP.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer;
    $mail->SMTPDebug = 0; //0 = nothing; 1 = error and messages; 2 = messages only
    $mail->isSMTP();
    $mail->Host = 'auth.smtp.1and1.co.uk';
    $mail->SMTPAuth = true;
    $mail->Username = 'elliot@elliotcallaghan.co.uk';
    $mail->Password = '';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom("$email", "$name");
    $mail->addAddress('elliot@elliotcallaghan.co.uk');

    $mail->isHTML(true);
    $mail->Subject = "$subject";
    $mail->Body = "<body style='white-space: pre-wrap;'>$message</body>";

    $mail->send();
}
?>
</body>
</html>
