<div class="TopPanelBox">
    <div class="TopPanel">
    	<div class="tpLogo"><? if (isset($VideoId)) {echo "<a href=\"?video=".$VideoId."\"></a>";} ?></div>

		<div class="add_bt"><a href="/add"><img src="img/add.png" title="<? echo $VideoCount ?>"></a></div>
<? 
			//Панель LoggedInfo
			if (isset($_SESSION['user_name'])) {
				echo '
			<table class="PersonalInfo"><tr>
				<td width="200">
					<div class="UserInfo">
						<a class="UserLogout" href="?logout"></a><div class="UserName">'.$_SESSION['user_name'].'</div>
					</div>
					<div class="Activity">activity <span class="Ratio">'.$_SESSION['user_activity'].'</span>
				</td>
				<td>
					<div class="UserStat">
						<div class="Add">Add <span class="Sum">'.$_SESSION['user_added'].'</span></div>
						<div class="Edit">Edit <span class="Sum">'.$_SESSION['user_edit'].'</span></div>
					</div>
					<div class="BoardSetup" id="BoardSetup">
						<div class="BoardTitle">';
				if ($_SESSION['user_board'] == 0) {echo "Common board";} else {echo "Personal board";}	
				echo '</div>
						<div class="DownArr"></div>
					</div>
				</td>
				</tr>
			</table>
				';
			}
?>
    </div>
    <div class="TopPanelBorder"></div>
</div>
<div class="TopPanelMargin"></div>