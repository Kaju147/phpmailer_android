<?php

session_start();
require 'mail/phpmailer.php';
require 'mail/smtp.php';

$ijson = file_get_contents('php://input');
$iarr = json_decode($ijson, true);


$servername = "ip address";
$uid = "uid";
$pwd = "pwd";
$dbname = "database";

$connectionInfo = array("UID" => "$uid", "PWD" => "$pwd", "DATABASE" => "$dbname");
$connection = sqlsrv_connect($servername, $connectionInfo);


if (count($iarr) > 0) {

    $response = [];

    if (array_key_exists('s_email', $iarr)) {

        $userid = '';
        if (isset($_SESSION['UserId'])) {
            $userid = $_SESSION['UserId'];
        }
        $userid1 = strval($userid);


        $email = $iarr['s_email'];
        $sub = '';
        if (isset($iarr['Subject'])) {
            $sub = $iarr['Subject'];
        }
        $subject = $sub;

        $body1 = '';
        if (isset($iarr['Body'])) {
            $body1 = $iarr['Body'];
        }
        $body = $body1;

        //   $subject ="OTP";
        $mail = new PHPMailer();

        $mail->IsSMTP(); // telling the class to use SMTP
        //$mail->Host       = "smtp.gmail.com"; // SMTP server
        $mail->SMTPDebug = 0;                     // enables SMTP debug information (for testing)
        // 1 = errors and messages
        // 2 = messages only
        $mail->SMTPAuth = true;                  // enable SMTP authentication
        $mail->Host = "smtp.gmail.com";
        //    $mail->Host       = "smtp.gmail.com";// sets the SMTP server
        $mail->Port = 465;                    // set the SMTP port for the GMAIL server
        $mail->Username = "username of gmail id"; // SMTP account username
        $mail->Password = "password";
        
        $mail->SMTPSecure = 'ssl';


        $mail->From = 'user id of gmail';
        $mail->FromName = 'MAILER';
        //$mail->addAddress('arpit.icreate@gmail.com', 'Joe User');     // Add a recipient
        $mail->addAddress($email);               // Name is optional
        //        $mail->addReplyTo('info@example.com', 'Information');
        //        $mail->addCC('cc@example.com');
        //        $mail->addBCC('bcc@example.com');
        //print_r($mail->ReplyTo);
        //print_r($mail->to);
        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


        if (!$mail->send()) {
            $response = array("result" => false,
                "msg" => "Mail not sent");
        } else {
            $query = "insert into tbl_Email_details (UserId,s_email,Subject,Body) values('$userid1','$email','$subject','$body')";
            $stmt = sqlsrv_query($connection, $query);

            if ($stmt > 0) {
                $response = array("result" => true,
                    "msg" => "Mail sent");
            } else {
                $response = array("result" => false,
                    "msg" => "Mail not sent error in query");
            }
        }
    } else {
        $response = array("result" => FALSE, "msg" => "Invalid Parameter");
    }
} else {
    $response = array("result" => FALSE, "msg" => "Mail Not Sent");
}

$oarr = array("Mail_Response" => $response);
$ojson = json_encode($oarr);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
echo $ojson;
?>


