<?php
namespace limb\app\form;
use limb\app\base as Base;
use limb\app\modules\commentary as Comm;
use limb\code\site as Site;
	/**
	 * 
	 */
	// class ArticleTable
	// {
		
	// 	function __construct()
	// 	{
	// 		echo "Клссс";
	// 	}
	// 	public static function insertFieldCom($ef)
	// 	{
	// 		echo "fr";
	// 	}
	// }

	class FormBase
	{	
		public $ini_new;//перезаписанный массив
		public $data;//массив данных полученный через форму
		public $ex = ["connect", "importBD", "newFields", "newTable", "redTable"];#исключения для htmlspecialchar
		protected $controlHtml;

		function __construct($data)
		{
			$this -> data = [];
			$this -> controlHtml = 2;
			for($i = 0; $i < count($this -> ex); $i++)
			{
				if($data["nameForm"] == $this -> ex[$i]) $this -> controlHtml += 1;
			}
			if($this -> controlHtml == 2)
			{
				foreach ($data as $key => $value) {
					if($key != "code")
					{
						$this -> data[$key] = htmlspecialchars($value, ENT_QUOTES);

					}
					else
					{
						$this -> data[$key] = $value;
					}
				}
			}
			else
			{
				$this -> data = $data;
			}

		}

		protected function newCommentary()
		{
			$ar = Comm\CommentaryTable::addCommentary($this -> data);
			return $ar;
		}
		public function tab_newIni()
		{
			// print_r($this -> data);
			$this -> ini_new = Base\control\Necessary::ConvertInIni($this -> data);
			// print_r($this -> ini_new);
			file_put_contents('../base/db.ini', $this -> ini_new);
			return true;
		}
		public function newRandomFields()
		{
			$ini = parse_ini_file('../base/db.ini');
			$table_name = $this -> data["name_db"];
			$class_name = 'limb\\code\\site\\'.ucfirst(str_replace($ini["fornameDB"], "", $table_name))."Table";
			$obj = $class_name::insertFieldLimb($this -> data['count_fields']);
		}
		public function saveGprF()
		{
			$verif_id = Base\control\Control::VerifIdUser();
			$name_gpr = $this -> data["name_tables"];
			$name_paragraph = $this -> data["name_paragraph"];
			$iw = [];
			foreach($this -> data as $key => $value)
			{
				if(strpos($key, "deinstr") !== false)
				{
					$iw[] = $value;
				}
			}
			
			$table_graphe = $name_paragraph."&";
			for($i = 0; $i < count($iw); $i++)
			{
				if($i != count($iw)-1)
					$table_graphe .= $iw[$i].",";
				else
					$table_graphe .= $iw[$i];
			}
			$name77656756 = 'frfaccr848er4_gpr';
			$table_key757658 = "`id`, `name`, `link`, `verif_id`, `table_graphe`, `scale`, `color`, `visible`, `date_creation`";
			
			$link = Base\control\Generate::codegenerateL(32);
			$scale = "0";
			$color = "0";
			$visible = "0";
			$date_creation = time();
			$value_string = "NULL, '".$name_gpr."', '".$link."', '".$verif_id."', '".$table_graphe."', '".$scale."', '".$color."', '".$visible."', '".$date_creation."'";

			$ri = new Base\RedactionInq($name77656756, $table_key757658);
			$result = $ri -> insert($value_string);

 			header('Location: \gprnew\\'.$link);
			exit();
		}

		public function redactionGprF()
		{
			$verif_id = Base\control\Control::VerifIdUser();


			$name_paragraph = $this -> data["name_paragraph"];
			$link = $this -> data["link"];
			$number = $this -> data["number_id"];

			$iw = [];
			foreach($this -> data as $key => $value)
			{
				if(strpos($key, "deinstr") !== false)
				{
					$iw[] = $value;
				}
			}

			$si = new Base\SearchInq("frfaccr848er4_gpr");
			$si -> selectQ();
			$si -> whereQ("verif_id", $verif_id, "=");
			$si -> andQ("link", $link, "=");
			$si -> orderDescQ();
			$result = $si -> resQ();  //массив со всеми записями

			if(isset($result[0]["id"]))
			{
				$table_graphe = $name_paragraph."&";
				for($i = 0; $i < count($iw); $i++)
				{
					if($i != count($iw)-1)
						$table_graphe .= $iw[$i].",";
					else
						$table_graphe .= $iw[$i];
				}

				$arr1 = explode("@", $result[0]["table_graphe"]);

				if(isset($arr1[$number-1]))
				{
					$arr1[$number-1] = $table_graphe;
				}

				$table_graphe_new = implode("@", $arr1);

				$name77656756 = 'frfaccr848er4_gpr';
				$table_key757658 = "`id`, `name`, `link`, `verif_id`, `table_graphe`, `scale`, `color`, `visible`, `date_creation`";
				

				$ri = new Base\RedactionInq($name77656756, $table_key757658);
				$result = $ri -> update("table_graphe", $table_graphe_new, "link", $link);

				header('Location: \gprnew\\'.$link);
				exit();
			}
			else{
				
				header('Location: \gprnew\\'.$link);
				exit();
			}
		}

		public function nextGprF()
		{
			$verif_id = Base\control\Control::VerifIdUser();
			$name_paragraph = $this -> data["name_paragraph"];
			$link = $this -> data["link"];
			$iw = [];
			foreach($this -> data as $key => $value)
			{
				if(strpos($key, "deinstr") !== false)
				{
					$iw[] = $value;
				}
			}
			$si = new Base\SearchInq("frfaccr848er4_gpr");
			$si -> selectQ();
			$si -> whereQ("verif_id", $verif_id, "=");
			$si -> andQ("link", $link, "=");
			$si -> orderDescQ();
			$result = $si -> resQ();  //массив со всеми записями
			if(isset($result[0]["id"]))
			{
				$table_graphe = $name_paragraph."&";
				for($i = 0; $i < count($iw); $i++)
				{
					if($i != count($iw)-1)
						$table_graphe .= $iw[$i].",";
					else
						$table_graphe .= $iw[$i];
				}
				$table_graphe_new = $result[0]["table_graphe"]."@".$table_graphe;

				$name77656756 = 'frfaccr848er4_gpr';
				$table_key757658 = "`id`, `name`, `link`, `verif_id`, `table_graphe`, `scale`, `color`, `visible`, `date_creation`";
				

				$ri = new Base\RedactionInq($name77656756, $table_key757658);
				$result = $ri -> update("table_graphe", $table_graphe_new, "link", $link);

				header('Location: \gprnew\\'.$link);
				exit();
			}
			else{
				
				header('Location: \gprnew\\'.$link);
				exit();
			}
			
		}
		public function cleanHistory()
		{
			$ini = parse_ini_file('../../setting.ini');
			if(isset($this -> data["password_user"]))
			{
				$password_user = md5($this -> data["password_user"]);
				$password_real = Base\control\Control::PasswordUser();
				if($password_user == $password_real)
				{
					$verif_id = Base\control\Control::VerifIdUser();
					if(isset($this -> data["note"]))
					{
						#находим все картинки
						$image_arr = [];
						$si = new Base\SearchInq("frfaccr848er4_note");
						$si -> selectQ();
						$si -> whereQ("name", $verif_id, "=");
						$results = $si -> resQ();
						if(isset($results[0]["id"]))
						{
							for($i = 0; $i < count($results); $i++)
							{
								if($results[$i]["foto"] != "nofoto")
								{
									$image_arr[] = $results[$i]["foto"];
								}
							}
						}
						for ($i=0; $i < count($image_arr); $i++) { 
							$add = __DIR__.'/../../resourse/data/user_image/'.$image_arr[$i];
							if(file_exists($add))
								unlink($add);
						}
						$name = 'frfaccr848er4_note';//имя таблицы которое используется по умолчанию
						$table_key = "`id`, `name`, `name_article`, `link`, `text_article`, `tags`, `foto`, `visible`, `count_commentary`, `level`, `status`, `date_start`, `date_end`";
						$ri = new Base\RedactionInq($name, $table_key);
						$ri -> delete("name", $verif_id);
					}
					if(isset($this -> data["report"]))
					{
						$name77656756 = 'frfaccr848er4_report';
						$table_key = "`id`, `user`, `link`, `address`, `theme`, `note`, `tags`, `text_arhive`, `date_creation`";
						$ri = new Base\RedactionInq($name77656756, $table_key);
						$ri -> delete("user", $verif_id);
					}
					if(isset($this -> data["tags"]))
					{
						$name77656756 = 'frfaccr848er4_tags';
						$table_key = "`id`, `tags`, `tags_transcript`, `user`, `level`, `unique`";
						$ri = new Base\RedactionInq($name77656756, $table_key);
						$ri -> delete("user", $verif_id);
					}
				}
			}
		}
		
		public function ImportBD()
		{
			$code = $this -> data['file_sql'];
			$tableInq = new Base\TableInq();
			//$code_array = Necessary::ToCodeSql($code);
			$result = $tableInq -> ImportBDU($code);
			if($result == true)
			{
				$result = "База данных успешно импортирована";
			}
			else
			{
				$result = "При импорте произошла ошибка";
			}
			return $result;
		}

	}
?>