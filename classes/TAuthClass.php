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


class TAuth
{


    // constructor
    function TAuth ()
    {

        $this->db = new DB();

        return TRUE;
    }


    #	Функція, яка логує користувача в системі
    #   INPUT:
    #		srting  $login   - логін
    #       srting  $pswd    - пароль
    #	OUTPUT:
    #		boolean
    function Login ($login, $pswd)
    {

        $login = $this->db->prepare ($login);
        $pswd  = $this->db->prepare ($pswd, FALSE);
        //$pswd  = self::hashPswd ($pswd);

        $lcQry      = "SELECT * FROM t_users WHERE login=".$login." AND pswd='".$pswd."'";
        $lnID       = $this->db->Qry ($lcQry);
        $lnRowCount = $this->db->RowCount ($lnID);

        if ($lnRowCount > 0) {
            $loUser = $this->db->getOneObject ($lnID);

            $lcLogHash              = $loUser->$pswd.date ("r").SALT;
            $_SESSION['log']        = sha1 ($lcLogHash);
            $_SESSION['idUser']     = $loUser->idt_users;
            $_SESSION['UserName']   = $loUser->fullname;
            $_SESSION['client_SVV'] = $loUser->client_SVV;

            $idUser = !empty($_SESSION['idUser']) ? $_SESSION['idUser'] : 0;
            $lcQry  = "DELETE FROM t_users_auth WHERE iduser=".(int)$idUser;
            $this->db->Qry ($lcQry);

            $lcQry = "INSERT INTO t_users_auth (iduser, log_hash)
	 	 	VALUES(".$_SESSION['idUser'].",'".$_SESSION['log']."')";
            $this->db->Qry ($lcQry);

            return $this->check_auth ();

        } else {
            return FALSE;
        }

    }


    #	Функція виходу користувача з системи
    #   INPUT:
    #		none
    #	OUTPUT:
    #		none
    function Logout ()
    {

        $idUser = !empty($_SESSION['idUser']) ? $_SESSION['idUser'] : 0;

        $lcQry = "DELETE FROM t_users_auth WHERE iduser=".(int)$idUser;
        $this->db->Qry ($lcQry);
        session_destroy ();

        unset($_SESSION['log']);

        return $this;
    }


    #	Функція, яка співставляє значення хешу в базі і хешу в сесійній змінній
    #   INPUT:
    #		none
    #	OUTPUT:
    #		boolean
    function check_auth ()
    {

        $idUser = !empty($_SESSION['idUser']) ? $_SESSION['idUser'] : 0;

        $lcQry  = "SELECT log_hash FROM t_users_auth WHERE iduser=".(int)$idUser;
        $lnId   = $this->db->Qry ($lcQry);
        $loHash = $this->db->getOneObject ($lnId);
        $lcHash = $loHash->log_hash;
        //echo $lcHash." ".$_SESSION['log'];
        if (($lcHash === $_SESSION['log']) and (!empty($lcHash)) and (isset($_SESSION['log']))) {

            return TRUE;
        } else {
            return FALSE;
        }
    }


    function hashPswd ($pswd)
    {
        return base64_encode ($pswd.SALT);
    }


}
