<div class="Input_Form">
    <div class="IntroTag">
        <a class="TvToDesktop" href="<? echo SITE_URL ?>"></a>
        <form method="get" autocomplete="off">
            <div <? if (!empty ($_GET['code'])) {
                if (!Check_Valid_Id($_GET['code'])) {
                    echo 'class="input_error"';
                }
            } ?>>
                <input name="code" class="code" placeholder="<? echo $nme_Code ?>"/></textarea>
                <input type="submit" value="" class="SendVideo"/></p>
            </div>
        </form>
    </div>

    <div class="tempLoginDiv">

        <?

        if (isset ($AuthUser)) {
            include("logged_in.php");

            echo '
    <div style="text-align:center; margin:20px 0 5px;">
        <a href="javascript:void(0)" style="border-bottom: dashed 1px #FF9900; text-decoration:none; color:#FFF;" id="HowItWorks">How it works?</a><br />
        <a href="https://docs.google.com/document/d/1qFXvgc-P5T7HBGVAo2p7Fqof72WtOX8BprumrjKcPE8/edit?usp=sharing" target="_blank">Sources List</a>
    </div>
        ';

        } else {
            echo '<p style="font-size:11px">You can not save the video to the database without authorization. <br /> <span style="color:grey">But, you still can specify a link to the video (or just an ID) and go further for demo purposes.</span></p><p>&nbsp;</p>';
            include("not_logged_in.php");
        }
        ?>

    </div>

    <div style="text-align:center;"><? if ($isVideoExist == 1) {
            echo 'This video is already in the database';
        }; ?></div>

    <div style="margin:0 auto; width:1096px; display:none;" id="HowItWorks-Img"><img src="_global/img/scheme.png"/>
    </div>
    <!--
    <section class="bookmarklet">
      <h2 class="title_4"></span></h2>
      <div class="note-box">
        <p>Занесите эту ссылку в закладки.</p>
       <a class="bookmarket" href="javascript:(function(){window.open('http://www.televisionlab.ru/add/?(code='+encodeURIComponentlocation.href));})()">Букмаркет TelevisionLab</a>
      </div>
      <h4>Как использовать букмарклет</h4>

      <p><b>Способ 1:</b> Щелкните правой кнопкой мыши на ссылке букмарклета и
    занесите эту ссылку в закладки браузера. Перейдите на веб-страницу, с которой
    необходимо скачать файл, и вызовите созданную закладку.</p>

    <p><b>Способ 2:</b> Пользователи браузера Chrome, Opera, Mozilla могут перетащить ссылку букмарклета
    на панель инструментов и нажатием кнопки вызывать букмарклет.</p>
    </section>
    -->

</div>