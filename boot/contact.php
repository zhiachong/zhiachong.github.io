<?php

$eol = '\n';

$to = 'zhiachong@gmail.com';
$message = isset($_POST['message']) ? $_POST['message'] : 'NO MESSAGE FOUND';
$name = isset($_POST['name']) ? $_POST['name'] : "NO NAME";
$email = isset($_POST['email']) ? $_POST['email'] : "NO EMAIL TO REPLY TO";
$from = $email;
$subject = "You have a contact request!";

$headers = "From: $name <$from>".$eol;
$headers .= "Reply-To: $name <$from>".$eol;
$headers .= "Return-Path: $name <$from>".$eol;     // these two to set reply address
$headers .= "Message-ID:<".time()." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol;
$headers .= "X-Mailer: PHP v".phpversion().$eol;


$result = mail ($to, $subject, $message, $headers, $parameters);

if ($result)
{
	header('Location: page.php?p=contact_success');
}
else 
{
	header('Location: page.php?p=contact_failure');
}
?>