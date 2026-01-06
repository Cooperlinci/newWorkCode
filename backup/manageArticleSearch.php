common/helps/HelpsHtml.php->public static function getDynamicConfig(string $module)
//modify：
        } else if (in_array($module, ['article'])) {
            $className = 'common\models\article\Article';
            $primaryKey = 'AId';
            $titleField = 'Title_en';
            $AccTime = 'AccTime';
            $isPopular = false;
            $moduleType = 'article';
        }

manage/controllers/view/VisualV2Controller.php->public function actionEditToolBar()
            //关联选择弹窗 页面  ($fiexPagesAry删除'article')
            $fiexPagesAry = ['list', 'article', 'news', 'cases', 'blog'];   //原版
            $fiexPagesAry = ['list', 'news', 'cases', 'blog'];  //modify

manage/web/ueeshop/js/view-v2.js
                if (_curPage == 'goods' || _curPage == 'news-detail' || _curPage == 'cases-detail' || _curPage == 'blog-detail') { //详细   //原版
                if (_curPage == 'goods' || _curPage == 'news-detail' || _curPage == 'cases-detail' || _curPage == 'blog-detail' || _curPage == 'article') { //详细、单页    //modify
                    let _curType = 'products';
                    if (_curPage == 'news-detail') _curType = 'news';
                    if (_curPage == 'cases-detail') _curType = 'cases';
                    if (_curPage == 'blog-detail') _curType = 'blog';
                    if (_curPage == 'article') _curType = 'article';    //modify
                    relatedProducts(draftsId, pagesId, {}, _curType, _curPage);
                } else if (_curPage == 'list' || _curPage == 'article' || _curPage == 'news' || _curPage == 'cases' || _curPage == 'blog') { //产品列表、单页、新闻列表、案例列表   //原版
                } else if (_curPage == 'list' || _curPage == 'news' || _curPage == 'cases' || _curPage == 'blog') { //产品列表、新闻列表、案例列表 //modify

                if (_curPage == 'goods' || _curPage == 'news-detail' || _curPage == 'cases-detail' || _curPage == 'blog-detail') { //产品详细 //原版
                if (_curPage == 'goods' || _curPage == 'news-detail' || _curPage == 'cases-detail' || _curPage == 'blog-detail' || _curPage == 'article') { //产品详细、单页    //modify
                    $(this).parents('.box').find('.proinfo').each(function(index){
                    let proid = $(this).data('id');
                        let img = $(this).data('img');
                    if (_curPage == 'news-detail') _curType = 'news';
                    if (_curPage == 'cases-detail') _curType = 'cases';
                    if (_curPage == 'blog-detail') _curType = 'blog';
                    if (_curPage == 'article') _curType = 'article';    //modify
                    relatedProducts(draftsId, pagesId, proInfo, _curType, _curPage);
                } else if (_curPage == 'list' || _curPage == 'article' || _curPage == 'news' || _curPage == 'cases' || _curPage == 'blog') { //产品列表 、单页、新闻列表、案例列表  //原版
                } else if (_curPage == 'list' || _curPage == 'news' || _curPage == 'cases' || _curPage == 'blog') { //产品列表、新闻列表、案例列表  //modify