<?php

namespace App\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CustomEmailVerification
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function send()
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = env('MAIL_HOST');        // SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = env('MAIL_USERNAME');   // SMTP username
            $mail->Password   = env('MAIL_PASSWORD');   // SMTP password
            $mail->SMTPSecure = env('MAIL_ENCRYPTION'); // Encryption type
            $mail->Port       = env('MAIL_PORT');       // TCP port

            // Sender and recipient
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $mail->addAddress($this->user->email, $this->user->name);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = "Email Verification";
            $mail->Body = "Hello " . $this->user->name . ",<br><br>
            Click the link below to verify your email: <br>
            <a href='" . url('email/verify?token=' . $this->user->email_verification_token . '&id=' . $this->user->id) . "'>Verify Email</a><br><br>
            Your User ID: " . $this->user->id . " From now on use this ID to log in.<br><br>
            Thank you for registering!";


            // Send email
            $mail->send();
            return true;

        } catch (Exception $e) {
            \Illuminate\Support\Facades\Log::error("Email not sent: {$mail->ErrorInfo}");
            return false;
        }
    }

    // public function build()
    // {
    //     return $this->view('emails.verify')
    //         ->with(['user' => $this->user])
    //         ->subject('Email Verification');
    // }
}
