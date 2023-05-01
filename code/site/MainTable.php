<?
namespace limb\code\site;
use limb\app\base as Base; #для работы с базой данный
use limb\app\worker as Worker; #для работы с базой данный
	/**
	 * работа с данными таблицы
	 *
	 */
	class MainTable
	{

		public function __construct()
		{
			
			if(isset($_COOKIE['language'])) $this -> language = $_COOKIE['language'];
			else 
			{
				$this -> language = "ru_";
			}
		}

		//метод достаюший все поля из таблицы
		public function searchFieldCom()
		{
			#$si = new Base\SearchInq($name);
			#$result = $si -> select() ->  where($key, $value, $operator) -> limit() -> res();

			#code...

		}
		#метод добавляющий данные в таблицу, value - строка следующего вида
		#NULL, '".$this -> title."', '".$this -> keywords."', '".$this -> description."'
		public function insertFieldCom($value)
		{
			#$ri = new Base\RedactionInq($this -> name, $this -> table_key);
			#$result = $ri -> insert($value);

			#code...
		}
		protected function Limb($auth = "noauth")#сборщик страницы
		{

			$menu = MenuTable::MenuLimb($this -> language, $auth);
			$limb = new Worker\Limb();
			$page_ini = parse_ini_file(__DIR__."/../../view/".$this -> language."page.ini");
			
				$template = [
					"norepeat" => ["%title%", "%description%", "%keywords%", "%menu%"],
					"internal" => [["name" => "content", "folder" => "main"]],
					"repeat_tm" => ["menu"]
				];

				$data = [
					"norepeat" => ["title" => $page_ini["main_page_title"], "description" => $page_ini["main_page_description"], "keywords" => $page_ini["main_page_keywords"], "menu" => $menu],
					"repeat_tm" => [[[]]]
				];
				$render = $limb -> TemplateMaster($template, $data, $auth, $this -> html);

				return $render;

			
		}
	}
?>
