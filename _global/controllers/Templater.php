<?php

function insertHead($LayoutSet, $Template)
{
    $PageLayout = file_get_contents($Template);

    foreach ($LayoutSet as $Param => $Value) {

        // Simple replacement of placeholders
        if (!is_array($Value)) {
            $PageLayout = str_replace("[*" . $Param . "*]", $Value, $PageLayout);

            // Other params will be with some additional logic
        } else {


            if ($Param == "css") {
                foreach ($Value as $SubValue) {

                    if ($SubValue == "google_fonts") {
                        $css[] = '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:600italic,700,600,400,300" />';
                    } else {
                        $css[] = '<link rel="stylesheet" type="text/css" href="' . $SubValue . '" />';
                    }
                }

                $css = implode("\n    ", $css);
                $PageLayout = str_replace("[*css*]", $css, $PageLayout);
            }

            if ($Param == "js") {
                foreach ($Value as $SubValue) {
                    $js[] = '<script type="text/javascript" src="' . $SubValue . '"></script>';
                }
                $js = implode("\n    ", $js);
                $PageLayout = str_replace("[*js*]", $js, $PageLayout);
            }

            if ($Param == "Append") {
                foreach ($Value as $SubValue) {
                    $PageLayout = str_replace("[*Append*]", $SubValue, $PageLayout);
                }
            }

            if ($Param == "Prepend") {
                foreach ($Value as $SubValue) {
                    $PageLayout = str_replace("[*Prepend*]", $SubValue, $PageLayout);
                }
            }
        }
    }
    $PageLayout = str_replace("\n    \r\n\r", "", $PageLayout);
    $PageLayout = str_replace("\n    \r", "", $PageLayout);

    echo $PageLayout;

}


function insertFooter($Template)
{
    $PageLayout = file_get_contents($Template);
    echo $PageLayout;

    global $TimeStat;
    echo "\n<!-- Generated: " . (microtime(true) - $TimeStat) . "s -->";
}