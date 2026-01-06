<?php !isset($c) && exit();?>
<?php
$footer_set_time=@filemtime(web::get_cache_path($c['themes']).'/footer.html');//文件生成时间
!$footer_set_time && $footer_set_time=0;
$set_cache=$c['time']-$footer_set_time-$c['cache_timeout'];	//当前时间 - 文件生成时间 - 自动生成静态文件时间间隔

$swap_chain=web::swap_chain(array('pb'));
if($set_cache>0 || !is_file(web::get_cache_path($c['themes']).'/footer.html')){
	ob_start();
?>
<div id="footer">
	<div class="wrap">
		<div class="link">
			<ul>
				<li class="tit"><?=$c['lang_pack']['products'];?></li>
				<?php 
				$foot_pro_cate = db::get_limit('products_category','UId="0,"','*',$c['my_order'].'CateId asc',0,4); 
				foreach((array)$foot_pro_cate as $v){
					$name = $v['Category'.$c['lang']];
					$url = web::get_url($v,'products_category');
					?>
					<li><a href="<?=$url; ?>" title="<?=$name; ?>"><?=$name; ?></a></li>
				<?php } ?>
			</ul>
			<?php 
			$foot_art_cate = db::get_limit('article_category','UId="0,"','*',$c['my_order'].'CateId asc',0,2); 
			foreach((array)$foot_art_cate as $v){
				$name = $v['Category'.$c['lang']];
				?>
				<ul>
					<li class="tit"><?=$name; ?></li>
					<?php 
					$foot_art_row = db::get_limit('article',"CateId={$v['CateId']}",'*',$c['my_order'].'CateId asc',0,4); 
					foreach((array)$foot_art_row as $v1){
						$name1 = $v1['Title'.$c['lang']];
						$url1 = web::get_url($v1,'article');
						?>
						<li><a href="<?=$url1; ?>" title="<?=$name1; ?>"><?=$name1; ?></a></li>
					<?php } ?>
                    <!-- 修改位置开始 -->
					<?php
					if($v['CateId'] == 1){
						?>
						<li><a href="/blogs/" title="blogs">blogs</a></li>
						<?php
					}
					?>
                    <!-- 修改位置结束 -->
				</ul>
			<?php } ?>
			<ul class="contact">
				<li class="tit"><?=$c['lang_pack']['contact'];?></li>
				<li class="i email"><span></span><?=ucfirst($c['lang_pack']['email']);?>: <a class="email_copy" href="mailto:<?=$c['config']['global']['Contact']['email'.$c['lang']]?$c['config']['global']['Contact']['email'.$c['lang']]:$c['config']['global']['Contact']['email_'.$c['config']['global']['LanguageDefault']]; ?>" title="<?=$c['config']['global']['Contact']['email'.$c['lang']]?$c['config']['global']['Contact']['email'.$c['lang']]:$c['config']['global']['Contact']['email_'.$c['config']['global']['LanguageDefault']]; ?>"><?=$c['config']['global']['Contact']['email'.$c['lang']]?$c['config']['global']['Contact']['email'.$c['lang']]:$c['config']['global']['Contact']['email_'.$c['config']['global']['LanguageDefault']]; ?></a></li>
				<li class="i tel"><span></span><?=ucfirst($c['lang_pack']['tel']);?>: <?=$c['config']['global']['Contact']['tel'.($c['lang']?$c['lang']:$c['config']['global']['LanguageDefault'])];?></li>
				<li class="i address"><span></span><?=ucfirst($c['lang_pack']['address']);?>:<?=$c['config']['global']['Contact']['address'.$c['lang']]?$c['config']['global']['Contact']['address'.$c['lang']]:$c['config']['global']['Contact']['address_'.$c['config']['global']['LanguageDefault']];?></li>
				<li class="share">
					<?=web::foot_share(2);?>
				</li>
			</ul>
			<span class="br"></span>
		</div>
		<?php
		$links=db::get_all('partners','1','*');
		if($links && $m=="index" && !$swap_chain){
		?>
			<div class="partners">
				<div class="title"><?=$c['lang_pack']['partner'];?></div>
				<div class="box">
					<?php
						$links = db::get_all('partners','1','*');
						foreach((array)$links as $k => $v){
					?>
						<div class="list fl">
							<div class="item"><a href="<?=$v['Url'];?>" title="<?=$v['Name'.$c['lang']];?>" class="pic_box"><img  alt="<?=$v['Name'.$c['lang']];?>" src="<?=$v['PicPath'];?>" /><em></em></a></div>
						</div>
					<?php }?>
					<div class="clear"></div>
				</div>
			</div>
		<?php } ?>
	</div>
	<?=$swap_chain;?>
	<div class="copyright">
		<div class="wrap">
			<div class="txt"><?=$c['config']['global']['Contact']['copyright'.$c['lang']]?$c['config']['global']['Contact']['copyright'.$c['lang']]:$c['config']['global']['Contact']['copyright_'.$c['config']['global']['LanguageDefault']].($c['config']['global']['powered_by']!=''?'&nbsp;&nbsp;&nbsp;&nbsp;'.$c['config']['global']['powered_by']:'');?></div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<?php include($c['static_path']."/inc/global/online_chat.php");?>
<?php include($c['static_path']."/inc/global/chat.php");?>
<?php
?>
<?php 
	$cache_contents=ob_get_contents();
	ob_end_clean();
	file::write_file(web::get_cache_path($c['themes'], 0), 'footer.html', $cache_contents);
	echo $cache_contents;
	unset($cache_contents);
}else{
	include(web::get_cache_path($c['themes']).'/footer.html');
}
if(!$c['google_hide']){
	echo web::output_third_code();
}
?>