<?php

namespace App\Component;

use App\Entity\ResetPasswordRequests;

class Email
{
    const DEFAULT_EMAIL = 'service.blindtyper@gmail.com';
    const NO_REPLY_EMAIL = 'noreply@gmail.com';

    public static function send(string $to, string $subject, string $message, bool $noReply = false)
    {
        $headers  = "Content-type: text/html; charset=windows-1251 \r\n";
        $headers .= "From: BlindTyper <". self::DEFAULT_EMAIL .">\r\n";
        $headers .= "Reply-To: ". ($noReply == false ? self::DEFAULT_EMAIL : self::NO_REPLY_EMAIL) ."\r\n";

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
        This link will be available for ". ResetPasswordRequests::HOURS_AVAILABLE ." hours.<br>
        If you didn't ask to change your password, don't worry! Your password is still safe and you can delete this email.<br><br>
        Best regards,<br> BlindTyper</span>
        ";
    }
}