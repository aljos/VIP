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

class  TCore
{


    // constructor
    function TCore ()
    {
        require ("config/main_conf.php");
        require ("classes/TDBclass.php");
        require ("classes/TTPLclass.php");
        require ("classes/TAuthClass.php");
        require ("classes/TBlockClass.php");
        require ("classes/TSenderClass.php");


        $_SESSION['idCat'] = empty($_SESSION['idCat']) ? DEFAULT_CAT : $_SESSION['idCat'];


        $this->tpl  = new Tpl();
        $this->auth = new TAuth();
        $this->db   = new DB();
        //$this->block  = new TBlock();
        $this->sender = new Sender();

        return TRUE;
    }


    function pluralForm ($n, $form1, $form2, $form5)
    {
        $n  = abs ($n) % 100;
        $n1 = $n % 10;
        if ($n > 10 && $n < 20) return $form5;
        if ($n1 > 1 && $n1 < 5) return $form2;
        if ($n1 == 1) return $form1;

        return $form5;
    }


    function translit ($string)
    {

        $trans = array ("а" => "a",
                        "б" => "b",
                        "в" => "v",
                        "г" => "h",
                        "д" => "d",
                        "е" => "e",
                        "є" => "ye",
                        "ж" => "zh",
                        "з" => "z",
                        "и" => "y",
                        "і" => "i",
                        "ї" => "yi",
                        "й" => "y",
                        "к" => "k",
                        "л" => "l",
                        "м" => "m",
                        "н" => "n",
                        "о" => "o",
                        "п" => "p",
                        "р" => "r",
                        "с" => "s",
                        "т" => "t",
                        "у" => "u",
                        "ф" => "f",
                        "х" => "kh",
                        "ц" => "ts",
                        "ч" => "ch",
                        "ш" => "sh",
                        "щ" => "sch",
                        "ю" => "yu",
                        "я" => "ya",
                        "ь" => "",

                        "А" => "A",
                        "Б" => "B",
                        "В" => "V",
                        "Г" => "H",
                        "Д" => "D",
                        "Е" => "E",
                        "Є" => "Ye",
                        "Ж" => "Zh",
                        "З" => "Z",
                        "И" => "Y",
                        "І" => "I",
                        "Ї" => "Yi",
                        "Й" => "Y",
                        "К" => "K",
                        "Л" => "L",
                        "М" => "M",
                        "Н" => "N",
                        "О" => "O",
                        "П" => "P",
                        "Р" => "R",
                        "С" => "S",
                        "Т" => "T",
                        "У" => "U",
                        "Ф" => "F",
                        "Х" => "Kh",
                        "Ц" => "Ts",
                        "Ч" => "Ch",
                        "Ш" => "Sh",
                        "Щ" => "Sch",
                        "Ю" => "Yu",
                        "Я" => "Ya",
                        "Ь" => "",
                        "ы" => "y",
                        "э" => "е",
                        "Ы" => "Y",

                        "`"     => "",
                        "’"     => "",
                        "'"     => "",
                        "."     => "_",
                        "("     => "_",
                        ")"     => "_",
                        ","     => "",
                        ">"     => "_less_",
                        "<"     => "_over_",
                        '"'     => "",
                        "_"     => "",
                        " "     => "-",
                        "№"     => "Numb",
                        "/"     => "_",
                        "%"     => "proc",
                        "&"     => "_and_",
                        "&amp;" => "_and_",
                        "+"     => "_plus_",
                        "?"     => "",
                        "!"     => "");

        return strtr ($string, $trans);

    }


    function translit_rus ($string)
    {

        $converter = array ('а' => 'a',
                            'б' => 'b',
                            'в' => 'v',
                            'г' => 'h',
                            'д' => 'd',
                            'е' => 'e',
                            'ё' => 'e',
                            'ж' => 'zh',
                            'з' => 'z',
                            'и' => 'i',
                            'й' => 'y',
                            'к' => 'k',
                            'л' => 'l',
                            'м' => 'm',
                            'н' => 'n',
                            'о' => 'o',
                            'п' => 'p',
                            'р' => 'r',
                            'с' => 's',
                            'т' => 't',
                            'у' => 'u',
                            'ф' => 'f',
                            'х' => 'kh',
                            'ц' => 'ts',
                            'ч' => 'ch',
                            'ш' => 'sh',
                            'щ' => 'sch',
                            'ь' => "",
                            'ы' => 'y',
                            'ъ' => "",
                            'э' => 'e',
                            'ю' => 'yu',
                            'я' => 'ya',
                            'і' => 'i',
                            'ї' => 'yi',
                            'є' => 'ye',

                            'А' => 'A',
                            'Б' => 'B',
                            'В' => 'V',
                            'Г' => 'H',
                            'Д' => 'D',
                            'Е' => 'E',
                            'Ё' => 'E',
                            'Ж' => 'Zh',
                            'З' => 'Z',
                            'И' => 'I',
                            'Й' => 'Y',
                            'К' => 'K',
                            'Л' => 'L',
                            'М' => 'M',
                            'Н' => 'N',
                            'О' => 'O',
                            'П' => 'P',
                            'Р' => 'R',
                            'С' => 'S',
                            'Т' => 'T',
                            'У' => 'U',
                            'Ф' => 'F',
                            'Х' => 'Kh',
                            'Ц' => 'Ts',
                            'Ч' => 'Ch',
                            'Ш' => 'Sh',
                            'Щ' => 'Sch',
                            'Ь' => "",
                            'Ы' => 'Y',
                            'Ъ' => "",
                            'Э' => 'E',
                            'Ю' => 'Yu',
                            'Я' => 'Ya',
                            'І' => 'I',
                            'Ї' => 'Yi',
                            'Є' => 'Ye',

                            "`"     => "",
                            "’"     => "",
                            "'"     => "",
                            "."     => "_",
                            "("     => "_",
                            ")"     => "_",
                            ","     => "",
                            ">"     => "_less_",
                            "<"     => "_over_",
                            '"'     => "",
                            "_"     => "",
                            " "     => "-",
                            "№"     => "Numb",
                            "/"     => "_",
                            "%"     => "proc",
                            "&"     => "_and_",
                            "&amp;" => "_and_",
                            "+"     => "_plus_",
                            "?"     => "",
                            "!"     => "");

        return strtr ($string, $converter);
    }


}