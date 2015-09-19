<?

//Подготовка теговой системы, пока статические данные

$Tag_SA_List = 'Art, Beauty, Adventures, Story, Fantasy, Spiritual, Culture, Sport, Games, Enertament, Mans, Womens, Comedy, Show, Cinema, Fun, Weird, News, Info, Promo, Test, Science, Education, History, Political, Social, Holiday, Nature, Health, Industry, Buisness, Finance, Services, Vehicles, Technology, Digital, CG, Crafts, War, Criminal, Sexual stuff';
	
$Tag_Fashion_List = 'gloss, corporate, gala, Elegant, modern, avant-garde, glamor, hipster, punk, Casual, ethnic, Country, thrash, military, childrens, teenage, retro, toys, uniform, Professional, Ancient, Antique, Vintage, Western, Urban, Formal, Active, Subculture, Geek, Luxury, Exotic';
	
$Tag_Music_List = 'neutral, electronic, hardcore, jazz, blues, classic, Acoustic, orchestra, pop, rnb, hiphop, rock, soul, ethno,  60s, 70s, 80s, 90s, Dance, Sound Fx, Noise, Bright, Optimistic, Positive, Calm, Gentle, Mellow, Soft, Warm, Dramatic, Disturbing, Angry, Epic, Power, Energy, Passion, Inspiring, Magic, Extreme, Bass, Drum, Buzz, Glitch, Mystical, Nostalgic, Funky, Minimal, Trip Hop, Dubstep, Lo-fi, Dub, Folk, House, Ambient, Breakbeat, Techno, Industrial, Noise';
	
$Tag_Arts_List	 = 'Realism, Abstract, Minimalism, Futurism, Sci-Fi, Pop-art, Surrealism, Contemporary, Cinematic, Cartoon, Collage, Retouch, Draw, Photography, Print, Typography, Maquette, Sculpt, Geometric, Materials, Construct, Micrographics';



//Подготовка тэглистов для тэг-системы
$Tag_SA_List_arr = explode(", ", $Tag_SA_List);
$Tag_Fashion_List_arr = explode(", ", $Tag_Fashion_List);
$Tag_Music_List_arr = explode(", ", $Tag_Music_List);
$Tag_Arts_List_arr = explode(", ", $Tag_Arts_List);

unset ($Tag_SA_List);
unset ($Tag_Fashion_List);
unset ($Tag_Music_List);
unset ($Tag_Arts_List);

foreach ($Tag_SA_List_arr as $key => $value) {
	$Tag_SA_List .= '<span class="tagInsertSa" data-num="'.$key.'">'.$value.'</span>, ';
	}
	
foreach ($Tag_Fashion_List_arr as $key => $value) {
	$Tag_Fashion_List .= '<span class="tagInsertFashion" data-num="'.$key.'">'.$value.'</span>, ';
	}
	
foreach ($Tag_Music_List_arr as $key => $value) {
	$Tag_Music_List .= '<span class="tagInsertMusic" data-num="'.$key.'">'.$value.'</span>, ';
	}
	
foreach ($Tag_Arts_List_arr as $key => $value) {
	$Tag_Arts_List .= '<span class="tagInsertArts" data-num="'.$key.'">'.$value.'</span>, ';
	}

$Tag_SA_List = preg_replace("/, $/", "", $Tag_SA_List);
$Tag_Fashion_List = preg_replace("/, $/", "", $Tag_Fashion_List);
$Tag_Music_List = preg_replace("/, $/", "", $Tag_Music_List);
$Tag_Arts_List = preg_replace("/, $/", "", $Tag_Arts_List);



?>