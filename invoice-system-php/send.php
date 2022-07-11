<?php
session_start();
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_GET['invoice_id']) && $_GET['invoice_id']) {
	echo $_GET['invoice_id'];
	$invoiceValues = $invoice->getInvoice($_GET['invoice_id']);		
	$invoiceItems = $invoice->getInvoiceItems($_GET['invoice_id']);	
}
$invoiceDate = date("j-F-y, H:i:s A", strtotime($invoiceValues['order_date']));





use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require("mail/Exception.php");
require("mail/PHPMailer.php");
require("mail/SMTP.php");

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


if(isset($_POST['send'])){
	// print_r($_FILES);
	$email = $_POST['email'];
	$subject = $_POST['subject'];
	$msg=$_POST['msg'];
}


try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'navdhillon954@gmail.com';                     //SMTP username
    $mail->Password   = 'uerdefjijrjilkol';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('navdhillon954@gmail.com', 'MODICARE DISTRIBUTION POINT');
    $mail->addAddress($email, 'Navneet');     //Add a recipient
	
    //Attachments
	if($_FILES['attachment']['name']!=null){
		if(move_uploaded_file($_FILES['attachment']['tmp_name'],"uploads/{$_FILES['attachment']['name']}")){
	$mail->addAttachment("uploads/{$_FILES['attachment']['name']}");    

		}

	}



    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
	
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject =  $subject;
    $mail->Body    = '<strong>' .$msg. $output1.'</strong>';
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo '<script>window.location.href="invoice_list.php?message_sent";</script>';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>