<?php

namespace App\Component;

class Email
{
    const DEFAULT_EMAIL = 'service.blindtyper@gmail.com';

    public static function send(string $to, string $subject, string $message)
    {
        $headers  = "Content-type: text/html; charset=windows-1251 \r\n";
        $headers .= "From: BlindTyper <". self::DEFAULT_EMAIL .">\r\n";
        $headers .= "Reply-To: ". self::DEFAULT_EMAIL ."\r\n";

        $errors = [];
        $result = mail($to, $subject, $message, $headers);
        if ($result == false) {
            $errors[] = "Message wasn't send, please try again later.";
        }

        return [
            'status' => empty($errors),
            'error' => $errors
        ];
    }

    public static function buildResetPasswordMessage($to, $link = '#')
    {
        return "
        <span style='font-size: 16px'>Hi, $to<br>
        We received a request to reset your password, just click on the button below to set a new password:<br>
        <a href='$link' style='padding: 10px 40px; line-height: 58px; text-decoration: none; background-color: #ffbb00; color: black; border-radius: 15px'>Set a new password</a><br>
        If you didn't ask to change your password, don't worry! Your password is still safe and you can delete this email.<br><br>
        Best regards,<br> BlindTyper</span>
        ";
    }
}