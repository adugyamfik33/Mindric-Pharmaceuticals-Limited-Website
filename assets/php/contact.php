<?php require("PHPMailer/PHPMailerAutoload.php");

// ADD your Email and Name
$recipientEmail='mindricinc@gmail.com';
$recipientName='Mindric Pharmaceuticals';

//collect the posted variables into local variables before calling $mail = new mailer

$senderName = $_POST['contact-name'];
$senderPhone = $_POST['contact-phone'];
$senderMessage= $_POST['contact-message'];
$senderSubject = 'New Message From ' . $senderName;
$senderEmail = $_POST['contact-email'];
$response_subject = "Re: Recent Email Inquiry From Mindric Pharmaceuticals";
//Create a new PHPMailer instance
$mail = new PHPMailer();
$response_mail = new PHPMailer();
$response_message = "Your email has been received.Thank you for reaching out. We will get back to you soon.";
//Set who the message is to be sent from
$mail->setFrom($recipientEmail, $recipientName);
$response_mail->setFrom($senderEmail, $senderName);
//Set an alternative reply-to address
$mail->addReplyTo($senderEmail,$senderName);
$response_mail->addReplyTo($recipientEmail,$recipientName);
//Set who the message is to be sent to
$mail->addAddress($senderEmail, $senderName );
$response_mail->addAddress($senderEmail, $senderName);
//Set the subject line
$mail->Subject = $senderSubject;
$response_mail->Subject = $response_subject;
$mail->Body = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
$response_mail->Body = "To view the message, please use an HTML compatible email viewer!";
$mail->MsgHTML($body);
$mail->AddAddress($recipientEmail, $recipientName);
$response_mail->MsgHTML($body);
$response_mail->AddAddress($senderEmail, $senderName);

//$mail-&gt;AddAttachment("images/phpmailer.gif"); // attachment
//$mail-&gt;AddAttachment("images/phpmailer_mini.gif"); // attachment

//now make those variables the body of the emails
$message = '<html><body>';
$message .= '<table rules="all" style="border:1px solid #38003d;width:300px;" cellpadding="10">';
$message .= ($senderName) ? "<tr style='background: #38003d;'><td><strong>Name:</strong> </td><td>" . $senderName . "</td></tr>" : '';
$message .= ($senderEmail) ?"<tr><td><strong>Email:</strong> </td><td>" . $senderEmail . "</td></tr>" : '';
$message .= ($senderPhone) ?"<tr><td><strong>Phone:</strong> </td><td>" . $senderPhone . "</td></tr>" : '';
$message .= ($senderMessage) ?"<tr><td><strong>Email:</strong> </td><td>" . $senderMessage . "</td></tr>" : '';

$message .= "</table>";
$message .= "</body></html>";

$rmessage = '<html><body>';
$rmessage .= '<table rules="all" style="border:1px solid #38003d;width:300px;" cellpadding="10">';
$rmessage .= "<tr style='background: #38003d;'><td><strong></strong> </td><td></td></tr>";
$rmessage .= "<tr><td> Hello ".$senderName."</td><td></td></tr>";
$rmessage .= "<tr><td><strong></strong> </td><td>" .$response_message. "</td></tr>";
$rmessage .= "<tr><td>Best regards,</td><td></td></tr>";
$rmessage .= "<tr><td>Mindric Pharmaceuticals</td><td></td></tr>";
$rmessage .= "</table>";
$rmessage .= "</body></html>";

$mail->Body = $message;
$response_mail->Body = $rmessage;
// $mail->Body="
// Name:$senderName<br/>
// Email: $senderEmail<br/>
// Suburb: $senderSubject<br/>
// Message: $senderMessage";

if(!$mail->Send()) {
	$result['code'] = 400;
	$result['message'] = $mail->ErrorInfo;
	// echo '<div class="alert alert-danger" role="alert">Error: '. $mail->ErrorInfo.'</div>';
} else {
	$response_mail->send();
	$result['code'] = 200;
	$result['message'] = "Sent Successfully";
	// echo '<div class="alert alert-success" role="alert">Thank you. We will contact you shortly.</div>';
}
header('Content-Type: application/json; charset = utf-8');
echo json_encode($result);
?>