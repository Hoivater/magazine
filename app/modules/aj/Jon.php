<?php
	namespace limb\app\modules\aj;
	use limb\app\modules\commentary as Com;
	use limb\code\site as Site;


	require "../../../autoload.php";

	class Jon
	{
		private $nameAj;
		private $ex = ["nameAj"];#исключения, которые не проходят через htmlspecialchars
		private $post_nohtml;#массив post пропущенный через htmls...

		function __construct($post)
		{
			$this -> nameAj = htmlspecialchars($post["nameAj"]);

			foreach ($post as $key => $value) {
				$res = $this -> parseHtml($key, $value);
				$this -> post_nohtml[$res[0]] = $res[1];
			}
			$result = $this -> {$this -> nameAj}();

		}
		private function parseHtml($key, $value)
		{
			for($i = 0; $i < count($this -> ex); $i++)
			{
				if($key == $this -> ex[$i] )
				{
					return [$key, $value];
				}
			}
			$key = htmlspecialchars($key, ENT_QUOTES);
			$value = htmlspecialchars($value, ENT_QUOTES);
			return [$key, $value];
		}

		########################################################################
		##########################FUNCTION######################################
		########################################################################
		public function newChecked()
		{
			$tt = new Site\TagsTable();

			$result = $tt -> ReverseUniquew($this -> post_nohtml["idEl"]);
		}
		public function loadCommentary()
		{
			$ct = new Com\CommentaryTable();

			$result = $ct -> LoadCommentary($this -> post_nohtml["id"]);

			echo $result;
		}
		public function newTags()
		{
			$nt = new Site\NoteTable();
			$nt -> newTagsForNote($this -> post_nohtml);

		}
		public function scaleDekada()
		{
			$nt = new Site\GprTable();
			$nt -> scaleDekadaF($this -> post_nohtml);

		}
		public function scaleDay()
		{
			$nt = new Site\GprTable();
			$nt -> scaleDayF($this -> post_nohtml);

		}
		public function visibleSwitch()
		{
			$nt = new Site\GprTable();
			$nt -> visibleSwitchF($this -> post_nohtml);

		}
		public function loadNote()
		{
			$nt = new Site\NoteTable();

			//создаем заметку 
			$res = $nt -> addNote($this -> post_nohtml);
			//удаляем заметку
			$bt = new Site\BloopTable();
			$bt -> deleteBloop($this -> post_nohtml["link"]);
		}

		public function successNote()
		{
			$nt = new Site\NoteTable();

			//создаем заметку 
			$nt -> addNote($this -> post_nohtml, 1);
			//удаляем заметку
			$bt = new Site\BloopTable();
			$bt -> deleteBloop($this -> post_nohtml["link"]);
            echo "ok";
		}

		public function successNoteLite()
		{
			$nt = new Site\NoteTable();

			//создаем заметку
			$res = $nt -> successLite($this -> post_nohtml["link"]);
			echo $res;
		}
		public function deleteNoteSe()
		{
			$nt = new Site\NoteTable();

			//создаем заметку
			$res = $nt -> deleteNoteS($this -> post_nohtml["link"]);
			echo $res;
		}
		public function searchTags()
		{
			$tt = new Site\TagsTable();

			//создаем заметку
			$res = $tt -> searchTags($this -> post_nohtml["search_word"]);
			echo $res;
		}
		public function dostupNoteLite()
		{
			$nt = new Site\NoteTable();

			//создаем заметку
			$res = $nt -> dostupLite($this -> post_nohtml["link"]);
			echo $res;
		}
		public function deleteNote()
		{
			
			//удаляем заметку
			$bt = new Site\BloopTable();
			$bt -> deleteBloop($this -> post_nohtml["link"]);
			echo "ok";

		}
		public function reportView()
		{
			
			$nt = new Site\NoteTable();
			//создаем заметку
			$res = $nt -> reportViewF($this -> post_nohtml["tags"]);
			// echo $res;

		}

		public function reportUpcomingView()
		{
			
			$nt = new Site\NoteTable();
			//создаем заметку
			$res = $nt -> reportUpComViewF();
			// echo $res;

		}

		########################################################################
		########################################################################
		########################################################################
	}

	#объект класса Jon создается лишь в том случае, когда строка post["nameAj"] соответствует названию функции в классе Jon
	if(isset($_POST["nameAj"]))
	{
		$res = method_exists(Jon::class, $_POST["nameAj"]);
		if($res === true)
		{
			$jon = new Jon($_POST);
		}
	}

?>