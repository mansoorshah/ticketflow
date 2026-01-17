<?php

require_once __DIR__ . '/../vendor/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../vendor/PHPMailer/SMTP.php';
require_once __DIR__ . '/../vendor/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    public static function send(string $to, string $subject, string $template, array $data = [])
    {
        extract($data);

        $templatePath = __DIR__ . "/../mail/templates/{$template}.php";
        if (!file_exists($templatePath)) {
            EmailLogger::log("Email template missing", ['template' => $template]);
            return false;
        }

        ob_start();
        require $templatePath;
        $body = ob_get_clean();

        return match (MAIL_DRIVER) {
            'mailersend' => self::sendViaMailerSend($to, $subject, $body),
            'smtp'       => self::sendViaSMTP($to, $subject, $body),
            default      => throw new Exception('Invalid MAIL_DRIVER')
        };
    }

    // ==========================
    // SMTP (PHPMailer)
    // ==========================
    private static function sendViaSMTP(string $to, string $subject, string $body): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = MAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = MAIL_USERNAME;
            $mail->Password   = MAIL_PASSWORD;
            $mail->Port       = MAIL_PORT;

            $mail->SMTPSecure = MAIL_ENCRYPTION === 'ssl'
                ? PHPMailer::ENCRYPTION_SMTPS
                : PHPMailer::ENCRYPTION_STARTTLS;

            $mail->setFrom(MAIL_FROM_EMAIL, MAIL_FROM_NAME);
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();

            EmailLogger::log('Email sent via SMTP', ['to' => $to]);
            return true;

        } catch (Exception $e) {
            EmailLogger::log('SMTP mail failed', [
                'error' => $mail->ErrorInfo,
                'exception' => $e->getMessage()
            ]);
            return false;
        }
    }

    // ==========================
    // MailerSend API
    // ==========================
    private static function sendViaMailerSend(string $to, string $subject, string $body): bool
    {
        if (empty(MAILERSEND_API_TOKEN)) {
            EmailLogger::log('MailerSend token missing');
            return false;
        }

        $payload = [
            'from' => [
                'email' => MAIL_FROM_EMAIL,
                'name'  => MAIL_FROM_NAME
            ],
            'to' => [[ 'email' => $to ]],
            'subject' => $subject,
            'html' => $body
        ];

        $ch = curl_init('https://api.mailersend.com/v1/email');

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . MAILERSEND_API_TOKEN,
                'Content-Type: application/json'
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_TIMEOUT => 10
        ]);

        $response = curl_exec($ch);
        $status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($status >= 400) {
            EmailLogger::log('MailerSend API error', ['response' => $response]);
            return false;
        }

        EmailLogger::log('Email sent via MailerSend', ['to' => $to]);
        return true;
    }
}
