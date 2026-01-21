controller.php
<?php
namespace common\widgets\cusvis_mode\product_list\mode_2;

use common\helps\HelpsGoogle;
use common\helps\HelpsJson;
use common\helps\HelpsPagination;
use common\helps\HelpsProducts;
use common\helps\HelpsString;
use common\helps\HelpsVisualV2;
use common\helps\HelpsWhere;
use common\helps\Ly200;
use common\models\products\ProductsCategory;
use common\models\products\ProductsSeo;
use common\models\Tags;
use frontend\controllers\ProductsController;
use frontend\modules\LangPack;
use Yii;

class Controller
{
	private $PId;

	public function __construct($data)
	{
		$this->PId = $data['PId'];
	}

	/**
	 * 获取数据
	 *
	 * @return void
	 */
	public function getData()
	{
		$c = Yii::$app->params;
		$client = Yii::$app->request->get('client','');
		//页面数据
		$pagesDataInit = Yii::$app->controller->pagesDataInit;
		$CateId = (int)$pagesDataInit['CateId'];
		$page = (int)$pagesDataInit['page'];
		$Sort = (int)$pagesDataInit['Sort'];
		//可视化数据
		$computeAry = HelpsVisualV2::getGlobalSize('ProductsPicScale',['width' => 500, 'height' => '500']);

		// 总产品列表默认排序
		$Sort = $CateId ? $Sort : ($c['config']['global']['ProductsSorting'] ?? $Sort);

		//列表页数据
		$limitOrderBy = $OrderBy = [];
		if (isset($c['products_sort'][$Sort])) {
			$limitOrderBy = $OrderBy = $c['products_sort'][$Sort];
		} else {
			//开启了产品置顶并且从指定链接进来
			if (@in_array('product_top', (array)$c['plugins']['Used']) && (isset($_GET['utm_campaign']) && $_GET['utm_campaign'])) {
				$limitOrderBy = $OrderBy = HelpsProducts::getProductTopOrder($CateId);
			}
		}

		$rowCount = $c['web_pack'][$this->PId]['Settings']['RowPc'] ?: 5;
		$lineCount = $c['web_pack'][$this->PId]['Settings']['ColumnsPc'] ?: 4;
		$PageStyle = 'number';
		if (Ly200::isMobileClient(1) || $client == 'mobile') {
			$rowCount = 8;
			$lineCount = $c['web_pack'][$this->PId]['Settings']['ColumnsMobile'] ?: 2;
			$PageStyle = $c['web_pack'][$this->PId]['Settings']['PageStyleMobile'] ?: 'number';
		}
		$pageCount = $rowCount * $lineCount;

		$CategoryRow = ProductsCategory::find()
			->where(['IsSoldOut' => 0])
			->orderBy(array_merge($c['my_order'], ['CateId' => SORT_ASC]))
			->asArray()
			->allCache();
			
		$allCategoryRow = [];
		foreach((array)$CategoryRow as $k => $v) {
			$allCategoryRow[$v['UId']][] = $v;
		}
		
		$where = [
			'and',
			$c['where']['products'],
		];
		
		// 筛选
		$Narrow = Yii::$app->request->get('Narrow', '');
		// 搜索产品
		$keyword = Ly200::formatKeyword();
		$isSearch = (substr_count($_SERVER['REQUEST_URI'], '/search/') || substr_count($_SERVER['REQUEST_URI'], '/products')) && $keyword;
		$fieldAry = ['*'];
		
		$screenAry = HelpsWhere::products($keyword, $Narrow, $OrderBy, $limitOrderBy, $CateId, $where);
		$where = $screenAry['where'];
		$fieldAry = $screenAry['fieldAry'];
		$OrderBy = $screenAry['OrderBy'];

		$productsRow = HelpsProducts::getProductsRow('get_limit_page',$CateId,$where, $fieldAry,$OrderBy,$page,$pageCount);
		if ($isSearch) ProductsController::searchLogs($productsRow[1]);
		$productsAry = $productsRow[0];


		// 新增tags标签的数据
		// ========== 核心：仅查询最新标签名称 ==========
		// 1. 解析所有产品的Tags字段，收集所有标签ID
		$allTagIds = [];
		$productTagIdMap = []; // 产品ProId => 标签ID数组
		foreach ($productsAry as $product) {
		    $proId = $product['ProId'];
		    $tagsStr = $product['Tags'] ?? '';
		    // 解析Tags格式：|1| → 1，|1|2| → [1,2]
		    $tagIdArr = array_filter(explode('|', trim($tagsStr, '|')));
		    $tagIdArr = array_map('intval', $tagIdArr);
		    $productTagIdMap[$proId] = $tagIdArr;
		    $allTagIds = array_merge($allTagIds, $tagIdArr);
		}
		$allTagIds = array_unique($allTagIds); // 去重减少查询

		// 2. 查询所有标签ID对应的最新标签名称（按id降序，取最新的一条）
		$tagNameMap = [];
		if (!empty($allTagIds)) {
		    $tagsRow = Tags::find()
		        ->select(['id', 'name'])
		        ->where(['in', 'id', $allTagIds])
		        ->orderBy(['id' => SORT_DESC]) // 按id降序，id越大越新（若有ModifyTime可改为：'ModifyTime' => SORT_DESC）
		        ->asArray()
		        ->all();
		    // 构建标签ID → 最新名称的映射（id降序后，第一个就是最新）
		    foreach ($tagsRow as $tag) {
		        if (!isset($tagNameMap[$tag['id']])) {
		            $tagNameMap[$tag['id']] = $tag['name'];
		        }
		    }
		}

		// products seo
		$proIdAry = array_column($productsAry, 'ProId');
		$seoRow = ProductsSeo::find()->allAsArrayCache(['in', 'ProId', $proIdAry]);
		$seoAry = array_column($seoRow, NULL, 'ProId');
		foreach ((array)$productsAry as $k => $v) {
			// 获取产品编号
            $productsNumber = HelpsProducts::getShowProductNumber($v, $c['web_pack']['Config']['ProductsNumberList']);
			$FirstImageData = HelpsJson::decode($v['FirstImageData']);

			// 新增tags标签的数据
            // 获取当前产品的最新标签名称（取第一个标签ID对应的最新名称，无则为空）
            $currentTagIds = $productTagIdMap[$v['ProId']] ?? [];
            $latestTagName = '';
            if (!empty($currentTagIds)) {
                $latestTagId = $currentTagIds[0]; // 取产品第一个标签ID（若要按标签ID最新，可改为max($currentTagIds)）
                $latestTagName = $tagNameMap[$latestTagId] ?? '';
            }


            $productsAry[$k]['Ext'] = [
                'computeWidth' => HelpsVisualV2::computeWidth($FirstImageData, $computeAry['ReplaceAry']['PicScale']),
                'computeRatio' => HelpsVisualV2::computeRatio($computeAry['ReplaceAry'], 'products', $v['FirstImageData']),
                'computeFilling' => HelpsVisualV2::computeFilling($computeAry['FillingAry']),
                'url' => Ly200::getUrl($v,'products'),
                'img' => Ly200::getSizeImg($v['PicPath_0'], '500x500'),
                'img1' => $v['PicPath_1'] ? Ly200::getSizeImg($v['PicPath_1'], '500x500') : Ly200::getSizeImg($v['PicPath_0'], '500x500'),
                'name' => $v['Name' . $c['lang']],
				'seoTitle' => $seoAry[$v['ProId']]['SeoTitle' . $c['lang']] ?? '',
				'productsNumber' => $productsNumber,
				'tagsName' => $latestTagName
            ];
        }
		$categoryRow = $pagesDataInit['categoryRow'] ?? [];
		$route = 'products';
		if($categoryRow) {
			$getPageUrl = Ly200::getUrl($categoryRow);			
			$route = $getPageUrl;
		}
		$pagination = HelpsPagination::getPagination([
			'totalCount'=>$productsRow[1],
			'pageSize'=>$pageCount,
			'params' => array_diff_key(Yii::$app->request->queryParams, array_flip(['CateId', 'PageUrl'])),
		], $route);
		$maxPage = $productsRow[3];
		
		$visualCount = Ly200::isMobileClient(1) || $client == 'mobile' ? 3 : 6;
		$Column = LangPack::lang('products.global.products');
		if ($categoryRow){
			$Column = $categoryRow['Category'.$c['lang']];
		}
		if ($c['web_pack'][$this->PId]['Settings']['ProductsCount']) $Column .= ' '.str_replace('{ProCount}', $productsRow[1], LangPack::lang('products.list.pro_count'));

		$inquiryBatButton = $c['web_pack']['Config']['ProductsBatchInquiry'];
		$inquiryBatButtonText = $c['web_pack']['Config']['ProductsBatchInquiryButtonText'];

		// Google View Item List Event Code
		$analyticsTitle = $spare_ary['SeoTitle'] ?? $keyword;

		ob_start();
		$google = new HelpsGoogle();
		$google->viewItemListEvent($analyticsTitle, $productsAry, $keyword);
		
		$googleviewItemListEvent = ob_get_contents();
		ob_clean();

		$categoryRow = ProductsCategory::find()->oneAsArrayCache($CateId) ?? [];
		$isShowScreening = in_array('screening',$c['plugins']['Used'] ?? []);
		$productsIdRowAry = array_column($productsAry,'ProId');
		$products_id = HelpsString::aryFormat($productsIdRowAry,2);
		$Narrow_ary = $screenAry['Narrow_ary'];

		$relatedRow = Ly200::getProductsListV2($c['web_pack'][$this->PId]['Settings']['Products'], 4);
		$HtagsAry = HelpsVisualV2::getListHTags($categoryRow, $allCategoryRow);
		// 筛选展示位置
		$filtersPosition = $c['web_pack'][$this->PId]['Settings']['FiltersPosition'] ?: 'left';
		$filterItemsDisplayContent = $c['web_pack'][$this->PId]['Settings']['FilterItemsDisplayContent'] ?: 'expand';

		// 多规格价格展示
		$productsAry = HelpsProducts::getShowCombinationPrice($productsAry);

		if (Yii::$app->request->get("test")){
			var_dump($productsAry);die;
		}

		return compact(
			'c',
			'productsAry',
			'allCategoryRow',
			'lineCount',
			'pagination',
			'visualCount',
			'PageStyle',
			'maxPage',
			'Column',
			'CateId',
			'inquiryBatButton',
			'inquiryBatButtonText',
			'categoryRow',
			'isShowScreening',
			'Narrow_ary',
			'products_id',
			'relatedRow',
			'googleviewItemListEvent',
			'HtagsAry',
			'filtersPosition',
			'filterItemsDisplayContent',
		);
	}
}
?>


index.php
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
                                <!-- 主要修改 -->
								<div class="tag_button"><?= $v['Ext']['tagsName'];?></div>
                                <!-- 修改结束 -->
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




main.css
.ly_product_list_2 .list_wrapper .themes_prod .tag_button {position: absolute;top: 5px;left: 10px;background: #03a861;z-index: 10;font-size: 20px;color: #ffffff;padding: 0 20px;border-radius: 2px;}