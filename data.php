<?php
header("Cache-Control: no-store");
require_once("lib/core.php");

$TvLab = new TvLab;
$q = new TvLabQuery;

/*Все параметры, передаваемые в GET URL скрипту index.php перенаправляются сюда через $HttpQuery = http_build_query($_GET, '', '&'); */


/*----------------Обработка входных данных */
$Input = array(
    "getSet" => $_GET['set'],
    "Mode" => $_GET['md'],
    "tags" => $_GET['tags'],
    "page" => $_GET['page'],
    "video" => $_GET['video']
);

extract( SecureVars( $Input ), EXTR_OVERWRITE );



//Начинаем формировать MySQL зпрос $specificQuery
$specificQuery = "SELECT * FROM u186876_tvarts.contents".$isStack." WHERE";


//Извлекаем данные из текстовой поисковой формы и прибавляем к строке запроса

if (isset($tags)) {//начинаем работу после проверки наличия содержимого в переменной с поисковой формы

	$SearchData = $tags;
	
	if (iconv_strlen($SearchData, 'UTF-8') > 1){ //продолжаем работу, если данные в форме есть и они больше двух символов
	
		$SearchData = substr($SearchData, 0, 128);//обрезаем строку до 128 символов
		$SearchData = preg_replace("/[^\s\w.,-]/", "", $SearchData);//оставляем только буквы, цифры, пробелы
		$SearchData = trim (preg_replace("/  +/", " ", $SearchData)); //убираем двойные и более пробелы, в т.ч. по краям
		$SearchWords = explode(" ", $SearchData); //разбиваем строку на отдельные слова, ориентируясь на пробелы
		$SearchWords_n = count ($SearchWords); //считаем слова поиска и запускаем цикл
		
		$specificQuery = $specificQuery.' ('; // открываем скобки для вербального запроса
		
		for ($x=0; $x<$SearchWords_n; $x++) {
			
			if (iconv_strlen($SearchWords[$x], 'UTF-8') < 4){ //к словаи меньше 4-ти применяем строгое вхождение по слову
				//далее прибавляем строку запроса на 8 столбцов из БД, по одному слову на каждую.
				$specificQuery = $specificQuery.' 
				Title RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR 
				Authors RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR 
				Brand RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR 
				Tv_Channel RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR 
				Location RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR
				Tags_SA RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR
				Tags_Fashion RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]"OR
				Tags_Arts RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR
				Tags_Music RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR
				Tags_Others RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR
				Year RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR';	
				
			} else { //к словам >= 4-ти применяем относительное (исправлено, тоже строгое) вхождение последовательности символов
			
				$specificQuery = $specificQuery.' 
				Title RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR 
				Authors RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR 
				Brand RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR 
				Tv_Channel RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR 
				Location RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR
				Tags_SA RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR
				Tags_Fashion RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR
				Tags_Arts RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR
				Tags_Music RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR
				Tags_Others RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR
				Year RLIKE "[[:<:]]'.$SearchWords[$x].'[[:>:]]" OR';

				//альтернативный вариант формирования SQL запроса RLIKE "(\w{0,6})var(\w{0,6})"
			};
			//конец цикла
		};

	
	//закрываем скобки заменой от последнего OR и ставим строгое условие с дальнейшими параметрами	
	if( preg_match("/ OR$/", $specificQuery)) {
		$specificQuery = preg_replace("/ OR$/", " ) AND", $specificQuery);
		}
		
	} else { 
	//если данные в форме отсутствуют или <= двух символов то Данные поисковой формы не участвует в общем SQL запросе
	};
};



/*---------------------------
	Извлекаем флаги из ключ-запроса*/

if(preg_match("/c1/", $getSet)) {$getMtype[] = 0;}
if(preg_match("/d1/", $getSet)) {$getMtype[] = 1;}
if(preg_match("/s1/", $getSet)) {$getMtype[] = 2;}
if(preg_match("/a1/", $getSet)) {$getMtype[] = 3;}
if(preg_match("/t1/", $getSet)) {$getMtype[] = 4;}
if(preg_match("/v1/", $getSet)) {$getMtype[] = 5;}


// Выборка строгая или нет
if ($Mode == "on") {

    $getMtypeInString = implode($getMtype, ",");

    if (isset($getMtypeInString)) {
        $specificQuery .= ' Motion_Type = "' . $getMtypeInString . '" AND';
    }

} else {

        if ($getMtype[0] >= 0) {
            $getMtype_n = count ($getMtype);
            for ($x=0; $x<$getMtype_n; $x++) {
                $specificQuery .= ' Motion_Type RLIKE '.$getMtype[$x].' AND';
            };
        };

    }




//Замена последнего AND в MySQL запросе

if( preg_match("/ AND$/", $specificQuery)) {
	$specificQuery = preg_replace("/ AND$/", "", $specificQuery);
	}

//профилактическая чистка запроса от двойных и более пробелов

$specificQuery = preg_replace("/  +/", " ", $specificQuery);


//Проверяем, имеется ли дополнительные условия (различия) от первоначального SQL запроса

if ($specificQuery == "SELECT * FROM u186876_tvarts.contents".$isStack." WHERE") {
	$specificQuery = "SELECT * FROM u186876_tvarts.contents".$isStack." WHERE State = 1"; //если условий не было, составляем общий запрос по умолчанию
}


//добавляем дополнительные условия к запросу, сортировка по возрасту

$specificQuery .= ' ORDER BY id DESC';


//Кол-во строк запроса $specificQuery для последующго разделения на порции
$TotalRows = $q->Query(preg_replace("/SELECT \*/", "SELECT COUNT(*)", $specificQuery))->fetch_row();

//Узнаем максимальное количество страниц на выдачу, устанавливаем лимит
$inPage = 10;
$MaxPages = ceil($TotalRows[0] / $inPage);
if ($page == 0) {$PageIncr = 0;} else {$PageIncr = ($page -1) * 10;}

//Финализируем запрос, добавляем лимит к запросу, для порционной выдачи (offset, number of rows)
$specificQuery .= ' LIMIT '.$PageIncr.','.$inPage.';';


//делаем запрос на $inPage (10) позиций
$result = $q->Query($specificQuery);


//Если в ответе что-то есть, формируем Json ответ
if ($result->num_rows > 0){

    include("nodes/WaterfallJson_Tpl.php");

}


