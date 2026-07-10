<?php

function sendLinkRecoveryMail() {
    $message = "ssdssd";
    $emailsubject = 'dsfdsdfs';
    $emailsender = 'emailsender';
    $site_name = 'site_name';
    //$emailsubject = $modx->config['emailsubject'];
    //$emailsender = $modx->config['emailsender'];
    //$site_name = $modx->config['site_name'];
    $sent = mail($email, "Ссылка для похода $site_name",$message,
            "From: ".$emailsender."\r\n"."X-Mailer: MODx Content Manager - PHP/".phpversion());
}