<?
	namespace limb\code\site;
	use limb\app\base as Base;#для работы с валидатором и бд
	use limb\app\base\control as Control;
	use limb\app\worker as Worker;#для шаблонизатора
	#use limb\app\form as Form;
	#use limb\app\modules\commentary as Comm;
	/**
	 * работа с данными таблицы
	 *
	 */
	class MenuTable
	{
		public $tmpltMenu = ['%id%', '%category%', '%subcategory%', '%value%', '%visible%'];//массив из таблиц
		public $resultMenu;//финишная сборка для шаблона для возврата в _Page
		public $name = 'fr3452_menu';//имя таблицы которое используется по умолчанию
		public $table_key = "`id`, `category`, `subcategory`, `value`, `visible`";
		protected $language;
		#public $replace = [$id, $category, $subcategory, $value, $visible];


		public function __construct()
		{
			if(isset($_COOKIE['language'])) $this -> language = $_COOKIE['language'];
			else 
			{
				$this -> language = "ru_";
			}
			#code...
		}

		//метод достаюший все поля из таблицы
		public function searchFieldCom()
		{
			#$si = new Base\SearchInq($name);
			#$si -> selectQ(); 
			#$si ->  whereQ($key, $value, $operator);
			#$si -> limitQ();
			#$result = $si -> resQ();

			#code...

		}
		#метод добавляющий данные в таблицу, value - строка следующего вида
		#NULL, '".$this -> title."', '".$this -> keywords."', '".$this -> description."'
		#функция для автозаполнения созданной таблицы, можно корретировать функции, например выбрать fotogenerate /в будущем =)
		public static function insertFieldLimb($num)
		{
			$name77656756 = 'fr3452_menu';
			$table_key757658 = "`id`, `category`, `subcategory`, `value`, `visible`";
			for($i = 0; $i <= $num-1; $i++)
			{
				$id = Control\Generate::this_idgenerate();
				$category = Control\Generate::varchargenerate(40);
				$subcategory = Control\Generate::intgenerate(2);
				$value = Control\Generate::linkgenerate($category);
				$visible = 0;
				$value = "".$id.", '".$category."', '".$subcategory."', '".$value."', '".$visible."'";
				$ri = new Base\RedactionInq($name77656756, $table_key757658);
				$result = $ri -> insert($value);
			}
			#code...
		}


		public static function MenuLimb($language, $auth = "noauth")#сборщик страницы
		{
			$limb = new Worker\Limb();
			$html_main = file_get_contents(__DIR__."/../../view/".$language."public/menu/menu.tm");
			$si = new Base\SearchInq("fr3452_menu");
			
			$si -> selectQ();
			$si -> orderDescQ();
			$result = $si -> resQ();  //массив со всеми записями
			$top = [];
			$sub_top = [];
			for ($i=0; $i < count($result); $i++) { 
				if($result[$i]["subcategory"] == 0) $top[] = $result[$i]; 
			}
			


			for($i = 0; $i < count($top); $i++)
			{
				if($i == 0) 
				{
					$top[$i]["active"] = "active";
					$top[$i]["true"] = "true";
					$top[$i]["active_show"] = "active show";
					

				}
				else
				{	
					$top[$i]["active"] = "";
					$top[$i]["true"] = "false";
					$top[$i]["active_show"] = "";
				}
				$top[$i]["text"] = self::TextForTwoMenu($top[$i]["id"], $language, $result, $limb, $auth);
				$top[$i]["width"] = self::CountWidth($top[$i]["id"], $result);
			}


			if(isset($result[0]["id"])){

				$template = [
								"repeat" => ["menu", "twomenu", "csss"]
							];
					$data = [
								"repeat" => [$top, $top, $top]
							];


				$render = $limb -> TemplateMaster($template, $data, $auth, $html_main);
			}
			else
			{
				header("Location:/");
				exit();
			}
			return $render;
		}
		public static function CountWidth($id, $result)
		{
			$array = [];
			for ($i=0; $i < count($result); $i++) { 
				if($result[$i]["subcategory"] == $id)
				{
					$array[] = $result[$i];
				}
			}

			return count($array) * 222;
		}
		public static function TextForTwoMenu($id, $language, $result, $limb, $auth)
		{
			$array = [];
			for ($i=0; $i < count($result); $i++) { 
				if($result[$i]["subcategory"] == $id)
				{
					$array[] = $result[$i];
				}
			}
			$html_main = file_get_contents(__DIR__."/../../view/".$language."public/menu/text.tm");
			
			$template = [
						"repeat" => ["text"]
					];
			$data = [
						"repeat" => [$array]
					];
			
			$render = $limb -> TemplateMaster($template, $data, $auth, $html_main);

			return $render;
		}
	}
?>
