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

class Tpl
{


    public $template_path = "views/"; # Шлях до каталогу з шаблонами
    public $template      = DEFAULT_TEMPLATE; # Стандартний файл шаблону


    // constructor


    function Tpl ()
    {
        $this->db = new DB();

        //$this->tpl = new Tpl();

        return TRUE;
    }


    #	Функція, яка зчитує HTML шаблон з файлу
    #   INPUT:
    #		srting  $file   - файл HTML шаблону
    #	OUTPUT:
    #		srting $tpl


    function ReadTpl ($file = "")
    {

        if ($file == "") {
            $file = $this->template_path.$this->template;
        } else {
            $file = $this->template_path.$file;
        }

        if (is_file ($file)) # Перевіряємо чи існує заданий шаблон
        {
            $strarr = file ($file); # Зчитуємо порядково шаблон в масив
            $tpl    = "";
            foreach ($strarr as $val) # Конвертуємо масив
            {
                if ($val != "") {
                    $tpl .= $val; # в строку
                }
            }
            if ($tpl != "") {
                return $tpl;
            }

        } else {
            echo "Не вдалось завантажити шаблон: ".$file;
            //return $this->ReadTpl ( "templates/not-tpl.tpl" );
        }
    }


    #	Функція, яка заміняє ключові слова в шаблоні на їхні значення
    #   INPUT:
    #		srting  $Tpl         - Шаблон, де буде проводитись заміна
    #		array    $ReplaceArr - Масив значень, які потрібно замінити
    #	OUTPUT:
    #		srting $Tpl


    function ReplceTpl ($Tpl, $ReplaceArr = array ("a" => "b"))
    {

        //$Tpl = $this->ReadTpl ( $TplFile ); // зчитую шаблон


        if (is_array ($ReplaceArr)) {
            foreach ($ReplaceArr as $key => $val) {
                $Tpl = str_ireplace ("{".$key."}", $val, $Tpl); # Заміняємо ключові слова у шаблоні
            }

            preg_match_all ("/{[a-zA-Z0-9_]*}/", $Tpl,
                $maches); # Шукаємо чи залишились у шаблоні не замінені ключові слова
            $maches = $maches[0];
            if (is_array ($maches) and count ($maches) > 0) {
                $ErrorKey = "";
                foreach ($maches as $err) {
                    $ErrorKey .= $err." | ";
                }

                //$lcErrorText = "Не вдалось замінити у шаблоні " . $TplFile . " наступні ключові слова: " . $ErrorKey;
                //$this->db->LogError($lcErrorText);                # Записуємо в базу ключові слова, яі не вдалось замінити

                $Tpl = preg_replace ("/{[a-zA-Z0-9_]*}/", "",
                    $Tpl); # Видаляємо зі шаблоні ключові слова які не вдалось замінити
            }

            return $Tpl;
        }

    }


    /**
     * @param $arrOut
     * array from module
     *
     * @return string
     */
    function render ($arrOut)
    {

        $template = $this->ReadTpl ("layouts/home.html");


        /*if (isset($_SESSION['log']) and !empty($_SESSION['log'])) {
            $authArr = array (
                'user_name' => $_SESSION['UserName']
            );

            $authBlock = $this->ReadTpl ("app/_authorized_block.html");
            $authBlock = $this->ReplceTpl ($authBlock, $authArr);

            $loginForm = "";
        } else {
            $authArr = array (
                'login_button' => LOGIN_BUTTON
            );

            $authBlock = $this->ReadTpl ("app/_not_authorized_block.html");
            $authBlock = $this->ReplceTpl ($authBlock, $authArr);

            $loginhArr = array (
                'login_popup_title'        => LOGIN_POPUP_TITLE,
                'login_popup_login_label'  => LOGIN_POPUP_LOGIN_LABEL,
                'login_popup_pswd_label'   => LOGIN_POPUP_PSWD_LABEL,
                'login_popup_forgot_pswd'  => LOGIN_POPUP_FORGOT_PSWD,
                'login_popup_login_button' => LOGIN_POPUP_LOGIN_BUTTON,
                'login_popup_no_account'   => LOGIN_POPUP_NO_ACCOUNT,
                'login_popup_reg_link'     => LOGIN_POPUP_REG_LINK,
            );

            $loginForm = $this->ReadTpl ("app/_login_form.html");
            $loginForm = $this->ReplceTpl ($loginForm, $loginhArr);
        }*/


        $arr = array (

            'catalog_menu' => $this->catalogMenu (),

        );

        $result_arr = array_merge ($arr, $arrOut);


        $tpl = $this->ReplceTpl ($template, $result_arr);


        return $tpl;
    }


    function replaceParamUrl ($var, $value, $url = NULL)
    {

        if (!$url) {
            $url = $_SERVER['REQUEST_URI'];
        }

        if ($_SERVER['QUERY_STRING'] == "") {
            return $url."?".$var."=".$value;
        } else {
            if (substr_count ($_SERVER['QUERY_STRING'], $var."=") > 0) {

                parse_str (parse_url ($url, PHP_URL_QUERY), $parameters);
                //$parameters[$var] = $value;

                $search  = $var."=".$parameters[ $var ];
                $replase = $var."=".$value;

                return str_replace ($search, $replase, $url);
            } else {
                return $url."&".$var."=".$value;
            }
        }
    }


    function deleteParamUrl ($var, $url = '')
    {

        $url = empty($url) ? $_SERVER['REQUEST_URI'] : $url;

        if ($_SERVER['QUERY_STRING'] == "") {
            return $url;
        } else {
            if (substr_count ($_SERVER['QUERY_STRING'], $var."=") > 0) {

                parse_str (parse_url ($url, PHP_URL_QUERY), $parameters);
                //$parameters[$var] = $value;

                $search  = "&".$var."=".$parameters[ $var ];
                $replase = "";

                return str_replace ($search, $replase, $url);
            } else {
                return $url;
            }
        }
    }


    function catalogMenu ()
    {

        //return $Tpl = $this->ReadTpl ("app/_catalog_structure.html");
        //$this->ReplceTpl ($authBlock, $authArr);

        $lcQry    = "SELECT * FROM tgrpware where onsite=1 and idtgrpware not in (11,6) order by sort";
        $lnId     = $this->db->Qry ($lcQry);
        $rowCount = $this->db->RowCount ($lnId);

        $firstCol  = ceil ($rowCount / 2);
        $secondCol = $rowCount - $firstCol;

        $loData = $this->db->getObject ($lnId);

        $firstColHtml  = "";
        $secondColHtml = "";

        $Tpl = $this->ReadTpl ("app/_catalog_structure.html");

        $i = 0;
        foreach ($loData as $item) {


            if ($i < $firstCol) {
                $firstColHtml .= '<li class="catalog-item-left"><a href="/catalog/'.$item->translit_name.'">'.$item->grpwarename.'</a></li>';
            } else {
                $secondColHtml .= '<li class="catalog-item"><a href="/catalog/'.$item->translit_name.'">'.$item->grpwarename.'</a></li>';
            }

            $i++;
        }

        $oneArr = array (
            'firstCol'  => $firstColHtml,
            'secondCol' => $secondColHtml
        );

        return $this->ReplceTpl ($Tpl, $oneArr);


        //return $Html;
    }


    function ajaxOk ($text = "")
    {
        $data['status'] = "OK";
        $data['text']   = $text;
        echo json_encode ($data);
        die;
    }

    function ajaxErr ($text)
    {
        $data['status'] = "ERROR";
        $data['text']   = $text;
        echo json_encode ($data);
        die;
    }


    function notAuthorizedPage ()
    {
        $arr = array (
            'text' => NOT_AUTHORIZED
        );

        $tpl = $this->ReadTpl ("app/_not-authorized_page.html");

        return $this->ReplceTpl ($tpl, $arr);
    }


    function citePopup ()
    {
        $arr = array (
            'text'  => RULES_OF_CITATION_TEXT,
            'close' => CLOSE
        );

        $tpl = $this->ReadTpl ("app/_info_popup_for_citation.html");

        return $this->ReplceTpl ($tpl, $arr);
    }


    function LoadCss ($FilesCss)
    {
        if (is_array ($FilesCss)) {
            $CssLink = "";
            foreach ($FilesCss as $val) {
                if (empty($val)) continue;
                $CssLink .= "<link href='css/".$val."' rel='stylesheet' type='text/css' />\n";
            }

            return $CssLink;
        } else {
            return "<link href='css/".$FilesCss."' rel='stylesheet' type='text/css' />\n";
        }
    }


    #	Функція, будує лінки на JS files
    #   INPUT:
    #		array    $FilesJs - Масив імен js файлів
    #	OUTPUT:
    #		srting $JsLink

    function LoadJs ($FilesJs)
    {
        if (is_array ($FilesJs)) {
            $JsLink = "";
            foreach ($FilesJs as $val) {
                if (empty($val)) continue;
                $JsLink .= "<script type='text/javascript' language='javascript' src='/js/".$val."'></script>\n";
            }

            return $JsLink;
        } else {
            return "<script type='text/javascript' language='javascript' src='/js/".$FilesJs."'></script>\n";
        }
    }


    public function getRemoteIPAddress ()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];

        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $_SERVER['REMOTE_ADDR'];
    }

    function callPhone ($phone)
    {
        $search  = array (
            "(",
            ")",
            "-",
            " "
        );
        $replace = array (
            "",
            "",
            "",
            ""
        );

        return str_ireplace ($search, $replace, $phone);
    }


    function dropDownIcon ()
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" fill="#000000" height="24" viewBox="0 0 24 24" width="24">
                    <path d="M7 10l5 5 5-5z"></path>
                    <path d="M0 0h24v24H0z" fill="none"></path>
                </svg>';
    }


    function print_paginator ($start, $page, $total_pages, $limit)
    {

        //echo $total_pages;

        // Initial page num setup
        if ($page == 0) {
            $page = 1;
        }
        $prev       = $page - 1;
        $next       = $page + 1;
        $lastpage   = ceil ($total_pages / $limit);
        $LastPagem1 = $lastpage - 1;

        $stages   = 3;
        $paginate = '';
        if ($lastpage > 1) {

            $paginate .= "<div class='paginate'>";

            // Pages
            if ($lastpage < 7 + ($stages * 2)) // Not enough pages to breaking it up
            {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page) {
                        $paginate .= "<a class='paginate_current'>$counter</a>";
                    } else {
                        $paginate .= "<a href='".$this->replaceParamUrl ("page", $counter)."'>$counter</a>";
                    }
                }
            } elseif ($lastpage > 5 + ($stages * 2)) // Enough pages to hide a few?
            {
                // Beginning only hide later pages
                if ($page < 1 + ($stages * 2)) {
                    for ($counter = 1; $counter < 4 + ($stages * 2); $counter++) {
                        if ($counter == $page) {
                            $paginate .= "<a class='paginate_current'>$counter</a>";
                        } else {
                            $paginate .= "<a href='".$this->replaceParamUrl ("page", $counter)."'>$counter</a>";
                        }
                    }
                    $paginate .= "...";
                    $paginate .= "<a href='".$this->replaceParamUrl ("page", $LastPagem1)."'>$LastPagem1</a>";
                    $paginate .= "<a href='".$this->replaceParamUrl ("page", $lastpage)."'>$lastpage</a>";
                } // Middle hide some front and some back
                elseif ($lastpage - ($stages * 2) > $page && $page > ($stages * 2)) {
                    $paginate .= "<a href='".$this->replaceParamUrl ("page", 1)."'>1</a>";
                    $paginate .= "<a href='".$this->replaceParamUrl ("page", 2)."'>2</a>";
                    $paginate .= "...";
                    for ($counter = $page - $stages; $counter <= $page + $stages; $counter++) {
                        if ($counter == $page) {
                            $paginate .= "<a class='paginate_current'>$counter</a>";
                        } else {
                            $paginate .= "<a href='".$this->replaceParamUrl ("page", $counter)."'>$counter</a>";
                        }
                    }
                    $paginate .= "...";
                    $paginate .= "<a href='".$this->replaceParamUrl ("page", $LastPagem1)."'>$LastPagem1</a>";
                    $paginate .= "<a href='".$this->replaceParamUrl ("page", $lastpage)."'>$lastpage</a>";
                } // End only hide early pages
                else {
                    $paginate .= "<a href='".$this->replaceParamUrl ("page", 1)."'>1</a>";
                    $paginate .= "<a href='".$this->replaceParamUrl ("page", 2)."'>2</a>";
                    $paginate .= "...";
                    for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page) {
                            $paginate .= "<a class='paginate_current'>$counter</a>";
                        } else {
                            $paginate .= "<a href='".$this->replaceParamUrl ("page", $counter)."'>$counter</a>";
                        }
                    }
                }
            }


            $paginate .= "</div>";


        }

        // pagination
        return $paginate;
    }

    function getUrl ()
    {
        $url = @($_SERVER["HTTPS"] != 'on') ? 'http://'.$_SERVER["SERVER_NAME"] : 'https://'.$_SERVER["SERVER_NAME"];
        $url .= ($_SERVER["SERVER_PORT"] != 80) ? ":".$_SERVER["SERVER_PORT"] : "";
        $url .= $_SERVER["REQUEST_URI"];

        return $url;
    }


    function FB_script ()
    {
        return "<script>(function(d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return;
                            js = d.createElement(s); js.id = id;
                            js.src = '//connect.facebook.net/uk_UA/sdk.js#xfbml=1&version=v2.3';
                            fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>";
    }


}
