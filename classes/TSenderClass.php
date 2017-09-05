<?php
/*
********************************************************************************
*   Project:        info.shuvar.com by PhpStorm
*   Description:    test.php
*   Author:         Matsiyevskyy Oleg
*   Created:        16.01.2017 11:48
*   Mail:           aljos@shuvar.com
********************************************************************************
*/

/**
 * Class Lang
 */
class Sender
{


    public $error;

    public $email_path  = "email/";      # Шлях до каталогу з шаблонами
    public $main_layout = "/_main.html"; # Стандартний файл шаблону


    function __construct ()
    {

        $this->db  = new DB();
        $this->tpl = new Tpl();


        return TRUE;
    }

    function SendEmail ($subject, $from_e, $from_n, $to_e, $to_n, $text)
    {


        require ("classes/class.phpmailer.php");
        require ("classes/class.smtp.php");


        $arr = array (
            'body' => $text
        );


        $tpl = $this->tpl->ReadTpl ($this->email_path."_main.html");
        $tpl = $this->tpl->ReplceTpl ($tpl, $arr);


        $mail           = new PHPMailer();
        $body           = $tpl;
        $mail->From     = $from_e;
        $mail->FromName = $from_n;
        $mail->Subject  = $subject;
        $mail->MsgHTML ($body);
        $mail->AddAddress ($to_e, $to_n);
        $mail->IsHTML (TRUE); // send as HTML
        if ($mail->Send ()) {
            return TRUE;
        } else {
            $this->error = $mail->ErrorInfo;

            return FALSE;
            //return $mail->ErrorInfo;
        }

    }


    function SendSMS ($number, $text)
    {

        // Need SOAP CLIENT!!!
        // Open new connection
        $client = new SoapClient('http://turbosms.in.ua/api/wsdl.html');

        // Auth
        $auth = array (
            'login'    => TURBO_SMS_LOGIN,
            'password' => TURBO_SMS_PSWD
        );

        // Авторизируемся на сервере
        $result = $client->Auth ($auth);
        if ($result->AuthResult == "Вы успешно авторизировались") {

            // Check balance
            $result = $client->GetCreditBalance ();
            if ($result->GetCreditBalanceResult > 0) {

                $sms    = array (
                    'sender'      => 'Shuvar',
                    'destination' => $number,
                    'text'        => $text
                );
                $result = $client->SendSMS ($sms);
                $result->SendSMSResult->ResultArray[0];

                return TRUE;

            } else {
                // if not enough money -  send email
                $this->error = "Не достатньо коштів";
                $this->SendEmail ("ТурбоСМС не достатньо коштів", "info@shuvar.com", "InfoShuvar", "o.aljos@gmail.com", "oleg", "Не достатньо коштів на рахунку Турбо СМС");

                return FALSE;
            }
        } else {
            $this->error = "Помилка авторизації";

            return FALSE;
        }
    }


}