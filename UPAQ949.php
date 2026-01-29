5.0 faq应用

主要内容是复制info的方式 4.0的可以魔法upap664，5.0的upaq949 5.0的需要到manage/static/inc/permit/0/php去写一个faq出来

首先是复制数据表

-- 复制info表为faq表
CREATE TABLE `faq` LIKE `info`;
ALTER TABLE `faq` CHANGE `InfoId` `FaqId` INT(10) NOT NULL AUTO_INCREMENT COMMENT 'FAQ主键';

-- 复制info_category表为faq_category表
CREATE TABLE `faq_category` LIKE `info_category`;

-- 复制info_content表为faq_content表
CREATE TABLE `faq_content` LIKE `info_content`;
ALTER TABLE `faq_content` CHANGE `InfoId` `FaqId` INT(10) NOT NULL COMMENT '关联FAQ主键';

下面是/manage/content/faq.php

<?php
manage::check_permit('content.faq', 2);//检查权限

$d_ary=array('index','edit','category','category_edit');
$d = $c['manage']['do'];
!in_array($d, $d_ary) && $d=$d_ary[0];

$CateId=(int)$_GET['CateId'];

$cate_ary=str::str_code(db::get_all('faq_category', '1'));
$category_ary=array();
foreach((array)$cate_ary as $v){
	$category_ary[$v['CateId']]=$v;
}
$category_count=count($category_ary);
unset($cate_ary);
?>
<div id="<?=($d=='index' || $d=='edit')?'faq':'faq_inside';?>" class="r_con_wrap">
	<div class="inside_container">
		<h1>{/module.content.faq.module_name/}</h1>
		<ul class="inside_menu">
			<li><a href="./?m=content&a=faq"<?=($d=='index' || $d=='edit')?' class="current"':'';?>>{/module.content.faq.list/}</a></li>
			<li><a href="./?m=content&a=faq&d=category"<?=($d=='category' || $d=='category_edit')?' class="current"':'';?>>{/global.category/}</a></li>
		</ul>
	</div>
	<?php if($d=='index'){
		//获取类别列表
		$cate_ary=str::str_code(db::get_all('faq_category', '1', '*'));
		$category_ary=array();
		foreach((array)$cate_ary as $v){
			$category_ary[$v['CateId']]=$v;
		}
		$category_count=count($category_ary);
		unset($cate_ary);

		//FAQ列表
		$Title=str::str_code($_GET['Title']);
		$CateId=(int)$_GET['CateId'];

		$where='1';//条件
		$page_count=10;//显示数量
		$Title && $where.=" and Title{$c['lang']} like '%$Title%'";
		if($CateId){
			$where.=' and '.category::get_search_where_by_CateId($CateId, 'faq_category');
			$category_one=str::str_code(db::get_one('faq_category', "CateId='$CateId'"));
			$UId=$category_one['UId'];
			$UId!='0,' && $TopCateId=category::get_top_CateId_by_UId($UId);
		}
	?>
	<div class="center_container_1000">
		<div class="inside_table">
			<div class="list_menu">
				<div class="search_form">
					<form method="get" action="?">
						<div class="k_input">
							<input type="text" name="Title" value="" class="form_input" size="15" autocomplete="off" />
							<input type="button" value="" class="more" />
						</div>
						<input type="submit" class="search_btn" value="{/global.search/}" />
						<div class="ext drop_down">
							<div class="rows item clean">
								<label>{/global.category/}</label>
								<div class="input">
									<div class="box_select"><?=category::ouput_Category_to_Select('CateId', '', 'faq_category', 'UId="0,"');?></div>
								</div>
							</div>
						</div>
						<div class="clear"></div>
						<input type="hidden" name="m" value="content" />
						<input type="hidden" name="a" value="faq" />
					</form>
				</div>
				<ul class="list_menu_button">
					<li><a class="add" href="./?m=content&a=faq&d=edit">{/global.add/}</a></li>
					<li><a class="del" href="javascript:;">{/global.del/}</a></li>
				</ul>
			</div>
			<script type="text/javascript">$(document).ready(function(){content_obj.faq_init();});</script>
			<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
				<thead>
					<tr>
						<td width="1%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
						<td width="32%" nowrap="nowrap">{/global.title/}</td>
						<td width="17%" nowrap="nowrap">{/global.category/}</td>
						<td width="8%" nowrap="nowrap">{/global.edit_time/}</td>
						<td width="10%" nowrap="nowrap" class="last">{/global.operation/}</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=1;
					$faq_row=str::str_code(db::get_limit_page('`faq`', $where, '*', $c['my_order'].'FaqId desc', (int)$_GET['page'], $page_count));
					foreach($faq_row[0] as $v){
						$name=$v['Title'.$c['lang']];
						$url=web::get_url($v, 'faq');
					?>
					<tr>
						<td nowrap="nowrap"><?=html::btn_checkbox('select', $v['FaqId']);?></td>
						<td><a href="/faq/" title="<?=$name;?>" target="_blank"><?=$name;?></a></td>
						<td nowrap="nowrap">
							<?php
							$UId=$category_ary[$v['CateId']]['UId'];
							if($UId){
								$key_ary=@explode(',',$UId);
								array_shift($key_ary);
								array_pop($key_ary);
								foreach($key_ary as $k2=>$v2){
									echo $category_ary[$v2]['Category'.$c['lang']].'->';
								}
							}
							echo $category_ary[$v['CateId']]['Category'.$c['lang']];
							?>
						</td>
						<td nowrap="nowrap"><?=$v['AccTime']?date('Y-m-d', $v['AccTime']):'N/A';?></td>
						<td nowrap="nowrap" class="operation">
							<a href="./?m=content&a=faq&d=edit&FaqId=<?=$v['FaqId'];?>" title="{/global.edit/}">{/global.edit/}</a>
							<a href="./?do_action=content.faq_del&id=<?=$v['FaqId'];?>" title="{/global.del/}" class="del" rel="del">{/global.del/}</a>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
			<input type="hidden" name="Type" value="faq" />
			<?=html::turn_page($faq_row[1], $faq_row[2], $faq_row[3], '?'.str::query_string('page').'&page=');?>
		</div>
	</div>
	<?php
	}elseif($d=='edit'){
		$PageUrl = '/faq-detail/';
		$PageName = 'Title'.$c['lang'];
		$PageId = 'FaqId';
		$FaqId=(int)$_GET['FaqId'];
		$faq_row = $seo_row = str::str_code(db::get_one('`faq`', "FaqId='$FaqId'"));
		$faq_content_row=str::str_code(db::get_one('faq_content', "FaqId='$FaqId'"));

		$faq_row['CateId'] && $uid=category::get_UId_by_CateId($faq_row['CateId'],'faq_category');
		$uid!='0,' && $TopCateId=category::get_top_CateId_by_UId($uid);
		$faq_category_row=str::str_code(db::get_one('faq_category', "CateId='{$TopCateId}'"));
		echo ly200::load_static('/static/js/plugin/ckeditor/ckeditor.js', '/static/js/plugin/daterangepicker/daterangepicker.css', '/static/js/plugin/daterangepicker/moment.min.js', '/static/js/plugin/daterangepicker/daterangepicker.js', '/static/js/plugin/dragsort/dragsort-0.5.1.min.js')
	?>
	<script type="text/javascript">$(document).ready(function(){content_obj.faq_edit_init();});</script>
	<form id="edit_form" name="faq_form" class="global_form">
		<div class="center_container_1000">
			<div class="global_container">
				<div class="big_title">{/global.base_info/}</div>
				<div class="rows clean">
					<label>{/products.language/}</label>
					<div class="input lang_list">
						<?php
						$this_pro_default_lang = $c['manage']['config']['LanguageDefault'];
						$first_lang = "";
						foreach($c['manage']['language_web'] as $k=>$v){
							(!$FaqId || $faq_row['Lang_'.$v]) && !$first_lang && $first_lang = $v;

						?>
							<span class="input_checkbox_box <?=!$FaqId || $faq_row['Lang_'.$v]?'checked':'';?>">
								<span class="input_checkbox">
									<input type="checkbox" name="Lang_<?=$v;?>" value="1" <?=!$FaqId || $faq_row['Lang_'.$v]?'checked':'';?> lang="<?=$v;?>" />
								</span><font>{/language.<?=$v;?>/}</font>
							</span>
						<?php }?>
					</div>
				</div>
				<?php
				foreach($c['manage']['language_web'] as $k=>$v){
					if($v==$c['manage']['config']['LanguageDefault']){
						$this_pro_default_lang = $first_lang;
						break;
					}
				}
				?>
				<input class="pro_default_lang" type="hidden" value="<?=$this_pro_default_lang;?>" />
				<div class="rows clean translation">
					<label>{/global.question/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
					<div class="input"><?=manage::form_edit($faq_row, 'text', 'Title', 53, 150, 'notnull');?></div>
				</div>
				<div class="rows clean">
					<label>{/global.category/}</label>
					<div class="input">
						<div class="box_select"><?=category::ouput_Category_to_Select('CateId', $faq_row['CateId'], 'faq_category', 'UId="0,"', 1, 'notnull');?></div>
					</div>
				</div>

				<div class="rows clean">
					<label>{/global.my_order/}</label>
					<div class="input">
						<div class="box_select width_90"><?=html::form_select(manage::language('{/global.my_order_ary/}'), 'MyOrder', $faq_row['MyOrder'], '', '', '', 'class="box_input"');?></div>
					</div>
				</div>

				<!-- 文字描述 -->
				<div class="rows clean translation">
					<label>{/global.answer/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
					<div class="input"><?=manage::form_edit($faq_row, 'textarea', 'BriefDescription');?></div>
				</div>

				<div class="rows clean">
					<label></label>
					<div class="input">
						<input type="submit" class="btn_global btn_submit" name="submit_button" value="{/global.save/}" />
						<input type="button" class="btn_global btn_translation" value="{/global.translation/}">
						<a href="./?m=content&a=faq"><input type="button" class="btn_global btn_cancel" value="{/global.return/}"></a>
					</div>
				</div>
			</div>
			<?php include("static/inc/seo.php");?>
		</div>
		<input type="hidden" id="FaqId" name="FaqId" value="<?=$FaqId;?>" />
		<input type="hidden" name="do_action" value="content.faq_edit" />
		<input type="hidden" id="back_action" name="back_action" value="<?=$_SERVER['HTTP_REFERER'];?>" />
	</form>
	<?php include("static/inc/translation.php");?>
	<?php
	}elseif($d=='category'){
		//分类列表
		echo ly200::load_static('/static/js/plugin/dragsort/dragsort-0.5.1.min.js');
	?>
	<div class="center_container_1000">
		<div class="inside_table">
			<div class="list_menu">
				<ul class="list_menu_button">
					<li><a class="add" href="./?m=content&a=faq&d=category_edit">{/global.add/}</a></li>
					<li><a class="del" href="javascript:;">{/global.del/}</a></li>
				</ul>
			</div>
			<script type="text/javascript">$(document).ready(function(){content_obj.faq_category_init()});</script>
			<table border="0" cellpadding="5" cellspacing="0" class="r_con_table" width="100%">
				<thead>
					<tr>
						<td width="1%" nowrap="nowrap" class="myorder"></td>
						<td width="1%" nowrap="nowrap"><?=html::btn_checkbox('select_all');?></td>
						<td width="4%" nowrap="nowrap">{/global.id/}</td>
						<td width="83%" nowrap="nowrap">{/global.category/}</td>
						<td width="20%" nowrap="nowrap">{/global.operation/}</td>
					</tr>
				</thead>
				<tbody>
					<?php
					$where='1';//条件
					if($CateId){
						$UId=category::get_UId_by_CateId($CateId,'faq_category');
						$where.=" and UId='{$UId}'";
					}else{
						$where.=' and UId="0,"';
					}
					$category_row=str::str_code(db::get_all('faq_category', $where, '*', $c['my_order'].'CateId asc'));
					$i=1;
					foreach($category_row as $v){
					?>
						<tr id="<?=$v['CateId'];?>">
							<td nowrap="nowrap" class="myorder move_myorder" data="move_myorder"><i class="icon_myorder"></i></td>
							<td nowrap="nowrap"><?=html::btn_checkbox('select', $v['CateId']);?></td>
							<td nowrap="nowrap"><?=$v['CateId'];?></td>
							<td><?=$v['Category_'.$c['manage']['language_web'][0]];?></td>
							<td nowrap="nowrap" class="operation">
								<a href="./?m=content&a=faq&d=category_edit&CateId=<?=$v['CateId'];?>">{/global.edit/}</a>
								<a class="del item" href="./?do_action=content.faq_category_del&id=<?=$v['CateId'];?>" rel="del">{/global.del/}</a>
							</td>
						</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
	}elseif($d=='category_edit'){
		$PageUrl = '/faq/';
		$PageName = 'Category'.$c['lang'];
		$PageId = 'CateId';
		$category_row=$seo_row=db::get_one('faq_category', "CateId='$CateId'");
	?>
	<script type="text/javascript">$(document).ready(function(){content_obj.faq_category_edit_init()});</script>
	<div class="center_container_1200">
		<form id="edit_form" class="global_form clean">
			<div class="center_container_1000">
				<div class="global_container">
					<div class="big_title">{/global.base_info/}</div>
					<div class="rows clean translation">
						<label>{/global.name/}<div class="tab_box"><?=manage::html_tab_button();?></div></label>
						<div class="input">
							<?=manage::form_edit($category_row, 'text', 'Category', 53, 255, 'notnull');?>
						</div>
					</div>
					<div class="rows clean">
						<label></label>
						<div class="input">
							<input type="submit" class="btn_global btn_submit" name="submit_button" value="{/global.save/}" />
							<input type="button" class="btn_global btn_translation" value="{/global.translation/}">
							<a href="<?=$_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:'./?m=content&a=faq&d=category';?>" class="btn_global btn_cancel">{/global.return/}</a>
						</div>
					</div>
				</div>
				<?php include("static/inc/seo.php");?>
			</div>
			<input type="hidden" name="CateId" value="<?=$CateId;?>" />
			<input type="hidden" name="do_action" value="content.faq_category_edit" />
		</form>
		<?php include("static/inc/translation.php");?>
	</div>
	<?php }?>
</div>

css样式
<style>
.ueeshop_responsive_faq_list{margin:30px 0; overflow:hidden;}
.ueeshop_responsive_faq_list .top_info {text-align: center;}
.ueeshop_responsive_faq_list .top_info .themes_box_title {color: #000000;}
.ueeshop_responsive_faq_list .top_info .top_title a {font-size: 42px;color: #111111;text-decoration: none;font-weight: bold;}
.ueeshop_responsive_faq_list .item{margin-top: 10px;padding: 32px 50px 32px 30px;width: 100%;box-sizing: border-box;word-wrap: break-word;background-color: #f5f5f5;}
.ueeshop_responsive_faq_list .item:last-child{margin:0;}
.ueeshop_responsive_faq_list .item .img{width:22%; float:left;}
.ueeshop_responsive_faq_list .item .faq{width:78%; float:right; padding-left:25px; box-sizing:border-box;}
.ueeshop_responsive_faq_list .item .faq .title{overflow:hidden; text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;padding-bottom:5px;}
.ueeshop_responsive_faq_list .item .faq .title{font-size:24px; color:#000000;font-weight: bolder;}
.ueeshop_responsive_faq_list .item.cur .faq .title,
.ueeshop_responsive_faq_list .item .faq .title:hover{color:#54b9fd;}
.ueeshop_responsive_faq_list .item .faq .time{font-size:14px; color:#999; line-height:20px;}
.ueeshop_responsive_faq_list .item .faq .time h2{display:none;}
.ueeshop_responsive_faq_list .item .faq .desc{font-size:14px; color:#999; line-height:150%; max-height:63px; overflow:hidden; margin-bottom:10px; margin-top:5px;font-size: 16px;color: #555555;background-color: #ffffff;line-height: 1.875;}
.ueeshop_responsive_faq_list .item .link{display:none;}
.ueeshop_responsive_faq_list .item.no_img .img{display:none;}
.ueeshop_responsive_faq_list .item.no_img .faq{width:100%; float:none; padding:0;}
.ueeshop_responsive_faq_list.s1 .item{position:relative; min-height:50px;}
.ueeshop_responsive_faq_list.s1 .item .img{display:none;}
.ueeshop_responsive_faq_list.s1 .item .faq{width:100%; padding:0 150px;}
.ueeshop_responsive_faq_list.s1 .item .faq .time{position:absolute; left:0; top:0;}
.ueeshop_responsive_faq_list.s1 .item .faq .time h1{display:none;}
.ueeshop_responsive_faq_list.s1 .item .faq .time h2{display:block; font-size:24px; font-weight:bold;} 
.ueeshop_responsive_faq_list.s1 .item .faq .time h2 span{display:block; font-size:16px; color:#a4a4ac; padding-top:8px;}
.ueeshop_responsive_faq_list.s1 .item .faq .title a{color:#333;}
.ueeshop_responsive_faq_list.s1 .item .link{display:block; width:20px; height:70%; position:absolute; right:0; top:0; background:url("../images/ico/icon_link.png") no-repeat center;}


/* faq详细(推荐文章) */
.rale_faq{ padding-bottom: 56px; width: 100%;}
.rale_faq .news_title{ width: 100%; height: 30px; line-height: 30px;font-family: "Montserrat-Regular";}
.rale_faq .news_title .title{ font-size: 22px; color: #191919;font-family: "Montserrat-Regular";}
.rale_faq .news_title .read_btn{ font-size: 14px; color: #888;font-family: "Opensans-Regular";}
.rale_faq .news_title .read_btn span{ font-size: 14px; color: #888; font-family: "Opensans-Regular"; font-weight: bold;}
.rale_faq .list{ display: grid; grid-template-columns: repeat(4, 23.25%); justify-content: space-between; margin-top: 23px; width: 100%;}
.rale_faq .list .item .img{ display: block; width: 100%; text-align: center; text-decoration: none; overflow: hidden;}
.rale_faq .list .item .title{ font-family: "Montserrat-Regular";display: -webkit-box; margin-top: 15px; line-height: 21px; font-size: 16px; color: #333; text-decoration: none; overflow: hidden; -webkit-box-orient: vertical; -webkit-line-clamp: 2;}
.rale_faq .list .item .time{ margin-top: 8px; width: 100%; height: 21px; line-height: 21px; font-size: 14px; color: #989898;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.rale_faq .list .item .brief{ display: -webkit-box; margin-top: 6px; line-height: 24px; font-size: 14px; color: #888; text-decoration: none; overflow: hidden; -webkit-box-orient: vertical; -webkit-line-clamp: 3;font-family: "Opensans-Regular";}
.rale_faq .list .item:hover .img img{ -webkit-transform: scale(1.1); transform: scale(1.1);}

</style>

content.js
<script>
    	// 1. 函数名：info_edit_init → faq_edit_init
	faq_edit_init:function(){
		frame_obj.translation_init();

		/*选择语言*/
		$(".tab_txt").hide();
		var pro_default_lang = $(".pro_default_lang").val();
		$(".tab_txt_"+pro_default_lang).show();
		//语言选择 - 选择器：#info → #faq
		$('body').on('click', '#faq .lang_list .input_checkbox_box', function(e){
			var $obj=$(this);
			if(!$obj.hasClass('checked')){
				if($('#faq .lang_list .checked').size()<1){ // 选择器：#info → #faq
					global_obj.win_alert(lang_obj.manage.set.select_once_language,function(){
						$obj.click();
					});
				}else{
					$obj.removeClass('checked').find('input').removeAttr('checked');
				}
			}else{
				$obj.addClass('checked').find('input').attr('checked','checked');
			}
			var $lang = $(".lang_list .input_checkbox input:checked").eq(0).attr('lang');
			$('.tab_txt').hide();
			$('.tab_txt_'+$lang).show();
			content_obj.products_edit_select_lang();
		});
		content_obj.products_edit_select_lang();
		/*选择语言-END*/

		$('#edit_form input[name=AccTime],#edit_form input[name=StartTime],#edit_form input[name=EndTime]').daterangepicker({singleDatePicker:true,showDropdowns:true});
		frame_obj.switchery_checkbox(function(obj){
			if(obj.parent().find('input[name=IsTimedRelease]').length){
				$('.ShowTimeRowStart').show();
			}else if(obj.parent().find('input[name=IsTimedReleaseEnd]').length){
				$('.ShowTimeRowEnd').show();
			}
		}, function(obj){
			if(obj.parent().find('input[name=IsTimedRelease]').length){
				$('.ShowTimeRowStart').hide();
			}else if(obj.parent().find('input[name=IsTimedReleaseEnd]').length){
				$('.ShowTimeRowEnd').hide();
			}
		});

		frame_obj.mouse_click($('.multi_img .upload_btn, .pic_btn .edit'), 'par', function($this){
			frame_obj.photo_choice_init('PicUpload', '.multi_img input[name=PicPath]', 'PicDetail', '', 1);
		});
		// 接口参数：a=info → a=faq
		frame_obj.submit_form_init($('#edit_form'), './?m=content&a=faq');
	},

	// 2. 函数名：info_category_init → faq_category_init
	faq_category_init:function(){
		// 选择器：.info_inside → .faq_inside（三处）
		frame_obj.del_init($('#faq_inside .r_con_table'));
		frame_obj.select_all($('#faq_inside .r_con_table input[name=select_all]'), $('#faq_inside .r_con_table input[name=select]'), $('.list_menu_button .del'));
		// 操作标识：content.info_category_del → content.faq_category_del
		frame_obj.del_bat($('.list_menu .del'), $('#faq_inside .r_con_table input[name=select]'), 'content.faq_category_del');
		// 操作标识：content.info_category_order → content.faq_category_order
		frame_obj.dragsort($('#faq_inside .r_con_table tbody'), 'content.faq_category_order');
	},

	// 3. 函数名：info_category_edit_init → faq_category_edit_init
	faq_category_edit_init:function(){
		frame_obj.translation_init();
		// 接口参数：a=info → a=faq
		frame_obj.submit_form_init($('#edit_form'), './?m=content&a=faq&d=category');
	},

	// 4. 函数名：info_init → faq_init
	faq_init:function(){
		// 选择器：#info → #faq
		$('#faq .r_con_table .myorder_select').on('dblclick', function(){
			var $obj=$(this),
				$number=$obj.attr('data-num'),
				$InfoId=$obj.parents('tr').find('td:eq(0) input').val(), // 保留InfoId（若后台表字段为FaqId需替换，否则不变）
				$mHtml=$obj.html(),
				$sHtml=$('#myorder_select_hide').html(),
				$val;
			$obj.html($sHtml+'<span style="display:none;">'+$mHtml+'</span>');
			$number && $obj.find('select').val($number).focus();
			$obj.find('select').on('blur', function(){
				$val=$(this).val();
				if($val!=$number){
					// 操作标识：content.info_my_order → content.faq_my_order
					$.post('?', 'do_action=content.faq_my_order&InfoId='+$InfoId+'&Number='+$(this).val(), function(data){
						if(data.ret==1){
							$obj.html(data.msg);
							$obj.attr('data-num', $val);
						}
					}, 'json');
				}else{
					$obj.html($obj.find('span').html());
				}
			});
		});

		$('.choose_order select[name=manage_myorder]').change(function(){
			var t_val = $(this).val();
			// 操作标识：content.config_info_switch → content.config_faq_switch
			$.get('?', 'do_action=content.config_faq_switch&field=manage_myorder&status='+t_val, function(data){
				if(data.ret==1){
					window.location.reload();
				}else{
					global_obj.win_alert_auto_close(lang_obj.global.set_error,'fail', 1000, '8%');
				}
			}, 'json');
		})

		// 选择器：#info → #faq（三处）
		frame_obj.del_init($('#faq .r_con_table'));
		frame_obj.select_all($('#faq .r_con_table input[name=select_all]'), $('#faq .r_con_table input[name=select]'), $('.list_menu_button .del'));
		// 操作标识：content.info_del → content.faq_del
		frame_obj.del_bat($('.list_menu .del'), $('#faq .r_con_table input[name=select]'), 'content.faq_del');
	},
</script>