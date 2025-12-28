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
            error_log("Email template missing: {$templatePath}");
            return;
        }

        ob_start();
        require $templatePath;
        $body = ob_get_clean();

        $payload = [
            'from' => [
                'email' => MAIL_FROM_EMAIL,
                'name'  => MAIL_FROM_NAME
            ],
            'to' => [
                [
                    'email' => $to
                ]
            ],
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
            error_log('MailerSend API error: ' . $response);
        }
    }
}
