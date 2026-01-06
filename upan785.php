<?php
$products_catalog_set_time=@filemtime(web::get_cache_path($c['themes']).'/products_catalog.html');//文件生成时间
!$products_catalog_set_time && $products_catalog_set_time=0;
$set_cache=$c['time']-$products_catalog_set_time-$c['cache_timeout'];	//当前时间 - 文件生成时间 - 自动生成静态文件时间间隔

if($set_cache>0 || !is_file(web::get_cache_path($c['themes']).'/products_catalog.html')){
	ob_start();

	$allcate_row=str::str_code(db::get_all('products_category', '1', "CateId,UId,Category{$c['lang']}",  $c['my_order'].'CateId asc'));
	$allcate_ary=array();
	foreach($allcate_row as $k=>$v){
		$allcate_ary[$v['UId']][]=$v;
	}
?>
	<div class="pro_cate">
		<div class="page_name"><?=$c['lang_pack']['products'];?></div>
		<div class="content">
			<?php
			$allcate_row=str::str_code(db::get_all('products_category', '1', "CateId,UId,Category{$c['lang']}",  $c['my_order'].'CateId asc'));
			$allcate_ary=array();
			foreach($allcate_row as $k=>$v){
				$allcate_ary[$v['UId']][]=$v;
			}
			foreach($allcate_ary["0,"] as $k=>$v){
				$allcate_count = count($allcate_ary["0,{$v['CateId']},"]);
			?>
			<div class="list <?=$TopCateId==$v['CateId']?'on':''?>">
				<div class="first_cate">
					<a href="<?=web::get_url($v);//$allcate_count?'javascript:;':web::get_url($v)?>" class="category_<?=$v['CateId']; ?>" title="<?=$v['Category'.$c['lang']];?>"><?=$v['Category'.$c['lang']];?></a>
					<div class="border"></div>
				</div>
				<?php if($allcate_count){?>
				<div class="son_cate">
					<?php foreach($allcate_ary["0,{$v['CateId']},"] as $k1=>$v1){?>
					<div class="item"><a href="<?=web::get_url($v1);?>" class="text-over block category_<?=$v1['CateId']; ?>" title="<?=$v1['Category'.$c['lang']];?>"><?=$v1['Category'.$c['lang']];?></a></div>
					<?php if(count($allcate_ary["0,{$v['CateId']},{$v1['CateId']},"])){?>
					<div class="subcate3 v_<?=$v1['CateId']; ?>">
						<?php foreach($allcate_ary["0,{$v['CateId']},{$v1['CateId']},"] as $k2=>$v2){?>
						<a href="<?=web::get_url($v2);?>" title="<?=$v2['Category'.$c['lang']];?>" class="text-over block sia sia3 category_<?=$v2['CateId']; ?> "><?=$v2['Category'.$c['lang']];?></a>
						<?php }?>
					</div>
					<?php }?>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<div class="leftContent">
			<?php $relate_pro = db::get_limit('products', 'IsHot=1', '*', $c['my_order'].'ProId desc', 0, 10);?>
			<div class="relate">
				<div class="title"><?=$c['lang_pack']['hot'];?></div>
				<div class="list">
					<?php foreach((array)$relate_pro as $k=>$v){
						$url = web::get_url($v, 'products');
					?>
						<div class="row">
							<a class="img trans fl" href="<?=$url?>"><img src="<?=img::get_small_img($v['PicPath_0'], '240x240')?>" alt=""></a>
							<div class="row_txt fl">
								<a class="name" href="<?=$url?>"><?=$v['Name'.$c['lang']]?></a>
								<a class="btn">
									<?=$c['lang_pack']['view']; ?>
								</a>
							</div>
							<div class="clear"></div>
						</div>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
<?php
	$cache_catalog_contents=ob_get_contents();
	ob_end_clean();
	file::write_file(web::get_cache_path($c['themes'], 0), 'products_catalog.html', $cache_catalog_contents);
	echo $cache_catalog_contents;
	unset($cache_catalog_contents);
}else{
	include(web::get_cache_path($c['themes']).'/products_catalog.html');
}
if($CateId){ ?>
<script>
	$('.category_<?=$TopCateId; ?>,.category_<?=$SecCateId; ?>,.category_<?=$CateId; ?>').addClass('on');
	$('.category_<?=$TopCateId; ?>').parents('.list').addClass('on').siblings().removeClass('on');
	$('.v_<?=$SecCateId; ?>').css('display','block');
</script>
<?php } ?>




<!-- 无用版本 -->
<?php
$products_catalog_set_time = @filemtime(web::get_cache_path($c['themes']).'/products_catalog.html');//文件生成时间
!$products_catalog_set_time && $products_catalog_set_time = 0;
$set_cache = $c['time'] - $products_catalog_set_time - $c['cache_timeout'];	//当前时间 - 文件生成时间 - 自动生成静态文件时间间隔

$current_cate_id = isset($CateId) ? $CateId : 0;
$current_top_cate = isset($TopCateId) ? $TopCateId : 0;
$current_sec_cate = isset($SecCateId) ? $SecCateId : 0;

$products_top_cate = 0;
$top_categories = str::str_code(db::get_all('products_category', "UId = '0,'", "CateId,Category{$c['lang']}"));
foreach($top_categories as $cate) {
    if(strtolower($cate["Category{$c['lang']}"]) == 'products') {
        $products_top_cate = $cate['CateId'];
        break;
    }
}

$industry_focus_id = 5;  // 假设Industry Focus对应的分类ID是5
$hot_new_id = 6;         // 假设Hot&New对应的分类ID是6

if($set_cache > 0 || !is_file(web::get_cache_path($c['themes']).'/products_catalog.html')){
	ob_start();

	$allcate_row = str::str_code(db::get_all('products_category', '1', "CateId,UId,Category{$c['lang']}",  $c['my_order'].'CateId asc'));
	$allcate_ary = array();
	foreach($allcate_row as $k => $v){
		$allcate_ary[$v['UId']][] = $v;
	}
	
	$display_cates = array();
	
	if($current_cate_id == $industry_focus_id || $current_cate_id == $hot_new_id) {
		$display_cates = isset($allcate_ary["0,{$products_top_cate},{$current_cate_id},"]) ? 
		                 $allcate_ary["0,{$products_top_cate},{$current_cate_id},"] : array();
	}

	elseif($current_sec_cate == $industry_focus_id || $current_sec_cate == $hot_new_id) {
		$display_cates = isset($allcate_ary["0,{$products_top_cate},{$current_sec_cate},"]) ? 
		                 $allcate_ary["0,{$products_top_cate},{$current_sec_cate},"] : array();
	}

	else {
		$display_cates = isset($allcate_ary["0,"]) ? $allcate_ary["0,"] : array();
	}
?>
	<div class="pro_cate">
		<div class="page_name"><?=$c['lang_pack']['products'];?></div>
		<div class="content">
			<?php foreach($display_cates as $k => $v){
				$allcate_count = count($allcate_ary["0,{$products_top_cate},{$current_sec_cate},{$v['CateId']},"]);
			?>
			<div class="list <?=$current_cate_id == $v['CateId'] ? 'on' : ''?>">
				<div class="first_cate">
					<a href="<?=web::get_url($v);?>" class="category_<?=$v['CateId']; ?>" title="<?=$v['Category'.$c['lang']];?>"><?=$v['Category'.$c['lang']];?></a>
					<div class="border"></div>
				</div>
				<?php if($allcate_count){?>
				<div class="son_cate">
					<?php foreach($allcate_ary["0,{$products_top_cate},{$current_sec_cate},{$v['CateId']},"] as $k1 => $v1){?>
					<div class="item"><a href="<?=web::get_url($v1);?>" class="text-over block category_<?=$v1['CateId']; ?>" title="<?=$v1['Category'.$c['lang']];?>"><?=$v1['Category'.$c['lang']];?></a></div>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<div class="leftContent">
			<?php $relate_pro = db::get_limit('products', 'IsHot=1', '*', $c['my_order'].'ProId desc', 0, 10);?>
			<div class="relate">
				<div class="title"><?=$c['lang_pack']['hot'];?></div>
				<div class="list">
					<?php foreach((array)$relate_pro as $k => $v){
						$url = web::get_url($v, 'products');
					?>
						<div class="row">
							<a class="img trans fl" href="<?=$url?>"><img src="<?=img::get_small_img($v['PicPath_0'], '240x240')?>" alt=""></a>
							<div class="row_txt fl">
								<a class="name" href="<?=$url?>"><?=$v['Name'.$c['lang']]?></a>
								<a class="btn">
									<?=$c['lang_pack']['view']; ?>
								</a>
							</div>
							<div class="clear"></div>
						</div>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
<?php
	$cache_catalog_contents = ob_get_contents();
	ob_end_clean();
	file::write_file(web::get_cache_path($c['themes'], 0), 'products_catalog.html', $cache_catalog_contents);
	echo $cache_catalog_contents;
	unset($cache_catalog_contents);
}else{
	include(web::get_cache_path($c['themes']).'/products_catalog.html');
}
if($CateId){ ?>
<script>
	$('.category_<?=$TopCateId; ?>,.category_<?=$SecCateId; ?>,.category_<?=$CateId; ?>').addClass('on');
	$('.category_<?=$TopCateId; ?>').parents('.list').addClass('on').siblings().removeClass('on');
	$('.v_<?=$SecCateId; ?>').css('display','block');
</script>
<?php } ?>



<!-- 最新版本 -->
<?php
$products_catalog_set_time = @filemtime(web::get_cache_path($c['themes']).'/products_catalog.html');//文件生成时间
!$products_catalog_set_time && $products_catalog_set_time = 0;
$set_cache = $c['time'] - $products_catalog_set_time - $c['cache_timeout'];	//当前时间 - 文件生成时间 - 自动生成静态文件时间间隔

$current_cate_id = isset($CateId) ? $CateId : 0;
$current_top_cate = isset($TopCateId) ? $TopCateId : 0;
$current_sec_cate = isset($SecCateId) ? $SecCateId : 0;

$industry_focus_id = 338;
$hot_new_id = 212;

// 获取所有分类并建立ID到名称的映射
$allcate_row = str::str_code(db::get_all('products_category', '1', "CateId,Category{$c['lang']}",  $c['my_order'].'CateId asc'));
$cate_names = array();
foreach($allcate_row as $k => $v){
    $cate_names[$v['CateId']] = $v["Category{$c['lang']}"];
}

// 确定页面标题
$page_name = $c['lang_pack']['products']; // 默认显示products
// 如果当前在Industry Focus分类下，显示其名称
if($current_top_cate == $industry_focus_id && isset($cate_names[$industry_focus_id])){
    $page_name = $cate_names[$industry_focus_id];
}
// 如果当前在Hot&New分类下，显示其名称
elseif($current_top_cate == $hot_new_id && isset($cate_names[$hot_new_id])){
    $page_name = $cate_names[$hot_new_id];
}

if($set_cache > 0 || !is_file(web::get_cache_path($c['themes']).'/products_catalog.html')){
	ob_start();


	$allcate_row = str::str_code(db::get_all('products_category', '1', "CateId,UId,Category{$c['lang']}",  $c['my_order'].'CateId asc'));
	$allcate_ary = array();
	foreach($allcate_row as $k => $v){
		$allcate_ary[$v['UId']][] = $v;
	}
	
	$display_cates = array();
	
	if($current_top_cate == $industry_focus_id || $current_top_cate == $hot_new_id) {
		$uid_key = "0,{$current_top_cate},";
		$display_cates = isset($allcate_ary[$uid_key]) ? $allcate_ary[$uid_key] : array();
	}
	elseif(($current_top_cate == $industry_focus_id || $current_top_cate == $hot_new_id) && $current_sec_cate > 0) {
		$uid_key = "0,{$current_top_cate},{$current_sec_cate},";
		$display_cates = isset($allcate_ary[$uid_key]) ? $allcate_ary[$uid_key] : array();
	}
	else {
		$display_cates = isset($allcate_ary["0,"]) ? $allcate_ary["0,"] : array();
	}
?>
	<div class="pro_cate">
		<!-- 使用动态确定的页面标题 -->
		<div class="page_name"><?=$page_name;?></div>
		<div class="content">
			<?php foreach($display_cates as $k => $v){
				if($current_top_cate > 0 && $current_sec_cate == 0) {
					$sub_uid_key = "0,{$current_top_cate},{$v['CateId']},";
				} elseif($current_top_cate > 0 && $current_sec_cate > 0) {
					$sub_uid_key = "0,{$current_top_cate},{$current_sec_cate},{$v['CateId']},";
				} else {
					$sub_uid_key = "0,{$v['CateId']},";
				}
				$has_children = isset($allcate_ary[$sub_uid_key]) && count($allcate_ary[$sub_uid_key]) > 0;
			?>
			<div class="list <?=$current_cate_id == $v['CateId'] ? 'on' : ''?>">
				<div class="first_cate">
					<a href="<?=web::get_url($v);?>" class="category_<?=$v['CateId']; ?>" title="<?=$v['Category'.$c['lang']];?>">
						<?=$v['Category'.$c['lang']];?>
					</a>
					<div class="border"></div>
				</div>
				<?php if($has_children){?>
				<div class="son_cate">
					<?php foreach($allcate_ary[$sub_uid_key] as $k1 => $v1){?>
					<div class="item">
						<a href="<?=web::get_url($v1);?>" class="text-over block category_<?=$v1['CateId']; ?>" title="<?=$v1['Category'.$c['lang']];?>">
							<?=$v1['Category'.$c['lang']];?>
						</a>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<div class="leftContent">
			<?php $relate_pro = db::get_limit('products', 'IsHot=1', '*', $c['my_order'].'ProId desc', 0, 10);?>
			<div class="relate">
				<div class="title"><?=$c['lang_pack']['hot'];?></div>
				<div class="list">
					<?php foreach((array)$relate_pro as $k => $v){
						$url = web::get_url($v, 'products');
					?>
						<div class="row">
							<a class="img trans fl" href="<?=$url?>"><img src="<?=img::get_small_img($v['PicPath_0'], '240x240')?>" alt=""></a>
							<div class="row_txt fl">
								<a class="name" href="<?=$url?>"><?=$v['Name'.$c['lang']]?></a>
								<a class="btn">
									<?=$c['lang_pack']['view']; ?>
								</a>
							</div>
							<div class="clear"></div>
						</div>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
<?php
	$cache_catalog_contents = ob_get_contents();
	ob_end_clean();
	file::write_file(web::get_cache_path($c['themes'], 0), 'products_catalog.html', $cache_catalog_contents);
	echo $cache_catalog_contents;
	unset($cache_catalog_contents);
}else{
	include(web::get_cache_path($c['themes']).'/products_catalog.html');
}
if($CateId){ ?>
<script>
	$('.category_<?=$TopCateId; ?>,.category_<?=$SecCateId; ?>,.category_<?=$CateId; ?>').addClass('on');
	$('.category_<?=$TopCateId; ?>').parents('.list').addClass('on').siblings().removeClass('on');
	<?php if($current_sec_cate > 0){?>
	$('.v_<?=$current_sec_cate; ?>').css('display','block');
	<?php }?>
</script>
<?php } ?>