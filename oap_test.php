<?php
$ThisVU="all";
$ModName="Работа с расписанием"; 
include("header.php");
include("function_oap.php");
function getBody($uid, $imap) {
    $body = get_part($imap, $uid, "TEXT/HTML");
    // if HTML body is empty, try getting text body
    if ($body == "") {
        $body = get_part($imap, $uid, "TEXT/PLAIN");
    }
    return $body;
}

function get_part($imap, $uid, $mimetype, $structure = false, $partNumber = false) {
    if (!$structure) {
           $structure = imap_fetchstructure($imap, $uid, FT_UID);
    }
    if ($structure) {
        if ($mimetype == get_mime_type($structure)) {
            if (!$partNumber) {
                $partNumber = 1;
            }
            $text = imap_fetchbody($imap, $uid, $partNumber, FT_UID);
            switch ($structure->encoding) {
                case 3: return imap_base64($text);
                case 4: return imap_qprint($text);
                default: return $text;
           }
       }

        // multipart
        if ($structure->type == 1) {
            foreach ($structure->parts as $index => $subStruct) {
                $prefix = "";
                if ($partNumber) {
                    $prefix = $partNumber . ".";
                }
                $data = get_part($imap, $uid, $mimetype, $subStruct, $prefix . ($index + 1));
                if ($data) {
                    return $data;
                }
            }
        }
    }
    return false;
}

function get_mime_type($structure) {
    $primaryMimetype = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");

    if ($structure->subtype) {
       return $primaryMimetype[(int)$structure->type] . "/" . $structure->subtype;
    }
    return "TEXT/PLAIN";
}

echo "<div class='head1'>Назначение пациентов</div>";
$user  = 'info@orto-premier.ru';
$pass = 'k8ynrqSv';
$connect = imap_open('{imap.orto-premier.ru:143/novalidate-cert}INBOX',$user, $pass);
if ($connect) echo 'Successful'; else {echo 'Failed'; die(imap_last_error());}
$from_stom_su=array();
$from_stom_su=imap_search($connect,"UNSEEN from kivdent@yandex.ru",SE_UID);
print_r($from_stom_su);
echo count($from_stom_su);
if (count($from_stom_su)!=0)
{
    foreach ($from_stom_su as $uid){
        $body=getBody($uid, $connect);
        $rbody=mb_convert_encoding($body, "cp1251");
        echo $rbody;
    }
}
include("footer.php");
?>