<?php

//require 'vendor/PHPMailer-master/PHPMailerAutoload.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mail
 *
 * @author Allan
 */
class Mail
{

    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer;

        $this->mail->isSMTP(); // Set mailer to use SMTP

        $this->mail->Host = MAIL_HOST; // Specify main and backup SMTP servers

        $this->mail->SMTPAuth = true; // Enable SMTP authentication

        $this->mail->Username = MAIL_USERNAME; // SMTP username

        $this->mail->Password = MAIL_PASSWORD; // SMTP password

        $this->mail->SMTPSecure = MAIL_ENCRYPTION_TYPE; // Enable TLS encryption, `ssl` also accepted

        $this->mail->Port = MAIL_PORT;
    }

    public function setFrom($email, $title)
    {
        $this->mail->setFrom($email, $title);
        return $this;
    }

    public function addAddress($email, $title)
    {
        $this->mail->addAddress($email, $title);
        return $this;
    }

    public function addReplyTo($email, $title)
    {
        $this->mail->addReplyTo($email, $title);
        return $this;
    }

    public function addCC($email)
    {
        $this->mail->addCC($email);
        return $this;
    }

    public function addBCC($email)
    {
        $this->mail->addBCC($email);
        return $this;
    }

    public function addAttachment($file_path)
    {
        $this->mail->addAttachment($file_path);
        return $this;
    }

    public function isHTML($isHTML = false)
    {
        $this->mail->isHTML($isHTML);
        return $this;
    }

    public function setBody($body)
    {
        $this->mail->Body = $body;
    }

    public function setAltBody($body)
    {
        $this->mail->AltBody = $body;
    }

    public function setSubject($subject)
    {
        $this->mail->Subject = $subject;
    }

    public function send()
    {
        if (!$this->mail->send()) {
            die($this->mail->ErrorInfo);
        } else {
            return true;
        }
    }

}
