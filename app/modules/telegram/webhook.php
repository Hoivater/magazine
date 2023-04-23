<?php 
namespace limb\app\modules\telegram;
use limb\app\modules\telegram as TLG;
require "../../../autoload.php";

define('TGKEY', '5266575318:AAGRUbSCa4AhDBWGR21yPW3Aa1R5qEBJwNU');


$body = file_get_contents('php://input');
$arr = json_decode($body, true); 

// $arr = ['message' => ['chat' => ['id' => '43544323'], 'text' => "Мое сообщение"]];

if(isset($arr))
{
    $tg = new TLG\TeleGram(TGKEY);//создаем экземпляр класса

    $tg_id = $arr['message']['chat']['id']; //получаем прилетевшее id пользователя
    
    $rez_kb = array();
    
    $message_text = $arr['message']['text'];//получаем текст пользователя
    if($message_text == "")
    {
        $message_text = $arr['message']['caption'];
        $id_photo = $arr['message']['photo'][count($arr['message']['photo'])-1]["file_id"];
    }
    $tg->sendChatAction($tg_id);
    $sett = parse_ini_file(__DIR__."/../../setting.ini");
    #########################ЗАГРУЗКА ИЗОБАЖЕНИЙ#########################
    $address_image = $sett["address_image"];
    $resi = $tg -> setImage($id_photo);
    if ($resi['ok']) {
		$src  = 'https://api.telegram.org/file/bot'.TGKEY.'/'.$resi['result']['file_path'];
        $new_name = $tg_id."_".time().basename($src);

        $dest = __DIR__.'/../../../resourse/data/user_image/'.$new_name;
		copy($src, $dest);
		if($message_text == "") 
		{
		    $message_text = "Без имени";
	        $sms_rev .= "
Изображение сохранено.
";
		}
	}
	
    #####################################################################
    if(isset($arr["message"]['forward_from_chat']))
    {
        $reply = $arr["message"]["forward_from_chat"]["username"];
    }
    else
    {
        $reply = "";
    }
    
    $message_arr = [$message_text, $reply, $new_name];

    ##################################################################
    #####################РАСПРЕДЕЛИТЕЛЬ###############################
    ##################################################################

    
    $core = new Core($tg_id);
    $auth = $core -> isUser();
    #проверка, не идет ли регистрация
    
    $comm = $core -> isHistory();
    
    
    if($auth === false)
    {
        if(is_array($comm) && $comm["command"] == "registration")
        {
                $sms_rev .= $core -> nextCommand($message_arr, $comm);
        }
        else
        {
            $sms_rev .= $core -> Command($tg_id, $message_arr, "registration");
        }
    }
    else
    {
         $sms_rev .= $core -> Command($tg_id, $message_arr);
    }
    
    // $sms_rev .= "Переслано из: t.me/".$arr["message"]["forward_from_chat"]["username"];
    //$sms_rev = file_get_contents('php://input')."\n\n".$resi["result"]["file_path"];
    ##################################################################
    #####################РАСПРЕДЕЛИТЕЛЬ###############################
    ##################################################################

    

    $tg->send($tg_id, $sms_rev, $rez_kb);
    
    exit('ok'); // говорим телеге, что все окей
}

?>