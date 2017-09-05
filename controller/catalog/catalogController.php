<?php

/*
********************************************************************************
*   Project:        info.shuvar.com by PhpStorm
*   Description:    TContactController.php
*   Author:         Matsiyevskyy Oleg
*   Created:        25.01.2017 10:22
*   Mail:           aljos@shuvar.com
********************************************************************************
*/

//require_once "controller/news/newsController.php";
//require_once "controller/event/eventController.php";

class catalogController
{


    function __construct ()
    {
        $this->db    = new DB();
        $this->block = new TBlock();
        $this->tpl   = new Tpl();
        //$this->news  = new newsController();
        //$this->event = new eventController();
    }


    function index ()
    {

        $arrContent = array (/*'main_banner'                         => self::mainBanner (),

            'person_block' => $this->personBlock (),

            'product_block_title' => PRODUCT_BLOCK_TITLE,
            'product_block'       => self::productBlock (),

            'project_block_title' => PROJECT_BLOCK_TITLE,
            'project_block'       => self::projectBlock (),

            'event_block_title' => EVENT_BLOCK_TITLE,
            'event_block'       => $this->event->listEvents (6),


            'view_all_link' => VIEW_ALL_LINK,*/

        );

        $tpl = $this->tpl->ReadTpl ("pages/catalog.html");
        $tpl = $this->tpl->ReplceTpl ($tpl, $arrContent);


        $arrPage = array (
            'content' => $tpl,
            //'script'  => $this->tpl->LoadJs (array ("characters_limit.js"))
        );

        $res_arr = array_merge ($arrPage, $this->pageSeo ());

        echo $this->tpl->render ($res_arr);

    }


    function productBlock ()
    {
        $lcQry  = "SELECT * FROM t_pavilions where onsite=1 order by sort limit 6";
        $lnId   = $this->db->Qry ($lcQry);
        $loData = $this->db->getObject ($lnId);

        $Tpl  = $this->tpl->ReadTpl ("app/_main_pavillions_block.html");
        $Html = "";

        $i = 0;
        foreach ($loData as $item) {

            $oneArr = array (
                'name'  => $this->db->TranslateValue ($item->name, $item->idt_pavilions, "name", "t_pavilions", $_SESSION['lang']),
                'photo' => $item->photo,
                'url'   => $item->translit_name
            );

            $Html .= $this->tpl->ReplceTpl ($Tpl, $oneArr);
            unset($oneArr);

            $i++;
        }


        return $Html;
    }


    function pageSeo ()
    {

        $arr = array (
            'page_title'    => 'Інтернет ринок `Шувар` | Доставка продуктів, доставка продуктів додому, доставка продуктів в офіс, доставка з Шувару',
            'page_descr'    => 'Доставка продуктів, доставка продуктів додому, доставка продуктів в офіс, доставка з Шувару',
            'page_keywords' => 'Доставка продуктів,доставка продуктів додому,доставка продуктів в офіс,доставка з Шувару,безкоштовна доставка,безкоштовна доставка з Шувару,безкоштовна доставка продуктів',
            'fb_url'        => $this->tpl->getUrl (),
            'fb_title'      => 'Інтернет ринок `Шувар` | Доставка продуктів з Шувару додому та в офіс.',
            'fb_image'      => 'https://shuvar.com/images/logo.png',
            'fb_descr'      => 'Широкий асортимент, низькі ціни, безкоштовна доставка',
            'csrf_token'    => $this->db->csrf_token ()

        );


        return $arr;
    }


}