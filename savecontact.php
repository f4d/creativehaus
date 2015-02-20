<?php
extract($_POST);

$to = 'steve@soundhousepromotions.com, ian@rezon8.net, info@soundhousepromotions.com';
$from=$email;

$msgbod="<p><strong>Contact Us Details</strong></p>
<p>Name : $name</p>
<p>Band Name : $brand</p>
<p>Email : $email</p>
<p>Website : $website</p>
<p>Message : $message</p>";

$subject = $subj;

$headers = "From: ".$name." <".strip_tags($from).">\r\n";
$headers .= "Reply-To: ".$name." <".strip_tags($from).">\r\n";

$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

mail($to, $subject, $msgbod, $headers);
