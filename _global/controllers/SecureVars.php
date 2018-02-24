<?php

function Triming( $value ) {
    $value = preg_replace("/[^\s\w\(\)&А-яЁе.,=\+\$№–!%:?-]/u", "", $value);
    $value = trim( preg_replace("/  +/", " ", $value) );
    return $value;
}


// general all inputs cleaning function
function SecureVars( $DataArr ) {
    if ( !is_array($DataArr) ) { $DataArr = array($DataArr); }

    $OutData = array();
    foreach ( $DataArr as $Key=>$Value ) {

        if ( !empty($Value) ) {

            if ( !is_array($Value) ) { $OutData[$Key] = Triming( $Value ); }

            else {

                $SubArr = array();
                foreach ( $Value as $SubKey=>$SubValue ) {

                    if ( !is_array($SubValue) ) { $SubArr[$SubKey] = Triming( $SubValue ); }

                }

                $OutData[$Key] = $SubArr;
            }
        }
    };

    return $OutData;
}


// cleaning function, keeps only letters, digits, spaces, dots, commas, dash, brackets
// somehow it passes symbol <
function GetSecureData ($GetData, $DataName) {
    if (isset($GetData)) {
        if (!is_array($GetData)) {$GetData = array($GetData);} // Если переменная не массив, назначаем её таковой
        $Amount = count ($GetData); //пересчет объектов в массиве
        for ($x=0; $x<$Amount; $x++) { // каждый объект массива прорабатываем отдельно в цикле

            $GetData[$x] = preg_replace("/[^\s\w\(\)&А-яЁе.,=-]/u", "", $GetData[$x]);//оставляем только буквы, цифры, пробелы, точки, запятые, тире
            $GetData[$x] = trim (preg_replace("/  +/", " ", $GetData[$x])); //убираем двойные и более пробелы, в т.ч. по краям
            $GetData[$x] = substr($GetData[$x], 0, 350);//обрезаем строку до 350 символов
            $OutData[] = $GetData[$x]; // собираем новый массив $OutData

        };
        return implode($OutData); // сливаем массив
    };
};


// cleaning function for arrays, keeps only letters, digits, spaces, dots, commas, dash, brackets
function GetSecureData_Arr ($GetData, $DataName) {
    if (isset($GetData)) {
        if (!is_array($GetData)) {$GetData = array($GetData);}
        $Amount = count ($GetData);
        for ($x=0; $x<$Amount; $x++) {

            $GetData[$x] = preg_replace("/[^\s\w\(\)&А-яЁе.,-]/u", "", $GetData[$x]);
            $GetData[$x] = trim (preg_replace("/  +/", " ", $GetData[$x]));
            $GetData[$x] = substr($GetData[$x], 0, 350);
            $OutData[] = $GetData[$x];

        };

        return ($OutData);
    };
};


// cleaning function, keeps only letters, digits, spaces, and .,-<>=!"
function GetSecureData_Links ($GetData, $DataName) {
    if (isset($GetData)) {
        if (!is_array($GetData)) {$GetData = array($GetData);}
        $Amount = count ($GetData);
        for ($x=0; $x<$Amount; $x++) {

            $GetData[$x] = preg_replace("/[^\s\w.,_:\/<&?;>=!\"\-]/", "", $GetData[$x]);
            $GetData[$x] = trim (preg_replace("/  +/", " ", $GetData[$x]));
            $GetData[$x] = substr($GetData[$x], 0, 500);
            $OutData[] = $GetData[$x];

        };
        return implode($OutData);
    };
};


// cleaning function, keeps only letters, digits, spaces, and ,_-
function GetSecureData_Tags ($GetData, $DataName) {
    if (isset($GetData)) {
        if (!is_array($GetData)) {$GetData = array($GetData);}
        $Amount = count ($GetData);
        for ($x=0; $x<$Amount; $x++) {

            $GetData[$x] = preg_replace("/[^\s\wА-яЁе,_-]/", "", $GetData[$x]);
            $GetData[$x] = trim (preg_replace("/  +/", " ", $GetData[$x]));
            $GetData[$x] = substr($GetData[$x], 0, 500);
            $OutData[] = $GetData[$x];

        };
        return implode($OutData);
    };
};


// cleaning function, keeps only digits
function GetSecureData_Digits ($GetData, $DataName) {
    if (isset($GetData)) {
        if (!is_array($GetData)) {$GetData = array($GetData);}
        $Amount = count ($GetData);
        for ($x=0; $x<$Amount; $x++) {

            if( preg_match("/[^\d]/", $GetData[$x])) {

                $GetData[$x] = preg_replace("/[^\d]/", "", $GetData[$x]);
                $GetData[$x] = substr($GetData[$x], 0, 3);
                $OutData[] = $GetData[$x];
            }

            else $OutData[] = substr($GetData[$x], 0, 3);

        };
        return implode($OutData);
    };
};