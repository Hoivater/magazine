<?php

namespace limb\app\modules\telegram;
use limb\code\site as Site;#для работы с таблицой
use limb\app\base as Base;#для работы с бд
use limb\app\base\control as Control;

 class Core
    {
    	private $ini;
        private $id_author;
        
        public function __construct($id_author){
            $this -> id_author = $id_author;
            $this -> ini = parse_ini_file(__DIR__."/command.ini");
        }
        

       	#функция проверяет наличие пользователя и возвращает его имя либо false
        public function isUser()
        {
        	$si = new Base\SearchInq("frfaccr848er4_account");
			$si -> selectQ();
			$si -> whereQ("verif_id", $this -> id_author, "=");
			$result = $si -> resQ();  //массив со всеми записями

            if(isset($result[0]["id"]))
            {
                return $data[0]["nickname"];
            }
            else
            {
                return false;
            }
        }
        public function Command($id, $message, $command = "")
        {
        	if($command == "")#ненасильная команда
        	{
        		#проверяем на команду,
        			#если команда начинаем ее выполнять
        			#если нет, то смотрим историю
        				#если история есть, то продолжаем выполнение команды,
        				#если нет - то начинаем добавление записи в таблицу, команда "add_post"
        		$result = $this -> isCommand($message[0]);
        		if($result === false) #пришедшее не относится к командам
        		{
        			$history = $this -> isHistory();
        			if($history === false) #в истории пользователя пусто
        			{
        				#выполняем добавления текста в таблицу
        				$sms_rev .= $this -> insertMessage($message);

        			}
        			else #история у пользователя есть история
        			{
        				#продолжаем выполнение команды
        				$sms_rev .= $this -> nextCommand($message, $history);//текущее сообщение, массив истории
        			}
        		}
        		else #пришедшее - это команда
        		{
        			$sms_rev .= $this -> runCommand(str_replace(['/', ' '], ['', ''], $message[0]));
        		}
        	}
        	else #насильное выполнение команды (вроде регистрации)
        	{
        	    if($command == "registration")
        	    {
        	        $sms_rev =  "Для продолжения работы, и получения доступа на сайт необходима регистрация\n";   
        	    }
        		$sms_rev .= $this -> runCommand($command);
        	}
    		return $sms_rev;
        }
        public function nextCommand($message, $history)
        {
        	#узнаем что сейчас в выполении
        	for($i = 0; $i < count($history["data"]); $i++)
        	{
        		if($history["data"][$i] == 0)
        		{
        			$history["data"][$i] = $message[0];	
        			break;
        		}
        	}
        	$newData = $history["command"]."&".implode("&", $history["data"]);
        	$this -> updateHistory($newData);
        	if(isset($this -> ini[$history["command"]]["text".($i+2)]))
	        {
	        	$sms_rev .= $this -> ini[$history["command"]]["text".($i+2)];
	        }
	        else{
	            $sms_rev .= $ini[$history]["command"];
	        	#ЗДЕСЬ НАЧИНАЕТСЯ ОСНОВНАЯ РАЗНИЦА В ЗАВИСИМОСТИ ОТ ИСПОЛНЯЕМОГО ДЕЙСТВИЯ
	        	#то есть основное действие в игре
	        	if($history["command"] == "registration")
	        	{
	        	    $table_key = "`id`, `verif_id`, `nickname`, `password`, `date_creation`";
	        	    #таблица с телеграмid
	        	    $ri = new Base\RedactionInq("frfaccr848er4_account", $table_key);
	        	    $times = time();
	        	    $value = "NULL, '".$this -> id_author."', '".mb_strtolower(trim($history["data"][0]))."', '".md5($history["data"][1])."', '".$times."'";
	        	    
	        	    #таблица с авторизацией
	        	    
	        	    $table_key_2 = "`id`, `name`, `email`, `password`, `access_user`, `code_email`, `code`, `date`";
	        	    $ri2 = new Base\RedactionInq("frfaccr848er4_user", $table_key_2);
	        	    $value2 = "NULL, '".mb_strtolower(trim($history["data"][0]))."', '".mb_strtolower(trim($history["data"][0]))."@iwrite.run', '".md5($history["data"][1])."', 'user', 'no', '".$this -> generateCodeUser."', '".$times."'";
	        	    
	        	    
			        $result = $ri -> insert($value);
			        
			        $result2 = $ri2 -> insert($value2);
			        
			        $sms_rev = "Регистрация завершена. Можно войти на свою страницу https://iwrite.run";
			        $this -> deleteHistory();
	        	}
	        	elseif($history["command"] == "addPost")
	        	{
	        	    
                    $sms_rev .= "Добавлено";
	        	}
	        	elseif($history["command"] == "newpassword")
	        	{
	        	    
	        	    $table_key = "`id`, `verif_id`, `nickname`, `password`, `date_creation`";
	        	    $table_key_2 = "`id`, `name`, `email`, `password`, `access_user`, `code_email`, `code`, `date`";
	        	    
                    
                    
                   $name_old = $this -> nameUserOld(); 
                    
	        	    
	        	    $ri = new Base\RedactionInq("frfaccr848er4_account", $table_key);
	        	    $ri -> update("password", md5(trim($history["data"][0])), "verif_id", $this -> id_author);
	        	    
	        	    $ri2 = new Base\RedactionInq("frfaccr848er4_user", $table_key_2);
	        	    $ri2 -> update("password", md5(trim($history["data"][0])), "name", $name_old);
    	        	    
	        	    
	        	    $sms_rev .= "Пароль изменен";
	        	    $this -> deleteHistory();
	        	}
	        	elseif($history["command"] == "newemail")
	        	{
	        	    
	        	    $table_key = "`id`, `verif_id`, `nickname`, `password`, `date_creation`";
	        	    $table_key_2 = "`id`, `name`, `email`, `password`, `access_user`, `code_email`, `code`, `date`";
	        	    
                    
                    
                    $name_old = $this -> nameUserOld(); 
                    
	        	    
	        	  //  $ri = new Base\RedactionInq("frfaccr848er4_account", $table_key);
	        	  //  $ri -> update("password", md5(trim($history["data"][0])), "verif_id", $this -> id_author);
	        	    
	        	    $ri2 = new Base\RedactionInq("frfaccr848er4_user", $table_key_2);
	        	    $ri2 -> update("email", $history["data"][0], "name", $name_old);
    	        	    
	        	    
	        	    $sms_rev .= "Email изменен на: ".$history["data"][0];
	        	    $this -> deleteHistory();
	        	}
	        	elseif($history["command"] == "report")
	        	{
	        	    
	        	  //  $table_key = "`id`, `verif_id`, `nickname`, `password`, `date_creation`";
	        	  //  $table_key_2 = "`id`, `name`, `email`, `password`, `access_user`, `code_email`, `code`, `date`";
	        	    
                    
                    
                    $name_old = $this -> nameUserOld(); 
	        	    $sms_rev .= Site\NoteTable::reportViewSmallTG($this -> id_author, $history["data"][0]);
	        	  //  $sms_rev .= $this -> id_author." ".$history["data"][0];
	        	    $this -> deleteHistory();
	        	}
	        	elseif($history["command"] == "newnick")
	        	{
	        	    
	        	    $si = new Base\SearchInq("frfaccr848er4_account");
                    $si -> selectQ();
                    $si -> whereQ("nickname", mb_strtolower(trim($history["data"][0])), "=");
                    $resulte = $si -> resQ(); 
                    
                    $name_old = $this -> nameUserOld(); 
                    // $sms_rev .= "@".$resulte2[0]["nickname"].$this -> id_author;
                    
                    if(isset($resulte[0]["id"]))
                    {
                        $sms_rev .= "Такое имя уже занято, попробуйте заново";
                        
    	        	    $this -> deleteHistory();
                    }
                    else
                    {
    	        	    $table_key = "`id`, `verif_id`, `nickname`, `password`, `date_creation`";
    	        	    $ri = new Base\RedactionInq("frfaccr848er4_account", $table_key);
    	        	    $ri -> update("nickname", mb_strtolower(trim($history["data"][0])), "verif_id", $this -> id_author);
    	        	    
    	        	    
    	        	    $table_key_2 = "`id`, `name`, `email`, `password`, `access_user`, `code_email`, `code`, `date`";
    	        	    $ri2 = new Base\RedactionInq("frfaccr848er4_user", $table_key_2);
    	        	    $ri2 -> update("email", mb_strtolower(trim($history["data"][0]))."@iwrite.run", "name",  $name_old);
    	        	    $ri2 -> update("name", mb_strtolower(trim($history["data"][0])), "name",  $name_old);
    	        	    
    	        	    
    	        	    
    	        	    
    	        	    $sms_rev .= "Имя изменено";
    	        	    $this -> deleteHistory();
                    }
	        	}
	        }
        	#меняем предыдущий 0 на message
        	#перезаписываем значение в таблице
        	#выдаем следующий текст, либо текст завершающий выполнение задачи
        	return $sms_rev;
        }
        public function nameUserOld()
        {
             #Ищем наше старое имя
            $si2 = new Base\SearchInq("frfaccr848er4_account");
            $si2 -> selectQ();
            $si2 -> whereQ("verif_id", $this -> id_author, "=");
            $resulte2 = $si2 -> resQ();
            return $resulte2[0]["nickname"];
        }
        #РЕШЕНИЕ ДЛЯ КОМАНД С НУЛЕВОЙ ИСТОРИЕЙ
        public function CommandNullArgs($command)
        {
            if($command == "myauth")
            {
                $si = new Base\SearchInq("frfaccr848er4_account");
                $si -> selectQ();
                $si -> whereQ("verif_id", $this -> id_author, "=");
                $result = $si -> resQ(); 
                if(isset($result[0]["id"]))
                {
                    $str = "Ваш nickname: ".$result[0]["nickname"].". Если вы также хотите вспомнить и пароль, то его вы можете просто поменять, потому как восстановлению он не подлежит. На ранее сохраненные данные это не повлияет.";
                }
            }
            
            return $str;
        }
        
    	private function generateCodeUser()
    	{
    		$arrayTranscription = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "A", "b", "B", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "r", "s", "t", "u", "v", "w", "x", "y", "z", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
    		$num = count($arrayTranscription)-1;
    		$code = "";
    		for ($i=0; $i <= 32 ; $i++) { 
    			$code .= $arrayTranscription[random_int(0, $num)];
    		}
    		return $code;
    	}
        public function updateHistory($data)
        {
        	$name77656756 = 'frfaccr848er4_history';
			$table_key757658 = "`id`, `id_user`, `history`";
			$ri = new Base\RedactionInq($name77656756, $table_key757658);
			$result = $ri -> update("history", $data, "id_user", $this -> id_author);
        }
        #запуск выполнения команды
        public function runCommand($command)
        {
        	#если есть запись в истории - удаляем
        	$this -> deleteHistory();
        	#пишем новую запись, выдаем сообщение text1
        	$command_null = $this -> buildHistory($command);
        	if($command_null === false)
        	{
        	    $result = $this -> CommandNullArgs($command);
        	    return $result;
        	}
        	else
        	{
        	    if($command == "report")
        	    {
        	        $si = new Base\SearchInq("frfaccr848er4_tags");
        	        $si -> selectQ();
					$si -> whereQ("user", $this -> id_author, "=");
					$si -> orderDescQ();
					$rese = $si -> resQ();  //массив со всеми записями
					$string_tags = "";
					if(isset($rese[0]["id"]))
					{
					    for($i = 0; $i < count($rese); $i++)
					    {
					        $string_tags .= ", ".$rese[$i]["tags"];
					    }
					}
					else
					{
					    $string_tags = "Вы пока ни одного тега не создали. Это можно сделать на сайте https://iwrite.run";
					}
        	        $result = str_replace("%tags%", $string_tags, $this -> ini[$command]["text1"]);
        	    }
        	    else
        	    {
        	        $result = $this -> ini[$command]["text1"];
        	    }
        	    return $result;
        	}
        }
        public function deleteHistory()
        {
    		$si = new Base\SearchInq("frfaccr848er4_history");
			$si -> selectQ();
			$si -> whereQ("id_user", $this -> id_author, "=");
			$result = $si -> resQ();
			if(isset($result[0]["id"]))
			{
				$name77656756 = 'frfaccr848er4_history';
				$table_key757658 = "`id`, `id_user`, `history`";
				$ri = new Base\RedactionInq($name77656756, $table_key757658);
				$ri -> delete("id", $result[0]["id"]);
			}
			return true;
        }
        #вставить сообщение 
        public function insertMessage($message)
        {
			$name77656756 = 'frfaccr848er4_bloop';
			$table_key757658 = "`id`, `verif_id`, `name_article`, `link`, `description`, `text_article`, `reply`,  `tags`, `category`, `foto`, `visible`, `popular`, `count_commentary`, `date`";
			
			$id = Control\Generate::this_idgenerate();
			$verif_id = $this -> id_author;
			$name = mb_substr($message[0], 0, 30);
			$link = time().$this -> isUser()."_".Control\Generate::codegenerateL(25);
			//$link = $this -> isUser()."/".Control\Generate::linkgenerate($name);
			$description = mb_substr($message[0], 0, 130);
// 			$text = htmlspecialchars($message);
            $text = $message[0];
            $reply = $message[1];
			$tags = "";
			$category = "noname";
			if(isset($message[2]))
			    $foto = $message[2];
			else
			    $foto = "nofoto";
			$visible = "0";
			$popular = "0";
			$count_commentary = "0";
			$date = time();
			$value = "".$id.", '".$verif_id."', '".$name."', '".$link."', '".$description."', '".$text."', '".$reply."', '".$tags."', '".$category."', '".$foto."', '".$visible."', '".$popular."', '".$count_commentary."', '".$date."'";
			$ri = new Base\RedactionInq($name77656756, $table_key757658);
			$result = $ri -> insert($value);
			$info = parse_ini_file(__DIR__."/../../../setting.ini");
			$name_site = $info["name_site"];
			$sms_rev = str_replace("%sms%", $name, $this -> ini["addPost"]["text1"]);
			return $sms_rev." Доступно по адресу: ".$name_site."/note/".$link;
        }
        public function buildHistory($message)
        {
        	#делаем первую запись в истории
        	#команда&0&0&0
        	$name77656756 = 'frfaccr848er4_history';
			$table_key757658 = "`id`, `id_user`, `history`";
			if($this -> ini[$message]["count_args"] == 0)
			{
			    return false;
			}
			else
			{   
    			$history = $this -> textHistory($message);
    			$value = "NULL, '".$this -> id_author."', '".$history."'";
    			$ri = new Base\RedactionInq($name77656756, $table_key757658);
    			$result = $ri -> insert($value);
    			return true;
			}
        }
        public function textHistory($message)
        {
        	$text = "";
        	if(isset($this -> ini[$message]))
        	{
        		$text .= $message;
        		$arr = $this -> ini[$message]; 
        		$text .= "&".str_repeat("0&", $this -> ini[$message]["count_args"]);
        		$text = substr_replace($text, "", -1);
        	}
        	return $text;
        }
        #возвращает массив
        #{команда, общее количество, текущий шаг, предыдущая информация}
        public function isHistory()
        {
        	$si = new Base\SearchInq("frfaccr848er4_history");
			$si -> selectQ();
			$si -> whereQ("id_user", $this -> id_author, "=");
			$result = $si -> resQ();

			if(isset($result[0]["id"]))
			{
				$arr = explode("&", $result[0]["history"]);
				$count_all = count($arr) - 1;
				$command = $arr[0];
				$data = [];
				$step = 1;
				for($i = 1; $i < count($arr); $i++)
				{
					if($arr[$i] !== 0)
					{
						$step = $i;
					}
					$data[] = $arr[$i];
				}
				$res = ["command" => $command, "count" => $count_all, "step" => $step, "data" => $data];
			}
			else
			{
				$res = false;
			}
			return $res;

        }
        #проверка на команду, существует ли такая (true, false)
        public function isCommand($message)
        {
        	$res = false;
        	foreach ($this -> ini as $key => $value) {
        		if(str_replace(['/', ' '], ['', ''], $message) == $key)
        		{
        			$res = true;
        		}
        	}
        	return $res;
        }
       

    }
?>