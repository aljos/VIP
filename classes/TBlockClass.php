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


class TBlock
{

    function TBlock ()
    {
        $this->db   = new DB();
        $this->tpl  = new Tpl();
        $this->auth = new TAuth();

    }

    function rightContentBlock ()
    {
        $html = $this->amountsOnline ();
        $html .= "<div style='clear: both; height: 15px;'><br /></div>";

        //$html .= "<div class='calendar_block'>";
        //$html .= "<a href='/?mode=pages&url=garlik'><img src='/images/chasnyk.jpg' style='border:1px solid #ccc;width:320px;'/></a>";
        //$html .= "</div>";
        //$html .= $this->eventCalendar();
        $html .= "<div style='clear: both; height: 15px;'><br /></div>";
        $html .= "<a href='/images/gazetka/gazeta1_10_01_2017.jpg'><img src='/images/gazetka/gazeta1_10_01_2017.jpg' style='border:1px solid #ccc;width:320px;'/></a>";
        $html .= "<div style='clear: both; height: 15px;'><br /></div>";
        $html .= "<a href='/images/gazetka/gazeta2_10_01_2017.jpg'><img src='/images/gazetka/gazeta2_10_01_2017.jpg' style='border:1px solid #ccc;width:320px;'/></a>";

        return $html;
    }


    function reklama ()
    {
        $tpl = $this->tpl->ReadTpl ("app/_advertisement.html");

        $arr = array ('advertising_title' => ADVERTISING_TITLE
        );

        return $this->tpl->ReplceTpl ($tpl, $arr);
    }


    function analitic_category ()
    {

        $lcQry = "SELECT * FROM (
            SELECT c.idt_analitic_cat AS id,c.name_".$_SESSION['lang']." AS name ,count_products_price(c.idt_analitic_cat) AS qty,photo
            FROM t_analitic_cat c WHERE   c.onsite=1 AND parent=0 ORDER BY sort
            ) a WHERE qty>0";
        $lnID  = $this->db->Qry ($lcQry);

        $catListTpl  = $this->tpl->ReadTpl ("app/_category_one_on_sidebar.html");
        $catListHtml = "";

        $Data = $this->db->getObject ($lnID);

        foreach ($Data as $item) {

            $oneArr = array (
                'id'                      => $item->id,
                'category_name'           => $item->name,
                'qty'                     => $item->qty,
                'filter_product_quantity' => FILTER_PRODUCT_QUANTITY,
                'icon'                    => $item->photo
            );


            $catListHtml .= $this->tpl->ReplceTpl ($catListTpl, $oneArr);
            unset($oneArr);

        }


        $arr = array ('filter_category_title' => FILTER_CATEGORY_TITLE,
                      'category_list'         => $catListHtml
        );

        $tpl = $this->tpl->ReadTpl ("app/_category_on_sidebar.html");

        return $this->tpl->ReplceTpl ($tpl, $arr);

    }


    function analitic_category_checkbox ()
    {

        $lcQry = "SELECT * FROM (
            SELECT c.idt_analitic_cat AS id,c.name_".$_SESSION['lang']." AS name ,count_products_price(c.idt_analitic_cat) AS qty,photo
            FROM t_analitic_cat c WHERE   c.onsite=1 AND parent=0 ORDER BY sort
            ) a WHERE qty>0";
        $lnID  = $this->db->Qry ($lcQry);

        $catListTpl  = $this->tpl->ReadTpl ("app/_filter_radio_one_cat.html");
        $catListHtml = "";

        $Data = $this->db->getObject ($lnID);

        foreach ($Data as $item) {

            $checked = $_SESSION['idCat'] == $item->id ? "checked" : "";
            $oneArr  = array (
                'id'            => $item->id,
                'category_name' => $item->name,
                'qty'           => $item->qty,
                'icon'          => $item->photo,
                'checked'       => $checked
            );


            $catListHtml .= $this->tpl->ReplceTpl ($catListTpl, $oneArr);
            unset($oneArr);

        }


        $arr = array ('filter_title'  => FILTER_TITLE,
                      'category_list' => $catListHtml
        );

        $tpl = $this->tpl->ReadTpl ("app/_filter_checkbox.html");

        return $this->tpl->ReplceTpl ($tpl, $arr);

    }


    function analitic_category_top ($id)
    {


        $lcQry = "SELECT * FROM (
            SELECT c.idt_analitic_cat AS id,c.name_".$_SESSION['lang']." AS name ,count_products_top(c.idt_analitic_cat) AS qty,photo
            FROM t_analitic_cat c WHERE   c.onsite=1 AND parent=0 ORDER BY sort
            ) a WHERE qty>0";
        $lnID  = $this->db->Qry ($lcQry);

        $catListTpl  = $this->tpl->ReadTpl ("app/_filter_radio_one_cat.html");
        $catListHtml = "";

        $Data = $this->db->getObject ($lnID);

        foreach ($Data as $item) {


            $checked = $_SESSION['idCat'] == $item->id ? "checked" : "";
            $oneArr  = array (
                'id'            => $item->id,
                'category_name' => $item->name,
                'qty'           => 10,
                'icon'          => $item->photo,
                'checked'       => $checked
            );


            $catListHtml .= $this->tpl->ReplceTpl ($catListTpl, $oneArr);
            unset($oneArr);

        }


        $arr = array ('filter_title'  => FILTER_TITLE,
                      'category_list' => $catListHtml
        );

        $tpl = $this->tpl->ReadTpl ("app/_filter_radio.html");

        return $this->tpl->ReplceTpl ($tpl, $arr);

    }

    function analitic_category_production ($prevYear, $curYear)
    {


        $lcQry = "SELECT * FROM (
            SELECT c.idt_analitic_cat AS id,c.name_".$_SESSION['lang']." AS name ,count_products_production(c.idt_analitic_cat,'".$prevYear."','".$curYear."') AS qty,photo
            FROM t_analitic_cat c WHERE   c.onsite=1 AND parent=0 ORDER BY sort
            ) a WHERE qty>0";
        $lnID  = $this->db->Qry ($lcQry);

        $catListTpl  = $this->tpl->ReadTpl ("app/_filter_radio_one_cat.html");
        $catListHtml = "";

        $Data = $this->db->getObject ($lnID);

        foreach ($Data as $item) {


            $checked = $_SESSION['idCat'] == $item->id ? "checked" : "";
            $oneArr  = array (
                'id'            => $item->id,
                'category_name' => $item->name,
                'qty'           => $item->qty,
                'icon'          => $item->photo,
                'checked'       => $checked
            );


            $catListHtml .= $this->tpl->ReplceTpl ($catListTpl, $oneArr);
            unset($oneArr);

        }


        $arr = array ('filter_title'  => FILTER_TITLE,
                      'category_list' => $catListHtml
        );

        $tpl = $this->tpl->ReadTpl ("app/_filter_radio.html");

        return $this->tpl->ReplceTpl ($tpl, $arr);

    }

    function analitic_category_zed ($year, $month)
    {


        $lcQry = "select if (cat is null,cat1,cat) as id, c.name_".$_SESSION['lang']." as name,c.photo, count(*) as qty from (
                    select * from (
                    SELECT p.idt_analitic_cat as cat, p.name_".$_SESSION['lang']." as name FROM t_analitics_zed z
                    inner join t_analitics_zed_products p on z.uktzed=p.uktzed
                    where z.zed_type=1 and year(z.date_post)='".$year."' and month(z.date_post)='".$month."'
                    group by name order by name
                    ) a
                    right JOIN
                    (SELECT p.idt_analitic_cat as cat1, p.name_".$_SESSION['lang']." as name1 FROM t_analitics_zed z
                    inner join t_analitics_zed_products p on z.uktzed=p.uktzed
                    where z.zed_type=2 and year(z.date_post)='".$year."' and month(z.date_post)='".$month."'
                    group by name1 order by name1) b on b.name1 =a.name

                    union

                    select * from (
                    SELECT p.idt_analitic_cat as cat,p.name_".$_SESSION['lang']." as name FROM t_analitics_zed z
                    inner join t_analitics_zed_products p on z.uktzed=p.uktzed
                    where z.zed_type=1 and year(z.date_post)='".$year."' and month(z.date_post)='".$month."'
                    group by name order by name
                    ) a
                    left JOIN
                    (SELECT p.idt_analitic_cat as cat1,p.name_".$_SESSION['lang']." as name FROM t_analitics_zed z
                    inner join t_analitics_zed_products p on z.uktzed=p.uktzed
                    where z.zed_type=2 and year(z.date_post)='".$year."' and month(z.date_post)='".$month."'
                    group by name order by name) b on b.name =a.name
                    )a
                    inner join t_analitic_cat c on c.idt_analitic_cat=a.cat
                    group by c.idt_analitic_cat
                    order by c.idt_analitic_cat";
        $lnID  = $this->db->Qry ($lcQry);

        $catListTpl  = $this->tpl->ReadTpl ("app/_filter_radio_one_cat.html");
        $catListHtml = "";

        $Data = $this->db->getObject ($lnID);

        foreach ($Data as $item) {


            $checked = $_SESSION['idCat'] == $item->id ? "checked" : "";
            $oneArr  = array (
                'id'            => $item->id,
                'category_name' => $item->name,
                'qty'           => $item->qty,
                'icon'          => $item->photo,
                'checked'       => $checked
            );


            $catListHtml .= $this->tpl->ReplceTpl ($catListTpl, $oneArr);
            unset($oneArr);

        }


        $arr = array ('filter_title'  => FILTER_TITLE,
                      'category_list' => $catListHtml
        );

        $tpl = $this->tpl->ReadTpl ("app/_filter_radio.html");

        return $this->tpl->ReplceTpl ($tpl, $arr);

    }

    function analitic_category_amounts ()
    {


        $_SESSION['idCat'] = 1;
        $lcQry             = "SELECT * FROM (
                    SELECT c.idt_analitic_cat AS id,c.name_".$_SESSION['lang']." AS name,count(c.idt_analitic_cat) as qty, photo FROM t_analitic_cat c
                    inner join
                    (select * from t_analitics_svv_products where onsite=1) p on p.idt_analitic_cat=c.idt_analitic_cat
                    inner join
                    (select * from  t_analitics_amounts_online where date_time > date_sub(now(), INTERVAL 15 MINUTE) and value!=0) o on o.product_svv=p.id
                    WHERE c.onsite=1 AND parent=0 group by c.idt_analitic_cat ORDER BY sort
                    ) a";
        $lnID              = $this->db->Qry ($lcQry);

        $catListTpl  = $this->tpl->ReadTpl ("app/_filter_radio_one_cat.html");
        $catListHtml = "";

        $Data = $this->db->getObject ($lnID);

        foreach ($Data as $item) {


            $checked = $_SESSION['idCat'] == $item->id ? "checked" : "";
            $oneArr  = array (
                'id'            => $item->id,
                'category_name' => $item->name,
                'qty'           => $item->qty,
                'icon'          => $item->photo,
                'checked'       => $checked
            );


            $catListHtml .= $this->tpl->ReplceTpl ($catListTpl, $oneArr);
            unset($oneArr);

        }


        $arr = array ('filter_title'  => FILTER_TITLE,
                      'category_list' => $catListHtml
        );

        $tpl = $this->tpl->ReadTpl ("app/_filter_radio.html");

        return $this->tpl->ReplceTpl ($tpl, $arr);

    }


    function expertViewBlock ()
    {

        $arr = array (
            'expert_view_title' => EXPERT_VIEW_TITLE

        );

        $tpl = $this->tpl->ReadTpl ("app/_expert_view.html");

        return $this->tpl->ReplceTpl ($tpl, $arr);
    }


}