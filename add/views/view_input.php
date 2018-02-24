
<main id="addVideo">
    <section>
        <div class="Input_Form">
            <div class="AddCanvas">
                <form method="post" autocomplete="off">
                    <table>
                        <tr>
                            <td width="50"></td>
                            <td colspan="2">

                                <? echo '<div class="UserTitle">';
                                if (isset($UserName)) {
                                    echo 'Вы авторизованы как  <span style="color:white">'.$UserName."</span>";
                                } else {
                                    echo 'Вы не сможе сохранить видео в базу без <a href="add/">авторизации.</a>';
                                }
                                echo "</div>"; ?>

                            </td>
                            <td width="50"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td width="650" rowspan="2" data-title="image" class="tags">
                                <a class="bt_back" href="add/"></a>
                                <a class="bt_download" href="http://sfrom.net/https://vimeo.com/<?= $Vimeo_Id; ?>" target="_blank"></a>
                                <?

                                // Вычисление scal'a высоты при ширине 500:
                                $FrameRatio = $Width/$Height;

                                if ($FrameRatio < 1.6 && $FrameRatio >= 1) {$RelWidth = 400;} elseif ($FrameRatio < 1) {$RelWidth = 150;} else {$RelWidth = 540;}
                                $RelHeight = round (($RelWidth/($FrameRatio)));

                                //Складываем новый код vimeo
                                $NewVimeoEmbed = '<iframe src="//player.vimeo.com/video/'.$OutId.'?title=0&amp;byline=0&amp;portrait=0&amp;color=e78b2f" width="'.$RelWidth.'" height="'.$RelHeight.'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';

                                // Складываем старый код vimeo на случай конфликта при первой передаче GET
                                // $OldVimeoEmbed = '<object width="'.$RelWidth.'" height="'.$RelHeight.'"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id='.$OutId.'&amp;force_embed=1&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00adef&amp;fullscreen=1&amp;autoplay=0&amp;loop=0" /><embed src="http://vimeo.com/moogaloop.swf?clip_id='.$OutId.'&amp;force_embed=1&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00adef&amp;fullscreen=1&amp;autoplay=0&amp;loop=0" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="'.$RelWidth.'" height="'.$RelHeight.'"></embed></object>';

                                //Условия при новом старом флаге
                                echo '<div class="VideoBlock">'.$NewVimeoEmbed.'</div>';


                                ?>
                                <div class="sep_v"></div>
                                <div id="tabs-container">
                                    <ul class="tabs-menu">
                                        <li class="current"><a href="#tab-1"><img src="_global/img/btn_a_sphere.png"></a></li>
                                        <li><a href="#tab-2"><img src="_global/img/btn_a_fashion.png"></a></li>
                                        <li><a href="#tab-3"><img src="_global/img/btn_a_art.png"></a></li>
                                        <li><a href="#tab-4"><img src="_global/img/btn_a_music.png"></a></li>
                                        <li><a href="#tab-5"><img src="_global/img/btn_a_other.png"></a></li>
                                    </ul>
                                    <div class="tab">
                                        <div id="tab-1" class="tab-content">
                                            <div class="tabDescr">
                                                <h2><?= $nme_Tag_SA ?></h2>
                                                <p><?= $nme_Tag_SA_cap ?></p>
                                                <textarea id="sa" class="tags" name="sa" placeholder="<?= $nme_Tag_SA_phd ?>"/><?= $getTags_SA; ?></textarea>

                                                <? if (strlen($Tag_SA_List) > 1) echo '<div class="TagOffer">'.$Tag_SA_List.'</div>'; ?>
                                            </div>
                                        </div>
                                        <div id="tab-2" class="tab-content">
                                            <div class="tabDescr">
                                                <h2><?= $nme_Tag_Fashion ?></h2>
                                                <p><?= $nme_Tag_Fashion_cap ?></p>
                                                <textarea id="fashion" class="tags" name="fashion" placeholder="<?= $nme_Tag_Fashion_phd ?>"/><?= $getTags_Fashion; ?></textarea>
                                                <? if (strlen($Tag_Fashion_List) > 1) echo '<div class="TagOffer">'.$Tag_Fashion_List.'</div>'; ?>
                                            </div>
                                        </div>
                                        <div id="tab-3" class="tab-content">
                                            <div class="tabDescr">
                                                <h2><?= $nme_Tag_Arts ?></h2>
                                                <p><?= $nme_Tag_Arts_cap ?></p>
                                                <textarea id="arts" class="tags" name="arts" placeholder="<?= $nme_Tag_Arts_phd ?>"/><?= $getTags_Arts; ?></textarea>
                                                <? if (strlen($Tag_Arts_List) > 1) echo '<div class="TagOffer">'.$Tag_Arts_List.'</div>'; ?>
                                            </div>
                                        </div>
                                        <div id="tab-4" class="tab-content">
                                            <div class="tabDescr">
                                                <h2><?= $nme_Tag_Music ?></h2>
                                                <p><?= $nme_Tag_Music_cap ?></p>
                                                <textarea id="music" class="tags" name="music" placeholder="<?= $nme_Tag_Music_phd ?>"/><?= $getTags_Music; ?></textarea>
                                                <? if (strlen($Tag_Music_List) > 1) echo '<div class="TagOffer">'.$Tag_Music_List.'</div>'; ?>
                                            </div>
                                        </div>
                                        <div id="tab-5" class="tab-content">
                                            <div class="tabDescr">
                                                <h2><?= $nme_Tag_List ?></h2>
                                                <p><?= $nme_Tag_List_cap ?></p>
                                                <textarea id="tags" class="tags" name="tags" placeholder="<?= $nme_Tag_List_phd ?>"/><?= $getTags_Others; ?></textarea>
                                                <? if (strlen($TagList) > 1) echo '<div class="TagOffer">'.$TagList.'</div>'; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br style="clear:both;" />
                                <? if (strlen($Desc) > 1) echo '<div class="Description"><h2>'.$nme_Related_Description.'</h2><pre>'.$Desc.'</pre></div>'; ?>
                                <? if (strlen($Desc) > 100) echo '<div class="ExpandDesc"></div>'; ?>
                            </td>
                            <td width="650" data-title="primary" class="primary">
                                <a class="bt_help" href="_global/img/collection_classes.png"></a>
                                <div class="CanvasLine<? if (!Check_Title($getTitle) and empty($Title)) {echo '  input_error';} ?>">
                                    <div class="Content"><?= $nme_Title ?>
                                        <input type="text" name="title" value='<? if (!isset ($getTitle)) {echo $Title;} else {echo $getTitle;} ?>'>
                                    </div>
                                </div>
                                <div class="CanvasLine<? if (!Check_Title($getAuthor)and empty($CastList)) {echo '  input_error';} ?>">
                                    <div class="Content_Inline"><?= $nme_Author ?>
                                        <input type="text" class="medium" name="authors" value="<? if (!isset ($getAuthors)) {echo $CastList;} else {echo $getAuthors;} ?>">
                                    </div>
                                    <div class="Content_Inline"><?= $nme_Location ?>
                                        <input type="text" class="short" name="location" value="<? if (isset ($getLocation)) {echo $getLocation;} else {echo $MainUserLocation;} ?>">
                                    </div>
                                </div>
                                <div class="CanvasLine<? if (!Check_Title($getYear)and empty($Year)) {echo '  input_error';} ?>">
                                    <div class="Content_Inline"> <?= $nme_Year ?>
                                        <input type="text" class="tiny" name="year" value="<? if (!isset ($getYear)) {echo $Year;} else {echo $getYear;} ?>">
                                    </div>
                                    <div class="Content_Inline<? if (!Check_Title($getBrand) and empty($Brand)) {echo '  input_error';} ?>"><?= $nme_Brand ?>
                                        <input type="text" class="short" name="brand" value="<? if (!isset ($getBrand)) {echo $Brand;} else {echo $getBrand;} ?>">
                                    </div>
                                    <div class="Content_Inline"><?= $nme_Tv_Channel ?>
                                        <input type="text" class="short" name="tv" value="<?= $getTv_Channel; ?>">
                                    </div>
                                </div>

                                <div class="sep_h"></div></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td data-title="flags" class="flags"><div class="CanvasLine">
                                    <div class="Header"><?= $nme_Broadcast_Type ?></div>
                                    <div class="Content">

                                        <select name="broadcast" id="broadcast">
                                            <option value="0" data-imagesrc="_global/img/bt_type_id.png" data-description="<?= $nme_cat_Identity_cap ?>" <? isSelected ($getBroadcast_Type,0); ?>><?= $nme_cat_Identity ?></option>
                                            <option value="1" data-imagesrc="_global/img/bt_type_adv.png" data-description="<?= $nme_cat_Advertising_cap ?>" <? isSelected ($getBroadcast_Type,1); ?>><?= $nme_cat_Advertising ?></option>
                                            <option value="2" data-imagesrc="_global/img/bt_type_pr.png" data-description="<?= $nme_cat_Presentation_cap ?>" <? isSelected ($getBroadcast_Type,2); ?>><?= $nme_cat_Presentation ?></option>
                                            <option value="3" data-imagesrc="_global/img/bt_type_information.png" data-description="<?= $nme_cat_Information_cap ?>" <? isSelected ($getBroadcast_Type,3); ?>><?= $nme_cat_Information ?></option>
                                            <option value="4" data-imagesrc="_global/img/bt_type_entertainment.png" data-description="<?= $nme_cat_Entertainment_cap ?>" <? isSelected ($getBroadcast_Type,4); ?>><?= $nme_cat_Entertainment ?></option>
                                            <option value="5" data-imagesrc="_global/img/bt_type_art.png" data-description="<?= $nme_cat_Artistic_cap ?>" <? isSelected ($getBroadcast_Type,5); ?>><?= $nme_cat_Artistic ?></option>
                                            <option value="6" data-imagesrc="_global/img/bt_type_education.png" data-description="<?= $nme_cat_Educational_cap ?>" <? isSelected ($getBroadcast_Type,6); ?>><?= $nme_cat_Educational ?></option>
                                        </select>

                                        <select name="broadcast" id="broadcastHidden">
                                            <option value="0">0</option>
                                            <option value="1">0</option>
                                            <option value="2">0</option>
                                            <option value="3">0</option>
                                            <option value="4">0</option>
                                            <option value="5">0</option>
                                            <option value="6">0</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="CanvasLine<? if (!Check_Digits($getMotion_Type)) {echo ' input_error';} ?>">
                                    <div class="Header"><?= $nme_Motion_Type ?></div>
                                    <div class="Content">
                                        <input type="checkbox" class="cbx" name="motion[]" data-sdb-image="url('_global/img/bt40_compositing.png')" value="0" alt="Compositing" <? isChecked ($getMotion_Type,0); ?> />
                                        <input type="checkbox" class="cbx" name="motion[]" data-sdb-image="url('_global/img/bt40_graphics.png')" value="1" alt="3d Graphics" <? isChecked ($getMotion_Type,1); ?> />
                                        <input type="checkbox" class="cbx" name="motion[]" data-sdb-image="url('_global/img/bt40_simulation.png')" value="2" alt="Simulation" <? isChecked ($getMotion_Type,2); ?> />
                                        <input type="checkbox" class="cbx" name="motion[]" data-sdb-image="url('_global/img/bt40_animation.png')" value="3" alt="Cartoon (Drawing)" <? isChecked ($getMotion_Type,3); ?> />
                                        <input type="checkbox" class="cbx" name="motion[]" data-sdb-image="url('_global/img/bt40_stop_motion.png')" value="4" alt="Stop Motion" <? isChecked ($getMotion_Type,4); ?> />
                                        <input type="checkbox" class="cbx" name="motion[]" data-sdb-image="url('_global/img/bt40_video.png')" value="5" alt="Video" <? isChecked ($getMotion_Type,5); ?> />
                                    </div>
                                </div>

                                <div class="CanvasLine<? if (!Check_Digits($getTempo)) {echo ' input_error';} ?>">
                                    <div class="Header"><?= $nme_Tempo ?>
                                        <div id="TempoDisplay"></div>
                                        <div id="TempoComment"></div>
                                    </div>
                                    <div class="Content">
                                        <div id="Slider">
                                            <div id="Tempo"></div>
                                            <div class="tempo-scale"></div>
                                            <input type="hidden" id="TempoAmount" name="tempo" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="CanvasLine">
                                    <div class="Header"><?= $nme_Internal_Rating ?>
                                        <div id="RatingDisplay"></div>
                                        <div id="RatingComment"></div>
                                    </div>
                                    <div class="Content">
                                        <div id="Slider">
                                            <div id="Rating"></div>
                                            <input type="hidden" id="RatingAmount"  name="rating" value="">
                                        </div>
                                    </div>
                                </div>
                                <? PlaceCSRFToken() ?><br />
                                <div class="send">
                                    <input type="submit" value="<? if ( basename(getcwd()) == "add" ) {echo $nme_Send_Video;} else {echo $nme_Save_Video;} ?>"/>

                                </div>
                                <input type="hidden" name="video" value="<? if (!isset ($getVideo)) {echo $Vimeo_Id;} else {echo $getVideo;} ?>">
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="2" data-title="final"></td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div id="ghost"></div>
    </section>

</main>




