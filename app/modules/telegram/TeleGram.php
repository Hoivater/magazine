<?php

namespace limb\app\modules\telegram;
use limb\app\base as Base; #для работы с базой данный

class TeleGram {
  
    public $token = '';
    /*Все крайне просто, в конструкторе сохраняем во внутреннюю переменную Api ключ, который получили от BotFather бота телеграмма.*/
    public function __construct($token) {
        $this->token = $token; 
    }
    #Получаем в параметрах ID диалога, сообщение и инлайн клавиатуру, если она нужна.
    public function send($id, $message, $kb) {
        $data = array(
            'chat_id' => $id,
            'text'  => $message,
            'parse_mode' => 'HTML',
            'disable_web_page_preview'=>true,
            'reply_markup' => json_encode(array('inline_keyboard' => $kb))
        );
        $this->request('sendMessage', $data);
    }  
    /*Редактируем с помощью нее сообщение бота в телеграме всемсте с инлайн клавиатурой, если нужно. 
    Получаем в качестве параметров ID чата, ID сообщения, новый текст сообщения, инлайн клавиатуру.*/
    public function editMessageText($id, $m_id, $m_text, $kb=''){
        $data=array(
             'chat_id' => $id,
             'message_id' => $m_id,
             'parse_mode' => 'HTML',
             'text' => $m_text
        );
        if($kb)
            $data['reply_markup']=json_encode(array('inline_keyboard' => $kb));

        $this->request('editMessageText', $data); 
    }


    public function editMessageReplyMarkup($id, $m_id, $kb){
        $data=array(
            'chat_id' => $id,
            'message_id' => $m_id,
            'reply_markup' => json_encode(array('inline_keyboard' => $kb))
        );
        $this->request('editMessageReplyMarkup', $data); 
    }
    /*Получаем в параметрах ID обратного запроса и текст ответа.*/
    public function answerCallbackQuery($cb_id, $message) {
        $data = array(
            'callback_query_id' => $cb_id,
            'text' => $message
        );
        $this->request('answerCallbackQuery', $data);
    } 
    /*Получаем как параметр ID чата, ID сообщения, новую разметку/клавиатуру. 
    Используем в паре с answerCallbackQuery, для ответа на запрос с заменой разметки.*/
    public function sendChatAction($id,$action='typing') {
        $data = array(
            'chat_id' => $id,
            'action'     => $action
        );
        $this->request('sendChatAction', $data);
    }
    /*Получаем картинку*/
    public function setImage($file_id)
    {
        $data = array('file_id' => $file_id);
        $res = $this -> request("getFile", $data);
        return $res;
    }
    /*Отправляем запрос вида https://api.telegram.org/botAPI_KEY/ИМЯ_МЕТОДА по протоколу post через curl.*/
    public  function request($method, $data = array()) {
        $curl = curl_init();
          
        curl_setopt($curl, CURLOPT_URL, 'https://api.telegram.org/bot'.$this->token.'/'.$method);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'); 
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          
        $out = json_decode(curl_exec($curl), true);
          
        curl_close($curl);
        return $out;
    }
}
?>