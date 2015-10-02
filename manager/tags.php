<?
require_once("../lib/core.php");

$TvLab = new TvLab;
$q = new TvLabQuery;

	
//подключаемся к базе
if (!mysql_connect(DB_HOST, DB_USER, DB_PASS)) {echo "<h2>MySQL Error!</h2>";exit;}
mysql_query('set names utf8');
		
//Если передается параметр перезагрузки, обновляем таблицы
if ($_GET['reload']== 1) {

		//Шаг 1 из 2, собираем ключевые слова из u186876_tvarts.contents 

		//Функция подключения, запроса и подготовки строки ключевых слов
		function ReadAndExplode ($Tags_Name) {
			$Query = "SELECT ".$Tags_Name." FROM u186876_tvarts.contents";
			$result = mysql_query ($Query);
			while ( $arr[] = mysql_fetch_array($result) );
			$numRows = mysql_num_rows ($result);
			for ($x=0; $x<$numRows; $x++) {$String .= $arr[$x][0].', ';}
			$String = preg_replace("/ ,/", "", $String);
			return explode(", ", $String);
			}
			
		//Собираем строки из общей таблицы, и приводим их к раздельному виду в 5-ти массивах
		$Tags_SA = ReadAndExplode("Tags_SA");
		$Tags_Fashion = ReadAndExplode("Tags_Fashion");
		$Tags_Arts = ReadAndExplode("Tags_Arts");
		$Tags_Music = ReadAndExplode("Tags_Music");
		$Tags_Others = ReadAndExplode("Tags_Others");
		
		//подсчет количества ключевых слов по каждой категории
		$num_Tags_SA = count($Tags_SA);
		$num_Tags_Fashion = count($Tags_Fashion);
		$num_Tags_Arts = count($Tags_Arts);
		$num_Tags_Music = count($Tags_Music);
		$num_Tags_Others = count($Tags_Others);
		
		//находим максимальную категорию
		$numMax = max($num_Tags_SA, $num_Tags_Fashion, $num_Tags_Arts, $num_Tags_Music, $num_Tags_Others);


		//Очистка таблицы
		$droptQuery = "TRUNCATE TABLE u186876_tvarts.tags";
		mysql_query($droptQuery);
		
		//помещаем все значения колонок в u186876_tvarts.tags в одном общем цикле
		for ($x=0; $x<$numMax; $x++) 
			{$insertQuery_Tags = "INSERT INTO u186876_tvarts.tags (Tags_SA, Tags_Fashion, Tags_Arts, Tags_Music, Tags_Others) VALUES ('$Tags_SA[$x]', '$Tags_Fashion[$x]', '$Tags_Arts[$x]', '$Tags_Music[$x]', '$Tags_Others[$x]')";
				mysql_query($insertQuery_Tags);
				$mysql_error = mysql_error(); echo '<br />'.$mysql_error.'<br />';
			}	
}


echo "<table><tr>";
ShowRating("Tags_SA",30);
ShowRating("Tags_Fashion",10);
ShowRating("Tags_Arts",10);
ShowRating("Tags_Music",10);
ShowRating("Tags_Others",10);
echo "</tr></table>";


?>