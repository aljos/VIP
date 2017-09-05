<?php

####################################
###   Database Conect Options    ###
####################################
define ("DB_HOST", "nvh143.mirohost.net");        # Адрес (хост) бази даних
define ("DB_NAME", "sim");                        # Назва бази даних
define ("DB_USER", "u_aljos_sim");             # Користувач бази даних
define ("DB_PSWD", "jktu291287fkmj");             # Пароль до бази даних
define ("DB_CHARSET", "SET NAMES utf8");        # Кодування бази даних


define ("DOC_ROOT", $_SERVER['DOCUMENT_ROOT']."/");

define ("CHARSET", "utf-8");                    # Кодування сторінки

define ("DEFAULT_CONTROLLER", "main");
define ("DEFAULT_ACTION", "index");
//define("DEFAULT_LANGUAGE","ua");
define ("DEFAULT_TEMPLATE", "main.tpl");
define ("DEFAULT_CAT", 1);


//define("TURBO_SMS_LOGIN","shuvar");
//define("TURBO_SMS_PSWD","jktu291287fkmjc");


define ("SALT", "DHtcTJ7DBL2F046dv23GdftbGALPQZ");


//**********************************************************

define ("ADMIN_PATH", "/admin_new/");


define ("ORDER_MIN_SUMM", 150);            //Мінімальна сума замовлення
define ("ORDER_MIN_SUMM_DELIVERY", 100);  //Мінімальна сума замовлення з доставкою
define ("SUMM_DELIVERY", 20);             //Сума доставки
define ("ID_DELIVERY", 8099);               //ID доставки
define ("EXPRESS_HOUR", 12);                //Година Експрес замовлень
define ("NIGHT_HOUR", 3);                    //Нічна година замовлень
define ("HOME_HOUR", 19);                    //Година замовлень домашки
define ("PACKAGE_ID", 4138);                //ID пакету великого
define ("PACKAGE_PRICEI", 1.8);          //Прихідна ціна пакету великого
define ("PACKAGE_PRICEO", 2.1);           //Розхідна ціна пакету великого
define ("PACKAGE_ID_V", 7198);            //ID пакету Вишиванка
define ("PACKAGE_V_PRICEI", 0.75);        //Прихідна ціна пакету Вишиванка
define ("PACKAGE_V_PRICEO", 0.90);         //Розхідна ціна пакету Вишиванка
define ("TARA_BOTTLE_ID", 7480);            //ID пляшки 1,5л
define ("TARA_BOTTLE_PRICEI", 3);         //Прихідна ціна пляшки 1,5л
define ("TARA_BOTTLE_PRICEO", 3.25);       //Розхідна ціна пляшки 1,5л
define ("TARA_BOTTLE_ID_2", 9416);            //ID пляшки 2л
define ("TARA_BOTTLE_PRICEI_2", 3.5);         //Прихідна ціна пляшки 2л
define ("TARA_BOTTLE_PRICEO_2", 3.75);       //Розхідна ціна пляшки 2л
define ("TARA_BOTTLE_1_ID", 9406);            //ID пляшки 1л
define ("TARA_BOTTLE_1_PRICEI", 2.5);         //Прихідна ціна пляшки 1л
define ("TARA_BOTTLE_1_PRICEO", 2.75);       //Розхідна ціна пляшки 1л
define ("PAIL_ID_SMALL", 7481);        //ID відерка 0,5л
define ("PAIL_ID_SMALL_PRICEI", 3);     //Прихідна ціна відерка 0,5л
define ("PAIL_ID_SMALL_PRICEO", 3.25);       //Розхідна ціна відерка 0,5л
define ("PAIL_ID_BIG", 7482);            //ID відерка 1 л.
define ("PAIL_ID_BIG_PRICEI", 4);       //Прихідна ціна відерка 1 л.
define ("PAIL_ID_BIG_PRICEO", 4.25);       //Розхідна ціна відерка 1 л.


define ("REG_BONUS", 10);                //Сума реєстраційного бонусу
define ("REG_BONUS_ID", 3449);        //ID реєстраційного бонусу
define ("LOYALTI_ID_3", 6302);        //ID знижки 3%
define ("LOYALTI_ID_4", 8413);        //ID знижки 4%
define ("LOYALTI_ID_5", 6871);        //ID знижки 5%
define ("LOYALTI_ID_6", 10268);        //ID знижки 6%
define ("LOYALTI_ID_8", 8414);        //ID знижки 8%
define ("LOYALTI_ID_10", 8415);       //ID знижки 10%
define ("ADD_LOYALTI_ID", 8892);      //ID додаткової знижки
define ("BIRTH_LOYALTI_ID", 10239);   //ID знижки на День народження
define ("BALANCE_ID", 10364);         //ID знижки на День народження
define ("NOT_DISCOUNT_GRP_ID", "0");      //ID підгруп без знижки


define ("GRUZ", 8735);                //ID розвантажувальних робіт%


// Коди сервісних товарів
define ("SERVICE_CODE_WARES", "4,3449,6302,8413,6871,8414,8415,8892,8735,8099,4138,7198,7480,9416,9406,7481,7482,10239,10268,10364,10543");
define ("NOT_DISCOUNT", "8892,10543,10364");


define ("WARE_PHOTO_MAX_SIZE", 1);
define ("SMALL_WARE_NOPHOTO", "/images/wares/small/no_image_available.png");
define ("SMALL_WARE_PHOTO_PATH", "/images/wares/small/");
define ("MEDIUM_WARE_PHOTO_PATH", "/images/wares/medium/");
define ("MEDIUM_WARE_NOPHOTO", "/images/wares/medium/no_image_available.png");
define ("BIG_WARE_PHOTO_PATH", "/images/wares/");
define ("BIG_WARE_NOPHOTO", "/images/wares/no_image_available.png");
define ("ANDROID_WARE_NOPHOTO", "/images/wares/small/none-photo.png");
define ("ANDROID_WARE_PHOTO_PATH", "/images/wares/android/");
define ("ADMIN_WARE_PHOTO_PATH", ADMIN_PATH."images/wares/");


//???????
define ("RECIPES_CAT_NOPHOTO", "/images/recipes/category/none-photo.png");
define ("RECIPES_CAT_PHOTO_PATH", "/images/recipes/category/");

define ("CATEGORY_PHOTO_PATH", "/images/subcategory/");
define ("CATEGORY_NOPHOTO", "/images/subcategory/no_image_available.png");

define ("RECIPES_NOPHOTO", "/images/recipes/none-photo.png");
define ("RECIPES_PHOTO_PATH", "/images/recipes/");


// ??????? ????????? ????, ??????, ??????? ????
define ("SMALL_VILLAGE_PHOTO_PATH", "/images/villages/small/");
define ("BIG_VILLAGE_PHOTO_PATH", "/images/villages/");

define ("SMALL_FARMER_PHOTO_PATH", "/images/farmers/small/");
define ("BIG_FARMER_PHOTO_PATH", "/images/farmers/");

//Клієнти для яких діють гуртові ціни
$wholesale_clients = array ("HoReCa", "Dnipro");

if (in_array ($_SESSION['CT'], $wholesale_clients)) {
    define ("PRICE", "price_g");
} elseif ($_SESSION['CT'] == "horeca_pdv") {
    define ("PRICE", "price_pdv");
} else {
    define ("PRICE", "price");
}
