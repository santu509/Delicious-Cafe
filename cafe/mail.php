<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/PHPMailer/src/Exception.php';
require_once 'vendor/PHPMailer/src/PHPMailer.php';
require_once 'vendor/PHPMailer/src/SMTP.php';
if (!function_exists('orderMail')) {

function sendmail($name, $email, $subject, $message)
{
    $mail = new PHPMailer(true);

    try {

        // SMTP Configuration
        $mail->isSMTP();

        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;

        $mail->Username   = 'santusau2006@gmail.com';


        $mail->Password   = 'lohn qfyw axmi cqti';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;


        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            ]
        ];

        // Sender
        $mail->setFrom(
            'santusau2006@gmail.com',
            'Cafe Website'
        );

        // Receiver
        $mail->addAddress(
            'santusau2006@gmail.com'
        );

        // Reply To User
        $mail->addReplyTo(
            $email,
            $name
        );

        $mail->isHTML(true);

        $mail->Subject = "Contact Form Message : " . $subject;

        $mail->Body = "
        <div style='font-family:Arial;padding:20px'>
            <h2>New Contact Message</h2>

            <hr>

            <p><strong>Name:</strong> {$name}</p>

            <p><strong>Email:</strong> {$email}</p>

            <p><strong>Subject:</strong> {$subject}</p>

            <p><strong>Message:</strong></p>

            <p>{$message}</p>

        </div>
        ";

        $mail->AltBody =
            "Name: $name\n" .
            "Email: $email\n" .
            "Subject: $subject\n" .
            "Message: $message";

        if ($mail->send()) {
            return true;
        }

        return false;
    } catch (Exception $e) {

        echo "<pre>";
        echo "MAIL ERROR : " . $mail->ErrorInfo;
        echo "</pre>";

        return false;
    }
}
}


// order mail function
if (!function_exists('orderMail')) {
function orderMail(
    $customerName,
    $customerEmail,
    $productName,
    $qty,
    $price,
    $total,
    $paymentMethod
) {
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        $mail->Username = 'santusau2006@gmail.com';
        $mail->Password = 'lohn qfyw axmi cqti';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom(
            'santusau2006@gmail.com',
            'Cafe Website'
        );

        // Customer Mail
        $mail->addAddress($customerEmail);

        $mail->isHTML(true);

        $mail->Subject = "Order Confirmation";

        $mail->Body = "
        <h2>Thank You For Your Order ☕</h2>

        <p>Hello <b>$customerName</b>,</p>

        <p>Your order has been placed successfully.</p>

        <hr>

        <p><b>Product :</b> $productName</p>
        <p><b>Quantity :</b> $qty</p>
        <p><b>Price :</b> ₹$price</p>
        <p><b>Total :</b> ₹$total</p>
        <p><b>Payment :</b> $paymentMethod</p>
        <hr>

        <p>We will prepare your order soon.</p>

        <h3>Thank you for Choose Delicious Cafe ☕</h3>
        ";

        return $mail->send();
    } catch (Exception $e) {

        return false;
    }
}
}