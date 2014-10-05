<?php

function parse()
{
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  if (!empty($email) || (!empty($message)))
  {
    $to = 'zhiachong@gmail.com';

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $subject = "You have a new inquiry from: " .$name;

    $eol = '<br/>';
    $mail = '<html><body>Name: ' . $name . $eol;
    $mail .= "Email: " . $email . $eol;
    $mail .= "Message: " . $message . $eol;
    
    if (mail($to, $subject, $mail, $headers))
    {
      header("Refresh:3;url=http://www.zhiachong.com");
      echo "I have successfully received your inquiry! Please hold on while I redirect you to my main page :) ";
    }  
  }
  else
  {
    if (empty($message))
    {
      echo "Oops, my psychic powers aren't working today. Please fill in what you want to tell me.";

    }
    else if (empty($email))
    {
      echo "Hmmm, it seems like your email isn't there. ";
    }
  }
  
}

parse();  


?>
