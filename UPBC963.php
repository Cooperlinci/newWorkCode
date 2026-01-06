缺陷修改：

common/helps/HelpsPagination.php
<?php

namespace common\helps;

use yii\data\Pagination;
use yii\web\UrlManager;

class HelpsPagination
{
	const SUFFIX_ROUTE_ARY = [
		'downloads'
	];
	
	public static function getPagination(array $params, string $route)
	{
		// 设置分页链接的路由
		$params['route'] = $route;

		// 设置分页链接的URL美化
		if (in_array($route, self::SUFFIX_ROUTE_ARY)) {
			$params['urlManager'] = new UrlManager([
				'enablePrettyUrl' => true,
				'scriptUrl' => '',
				'suffix' => '/'
			]);
		} else {
			$params['urlManager'] = new UrlManager([
				'enablePrettyUrl' => true,
				'scriptUrl' => '',
			]);
		}
		
		return new Pagination($params);
	}

}



common/widgets/cusvis_mode/download_list/mode_1/Controller.php

$CateId = $pagesDataInit['CateId'];
$categoryRow = $pagesDataInit['categoryRow'];

$currentCategoryName = $categoryRow['Category'] ?? LangPack::lang('web.global.download');

$route = 'downloads'; // modify
$downloadQuery = Download::find()->where(['IsListShow' => 1]);