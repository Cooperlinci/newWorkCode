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