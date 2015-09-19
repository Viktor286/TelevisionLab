<form action="add/" method="get" autocomplete="off">
    <div <? if (!empty ($_GET['code'])) {if (!Check_Valid_Id($_GET['code'])) {echo 'class="input_error"';}} ?>>
    <input name="code" class="code" placeholder="New Video..."  /></textarea>
    <input type="submit" value="" class="SendVideo"/></p>
    </div>
</form>