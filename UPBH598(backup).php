<!-- NavThemesService.php -->
<?php
namespace frontend\app\navThemes;

use common\helps\HelpsImg;
use common\helps\HelpsJson;
use common\helps\Ly200;
use common\models\app\AppConfig;
use Yii;

/**
 * 导航风格
 * Class nav_themes
 */
class NavThemesService
{
	/**
	 * 获取导航风格
	*/
	public static function getNavThemes(array $data)
	{
		$c = Yii::$app->params;
		$postData = $data;
		$defaultNavSwitch = (int)($postData['defaultNavSwitch'] ?? 0);
		$navData = $defaultNavSwitch ? Ly200::getNavData() : [];
		$navMenu = $navData['Menu'] ?? [];

		$navConfigJson = AppConfig::find()->where(['ClassName' => 'nav_themes'])->select(['ConfigData'])->limit(1)->asArray()->oneCache();
		$navConfigData = HelpsJson::decode($navConfigJson['ConfigData'] ?? '');

		$navHtml = '';
		foreach ((array)$navMenu as $k => $v) {
			$menuThemesData = $navConfigData[$v['MId']] ?? [];
			$menuThemesType = $menuThemesData['Type'] ?? 1;
			$navHtml .=	'<li class="first_nav_li ' . ($v['Down'] ? 'has_sec' : '') . ($menuThemesType != 1 ? ' full_nav_style' : ' default_nav_themes') . '">';
			$navHtml .=		'<a class="first_nav " href="' . $v['Url'] . '"' . $v['Target'] . '><span>' . $v['Name'] . '</span></a>';
			$navHtml .= 	self::getSecNavData($v, $k, $navData, $menuThemesData);
			$navHtml .=	'</li>';
		}

		Ly200::eJson($navHtml, 1, 0);
	}

	public static function getSecNavData(array $data, int $key, array $navData, array $menuThemesData = [])
	{
		$c = Yii::$app->params;
		$secHtml = '';

		$navType = $menuThemesData['Type'] ?? 1;
		if ($data['Down'] && !empty($navData['MenuSub'])) {
			$imgLang = substr($c['lang'], 1);
			// 下拉样式
			$dropType = $data['DropType'];

			$navHtml = '';
			if ($navType == 3) {
				$UId = "0,{$data['MId']},";
				$secondData = $navData['MenuSub'][$UId] ?? [];
				$menuCount = count($secondData);
				$picCount = !empty($menuThemesData['Data']) ? count($menuThemesData['Data']) : 0;
				$count = max([$menuCount, $picCount]);

				$navHtml .= '<div id="nav_sec_' . $key . '" class="nav_list">';
				
				for ($i = 0; $i < $count; ++$i) {
					$menuData = $navData['MenuSub'][$UId][$i] ?? ['Name' => '', 'Url' => '', 'MId' => 0];
					$imageData = $menuThemesData['Data'][$i] ?? ['PicPath' => ''];
					$menuIcon = Ly200::checkCdnPicture($menuData['Icon'] ?? '');
					
					$thirdUId = "0,{$data['MId']},{$menuData['MId']},";
					$thirdData = $navData['MenuSub'][$thirdUId] ?? [];
					$thirdCount = count($thirdData);
					$navHtml .=	'<dl class="nav_sec_item ' . ($thirdCount > 0 ? 'has_third' : '') . ' ">';
					$navHtml .=		'<dt>';
					$navHtml .=			'<a class="nav_sec_a" href="' . $menuData['Url'] . '" title="' . $menuData['Name'] . '" ' . ($menuData['Target'] ?? '') . '>' . ($menuIcon ? '<span class="nav_sec_icon nav_icon"><img src="' . $menuIcon . '" /><span></span></span>' : '') . $menuData['Name'] . '<em></em></a>';
					$navHtml .=			'<div class="nav_third_box">';
										foreach ((array)$thirdData as $v2) {
											$fourthUId = "{$thirdUId}{$v2['MId']},";
											$fourthData = $navData['MenuSub'][$fourthUId] ?? [];
											$fourthCount = count($fourthData);
											$menuIconV2 =  Ly200::checkCdnPicture($v2['Icon'] ?? '');

											$navHtml .=	'<dl class="nav_third_item ' . ($fourthCount > 0 ? 'has_fourth' : '') . '">';
											$navHtml .=		'<dt>';
											$navHtml .=			'<a class="nav_third_a" href="' . $v2['Url'] . '" title="' . $v2['Name'] . '" ' . ($v2['Target'] ?? '') . '>' . ($menuIconV2 ? '<span class="nav_third_icon nav_icon"><img src="' . $menuIconV2 . '" /><span></span></span>' : '') . $v2['Name'] . '</a>';
											$navHtml .=			'<div class="nav_fourth_box">';
																foreach ((array)$fourthData as $v3) {
																	$menuIconV3 = Ly200::checkCdnPicture($v3['Icon'] ?? '');

																	$navHtml .=	'<dl class="nav_fourth_item">';
																	$navHtml .=		'<dt>';
																	$navHtml .=			'<a class="nav_fourth_a" href="' . $v3['Url'] . '" title="' . $v3['Name'] . '" ' . ($v3['Target'] ?? '') . '>' . ($menuIconV3 ? '<span class="nav_fourth_icon nav_icon"><img src="' . $menuIconV3 . '" /><span></span></span>' : '') . $v3['Name'] . '</a>';
																	$navHtml .=		'</dt>';
																	$navHtml .=	'</dl>';
																}
											$navHtml .=			'</div>';
											$navHtml .=		'</dt>';
											$navHtml .=	'</dl>';
										}
					$navHtml .=			'</div>';
					$navHtml .=		'</dt>';
					$navHtml .=		'<dd class="nav_img">';
					if (!empty($imageData['PicPath'])) {
						$navHtml .=			'<div class="imgl pic_box">';
						$navHtml .=				'<a href="' . (!empty($imageData['Url']) ? $imageData['Url'] : 'javascript:;') . '"  ' . (!empty($imageData['Url']) ? 'target="_blank"' : '') . '><img src="' . Ly200::checkCdnPicture($imageData['PicPath']) . '" alt="' . HelpsImg::imgAlt($data['PicPathName_' . $i][$imgLang] ?? '') . '" /><span></span></a>';
						$navHtml .=			'</div>';
					}
					$navHtml .=			'<div class="clear"></div>';
					$navHtml .=		'</dd>';
					$navHtml .=	'</dl>';
				}

				$navHtml .=	'</div>';

			} else if($navType == 4){
				$UId = "0,{$data['MId']},";
				$secondData = $navData['MenuSub'][$UId] ?? [];
				$menuCount = count($secondData);
				$picCount = !empty($menuThemesData['Data']) ? count($menuThemesData['Data']) : 0;
				$count = max([$menuCount, $picCount]);
				$navHtml .= '<div id="nav_sec_' . $key . '" class="nav_list w1440">';
				$navHtml 	.= '<div class="nav_item2 dis_wrap fnt_18">';

				if (!empty($menuThemesData['Data']) && is_array($menuThemesData['Data'])) {
					foreach ($menuThemesData['Data'] as $i => $navValue) {
						$title = htmlspecialchars($navValue['Title'] ?? '', ENT_QUOTES, 'UTF-8');
						$url   = htmlspecialchars($navValue['Url'] ? $navValue['Url'] : 'javascript:;', ENT_QUOTES, 'UTF-8');
						$img   = Ly200::checkCdnPicture($navValue['PicPath'] ?? '');

						$navHtml .= '<a class="nav_item2_item_box" href="' . $url . '" title="' . $title . '">';
						$navHtml .=     '<div class="nav_item2_item">';
						$navHtml .=         '<img alt="' . $title . '" src="' . $img . '"/>';
						$navHtml .=         '<span class="nav_text">' . $title . '</span>'; 
						$navHtml .=     '</div>';
						$navHtml .= '</a>';
					}
				}
				$navHtml 	.=	'</div>';
				$navHtml .=	'</div>';
			} else {
				$navHtml .= '<div id="nav_sec_' . $key . '" class="nav_list">';
				
				$UId = "0,{$data['MId']},";
				$secondData = $navData['MenuSub'][$UId] ?? [];
				foreach ((array)$secondData as $v1) {
					$thirdUId = "0,{$data['MId']},{$v1['MId']},";
					$thirdData = $navData['MenuSub'][$thirdUId] ?? [];
					$thirdCount = count($thirdData);
					$menuIconV1 = Ly200::checkCdnPicture($v1['Icon'] ?? '');

					$navHtml .=	'<dl class="nav_sec_item ' . ($thirdCount > 0 ? 'has_third' : '') . ' ">';
					$navHtml .=		'<dt>';
					$navHtml .=			'<a class="nav_sec_a" href="' . $v1['Url'] . '" title="' . $v1['Name'] . '" ' . ($v1['Target'] ?? '') . '>' . ($menuIconV1 ? '<span class="nav_sec_icon nav_icon"><img src="' . $menuIconV1 . '" /><span></span></span>' : '') . $v1['Name'] . ($thirdCount > 0 ? '<em></em>' : '') . '</a>';
					$navHtml .=			'<div class="nav_third_box">';
										foreach ((array)$thirdData as $v2) {
											$fourthUId = "{$thirdUId}{$v2['MId']},";
											$fourthData = $navData['MenuSub'][$fourthUId] ?? [];
											$fourthCount = count($fourthData);
											$menuIconV2 = Ly200::checkCdnPicture($v2['Icon'] ?? '');

											$navHtml .=	'<dl class="nav_third_item ' . ($fourthCount > 0 ? 'has_fourth' : '') . '">';
											$navHtml .=		'<dt>';
											$navHtml .=			'<a class="nav_third_a" href="' . $v2['Url'] . '" title="' . $v2['Name'] . '" ' . ($v2['Target'] ?? '') . '>' . ($menuIconV2 ? '<span class="nav_third_icon nav_icon"><img src="' . $menuIconV2 . '" /><span></span></span>': '') . $v2['Name'] . ($fourthCount > 0 ? '<em></em>' : '') . '</a>';
											$navHtml .=			'<div class="nav_fourth_box">';
																foreach ((array)$fourthData as $v3) {
																	$menuIconV3 = Ly200::checkCdnPicture($v3['Icon'] ?? '');

																	$navHtml .=	'<dl class="nav_fourth_item">';
																	$navHtml .=		'<dt>';
																	$navHtml .=			'<a class="nav_fourth_a" href="' . $v3['Url'] . '" title="' . $v3['Name'] . '" ' . ($v3['Target'] ?? '') . '>' . ($menuIconV3 ? '<span class="nav_fourth_icon nav_icon"><img src="' . $menuIconV3 . '" /><span></span></span>' : '') . $v3['Name'] . '</a>';
																	$navHtml .=		'</dt>';
																	$navHtml .=	'</dl>';
																}
											$navHtml .=			'</div>';
											$navHtml .=		'</dt>';
											$navHtml .=	'</dl>';
										}
					$navHtml .=			'</div>';
					$navHtml .=		'</dt>';
					$navHtml .=	'</dl>';
				}
			
				$navHtml .=		'<div class="clear"></div>';
				$navHtml .=	'</div>';

				if ($navType != 1) {
					$navHtml .=	'<div class="nav_img">';
					if(isset($menuThemesData['Data'])) {
						foreach ((array)$menuThemesData['Data'] as $k1 => $v1) {
							if ($v1['PicPath'] == '') continue;
							$navHtml .=	'<div class="imgl pic_box">';
							$navHtml .=		'<a href="' . (!empty($v1['Url']) ? $v1['Url'] : 'javascript:;') . '"  ' . (!empty($v1['Url']) ? '' : '') . '><img src="' . Ly200::checkCdnPicture($v1['PicPath']) . '" alt="' . HelpsImg::imgAlt($data['PicPathName_' . $k1][$imgLang] ?? '') . '" /><span></span></a>';
							$navHtml .=	'</div>';
						}
					}
					$navHtml .=		'<div class="clear"></div>';
					$navHtml .=	'</div>';
					$navHtml .=	'<div class="clear"></div>';
				}
			}

			$secHtml .= '<div class="nav_sec nav_type_' . $navType . ' ' . ($dropType == 0 ? 'small_nav_sec' : '') . '">';
			$secHtml .= 	'<div class="top"></div>';
			$secHtml .=		'<div class="nav_sec_box' . ($navType > 1 ? ' container_screen' : '') . '">';
			$secHtml .=			'<div class="' . ($navType == 2 ? 'small' : '') . '">' . $navHtml . '</div>';
			$secHtml .=		'</div>';
			$secHtml .=	'</div>';
		}

		return $secHtml;
	}
}





?>






// modify
<?php
            else if($navType == 4){
                $UId = "0,{$data['MId']},";
                $secondData = $navData['MenuSub'][$UId] ?? [];
                $navHtml .= '<div id="nav_sec_' . $key . '" class="nav_list w1440">';
                $navHtml  .= '<div class="nav_item2 dis_wrap fnt_18">';
                if (!empty($secondData) && is_array($secondData)) {
                    foreach ($secondData as $i => $navValue) {
                        $title = htmlspecialchars($navValue['Name'] ?? '', ENT_QUOTES, 'UTF-8');
                        $url   = htmlspecialchars($navValue['Url'] ? $navValue['Url'] : 'javascript:;', ENT_QUOTES, 'UTF-8');
                        $img   = Ly200::checkCdnPicture($navValue['Icon'] ?? '');
                        $navHtml .= '<a class="nav_item2_item_box" href="' . $url . '" title="' . $title . '">';
                        $navHtml .=     '<div class="nav_item2_item">';
                        $navHtml .=         '<img alt="' . $title . '" src="' . $img . '"/>';
                        $navHtml .=         '<span class="nav_text">' . $title . '</span>'; 
                        $navHtml .=     '</div>';
                        $navHtml .= '</a>';
                    }
                }
                $navHtml  .=	'</div>';
                $navHtml .=	'</div>';
            }

?>



<script>
    /*
Powered by ueeshop.com		http://www.ueeshop.com
广州联雅网络科技有限公司		020-83226791
*/

var nav_themes_obj={
	nav_themes_init: function(){
		var cur_type = $('#nav_themes').find('.type_item.cur').attr('data-type');
		if(cur_type == 4){
			$('#nav_themes_edit_form .data_list .option_row .rows.float:eq(1) .input .box_input').attr('size','30');
			$('#nav_themes_edit_form .data_list .option_row .rows.float:last').show();
		}else{
			$('#nav_themes_edit_form .data_list .option_row .rows.float:eq(1) .input .box_input').attr('size','70');
			$('#nav_themes_edit_form .data_list .option_row .rows.float:last').hide();
		}
		$_MenuHtml = '';
		$_MenuHtml += '<div class="option_row">';
		$_MenuHtml +=     '<div class="rows float clean">';
		$_MenuHtml +=         '<label>' + lang_obj.global.picture + '</label>';
		$_MenuHtml +=         '<div class="input">';
		$_MenuHtml += 			'<div class="multi_img upload_file_multi pro_multi_img" id="PicDetail_%OptionIndex%">';
		$_MenuHtml += 				frame_obj.multi_img_item("PicPath[]", '%OptionIndex%', 0);
		$_MenuHtml += 			'</div>';
		$_MenuHtml +=         '</div>';
		$_MenuHtml +=     '</div>';
		$_MenuHtml +=     '<div class="rows float clean">';
		$_MenuHtml +=         '<label>' + lang_obj.manage.app.nav_themes.link + '</label>';
		$_MenuHtml +=         '<div class="input"><input type="text" name="Url[]" value="" class="box_input" size="'+ (cur_type == 4 ? 30 : 70) + '" maxlength="225" data-input="name" /></div>';
		$_MenuHtml +=     '</div>';
		if(cur_type == 4){
			$_MenuHtml +=     '<div class="rows float clean">';
			$_MenuHtml +=         '<label>' + lang_obj.manage.app.nav_themes.title + '</label>';
			$_MenuHtml +=         '<div class="input"><input type="text" name="Title[]" value="" class="box_input" size="40" maxlength="225" data-input="name" /></div>';
			$_MenuHtml +=     '</div>';
		}
		$_MenuHtml +=     '<div class="float button fr">';
		$_MenuHtml +=         '<a href="javascript:;" class="btn_option fl btn_option_remove"><i></i></a>';
		$_MenuHtml +=    '</div>';
		$_MenuHtml +=     '<div class="clear"></div>';
		$_MenuHtml += '</div>';

		

		let nav_obj = {
			'themes_obj' : $('#nav_themes'),
			'menu_form' : $('#nav_themes_edit_form'),
			'add_menu_option' : function($_MenuHtml,OptionIndex){
				let data_box = nav_obj.menu_form.find('.data_list');
				$_MenuHtml = $_MenuHtml.replaceAllUee('%OptionIndex%', OptionIndex);
				data_box.append($_MenuHtml);
			},
			'del_option' : function(obj){
				//移除选项
				obj.parents('.option_row').fadeOut(function() {
					$(this).remove();
				});
				
			},
			'side_picture_upload': function() {
				$(".navpic_box  .data_list").off().on("click", ".upload_btn", function() {
					let $id = $(this).parents(".multi_img").attr("id"),
					$num = $(this).parents('.img').attr('num');
					frame_obj.photo_choice_init($id + " .img[num;" + $num + "]", "", 1, "", 1, "");
				});
				$('body').on("click", ".navpic_box  .data_list .del", function(e) {
					let $this = $(this);
					let $obj = $this.parents('.img');
					$obj.removeClass('isfile').removeClass('show_btn').parent().append($obj);
					$obj.find('.pic_btn .zoom').attr('href','javascript:;');
					$obj.find('.preview_pic .upload_btn').show();
					$obj.find('.preview_pic a').remove();
					$obj.find('.preview_pic input:hidden').val('').attr('save', 0).trigger('change');
				});
			},
			'getHtml' : function(cur_type){
				$_MenuHtml = '';
				$_MenuHtml += '<div class="option_row">';
				$_MenuHtml +=     '<div class="rows float clean">';
				$_MenuHtml +=         '<label>' + lang_obj.global.picture + '</label>';
				$_MenuHtml +=         '<div class="input">';
				$_MenuHtml += 			'<div class="multi_img upload_file_multi pro_multi_img" id="PicDetail_%OptionIndex%">';
				$_MenuHtml += 				frame_obj.multi_img_item("PicPath[]", '%OptionIndex%', 0);
				$_MenuHtml += 			'</div>';
				$_MenuHtml +=         '</div>';
				$_MenuHtml +=     '</div>';
				$_MenuHtml +=     '<div class="rows float clean">';
				$_MenuHtml +=         '<label>' + lang_obj.manage.app.nav_themes.link + '</label>';
				$_MenuHtml +=         '<div class="input"><input type="text" name="Url[]" value="" class="box_input" size="'+ (cur_type == 4 ? 30 : 70) + '" maxlength="225" data-input="name" /></div>';
				$_MenuHtml +=     '</div>';
				if(cur_type == 4){
					$_MenuHtml +=     '<div class="rows float clean">';
					$_MenuHtml +=         '<label>' + lang_obj.manage.app.nav_themes.title + '</label>';
					$_MenuHtml +=         '<div class="input"><input type="text" name="Title[]" value="" class="box_input" size="40" maxlength="225" data-input="name" /></div>';
					$_MenuHtml +=     '</div>';
				}
				$_MenuHtml +=     '<div class="float button fr">';
				$_MenuHtml +=         '<a href="javascript:;" class="btn_option fl btn_option_remove"><i></i></a>';
				$_MenuHtml +=    '</div>';
				$_MenuHtml +=     '<div class="clear"></div>';
				$_MenuHtml += '</div>';
				return $_MenuHtml;
			}
		}
		nav_obj.side_picture_upload();

		//选中类型效果
		nav_obj.themes_obj.on('click','.type_item',function(){
			let _this = $(this),
				$Obj = _this.parent(),
				type = _this.data('type'),
				picShow = 0;
			_this.addClass('cur').siblings().removeClass('cur');
			$Obj.find('input[name=Type]').val(type);
			if(type!=1 && type != 4) {picShow = 1};
			size = '280*180';
			if(type == 2) size = '180*280';
			if(type == 4) size = '305*171';
			$('.navpic_box .tips span').html(size);
			if(picShow){
				nav_obj.themes_obj.find('.navpic_box').show()
			}else{
				nav_obj.themes_obj.find('.navpic_box').hide()
			}
			// $('#nav_themes_edit_form .data_list .option_row').each(function(i,e){
			// 	if($(e).find('.rows.float').length > 2){
			// 		$(e).find('.input .box_input[name=Url]').attr('size','30');
			// 	}else{
			// 		$(e).find('.input .box_input[name=Url]').attr('size','70');
			// 	}
			// })
			if(type == 4){
				$('#nav_themes_edit_form .data_list .option_row .rows.float .input .box_input').attr('size','30');
				$('#nav_themes_edit_form .data_list .option_row').each(function(i,e){
					console.log($(e).find('.rows:last'));
					
					$(e).find('.rows:last').show();
				})
			}else{
				$('#nav_themes_edit_form .data_list .option_row .rows.float .input .box_input').attr('size','70');
				$('#nav_themes_edit_form .data_list .option_row').each(function(i,e){
					console.log($(e).find('.rows:last'));
					$(e).find('.rows:last').hide();
				})
			}
		})

		nav_obj.menu_form.delegate('.btn_option_remove','click',function(){
			nav_obj.del_option($(this))
		}).delegate('.add_option_btn','click',function(){
			cur_type = nav_obj.themes_obj.find('.type_item.cur').attr('data-type');
			let OptionIndex = parseInt($('.data_list').find('.option_row').size())
			nav_obj.add_menu_option(nav_obj.getHtml(cur_type), OptionIndex + 1)
		})

		frame_obj.submit_form_init(nav_obj.menu_form, '', function () {
			
		}, '', function(data) {
			if(data.ret==1){
				global_obj.win_alert_auto_close(lang_obj.global.saved, '', 1000, '8%');
				window.location.reload();
			}
		});

	}
}
</script>