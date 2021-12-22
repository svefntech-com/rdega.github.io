<?php

$errors = [];
$errorMessage = '';

$secret = '6LcNMKoaAAAAAP0FVwKrrRtrbn-CWoUde5lk1Vf2';

if (!empty($_POST)) {
    $semail = $_POST['semail'];
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    $recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$recaptchaResponse}";
    $verify = json_decode(file_get_contents($recaptchaUrl));

    if (empty($semail)) {
        $errors[] = 'Email is empty';
    } else if (!filter_var($semail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is invalid';
    }

    if (!empty($errors)) {
        $allErrors = join('<br/>', $errors);
        $errorMessage = "<p style='color: red;'>{$allErrors}</p>";
    } else {
        $toEmail = 'support@apeksya.com';
        $emailSubject = 'New email to Subscribe APEKSYA';
        $headers = ['From' => $semail, 'Reply-To' => $semail, 'Content-type' => 'text/html; charset=iso-8859-1'];

        $bodyParagraphs = ["Email: {$semail}"];
        $body = join(PHP_EOL, $bodyParagraphs);

        if (mail($toEmail, $emailSubject, $body, $headers)) {
            header('Location: sthankyou.html');
        } else {
            $errorMessage = "<p style='color: red;'>Oops, something went wrong. Please try again later</p>";
        }
    }
}

?>