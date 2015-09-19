<?php

header("Cache-Control: no-store");
require_once("lib/core.php");

$TvLab = new TvLab;
$q = new TvLabQuery;

/*Все параметры, передаваемые в GET URL скрипту index.php перенаправляются сюда через $HttpQuery = http_build_query($_GET, '', '&'); */


/*----------------Обработка входных данных */
$Input = array(

    "page" => $_GET['page'],
    "User" => $_GET['user'],
    "Section" => $_GET['section']
);

extract( SecureVars( $Input ), EXTR_OVERWRITE );


$SectionList = array(
    "timeline",
    "approved",
    "stacked",
    "review"
);

//Give first name from SectionList (timeline)  to empty section
if ( empty ($Section) ) { $Section = $SectionList[0]; }

//Test for right section or die
if ( !in_array( $Section, $SectionList ) )  {echo "no section"; die();}


//Test for right user or die
$UserQuery = '(SELECT * FROM u186876_tvarts.users WHERE user_name = "'.$User.'")';
$result = $q->Query($UserQuery);
if ($result->num_rows != 1) { echo "no such user"; die(); }


//Выбор таблицы contents в зависимости от юзера
//if (RoleState() == 1 or RoleState() == 2) {$isStack = "_stack"; $UserOutput = " AND By_User = '".$_SESSION['user_name']."'";}
//if (RoleState() == 0) {$isStack = ""; $UserOutput = "";}

//Model
$Timeline = '(SELECT * FROM u186876_tvarts.contents WHERE By_User =  "'.$User.'") UNION (SELECT * FROM u186876_tvarts.contents_stack WHERE By_User =  "'.$User.'")';

$Approved = '(SELECT * FROM u186876_tvarts.contents WHERE By_User = "'.$User.'")';

$Stacked = '(SELECT * FROM u186876_tvarts.contents_stack WHERE By_User = "'.$User.'")';

$Review = '(SELECT * FROM u186876_tvarts.contents_stack WHERE By_User != "'.$User.'")';

//Logic of model
switch ($Section) {
    case "timeline": $specificQuery = $Timeline; break;
    case "approved": $specificQuery = $Approved; break;
    case "stacked": $specificQuery = $Stacked; break;
    case "review": $specificQuery = $Review; break;
}

$specificQuery_cnt = preg_replace("/SELECT \*/", "SELECT COUNT(*)", $specificQuery);

//Кол-во строк запроса $specificQuery для последующго разделения на порции
$result = $q->Query($specificQuery_cnt);

$TotalRows = 0;
while($row = $result->fetch_assoc()){
    $TotalRows = $TotalRows +  $row['COUNT(*)'];
}

//Узнаем максимальное количество страниц на выдачу, устанавливаем лимит
if ($Section == $SectionList[0] ) { $inPage = 3; } else { $inPage = 10; }

$MaxPages = ceil($TotalRows / $inPage);
if ($page == 0) {$PageIncr = 0;} else {$PageIncr = ($page -1) * $inPage;}


//Финализируем запрос, добавляем лимит к запросу, для порционной выдачи (offset, number of rows)
$specificQuery .= ' ORDER BY id DESC';
$specificQuery .= ' LIMIT '.$PageIncr.','.$inPage.';';

//делаем запрос на 10 позиций
$result = $q->Query($specificQuery);

//echo $specificQuery;

//Если в ответе что-то есть, формируем Json ответ
if ($result->num_rows > 0){

	echo '
        {
            "total": '.$TotalRows.',
            "pages": '.$MaxPages.',
            "page": '.$page.',
            "result": [';

        while ($row = $result->fetch_assoc()) {

            $Rating = $row['Rating'] / 10000;
            $Rating = round($Rating,1);

            if ($video == $row['OutId']) { $CurrentClass = " here"; } else {$CurrentClass = "";}

            $Collect_JSON_Attr .= '
        {

                "Title": "'.$row['Title'].'",
                "Img": "'.$row['Img'].'",
                "Authors": "'.$row['Authors'].'",
                "Location": "'.$row['Location'].'",
                "Brand": "'.$row['Brand'].'",
                "Tv_Channel": "'.$row['Tv_Channel'].'",
                "Likes": "'.$row['Likes'].'",
                "Rating": "'.$Rating.'",
                "Motion_Type": "'.$row['Motion_Type'].'",
                "Broadcast_Type": "'.$row['Broadcast_Type'].'",
                "Tempo": "'.$row['Tempo'].'",
                "Tags_SA": "'.$row['Tags_SA'].'",
                "Tags_Fashion": "'.$row['Tags_Fashion'].'",
                "Tags_Arts": "'.$row['Tags_Arts'].'",
                "Tags_Music": "'.$row['Tags_Music'].'",
                "Tags_Others": "'.$row['Tags_Others'].'",
                "Year": "'.$row['Year'].'",
                "Img_Small": "'.$row['Img_Small'].'",
                "Width": 640,
                "Height": 360,
                "CurrentClass": "'.$CurrentClass.'",
                "OutId": "'.$row['OutId'].'"
            },';

        };

        //Удаляем последнюю запятую
        $Collect_JSON_Attr = preg_replace("/,$/", "", $Collect_JSON_Attr);

        //выводим Json собраные циклом блоки и закрываем
        echo $Collect_JSON_Attr.'
                 ]
        }
    ';

}


