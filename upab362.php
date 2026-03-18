<style>
    .detail_desc .text strong iframe {aspect-ratio: 5/9;display: grid;width: 100%;height: auto;}
    .art_content strong iframe {aspect-ratio: 5/9;display: grid;width: 100%;height: auto;}
</style>

<?
class ly200 {
	public static function seo_meta($row=array(), $spare_row=array()){	//前台页面输出标题标签
		global $c;
		$lang=$c['lang'];
		$home_row=str::str_code(db::get_one('meta', "Type='home'"));
		$SeoTitle=$row['SeoTitle'.$lang]?$row['SeoTitle'.$lang]:$spare_row['SeoTitle'];
		$SeoKeywords=$row['SeoKeyword'.$lang]?$row['SeoKeyword'.$lang]:$spare_row['SeoKeyword'];
		$SeoDescription=$row['SeoDescription'.$lang]?$row['SeoDescription'.$lang]:$spare_row['SeoDescription'];
		if(!$SeoTitle && !$SeoKeywords && !$SeoDescription){
			$SeoTitle=$home_row['SeoTitle'.$lang]?$home_row['SeoTitle'.$lang]:$c['config']['global']['SiteName'];
			$SeoKeywords=$home_row['SeoKeyword'.$lang]?$home_row['SeoKeyword'.$lang]:$c['config']['global']['SiteName'];
			$SeoDescription=$home_row['SeoDescription'.$lang]?$home_row['SeoDescription'.$lang]:$c['config']['global']['SiteName'];
		}
		$copyCode=(int)$c['config']['global']['IsCopy']?'<script type="text/javascript">document.oncontextmenu=new Function("event.returnValue=false;");document.onselectstart=new Function("event.returnValue=false;");</script>':'';	//防复制
		$str='';
		if($_SERVER['HTTP_X_FROM']){  //临时域名(使用代理),禁止收录
			$str.='<meta name="robots" content="noindex,nofollow,noarchive" />';
		}
		$where='IsUsed=1 and IsMeta=1 and IsBody=0';
		$where.=(web::is_mobile_client(1)?' and CodeType in(0,2)':' and CodeType in(0,1)');

		/* $CookiesUsed = (int)db::get_value('policies', "Type = 'cookies'", 'IsUsed');
		if (ly200::isEU() && $CookiesUsed) echo  "<script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('consent', 'default', {'ad_storage': 'denied', 'ad_user_data': 'denied', 'ad_personalization': 'denied', 'analytics_storage': 'denied'});</script>";
		if (ly200::isEU() && $CookiesUsed && (int)$_COOKIE['is_agreement_status']) echo  "<script>gtag('consent', 'update', { 'ad_storage': 'granted', 'ad_user_data': 'granted', 'ad_personalization': 'granted', 'analytics_storage': 'granted' });</script>"; */

		// Google高级意见征求模式全局初始化代码
		$str .= ly200::GoogleConsentMode();

		if(!$c['google_hide']){
			$third_row=db::get_all('third', $where, '*', 'TId desc');	//自定义Meta代码
		}
		$url=web::get_domain().$_SERVER['REQUEST_URI'];
		// 新增
		$base_url = reset(explode('?', $url));
		if ($_GET['m']=='products' && $_GET['page']) {
			$cate_id = $_GET['CateId'] ?? 0;
			$base_url = str_replace(($cate_id ? '/' : '')."{$_GET['page']}.html", '', $base_url);
		}
		// 新增结束



		foreach((array)$third_row as $v) $str.=$v['Code'];
		if ($_GET['m']=='products'){
			global $category_row;
			global $Column;
			$Name=htmlspecialchars(htmlspecialchars_decode($Column));
			$BriefDescription=htmlspecialchars(htmlspecialchars_decode($category_row['Description'.$c['lang']]));
			$img=web::get_domain().$c['config']['global']['LogoPath'];
			$SiteName=htmlspecialchars(htmlspecialchars_decode($c['config']['global']['SiteName']));
			//<!-- Product Pins -->
			$str.="<meta property=\"og:title\" content=\"{$Name}\" />";
			$str.='<meta property="og:type" content="products_category" />';
			$str.="<meta property=\"og:url\" content=\"{$url}\" />";
			$str.="<meta property=\"og:image\" content=\"{$img}\" />";
			$str.='<meta property="og:description" content="'.($BriefDescription?$BriefDescription:$Name).'" />';
			$str.="<meta property=\"og:site_name\" content=\"{$SiteName}\" />";
			$img_info =  getimagesize($c['root_path'].$c['config']['global']['LogoPath']);
			$str.='<meta property="og:image:width" content="'.$img_info[0].'"/><meta property="og:image:height" content="'.$img_info[1].'"/>';
		}
		if ($_GET['m']=='goods'){//产品详细页分享插件引用的图片
			global $products_row;
			$Name=htmlspecialchars(htmlspecialchars_decode($products_row['Name'.$c['lang']]));
			$BriefDescription=htmlspecialchars(htmlspecialchars_decode($products_row['BriefDescription'.$c['lang']]));
			$img=web::get_domain().img::get_small_img($products_row['PicPath_0'], '500x500');
			$CurPrice=$products_row['Price_1'];
			$SiteName=htmlspecialchars(htmlspecialchars_decode($c['config']['global']['SiteName']));
			$sku=htmlspecialchars(htmlspecialchars_decode($products_row['Prefix'].$products_row['Number']));
			$priceValidUntil=date('Y-m-d', $c['time']+10*365*12*24*3600);
			// 品牌
			$Brand=$c['config']['global']['SiteName'];
			//offer
			$priceCurrency=$_SESSION['Currency']['Symbol']?$_SESSION['Currency']['Symbol']:'$';
			// 评论
			$reviewCount = db::get_row_count('products_review',"ProId='{$products_row['ProId']}'");
			$review_row=db::get_limit('products_review', "ProId='{$products_row['ProId']}'", '*', 'AccTime desc', 0, 10);
			$is_stockout=0;
			$show_currency = $_SESSION['Currency']['Currency']?$_SESSION['Currency']['Currency']:'USD';
			//<!-- Product Pins -->
			$str.="<meta property=\"og:title\" content=\"{$Name}\" />";
			$str.='<meta property="og:type" content="product" />';
			$str.="<meta property=\"og:url\" content=\"{$url}\" />";
			$str.="<meta property=\"og:image\" content=\"{$img}\" />";
			$str.='<meta property="og:description" content="'.($BriefDescription?htmlspecialchars($BriefDescription):$Name).'" />';
			$str.="<meta property=\"og:site_name\" content=\"{$SiteName}\" />";
			$str.="<meta property=\"product:price:amount\" content=\"{$CurPrice}\" />";
			$str.="<meta property=\"product:price:currency\" content=\"{$show_currency}\" />";
			$str.='<meta property="og:availability" content="'.($is_stockout ? 'backorder' : 'instock').'" />';
			$img_info =  getimagesize($c['root_path'].img::get_small_img($products_row['PicPath_0'], '500x500'));
			$str.='<meta property="og:image:width" content="'.$img_info[0].'"/><meta property="og:image:height" content="'.$img_info[1].'"/>';

			//<!-- Twitter Card -->
			$str.='<meta name="twitter:card" content="summary_large_image" />';
			$str.="<meta name=\"twitter:title\" content=\"{$Name}\" />";
			$str.='<meta name="twitter:description" content="'.($BriefDescription?htmlspecialchars($BriefDescription):$Name).'" />';

			//<!-- http://schema.org -->
			$str.="<script type=\"application/ld+json\">";
			    $str.="{";
			        $str.="\"@context\": \"http://schema.org/\",";
			        $str.="\"@type\": \"Product\",";
			        $str.="\"name\": \"".$Name."\",";
			        $sku && $str.="\"sku\": \"".$sku."\",";
			        $str.="\"url\": \"{$url}\",";
			        $str.="\"image\": [";
			          $str.="\"{$img}\"";
			        $str.="],";
			        $str.="\"description\": \"".str::jsformat($BriefDescription) ."\",";
			        //$str.="\"brand\": \"{$Brand}\",";
			        $str.="\"brand\": {";
			        	$str.="\"@type\" : \"Brand\",";
			        	$str.="\"name\" : \"{$Brand}\"";
			        $str.="},";
			        $str.="\"offers\": {";
			            $str.="\"@type\" : \"Offer\",";
			            $str.="\"availability\" : \"http://schema.org/".($is_stockout ? 'OutOfStock' : 'InStock')."\",";
			            $str.="\"price\" : \"{$CurPrice}\",";
			            $str.="\"priceCurrency\" : \"{$priceCurrency}\",";
			            $str.="\"url\" : \"{$url}\",";
			            $str.="\"priceValidUntil\" : \"{$priceValidUntil}\"";
			        $str.="},";
					$reviewCount || $reviewCount = 1;
				    if(empty($review_row)){
				    	$review_row = array(
				    		0 => array(
				    			'Name'		=>	$Name,
				    			'Content'	=>	$Name,
				    			'AccTime'	=>	$c['time'],
				    		),
				    	);
					}
					$str.="\"aggregateRating\": {";
						$str.="\"@type\" : \"AggregateRating\",";
						$str.="\"ratingValue\" : \"5\",";
						$str.="\"reviewCount\" : \"{$reviewCount}\"";
					$str.="},";
					$str.="\"review\": [";
						foreach((array)$review_row as $k=>$v){
							$name=str::jsformat($v['Name']) ? str::jsformat($v['Name']) : 'Customer';
							$content=str::jsformat($v['Content']) ? str::jsformat($v['Content']) : str::jsformat($Name);
							$str.=($k==0?'':',')."{";
								$str.="\"@type\" : \"Review\",";
								//$str.="\"author\" : \"{$name}\",";
								$str.="\"author\": {";
						        	$str.="\"@type\" : \"Person\",";
						        	$str.="\"name\" : \"{$name}\"";
								$str.="},";
								$str.="\"datePublished\" : \"".date('Y-m-d', $v['AccTime'])."\",";
								$str.="\"description\" : \"{$content}\",";
								$str.="\"name\" : \"{$name}\",";
								$str.="\"reviewRating\": {";
									$str.="\"@type\" : \"Rating\",";
									$str.="\"bestRating\" : \"5\",";
									$str.="\"ratingValue\" : \"5\",";
									$str.="\"worstRating\" : \"1\"";
								$str.="}";
							$str.="}";
						}
					$str.="],";
					$str.="\"mpn\" : \"{$sku}\"";
				$str.="}";
			$str.="</script>";
		}elseif($_GET['m']=='info-detail'){
			global $info_row;
			$Name=htmlspecialchars(htmlspecialchars_decode($info_row['Title'.$c['lang']]));
			$BriefDescription=htmlspecialchars(htmlspecialchars_decode($info_row['BriefDescription'.$c['lang']]));
			$img=web::get_domain().(@is_file($c['root_path'].$info_row['PicPath'])?$info_row['PicPath']:$c['config']['global']['LogoPath']);
			$str.="<meta property=\"og:title\" content=\"{$Name}\" />";
			$str.='<meta property="og:type" content="article" />';
			$str.="<meta property=\"og:url\" content=\"{$url}\" />";
			$str.="<meta property=\"og:image\" content=\"{$img}\" />";
			$str.='<meta property="og:description" content="'.($BriefDescription?htmlspecialchars($BriefDescription):$Name).'" />';
		}elseif($_GET['m']=='article'){
			global $article_row;
			$Name=htmlspecialchars(htmlspecialchars_decode($article_row['Title'.$c['lang']]));
			$img=web::get_domain().$c['config']['global']['LogoPath'];
			$str.="<meta property=\"og:title\" content=\"{$Name}\" />";
			$str.="<meta property=\"og:url\" content=\"{$url}\" />";
			$str.="<meta property=\"og:image\" content=\"{$img}\" />";
		}

		// 新增 hreflang
		$canonicalUrl = defined('CANONICAL_URL') ? web::get_domain() . constant('CANONICAL_URL') : $base_url;
		$langMap = ['cn'=>'zh-Hans', 'zh-tw'=>'zh-Hant', 'jp'=>'ja'];
		$langList = [$lang];
		$alternateTags = '';
		$defaultTag = '';
		foreach ($langList as $v) {
			$cleanV = ltrim($v, '_');
			$langCode = $langMap[$cleanV] ?? $cleanV;
			$domainPrefix = '';
			$altUrl = str_replace('://', "://{$domainPrefix}", $canonicalUrl);
			$alternateTags .= "\r\n<link rel=\"alternate\" hreflang=\"{$langCode}\" href=\"{$altUrl}\" />";
			$defaultTag = "\r\n<link rel=\"alternate\" hreflang=\"x-default\" href=\"{$altUrl}\" />";
		}
		$finalMeta = "{$str}{$defaultTag}{$alternateTags}\r\n";
		$finalMeta .= "<link rel=\"canonical\" href=\"{$canonicalUrl}\" />\r\n";
		$finalMeta .= "<link rel='shortcut icon' href='{$c['config']['global']['IcoPath']}' />\r\n";
		$finalMeta .= "<meta name=\"keywords\" content=\"{$SeoKeywords}\" />\r\n";
		$finalMeta .= "<meta name=\"description\" content=\"{$SeoDescription}\" />\r\n";
		$finalMeta .= "<title>{$SeoTitle}</title>\r\n{$copyCode}";

		return $finalMeta;
		// 新增结束


		// return "<link rel='shortcut icon' href='{$c['config']['global']['IcoPath']}' />\r\n{$str}<link rel=\"canonical\" href=\"{$url}\" />\r\n<meta name=\"keywords\" content=\"$SeoKeywords\" />\r\n<meta name=\"description\" content=\"$SeoDescription\" />\r\n<title>$SeoTitle</title>\r\n".$copyCode;
	}
}
?>


<div class="input"><?=manage::form_edit($products_row, 'textarea', 'BriefDescription','',255);?></div>

<div class="input"><?=manage::form_edit($products_description_row, 'editor', 'Description');?></div>

		<div class="rows clean translation">   
			<label>
				{/set.config.contact.address/}
				<div class="tab_box"><?=manage::html_tab_button();?></div>
			</label>
			<div class="input">
				<?=manage::form_edit($config_contact, 'editor', 'address');?>
			</div>
		</div>