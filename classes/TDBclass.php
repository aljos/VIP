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


class DB
{

    // Встановлюємо зєднання з базою даних
    function DB ()
    {
        global $pnCH;
        $pnCH = mysqli_connect (DB_HOST, DB_USER, DB_PSWD) or die ("Не можливо створити з*єднання з базою даних");
        mysqli_select_db ($pnCH, DB_NAME) or die ("Не можливо вибрати базу");
        mysqli_query ($pnCH, DB_CHARSET); //Задаємо кодування для бази даних
        return TRUE;
    }


    #	Функція, яка відсилає запит до бази даних
    #   INPUT:
    #		srting  $Qry   - SQL запит
    #       boolean $log   - Чи потрібно логувати запит
    #       srting  $descr - Опис запиту
    #	OUTPUT:
    #		boolean or resource $lnID
    function Qry ($Qry, $log = FALSE, $descr = "")
    {
        global $pnCH;
        //echo $Qry;
        $lnID = mysqli_query ($pnCH, $Qry);
        if (!$lnID) {
            $lcErrorText = "Не вдалось виконати запит: ".$Qry." || ".mysqli_errno ($pnCH)." : ".mysqli_error ($pnCH);
            $this->LogError ($lcErrorText);

            return FALSE;
        } else {
            if ($log) {
                $this->log_query ($Qry, $descr);
            }

            return $lnID;
        }
    }


    #	Функція, яка відсилає запит до бази даних
    #   INPUT:
    #		srting  $Qry   - SQL запит
    #       boolean $log   - Чи потрібно логувати запит
    #       srting  $descr - Опис запиту
    #	OUTPUT:
    #		boolean or resource $lnID
    function multiQry ($Qry, $log = FALSE, $descr = "")
    {
        global $pnCH;
        //echo $Qry;
        $lnID = mysqli_multi_query ($pnCH, $Qry);
        if (!$lnID) {
            $lcErrorText = "Не вдалось виконати запит: ".$Qry." || ".mysqli_errno ($pnCH)." : ".mysqli_error ($pnCH);
            $this->LogError ($lcErrorText);

            return FALSE;
        } else {
            if ($log) {
                $this->log_query ($Qry, $descr);
            }

            return $lnID;
        }
    }


    #	Функція, для екранування змінних
    #   INPUT:
    #		srting $value
    #	OUTPUT:
    #       srting $value
    # !!!!!!!!!переробити щоб можня було передавати масив!!!!!!!!!!!!!!!1
    function prepare ($value, $escape = TRUE)
    {
        global $pnCH;
        $search  = array (
            chr (92),
            "C:/fakepath/",
            " union ",
            " select ",
            " delete ",
            " or ",
            " exec "
        );
        $replace = array (
            '',
            "",
            "",
            "",
            "",
            "",
            ""
        );
        $value   = str_ireplace ($search, $replace, $value);
        if ($escape) {
            // якщо magic_quotes_gpc включена - використовуємо stripslashes
            if (get_magic_quotes_gpc ()) {
                $value = stripslashes ($value);
            }
            // Якщо змінна - число, то екранувати її не потрібно
            // Якщо ні - то беремо її в кавички, та екрануємо
            if (!is_numeric ($value)) {
                $value = "'".mysqli_real_escape_string ($pnCH, $value)."'";
            }
        }

        return $value;
    }

    function floatData ($value)
    {
        $value = (float)str_replace (",", ".", $value);

        return $value;
    }


    #	Функція, яка повертає масив з обєктами записів
    #   INPUT:
    #		resource $lnID - Вказівник на результат запиту
    #	OUTPUT:
    #       array
    function getObject ($lnID)
    {
        $array = array ();
        while ($row = @mysqli_fetch_object ($lnID)) {
            $array[] = $row;
        }

        return $array;
    }


    #	Функція, яка повертає обєкт одного запису
    #   INPUT:
    #		resource $lnID - Вказівник на результат запиту
    #	OUTPUT:
    #       object
    function getOneObject ($lnID)
    {
        $row = mysqli_fetch_object ($lnID);

        return $row;
    }


    /*function getArray ($lnID)
    {
        while ($row = mysqli_fetch_array ($lnID)) {
            extract ($row);
            $datetime *= 1000; // convert from Unix timestamp to JavaScript time
            $data[] = "[$datetime, $value]";
        }
    }*/


    #	Функція, яка повертає кількіть записів після виконання запиту
    #   INPUT:
    #		resource $lnID - Вказівник на результат запиту
    #	OUTPUT:
    #       integer к-ть записів
    function RowCount ($lnID)
    {
        if ($lnID) {
            return @mysqli_num_rows ($lnID);
        } else {
            return FALSE;
        }

    }

    function getVarSetting ($varName)
    {
        $lcQry  = "SELECT value FROM t_admin_var WHERE name ='".$varName."'";
        $lnID   = $this->Qry ($lcQry);
        $loData = $this->getOneObject ($lnID);

        return $loData->value;
    }



    #	Функція, яка конвертує дату дд.мм.рр в рр-мм-дд
    #   INPUT:
    #		$date - дата
    #	OUTPUT:
    #       $date - дата Mysql
    function DateToMysql ($date)
    {
        $dateArr = explode (".", $date);
        $newDate = $dateArr[2]."-".$dateArr[1]."-".$dateArr[0];

        return $newDate;
    }

    function ConvertDateMySQLToUkr ($value, $lang = "ua")
    {
        $Dt     = explode (" ", $value); //Розбиваємо на дату і час
        $lcDate = explode ("-", $Dt[0]); //Розбиваємо дату на рік місяць день
        if ($lang == "ua") {
            return $lcDate[2].' '.self::ukrMonth ($lcDate[1], $lang).' '.$lcDate[0];
        } else {
            return self::ukrMonth ($lcDate[1], $lang).' '.$lcDate[2].', '.$lcDate[0];
        }

    }

    function toUkrDataTime ($value, $lang = "ua")
    {
        $Dt     = explode (" ", $value); //Розбиваємо на дату і час
        $lcDate = explode ("-", $Dt[0]); //Розбиваємо дату на рік місяць день
        if ($lang == "ua") {
            return $lcDate[2].' '.self::ukrMonth ($lcDate[1], $lang).' '.$lcDate[0].' '.$Dt[1];
        } else {
            return self::ukrMonth ($lcDate[1], $lang).' '.$lcDate[2].', '.$lcDate[0].' '.$Dt[1];
        }

    }

    function getFieldByID ($table, $field, $id)
    {
        $lcQry  = "select ".$field." from ".$table." where id".$table."=".$id;
        $lnID   = $this->Qry ($lcQry);
        $loData = $this->getOneObject ($lnID);

        return $loData->$field;
    }


    function setFieldByID ($table, $field, $val, $id)
    {
        $lcQry = "update ".$table." set ".$field."=".$val." where id".$table."=".$id;

        if ($this->Qry ($lcQry)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    #	Функція, яка заносить в базу інфо про дії користувачів (логи)
    #   INPUT:
    #		string $logQry - Запит для логу
    #       string $Descr  - Опис запиту
    #	OUTPUT:
    #       none
    # Доробити ПАРСЕР запитів!!!!
    function log_query ($logQry, $descr = "")
    {
        $lcQry  = "SELECT login FROM t_admin_user WHERE idt_admin_user=".(int)$_SESSION['idAdmin'];
        $lnId   = $this->Qry ($lcQry);
        $loData = $this->getOneObject ($lnId);
        $login  = $loData->login;
        $lcQry  = "INSERT INTO t_admin_log (login, IP, descr, query)
		VALUES('".$login."','".$_SERVER['REMOTE_ADDR']."','".$descr."', '".addslashes ($logQry)."')";
        $this->Qry ($lcQry);

    }


    #	Функція, яка заносить в базу інфо про невдалі запити
    #   INPUT:
    #		string $qry - Запит де сталась помилка
    #	OUTPUT:
    #       none
    function LogError ($lcErrorText)
    {
        global $pnCH;
        $lcQry = "INSERT INTO t_admin_error (error, url)
		VALUES('".addslashes ($lcErrorText)."','".$_SERVER['REQUEST_URI']."')";
        mysqli_query ($pnCH, $lcQry);
    }

    //Конвертуємо номер місяця у його укр. назву
    function ukrMonth ($Month, $lang = "ua")
    {
        switch ($Month) {
            case 1:
                $lcMonth["ua"] = "січня";
                $lcMonth["ru"] = "января";
                $lcMonth["en"] = "January";
                break;
            case 2:
                $lcMonth["ua"] = "лютого";
                $lcMonth["ru"] = "февраля";
                $lcMonth["en"] = "February";
                break;
            case 3:
                $lcMonth["ua"] = "березня";
                $lcMonth["ru"] = "марта";
                $lcMonth["en"] = "March";
                break;
            case 4:
                $lcMonth["ua"] = "квітня";
                $lcMonth["ru"] = "апреля";
                $lcMonth["en"] = "April";
                break;
            case 5:
                $lcMonth["ua"] = "травня";
                $lcMonth["ru"] = "мая";
                $lcMonth["en"] = "May";
                break;
            case 6:
                $lcMonth["ua"] = "червня";
                $lcMonth["ru"] = "июня";
                $lcMonth["en"] = "June";
                break;
            case 7:
                $lcMonth["ua"] = "липня";
                $lcMonth["ru"] = "июля";
                $lcMonth["en"] = "July";
                break;
            case 8:
                $lcMonth["ua"] = "серпня";
                $lcMonth["ru"] = "августа";
                $lcMonth["en"] = "August";
                break;
            case 9:
                $lcMonth["ua"] = "вересня";
                $lcMonth["ru"] = "сентября";
                $lcMonth["en"] = "September";
                break;
            case 10:
                $lcMonth["ua"] = "жовтня";
                $lcMonth["ru"] = "октября";
                $lcMonth["en"] = "October";
                break;
            case 11:
                $lcMonth["ua"] = "листопада";
                $lcMonth["ru"] = "ноября";
                $lcMonth["en"] = "November";
                break;
            case 12:
                $lcMonth["ua"] = "грудня";
                $lcMonth["ru"] = "декабря";
                $lcMonth["en"] = "December";
                break;
            case 0:
                $lcMonth["ua"] = $Month;
                $lcMonth["ru"] = $Month;
                $lcMonth["en"] = $Month;
                break;
        }

        return $lcMonth[ $lang ];
    }


    //ToDo Конвертуємо номер дня у його укр. назву
    function ukrDays ($day, $lang = "ua")
    {
        switch ($day) {
            case 1:
                $lcMonth["ua"] = "січня";
                $lcMonth["ru"] = "января";
                $lcMonth["en"] = "January";
                break;
            case 2:
                $lcMonth["ua"] = "лютого";
                $lcMonth["ru"] = "февраля";
                $lcMonth["en"] = "February";
                break;
            case 3:
                $lcMonth["ua"] = "березня";
                $lcMonth["ru"] = "марта";
                $lcMonth["en"] = "March";
                break;
            case 4:
                $lcMonth["ua"] = "квітня";
                $lcMonth["ru"] = "апреля";
                $lcMonth["en"] = "April";
                break;
            case 5:
                $lcMonth["ua"] = "травня";
                $lcMonth["ru"] = "мая";
                $lcMonth["en"] = "May";
                break;
            case 6:
                $lcMonth["ua"] = "червня";
                $lcMonth["ru"] = "июня";
                $lcMonth["en"] = "June";
                break;
            case 7:
                $lcMonth["ua"] = "липня";
                $lcMonth["ru"] = "июля";
                $lcMonth["en"] = "July";
                break;
            case 8:
                $lcMonth["ua"] = "серпня";
                $lcMonth["ru"] = "августа";
                $lcMonth["en"] = "August";
                break;
            case 9:
                $lcMonth["ua"] = "вересня";
                $lcMonth["ru"] = "сентября";
                $lcMonth["en"] = "September";
                break;
            case 10:
                $lcMonth["ua"] = "жовтня";
                $lcMonth["ru"] = "октября";
                $lcMonth["en"] = "October";
                break;
            case 11:
                $lcMonth["ua"] = "листопада";
                $lcMonth["ru"] = "ноября";
                $lcMonth["en"] = "November";
                break;
            case 12:
                $lcMonth["ua"] = "грудня";
                $lcMonth["ru"] = "декабря";
                $lcMonth["en"] = "December";
                break;
            case 0:
                $lcMonth["ua"] = $Month;
                $lcMonth["ru"] = $Month;
                $lcMonth["en"] = $Month;
                break;
        }

        return $lcMonth[ $lang ];
    }


    function csrf_token ()
    {
        return sha1 (base64_encode (date ("Y.m.d").$_SESSION['log']));
    }

}
