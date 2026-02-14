/common/widgets/cusvis_mode/product_list/mode_2/index.php
<?php

use common\helps\HelpsHtml;
use common\helps\HelpsImg;
use common\helps\HelpsJson;
use common\helps\HelpsString;
use common\helps\HelpsVisualV2;
use common\helps\Ly200;
use frontend\modules\LangPack;
use yii\helpers\Html;
?>
<div class="ly_product_list_2" data-visual-id="<?=$PId;?>">
	<?=$googleviewItemListEvent;?>
	<?=HelpsVisualV2::getButtonCss('BatchInquiryList', [
		'class' => '.ly_product_list_2[data-visual-id="' . $PId . '"] .global_inquiry_bat_button',
		'padding' => '10px 30px',
		'paddingM' => '10px 15px',
	]);?>
	<?=HelpsVisualV2::getSpacingCss($PId, $c['web_pack'][$PId]['Settings'],[
        'mainObj'   =>  '.ly_product_list_2[data-visual-id="' . $PId . '"]',
        'contentArea'   =>  '.ly_product_list_2[data-visual-id="' . $PId . '"] .wide',
        'paddingArea'   =>  '.ly_product_list_2[data-visual-id="' . $PId . '"] .wide .section',
    ]);?>
	<style>
		.ly_product_list_2[data-visual-id="<?=$PId;?>"] .products_category_box .top_title{color:<?=$c['web_pack'][$PId]['Settings']['CategoryNameColor'];?>;background-color:<?=$c['web_pack'][$PId]['Settings']['CategoryNameBgColor'];?>;}
		.ly_product_list_2[data-visual-id="<?=$PId;?>"] .products_category_wrapper .cate_item{color:<?=$c['web_pack'][$PId]['Settings']['CategoryTitleColor'];?>}
		.ly_product_list_2[data-visual-id="<?=$PId;?>"] .products_category_wrapper .cate_item:hover{color:<?=$c['web_pack'][$PId]['Settings']['CategoryTitleHoverColor'];?>}
		.ly_product_list_2[data-visual-id="<?=$PId;?>"] .products_category_wrapper .cate_item.cur{color:<?=$c['web_pack'][$PId]['Settings']['CategoryTitleHoverColor'];?>}
		.ly_product_list_2[data-visual-id="<?=$PId;?>"] .list_box{grid-template-columns: repeat(<?=$lineCount;?>, calc((100% - <?=($lineCount - 1) * 30;?>px) / <?=$lineCount;?>));}
		.ly_product_list_2[data-visual-id="<?=$PId;?>"] .relate_box .top_title { color: <?=$c['web_pack'][$PId]['Settings']['RecommendProductTitleColor'];?>; }
		.ly_product_list_2[data-visual-id="<?=$PId;?>"] .relate_box.list_bottom_box .top_title{ color: <?=$c['web_pack'][$PId]['Settings']['RecommendProductTitleColor'];?>; }
		.ly_product_list_2[data-visual-id="<?=$PId;?>"] .products_category_wrapper .products_category_box .one_title .cate_item{font-size: <?=$c['web_pack'][$PId]['Settings']['FirstCategoryTitleFontSizePc'];?>;}
		.ly_product_list_2[data-visual-id="<?=$PId;?>"] .products_category_wrapper .products_category_box .sec_title .cate_item{font-size: <?=$c['web_pack'][$PId]['Settings']['SecondCategoryTitleFontSizePc'];?>;}
		.ly_product_list_2[data-visual-id="<?=$PId;?>"] .products_category_wrapper .products_category_box .third_item .cate_item{font-size: <?=$c['web_pack'][$PId]['Settings']['ThirdCategoryTitleFontSizePc'];?>;}
		@media screen and (max-width: 1000px) {
			.ly_product_list_2[data-visual-id="<?=$PId;?>"] .products_category_wrapper .products_category_box .one_title .cate_item{font-size: <?=$c['web_pack'][$PId]['Settings']['FirstCategoryTitleFontSizeMobile'];?>;}
			.ly_product_list_2[data-visual-id="<?=$PId;?>"] .products_category_wrapper .products_category_box .sec_title .cate_item{font-size: <?=$c['web_pack'][$PId]['Settings']['SecondCategoryTitleFontSizeMobile'];?>;}
			.ly_product_list_2[data-visual-id="<?=$PId;?>"] .products_category_wrapper .products_category_box .third_item .cate_item{font-size: <?=$c['web_pack'][$PId]['Settings']['ThirdCategoryTitleFontSizeMobile'];?>;}
		}
	</style>
	<?php
	?>
	<div class="wide">
		<div class="section">
			<div class="prdocuts_wrapper">
				<?php if($c['web_pack'][$PId]['Settings']['RecommendProduct'] || $c['web_pack'][$PId]['Settings']['CategoryShowLeft'] || ($isShowScreening && $filtersPosition == 'left')) {?>
					<div class="products_category_wrapper <?=$isShowScreening ? 'has_wrapper_screening' : ''?>">
						<?php if ($c['web_pack'][$PId]['Settings']['CategoryShowLeft']) { ?>
							<div class="products_category_box">
								<div class="top_title"><?=LangPack::lang('web.global.category');?></div>
								<div class="category_box">
									<?php
									$UId = '0,';
									$uidAry = [];
									if($categoryRow) {
										$uidAry = explode(',', trim($categoryRow['UId']));
										$uidAry = array_filter($uidAry);
									}
									if(isset($allCategoryRow[$UId]) && count($allCategoryRow[$UId]) > 0) {?>
									<?php
									foreach ((array)$allCategoryRow[$UId] as $k => $v) {
										$twoUId = $UId . $v['CateId'] . ',';
										$current = $CateId == $v['CateId'];
										$hasSub = isset($allCategoryRow[$v['UId'] . $v['CateId'] . ',']);
										$iconClass = $hasSub ? (($current || in_array($v['CateId'], $uidAry)) ? 'sub_show' : 'sub_hide') : '';
										$curClass = $hasSub ? (($current || in_array($v['CateId'], $uidAry)) ? 'cur' : '') : '';?>
												<div class="one_item <?=$iconClass;?>">
													<div class="one_title item_title">
														<a href="<?=Ly200::getUrl($v)?>" class="cate_item <?=$CateId == $v['CateId'] ? ' cur' : ''?>" title="<?=Html::encode($v['Category'.$c['lang']])?>">
															<?=HelpsVisualV2::echoListHTags($v['Category'.$c['lang']], [
																'data' => $HtagsAry, 'innerData' => $v, 'Dept' => 1
															])?>
														</a>
														<?php if(isset($allCategoryRow[$twoUId]) && count($allCategoryRow[$twoUId]) > 0) {?><i class="iconfont <?=$curClass;?>"></i><?php }?>
													</div>
													<?php if(isset($allCategoryRow[$twoUId]) && count($allCategoryRow[$twoUId]) > 0) {?>
														<div class="sec_box next_box">
															<?php foreach((array)$allCategoryRow[$twoUId] as $k1 => $v1) {
																$hasSub2 = isset($allCategoryRow[$v1['UId'] . $v1['CateId'] . ',']);
																$current2 = $CateId == $v1['CateId'];
																$iconClass2 = $hasSub2 ? (($current2 || in_array($v1['CateId'], $uidAry)) ? 'sub_show' : 'sub_hide') : '';
																$thirdUId = $twoUId . $v1['CateId'] . ',';
																$curClass2 = $hasSub2 ? (($current2 || in_array($v1['CateId'], $uidAry)) ? 'cur' : '') : '';?>
																<div class="sec_item <?=$iconClass2;?>">
																	<div class="sec_title item_title">
																		<a href="<?=Ly200::getUrl($v1)?>" class="cate_item <?=$CateId == $v1['CateId'] ? ' cur' : ''?>" title="<?=Html::encode($v1['Category'.$c['lang']])?>">
																			<?=HelpsVisualV2::echoListHTags($v1['Category'.$c['lang']], [
																				'data' => $HtagsAry, 'innerData' => $v1, 'Dept' => 2
																			])?>
																		</a>
																		<?php if(isset($allCategoryRow[$thirdUId]) && count($allCategoryRow[$thirdUId]) > 0) {?><i class="iconfont <?=$curClass2;?>"></i><?php }?>
																	</div>
																	<?php if(isset($allCategoryRow[$thirdUId]) && count($allCategoryRow[$thirdUId]) > 0) {?>
																		<div class="third_box next_box">
																			<?php foreach((array)$allCategoryRow[$thirdUId] as $k2 => $v2) {?>
																				<div class="third_item">
																					<a href="<?=Ly200::getUrl($v2)?>" class="cate_item <?=$CateId == $v2['CateId'] ? ' cur' : ''?>" title="<?=Html::encode($v2['Category'.$c['lang']])?>">
																						<?=HelpsVisualV2::echoListHTags($v2['Category'.$c['lang']], [
																							'data' => $HtagsAry, 'innerData' => $v2, 'Dept' => 3
																						])?>
																					</a>
																				</div>
																			<?php }?>
																		</div>
																	<?php }?>
																</div>
															<?php }?>
														</div>
													<?php }?>
												</div>
										<?php } ?>
									<?php }?>
								</div>
							</div>
						<?php }
						if ($isShowScreening && $filtersPosition == 'left') { ?>
						<div id="themes_plist_left" class="themes_plist_left" data-filters-display="<?=$filterItemsDisplayContent?>"></div>
						<?php } ?>
						<?php if($c['web_pack'][$PId]['Settings']['RecommendProduct']) {?>
							<div class="relate_box">
								<div class="top_title"><?=$c['web_pack'][$PId]['Settings']['RecommendProductTitle'];?></div>
								<div class="pro_list">
									<?php foreach((array)$relatedRow as $k => $v) {?>
										<div class="related_item">
											<div class="pic_box">
												<a href="<?=Ly200::getUrl($v, 'products');?>">
													<img class="lazyload trans" src="<?=Ly200::getSizeImg($v['PicPath_0'], '80x80');?>" alt="<?=HelpsImg::imgAlt($v['Name'.$c['lang']], 'productsName', '', ['seoTitle' => $v['seoTitle'] ?? '']);?>">
												</a>
											</div>
											<div class="content">
												<a href="<?=Ly200::getUrl($v, 'products');?>" class="g_name themes_products_title"><?=Html::encode($v['Name'.$c['lang']])?></a>
												<?php if($v['Number']) {?>
													<div class="g_number themes_text_content"><?=Html::encode($v['Number']);?></div>
												<?php }?>
											</div>
										</div>
									<?php }?>
								</div>
							</div>
						<?php }?>
					</div>
				<?php }?>
				<?php if ($isShowScreening) { ?>
					<div class="list_category"></div>
				<?php } ?>
				<div class="list_wrapper <?=$c['web_pack'][$PId]['Settings']['CategoryShowLeft'] ? '' : 'full';?>">
					<?php if ($c['web_pack'][$PId]['Settings']['CategoryShowLeft']) { ?>
					<div class="top_title"><h1><?=$Column;?></h1><i class="iconfont icon-mb_add4"></i></div>
					<?php } ?>



					<div class="category_filter">
						<select id="category_level1" class="category_select">
							<option value="0"><?=LangPack::lang('web.global.filters.category_level1');?></option>
							<?php if(isset($allCategoryRow['0,']) && count($allCategoryRow['0,']) > 0) {?>
								<?php foreach((array)$allCategoryRow['0,'] as $k => $v) {?>
									<option value="<?=$v['CateId'];?>"><?=Html::encode($v['Category'.$c['lang']]);?></option>
								<?php }?>
							<?php }?>
						</select>
						<select id="category_level2" class="category_select">
							<option value="0"><?=LangPack::lang('web.global.filters.category_level2');?></option>
						</select>
						<select id="category_level3" class="category_select">
							<option value="0"><?=LangPack::lang('web.global.filters.category_level3');?></option>
						</select>
					</div>



					<?php if (isset($categoryDescriptionRow['Description_en']) && $categoryDescriptionRow['Description_en'] && ( $c['web_pack'][$PId]['Settings']['CategoryDescriptionPosition'] == 'top' || !isset($c['web_pack'][$PId]['Settings']['CategoryDescriptionPosition']))) {?>
						<div class="list_category_description">
							<div class="editor_txt"><?=$categoryDescriptionRow['Description_en'];?></div>
						</div>
					<?php }?>
					<?php if ($isShowScreening && $filtersPosition == 'top') { ?>
						<div id="themes_plist_top" class="themes_plist_top"></div>
					<?php } ?>
					<div class="list_box">
						<?php foreach ((array)$productsAry as $k => $v) { ?>
							<div class="themes_prod">
								<div class="pic_box <?=$c['web_pack'][$PId]['Settings']['ImagePointingEffect'] == 13 ? 'switch_second_img' : 'hover_scale_img'?>">
									<div class="compute_item_img" style="<?=$v['Ext']['computeWidth'];?>">
										<div class="compute_process_img" style="<?=$v['Ext']['computeRatio'];?>">
											<a href="<?=$v['Ext']['url'];?>" title="<?=Html::encode($v['Ext']['name']);?>">
												<img <?=Ly200::getLazyPreloadingImage(Ly200::getSizeImg($v['Ext']['img'], '80x80'), 'trans');?> alt="<?=Html::encode(HelpsImg::imgAlt($v['Ext']['name'], 'productsName', '', ['seoTitle' => $v['Ext']['seoTitle']]));?>" style="<?=$v['Ext']['computeFilling'];?>">
												<?php if ($c['web_pack'][$PId]['Settings']['ImagePointingEffect'] == 13) { ?>
												<img <?=Ly200::getLazyPreloadingImage(Ly200::getSizeImg($v['Ext']['img1'], '80x80'), 'trans');?> alt="<?=Html::encode(HelpsImg::imgAlt($v['Ext']['name'], 'productsName', '', ['seoTitle' => $v['Ext']['seoTitle']]));?>" style="<?=$v['Ext']['computeFilling'];?>">
												<?php } ?>
											</a>
										</div>
									</div>
								</div>
								<div class="name themes_products_title">
									<a href="<?=$v['Ext']['url'];?>" class="themes_products_title" title="<?=Html::encode($v['Ext']['name']);?>">
										<?=HelpsVisualV2::echoListHTags($v['Ext']['name'], [
											'data' => $HtagsAry, 'key' => 'Tags'
										])?>
									</a>
								</div>
								<?php
									if ($v['Ext']['productsNumber']) {
										echo '<div class="number">' . $v['Ext']['productsNumber'] . '</div>';
									}
									echo HelpsHtml::showProductsPluginsPrice($v, 'products_list');
									
									if ($inquiryBatButton) {
								?>
									<div class="inquiry_button_box">
										<a class="global_inquiry_bat_button trans3 themes_box_button" href="javascript:;" data-proid="<?=$v['ProId'];?>" data-price-show="<?= (int)(Yii::$app->params['web_pack']['Config']['ProductsPriceShowDetail'] ?? 0) ?>" title="<?=Html::encode($inquiryBatButtonText);?>"><?=$inquiryBatButtonText;?></a>
										<a class="global_inquiry_bat_cart themes_box_button" href="/inquiry.html" title="<?=LangPack::lang('web.global.inquiry_browse');?>"><?=LangPack::lang('web.global.inquiry_browse');?></a>
									</div>
								<?php }?>
							</div>
						<?php } ?>
					</div>
					<?php if($PageStyle == 'number') { ?>
						<?=HelpsHtml::turnPage($pagination);?>
					<?php } elseif ($PageStyle == 'dropdown') {?>
						<div class="dropdown_loading"></div>
						<div id="dropdown_page" page="1" mobile="<?=Ly200::isMobileClient(1)?>" max-page="<?=$maxPage?>"></div>
					<?php }?>
					<?php if (isset($categoryDescriptionRow['Description_en']) && $categoryDescriptionRow['Description_en'] && $c['web_pack'][$PId]['Settings']['CategoryDescriptionPosition'] == 'bottom' ) {?>
						<div class="list_category_description">
							<div class="editor_txt"><?=$categoryDescriptionRow['Description_en'];?></div>
						</div>
					<?php }?>
				</div>
	
				<?php if($c['web_pack'][$PId]['Settings']['RecommendProduct']) {?>
					<div class="relate_box list_bottom_box">
						<div class="top_title"><?=$c['web_pack'][$PId]['Settings']['RecommendProductTitle'];?></div>
						<div class="pro_list">
							<?php foreach((array)$relatedRow as $k => $v) {?>
								<div class="related_item">
									<div class="pic_box">
										<a href="<?=Ly200::getUrl($v, 'products');?>">
											<img <?=Ly200::getLazyPreloadingImage(Ly200::getSizeImg($v['PicPath_0'], '80x80'), 'trans');?> alt="<?=HelpsImg::imgAlt($v['Name'.$c['lang']], 'productsName', '', ['seoTitle' => $v['seoTitle'] ?? '']);?>">
										</a>
									</div>
									<div class="content">
										<a href="<?=Ly200::getUrl($v, 'products');?>" class="g_name themes_products_title">
											<?=Html::encode($v['Name'.$c['lang']]);?>
										</a>
										<?php if($v['Number']) {?>
											<div class="g_number themes_text_content"><?=Html::encode($v['Number']);?></div>
										<?php }?>
									</div>
								</div>
							<?php }?>
						</div>
					</div>
				<?php }?>
	
			</div>
		</div>
	</div>
	<script>
		const categoryData = <?php echo HelpsJson::encode($allCategoryRow);?>;
		const currentLang = '<?=$c['lang'];?>';
		const langPack = {
			categoryLevel1: '<?=LangPack::lang('web.global.filters.category_level1');?>',
			categoryLevel2: '<?=LangPack::lang('web.global.filters.category_level2');?>',
			categoryLevel3: '<?=LangPack::lang('web.global.filters.category_level3');?>'
		};
		$(function(){
			dropdown_page();
			mobile_select_category($('.ly_product_list_2[data-visual-id="<?=$PId;?>"] .list_wrapper .top_title'), $('.ly_product_list_2[data-visual-id="<?=$PId;?>"] .products_category_wrapper'));
			left_category_click($('.ly_product_list_2[data-visual-id="<?=$PId;?>"] .category_box'));
			category_filter_init();
		})
	</script>
	<input type="hidden" name="ProIdString" id="ProIdString" value="<?=$products_id?>">
	<input type="hidden" name="CateId" id="CateId" value="<?=$CateId?>">
	<input type="hidden" name="NarrowAry" id="NarrowAry" value="<?=HelpsString::format(HelpsJson::encode($Narrow_ary))?>">
</div>



/common/widgets/cusvis_mode/product_list/mode_2/main.js
<script>
function dropdown_page(){
	// 翻页
	let timer = null;
	let start = new Date();
	let limit = 1000;  // 1s间隔执行一次     
	$(window).on('scroll', function(){
		if (timer) clearTimeout(timer);
		let cur = new Date();
		let scrollFunc = () => {
			let _container = $('.ly_product_list_2 .list_box');
			let top = $(this).scrollTop();
			let height = $(this).height();
			let scrollHeight = _container[0].scrollHeight;
			let loadHeight = 120;
			if (scrollHeight - (top + height) < loadHeight) {
				let _pageObj = $('#dropdown_page');
				let page = parseInt(_pageObj.attr('page'));
				let maxPage = parseInt(_pageObj.attr('max-page'));
				let mobile = parseInt(_pageObj.attr('mobile'));
				if (page < maxPage) {
					$('.dropdown_loading').loading();
					page = page + 1;
					_pageObj.attr('page', page);
					let data = {'page':page};
					let url = window.location.search;
					$.ajax({
						url:url,
						async:true,
						type:'get',
						data: data,
						dataType:'html',
						success:function(data){
							console.log(window.location)
							$('.dropdown_loading').unloading();
							let _dataHtml = $(data),
								_listData = _dataHtml.find('.list_box'),
								_itemData = _listData.find('.themes_prod');
							if (_itemData.length > 0){
								_container.append(_itemData);
							}
						}
					});
				}
			}
		}
		if (cur - start >= limit) {
			scrollFunc();
			start = cur;
		} else {
			timer = setTimeout(scrollFunc, 300);
		}
	});
}

function mobile_select_category(_click_obj, nav_obj){
	_click_obj.on('click', function(){
		if(!_click_obj.length || !nav_obj.length || $(window).width()>1000) { return false; }
		let cur =_click_obj.hasClass('cur'),
			top = _click_obj.offset().top - 10, //间距
			height = _click_obj.outerHeight() + 10;
		cur ? $(this).removeClass('cur') : $(this).addClass('cur');
		cur ? nav_obj.hide() : nav_obj.show();
		nav_obj.css('top', height);
		let _screeningPositionClass = 'sticky';
		if (nav_obj.hasClass('has_wrapper_screening') && !cur || $(window).width() <= 1000) {
			_screeningPositionClass = 'absolute';
		}
		nav_obj.css('position',_screeningPositionClass);
	})
}

function left_category_click(_obj) {
	if(!_obj) return;
	_obj.on('click', 'i', function(){
		let _this = $(this),
			_cur = _this.hasClass('cur') ? true : false;
		if(_cur) {
			_this.removeClass('cur').parent().next().slideUp();
		} else {
			_this.addClass('cur').parent().next().slideDown();
		}
	})
}


// 修改
function category_filter_init() {
	initCategoryFilter();
	$('#category_level1').on('change', function() {
		let level1Id = $(this).val();
		$('#category_level2').html('<option value="0">' + langPack.categoryLevel2 + '</option>');
		$('#category_level3').html('<option value="0">' + langPack.categoryLevel3 + '</option>');
		if(level1Id != 0) {
			let level2Key = '0,' + level1Id + ',';
			if(categoryData[level2Key] && categoryData[level2Key].length > 0) {
				$.each(categoryData[level2Key], function(index, item) {
					let categoryName = item['Category' + currentLang] || item['Category' + 'en'] || 'Unknown';
					$('#category_level2').append('<option value="' + item.CateId + '">' + categoryName + '</option>');
				});
			}
			let categoryUrl = findCategoryUrl(level1Id);
			if(categoryUrl) {
				window.location.href = categoryUrl;
			}
		}
	});
	$('#category_level2').on('change', function() {
		let level1Id = $('#category_level1').val();
		let level2Id = $(this).val();
		$('#category_level3').html('<option value="0">' + langPack.categoryLevel3 + '</option>');
		if(level1Id != 0 && level2Id != 0) {
			let level3Key = '0,' + level1Id + ',' + level2Id + ',';
			if(categoryData[level3Key] && categoryData[level3Key].length > 0) {
				$.each(categoryData[level3Key], function(index, item) {
					let categoryName = item['Category' + currentLang] || item['Category' + 'en'] || 'Unknown';
					$('#category_level3').append('<option value="' + item.CateId + '">' + categoryName + '</option>');
				});
			}
			let categoryUrl = findCategoryUrl(level2Id);
			if(categoryUrl) {
				window.location.href = categoryUrl;
			}
		}
	});
	$('#category_level3').on('change', function() {
		let level3Id = $(this).val();
		if(level3Id != 0) {
			let categoryUrl = findCategoryUrl(level3Id);
			if(categoryUrl) {
				window.location.href = categoryUrl;
			}
		}
	});
}
function findCategoryUrl(cateId) {
	for(let key in categoryData) {
		if(categoryData.hasOwnProperty(key)) {
			let items = categoryData[key];
			for(let i = 0; i < items.length; i++) {
				if(items[i].CateId == cateId) {
					if(items[i].Url) {
						return items[i].Url;
					}
					let categoryName = items[i]['Category' + currentLang] || items[i]['Category' + 'en'] || '';
					if(categoryName) {
						let friendlyName = categoryName.toLowerCase().replace(/\s+/g, '-').replace(/[^\p{L}\p{N}-]/gu, '');
						return '/collections/' + friendlyName;
					}
					return null;
				}
			}
		}
	}
	return null;
}
function initCategoryFilter() {
	let currentCateId = parseInt($('#CateId').val()) || 0;
	if(currentCateId == 0) return;
	let level1Id = 0, level2Id = 0, level3Id = 0;
	let found = false;
	for(let level1Key in categoryData) {
		if(categoryData.hasOwnProperty(level1Key)) {
			let level1Items = categoryData[level1Key];
			$.each(level1Items, function(index, level1Item) {
				if(level1Item.CateId == currentCateId) {
					level1Id = currentCateId;
					found = true;
					return false;
				}
				let level2Key = level1Key + level1Item.CateId + ',';
				if(categoryData[level2Key]) {
					$.each(categoryData[level2Key], function(index, level2Item) {
						if(level2Item.CateId == currentCateId) {
							level1Id = level1Item.CateId;
							level2Id = currentCateId;
							found = true;
							return false;
						}
						let level3Key = level2Key + level2Item.CateId + ',';
						if(categoryData[level3Key]) {
							$.each(categoryData[level3Key], function(index, level3Item) {
								if(level3Item.CateId == currentCateId) {
									level1Id = level1Item.CateId;
									level2Id = level2Item.CateId;
									level3Id = currentCateId;
									found = true;
									return false;
								}
							});
							if(found) return false;
						}
					});
					if(found) return false;
				}
			});
			if(found) break;
		}
	}
	if(level1Id != 0) {
		$('#category_level1').val(level1Id);
		let level2Key = '0,' + level1Id + ',';
		if(categoryData[level2Key] && categoryData[level2Key].length > 0) {
			$('#category_level2').html('<option value="0">' + langPack.categoryLevel2 + '</option>');
			$.each(categoryData[level2Key], function(index, item) {
				let categoryName = item['Category' + currentLang] || item['Category' + 'en'] || 'Unknown';
				$('#category_level2').append('<option value="' + item.CateId + '">' + categoryName + '</option>');
			});
			if(level2Id != 0) {
				$('#category_level2').val(level2Id);
				let level3Key = '0,' + level1Id + ',' + level2Id + ',';
				if(categoryData[level3Key] && categoryData[level3Key].length > 0) {
					$('#category_level3').html('<option value="0">' + langPack.categoryLevel3 + '</option>');
					$.each(categoryData[level3Key], function(index, item) {
						let categoryName = item['Category' + currentLang] || item['Category' + 'en'] || 'Unknown';
						$('#category_level3').append('<option value="' + item.CateId + '">' + categoryName + '</option>');
					});
					if(level3Id != 0) {
						$('#category_level3').val(level3Id);
					}
				}
			}
		}
	}
}
function getCurrentLang() {
	return typeof c !== 'undefined' && c.lang ? c.lang : 'en';
}</script>


/common/widgets/cusvis_mode/product_list/mode_2/main.class
<style>
/* 修改 */
@media screen and (max-width: 1000px) {
    .ly_product_list_2 .category_filter {flex-direction: column;}
    .ly_product_list_2 .category_select {width: 100%;min-width: unset;}
}
.ly_product_list_2 .category_filter {margin-bottom: 20px;padding: 15px;background-color: #f8f8f8;border-radius: 4px;display: flex;gap: 10px;flex-wrap: wrap;}
.ly_product_list_2 .category_select {padding: 8px 12px;border: 1px solid #ddd;border-radius: 4px;font-size: 14px;min-width: 150px;}
</style>



// 后端修改
<?php


