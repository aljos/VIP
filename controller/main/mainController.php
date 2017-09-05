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

class mainController
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

        $arrContent = array (
            'main_slider'  => self::mainSlider (),
            'hit_products' => self::hitProducts (),

        );

        $tpl = $this->tpl->ReadTpl ("pages/main.html");
        $tpl = $this->tpl->ReplceTpl ($tpl, $arrContent);


        $arrPage = array (
            'content' => $tpl,
            //'script'  => $this->tpl->LoadJs (array ("characters_limit.js"))
        );

        $res_arr = array_merge ($arrPage, $this->pageSeo ());

        echo $this->tpl->render ($res_arr);

    }


    function mainSlider ()
    {

        $lcQry  = "SELECT * FROM `tbanners` where idtbanners_location=1 AND onsite=1 AND idtbanners!=0
										and curdate() between show_from and if(show_to='0000-00-00','2100-01-01',show_to) order by sort ";
        $lnId   = $this->db->Qry ($lcQry);
        $loData = $this->db->getObject ($lnId);

        $slideTpl = $this->tpl->ReadTpl ("app/_main_slider_item.html");


        $slideHtml = "";
        $i         = 1;
        foreach ($loData as $item) {

            $oneArr = array (
                'url'   => $item->target_url,
                'photo' => $item->source,
            );

            $slideHtml .= $this->tpl->ReplceTpl ($slideTpl, $oneArr);
            unset($oneArr);

            $i++;
        }

        $arr = array (
            'slider' => $slideHtml
        );

        $tpl = $this->tpl->ReadTpl ("app/_main_slider_structure.html");
        $tpl = $this->tpl->ReplceTpl ($tpl, $arr);

        return $tpl;
    }

    function hitProducts ()
    {

        $lcQry  = "SELECT w.idtwares,w.warename,w.idtfarmers,sg.translit_name cat,w.translit_name,w.".PRICE." as price, w.idtsub_grpware,w.photo,w.min_weight, w.note, w.action, u.unitname, u.idtunits, count(w.idtwares) as count FROM tdetails d
									inner join
									(select idtheaders from theaders where date(docdate) between curdate()-interval 1 month and curdate()) h on h.idtheaders=d.idtheaders
									inner join twares  w on w.idtwares=d.idtwares
									inner join tunits u on w.idtunits=u.idtunits
									inner join tsub_grpware sg on sg.idtsub_grpware=w.idtsub_grpware
									where w.idtwares not in (".SERVICE_CODE_WARES.") and w.onsite=2
									group by w.idtwares order by count desc limit 20";
        $lnId   = $this->db->Qry ($lcQry);
        $loData = $this->db->getObject ($lnId);

        $hitTpl = $this->tpl->ReadTpl ("app/_main_hit_products_item.html");


        $hitHtml = "";
        $i       = 1;
        foreach ($loData as $item) {

            $oneArr = array (
                'id'         => $item->idtwares,
                'name'       => $item->warename,
                'price'      => $item->price,
                //'url'   => $item->target_url,
                'min_weight' => $item->min_weight,
                'photo'      => $item->photo,
                'unit'       => $item->unitname,
            );

            $hitHtml .= $this->tpl->ReplceTpl ($hitTpl, $oneArr);
            unset($oneArr);

            $i++;
        }

        $arr = array (
            'hit_products_list' => $hitHtml
        );

        $tpl = $this->tpl->ReadTpl ("app/_main_hit_products_structure.html");
        $tpl = $this->tpl->ReplceTpl ($tpl, $arr);

        return $tpl;
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