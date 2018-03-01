<div class="NoResultBlock">
    <div class="NoResultMsg">
        <span>Search robot returned no result</span>
        <a href="javascript:void(0);" onclick="DropTypeOnClick();return true">Drop Types</a>
        <!--
        <a href="/?video=<?
        $VideoHistoryArr = explode(",", $_COOKIE["VideoHistory"]); //already filtered when was added to cookie
        echo $VideoHistoryArr[0];
        //$VideoHistory = trim( str_replace("  ", " ", preg_replace("/[^\s\w\(\)&А-яЁе.,=\+\$№–!%:?-]/u", "", $_COOKIE["VideoHistory"]) ) );
        //$VideoHistoryArr = explode(",",$VideoHistory);
        //echo $VideoHistoryArr[0];
        ?>" class="StartOver">&#8634; Start over</a>
        -->
        <a href="/" class="StartOver">&#8634; Start over</a>

    </div>
    <div class="NoResultAdvice">
        <div>Popular kewords:</div>
        <br/>
        <span class="Tags">

                        <?
                        $PopularTags = array(
                            "micrographics",
                            "shapes",
                            "explaner",
                            "typography",
                            "arena",
                            "flat",
                            "corporate",
                            "urban",
                            "infographics",
                            "colorful",
                            "digital",
                            "sport",
                            "science",
                            "sound fx",
                            "orchestra",
                            "inspiring"
                        );

                        foreach ($PopularTags as $TagName) {
                            echo '<a class="advice-tag" href="javascript:void(0);" title="' . $TagName . '" onclick="ResetSet(\'' . $TagName . '\'); return true;">' . $TagName . '</a>' . "\n";
//                                echo '<a class="tag" title="'.$TagName.'" data-tag="'.$TagName.'">'.$TagName.'</a>'."\n";
                        }

                        ?>

                    </span>
    </div>
</div>
