<?php
/**
 * Banner轮播插件
 * Type: Banner图片类型  0.宽高不固定,图片自动缩 1.固定宽高,图片等比例缩 2.宽高固定,图片不缩
 * ShowType: 显示方式  0渐显 1.上滚动 2.做滚动
 */
// 可视化变量配置
if (!$c['web_pack'][$WId]['Data'][0]) return;
$param = $c['web_pack'][$WId]['Data'];				//数据
$style = $c['web_pack'][$WId]['DataStyle'];		//数据样式
$config = $c['web_pack'][$WId]['PluginConfig'];	//配置
$Layout = $config['Layout'];//显示方式
$wid = $WId;
//unset($param['WhereSet'], $param['WhereStr'], $param['Layout'], $param['WId']);  // 配置存变量后踢掉


// 基本配置
// if (!method_exists('themes_set', 'themes_banner_init')) exit('请技术先配置广告图函数');
$width = $style[0]['Ary'][0]['Pic']['width'];
!$width && $width = 1920;
$height = $style[0]['Ary'][0]['Pic']['height'];

$mobile_width = $style[0]['Ary'][1]['Pic']['width'];
!$mobile_width && $mobile_width = 750;
$mobile_height = $style[0]['Ary'][1]['Pic']['height'];

// $config = themes_set::themes_banner_init();
$data_type = 1;
$font = array();  //需要载入的字体库
$tab = '';
// 移动端配置
$mobile = 0;
if ($_POST['visual']['Client'] == 'mweb' || web::is_mobile_client(1)) {  // 后台切换移动端 || 移动端
	$mobile = 1;
	// 重定义移动端为滑动效果
	$Layout = 2;
}
// 判断广告图数量
$banner_num = 0;

$video_data = array();
for ($j = 0; $j < count($param); $j++) {
	if ((int)$param[$j]['Video']) {
		$video_data = $param[$j];
	} else {
		if ($mobile) {
			($param[$j]['Ary'][1]['Pic'] || $param[$j]['Ary'][0]['Pic']) && $banner_num += 1;
		} else {
			$param[$j]['Ary'][0]['Pic'] && $banner_num += 1;
		}
	}
}

?>
<link rel="stylesheet" type="text/css" href="../../../../static/themes/t262/css/swiper-bundle.min.css">
<script src="../../../../static/themes/t262/js/swiper-bundle.min.js"></script>
<div id="banner" plugins="banner-0" effect="0-1" visualwid="<?=$wid;?>">
	<?php if ((!isset($_POST['visual']) && !(int)$config['Video']) || !trim($video_data['Link']) || (isset($_POST['visual']) && !(int)$_POST['visual'][$WId]['PluginConfig']['Video'])) { ?>
	<div id="banner_edit" data-type="<?=$data_type;?>" data-slidetype="<?=$Layout;?>" data-width="<?=$width;?>" data-height="<?=$height;?>" data-mobile-width="<?=$mobile_width;?>" data-mobile-height="<?=$mobile_height;?>">
		<div class="banner_box">
			<div class="swiper mySwiper">
				<div class="swiper-wrapper ro_img">
			<?php
			// 循环banner图
			for ($i = 0; $i < count($param); $i++) {
				$banner_pic = $param[$i]['Ary'][0]['Pic'];
				if ($mobile && $param[$i]['Ary'][1]['Pic']) $banner_pic = $param[$i]['Ary'][1]['Pic'];

				if ($i == 0 && !$banner_num) {  //  没有上传图片使用默认图片
					$banner_pic = '/static/ico/visual/banner.svg';
				}
				if($banner_pic == '') continue;

				if (!in_array($style[$i]['Ary'][2]['Content']['font-family'] , $font)) $font[] = $style[$i]['Ary'][2]['Content']['font-family'];
				if (!in_array($style[$i]['Ary'][3]['Content']['font-family'] , $font)) $font[] = $style[$i]['Ary'][3]['Content']['font-family'];
				
				$js_json = array('banner'=>$style[$i]['Ary']['0']['Pic'], 'title'=>$style[$i]['Ary'][2]['Content'], 'brief'=>$style[$i]['Ary'][3]['Content'], 'mainpic'=>$style[$i]['Pic'],'mobile_banner'=>$style[$i]['Ary']['1']['Pic']); 
				//unset($js_json['banner']['url'], $js_json['banner']['link'], $js_json['banner']['width'], $js_json['banner']['height'], $js_json['title']['content'], $js_json['brief']['content'], $js_json['mainpic']['url']);  // 去除不是样式的参数
				$alt = $param[$i]['Ary'][2]['Content'];
				$tab .= '<a href="javascript:;" ' . ($i ? '' : 'class="on"') . '></a>';
			?>
			<div class="swiper-slide">
			<div class="banner_list" data-data="<?=htmlspecialchars(str::json_data($js_json));?>">
				<?php if ($param[$i]['Link']) { ?><a href="<?=$param[$i]['Link'];?>" title="<?=$alt;?>" target="_blank"><?php }?>
				
							
								
				<div class="banner_position">
					<img src="<?=$banner_pic;?>" alt="<?=$alt;?>" />
					<?php /*
					<div class="banner_title"><?=$param[$i]['Ary'][2]['Content'];?></div>
					<div class="banner_brief"><?=$param[$i]['Ary'][3]['Content'];?></div>
					*/?>
					<div class="banner_mainpic">
						<?php if ($param[$i]['Pic']) {?>
							<img src="<?=$param[$i]['Pic'];?>"/>
						<?php }?>
					</div>
				</div>
				<?php if ($param[$i]['Link']) { ?></a><?php }?>
			</div>
			</div>
			<?php }?>
			</div>
			
			</div>
			<div class="ro_next">
				<div class="ro_next_icon">

				</div>
			</div>
			<div class="ro_prev">
				<div class="ro_prev_icon">

				</div>
			</div>
		</div>
		<div class="banner_tab"><?=$tab;?></div>
		<a class="banner_prev" href="javascript:;"></a>
		<a class="banner_next" href="javascript:;"></a>
		<div class="banner_loading"></div>
	</div>
	<?php
	$font = array_filter($font);
	visual::font('load', 1, $font);
	?>
	<?php } else { ?>
	<div class="index_banner_video">
		<div class="index_banner_video_box">
			<?=html::video_show(trim($video_data['Link']), (int)$video_data['Ary'][0]['Drop'], (int)$video_data['Ary'][1]['Drop']);?>
		</div>
	</div>
	<?php } ?>
</div>
<div class="clear"></div>