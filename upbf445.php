主要修改是修改header模块，但是config的添加的内容，需要到manage/config/lang/zh-CN/view.php 那个改内容
还有手机端头部的修改
// index.php
<?php
use common\helps\HelpsHtml;
use common\helps\HelpsVisualV2;
use common\helps\Ly200;
use yii\helpers\Html;

?>
<div id="header" class="ly_header_24 header <?=$headerClass;?>" data-visual-id="<?=$PId;?>">
    <?php
		echo HelpsVisualV2::getButtonCss('Custom', [
			'class' => '.ly_header_24[data-visual-id="' . $PId . '"] .tool .tool_inquiry_btn a, .nav_center_fixed .box_center .tool_inquiry_btn',
			'padding' => '12px 18px',
		], $inquiryBtnStyle);
	?>
    <style>
        <?=$rootStyle;?>
		.ly_header_24[data-visual-id="<?=$PId;?>"] .logo{ width: <?=$c['web_pack'][$PId]['Blocks']['Logo']['LogoWidth'];?>; }
        .ly_header_24[data-visual-id="<?=$PId;?>"] .themes_global_header{ background-image: url(<?=$c['web_pack'][$PId]['Settings']['Pic']?>); }
		.ly_header_24[data-visual-id="<?=$PId;?>"] .nav li>a { font-size: <?=$c['web_pack'][$PId]['Blocks']['Menu']['NavFontSizePc'];?>;padding:0 <?=(int)$c['web_pack'][$PId]['Blocks']['Menu']['ColumnSpacing'] / 2;?>px; }
        .ly_header_24[data-visual-id="<?=$PId;?>"] .nav li a.nav_sec_a{ font-size: <?=$c['web_pack'][$PId]['Blocks']['Menu']['SecondLevelNavFontSizePc'];?>; }
		.ly_header_24[data-visual-id="<?=$PId;?>"] .nav li a.nav_third_a{ font-size: <?=$c['web_pack'][$PId]['Blocks']['Menu']['ThirdLevelNavFontSizePc'];?>; }
		.ly_header_24[data-visual-id="<?=$PId;?>"] .nav li a.nav_fourth_a{ font-size: <?=$c['web_pack'][$PId]['Blocks']['Menu']['FourthLevelNavFontSizePc'];?>; }
        .ly_header_24[data-visual-id="<?=$PId;?>"] .nav .default_nav_style{justify-content: <?=$c['web_pack'][$PId]['Blocks']['Menu']['NavTextAlign'];?>;}
		.ly_header_24[data-visual-id="<?=$PId;?>"] .tool_inquiry .list_numner{background-color:<?=$c['web_pack'][$PId]['Settings']['InquiryListQuantityBgColor']?>; color:<?=$c['web_pack'][$PId]['Settings']['InquiryListQuantityColor']?>}
		.ly_header_24[data-visual-id="<?=$PId;?>"] .tool_language .default_language_currency_style dt .current_language_abbreviation{ font-size: <?=$c['web_pack'][$PId]['Blocks']['Language']['LanguageNameFontSize'];?>; color: <?=$c['web_pack'][$PId]['Blocks']['Language']['LanguageNameColor'];?>; }
		.ly_header_24[data-visual-id="<?=$PId;?>"] .tool_language .default_language_currency_style dt .iconfont{ color: <?=$c['web_pack'][$PId]['Blocks']['Language']['LanguageIconColor'];?>; }

        @media screen and (max-width: 1000px) {
			.ly_header_24[data-visual-id="<?=$PId;?>"] .logo{ width: <?=$c['web_pack'][$PId]['Blocks']['Logo']['MobileLogoWidth'];?>; }
		}
	</style>
    <div class="headerFixed">
        <?=$this->render('@frontend/views/common/operation_activities');?>
        <div class="themes_global_header">
            <?=HelpsHtml::getHeaderBoardHtml($PId)?>
            <div class="wide">
                <div class="logo">
                    <div class="compute_item_img" style="<?=$logoComputeWidth;?>">
                        <div class="compute_process_img" style="<?=$logoComputeRatio;?>">
                            <?=$logoPath;?>
                        </div>
                    </div>
                </div>
                <div class="company-info">
                    <h2 class="company-name"><?=$c['web_pack'][$PId]['Settings']['Title'] ?></h2>
                    <div class="company-basic">
                        <span class="years"><?=$c['web_pack'][$PId]['Settings']['SubTitle'] ?></span>
                    </div>
                    <p class="main-categories"><?=$c['web_pack'][$PId]['Settings']['Content'] ?></p>
                    <div class="company-tags">
                        <?php
                        $tagContents = [
                            trim($c['web_pack'][$PId]['Settings']['Content1'] ?? ''),
                            trim($c['web_pack'][$PId]['Settings']['Content2'] ?? ''),
                            trim($c['web_pack'][$PId]['Settings']['Content3'] ?? ''),
                            trim($c['web_pack'][$PId]['Settings']['Content4'] ?? '')
                        ];
                        $pic1 = $c['web_pack'][$PId]['Settings']['Pic1'] ?? '';
                        foreach ($tagContents as $content) {
                            $tagClass = 'tag-item';
                            if ($content !== '') {
                                $tagClass .= ' has-content';
                            }
                            echo "<span class=\"{$tagClass}\"><img src=\"{$pic1}\">{$content}</span>";
                        }
                        ?>
                    </div>
                </div>

                <div class="tool">
                    <div class="tool_search">
                        <?php
                        echo $this->render('@frontend/views/common/search', [
                            'PId' => $PId,
                            'searchType' => 1,
                            'RecentlySearch' => $c['web_pack'][$PId]['Settings']['RecentlySearch'],
                            'HotSearch' => $c['web_pack'][$PId]['Settings']['HotSearch'],
                            'SearchEffect' => $c['web_pack'][$PId]['Settings']['SearchEffect']
                        ]);
                        ?>
                    </div>
                    <div class="tool_language">
                        <?php
                        echo $this->render('@frontend/views/common/language', [
                            'languageRow' => $languageRow,
                            'languageType' => 'icon',
							'languageIcon' => 'icon-language1',
                            'Data' =>  $c['web_pack'][$PId]['Blocks']['Language'],
                        ]);
                        ?>
                    </div>
                    <?php 
                        $UserEntrance = $c['web_pack'][$PId]['Settings']['UserEntrance'];
                        if ($UserEntrance && in_array('memberUser', (array)Yii::$app->params['rules'])) { ?>
                        <div class="tool_user">
                            <?php
                            echo $this->render('@frontend/views/common/sign_in', [
                                'PId' => $PId,
                                'signInIcon' => 'icon-member2'
                            ]);
                            ?>
                        </div>
                    <?php } ?>
                    <div class="tool_inquiry">
                        <?php
                        echo $this->render('@frontend/views/common/inquiry_icon', [
                            'inquiryIcon' => 'icon-inquiry1',
                            'inquiryListNumber' => $inquirylistNumber
                        ]);
                        ?>
                    </div>
                    <div class="tool_inquiry_btn trans3"><a <?=$FormFields ? 'data-fields="' . $FormFields . '"' : '';?> href="<?=$inquiryInfo['Link'];?>" class="<?=$inquiryInfo['Class'];?> trans3 themes_box_button" <?=$labelAttrInfo?> data-id="<?=$inquiryInfo['Id'];?>" title="<?=Html::encode($inquiryInfo['Text']);?>"><?=$inquiryInfo['Text']?></a></div>
                    <div class="tool_menu global_menu"><i class="iconfont icon-mb_menu2"></i></div>
                </div>
            </div>
            <div class="nav">
                <?php
                    echo $this->render('@frontend/views/common/nav', [
                        'navData' => $navData,
                        'navConfigData' => $navConfigData,
                        'cateidCateAry' => $cateidCateAry,
                        'defaultNavSwitch' => $defaultNavSwitch,
                        'menuSetting' => $c['web_pack'][$PId]['Blocks']['Menu']
                    ]);
                ?>
            </div>
        </div>
        <?=Ly200::setMobileHeader($PId, '', $c['web_pack'][$PId]);?>
    </div>
    <div class="header_content_height"></div>
</div>

<!-- <script>
document.addEventListener('DOMContentLoaded', function() {
    function isPC() {
        return window.innerWidth > 1000;
    }
    if (isPC()) {
        const nav = document.querySelector('.ly_header_24[data-visual-id="<?=$PId;?>"] .themes_global_header .nav');
        const headerContentHeight = document.querySelector('.header_content_height');
        const scrollThreshold = 150;
        function handleScroll() {
            if (!isPC()) return;
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > scrollThreshold) {
                nav.classList.add('fixed');
                headerContentHeight.classList.add('fixed-nav');
            } else {
                nav.classList.remove('fixed');
                headerContentHeight.classList.remove('fixed-nav');
            }
        }
        window.addEventListener('scroll', handleScroll);
        window.addEventListener('resize', function() {
            if (!isPC()) {
                nav.classList.remove('fixed');
                headerContentHeight.classList.remove('fixed-nav');
                window.removeEventListener('scroll', handleScroll);
            }
        });
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('ul.default_nav_style li a');
        navLinks.forEach(link => {
            link.parentElement.classList.remove('current');
        });
        if (currentPath.includes('collections')) {
            navLinks.forEach(link => {
                const tempLink = document.createElement('a');
                tempLink.href = link.getAttribute('href') || '';
                const linkPath = tempLink.pathname;
                if (linkPath.includes('products')) {
                    link.parentElement.classList.add('current');
                }
            });
        } else if (currentPath.includes('products')) {
            navLinks.forEach(link => {
                const tempLink = document.createElement('a');
                tempLink.href = link.getAttribute('href') || '';
                const linkPath = tempLink.pathname;
                if (linkPath.includes('products')) {
                    link.parentElement.classList.add('current');
                }
            });
        } else if (currentPath.includes('cases-detail')) {
            navLinks.forEach(link => {
                const tempLink = document.createElement('a');
                tempLink.href = link.getAttribute('href') || '';
                const linkPath = tempLink.pathname;
                if (linkPath.includes('cases')) {
                    link.parentElement.classList.add('current');
                }
            });
        } else {
            navLinks.forEach(link => {
                const tempLink = document.createElement('a');
                tempLink.href = link.getAttribute('href') || '';
                const linkPath = tempLink.pathname;
                if (linkPath.replace(/\/$/, '') === currentPath.replace(/\/$/, '')) {
                    link.parentElement.classList.add('current');
                }
            });
        }
    } 
    const tagItems = document.querySelectorAll('.ly_header_24 .tag-item');
    tagItems.forEach(item => {
        const pureText = item.textContent.replace(/[\s\u00A0\u3000\n\r\t]/g, '').trim();
        if (pureText) {
            item.style.display = 'block';
            const img = item.querySelector('img');
            if (img) img.style.display = 'inline-block';
        } else {
            item.style.display = 'none';
        }
    });
});
</script> -->
<script src="<?=Yii::$app->params['root_path'];?>common/widgets/cusvis_mode/header/mode_24/main.js"></script>

main.js

<script>document.addEventListener('DOMContentLoaded', function() {
    function isPC() {
        return window.innerWidth > 1000;
    }
    if (isPC()) {
        const headerElement = document.querySelector('.ly_header_24');
        if (!headerElement) return;
        
        const PId = headerElement.getAttribute('data-visual-id');
        const nav = document.querySelector('.ly_header_24[data-visual-id="' + PId + '"] .themes_global_header .nav');
        const headerContentHeight = document.querySelector('.header_content_height');
        const scrollThreshold = 150;
        
        function handleScroll() {
            if (!isPC()) return;
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > scrollThreshold) {
                nav.classList.add('fixed');
                headerContentHeight.classList.add('fixed-nav');
            } else {
                nav.classList.remove('fixed');
                headerContentHeight.classList.remove('fixed-nav');
            }
        }
        
        window.addEventListener('scroll', handleScroll);
        window.addEventListener('resize', function() {
            if (!isPC()) {
                nav.classList.remove('fixed');
                headerContentHeight.classList.remove('fixed-nav');
                window.removeEventListener('scroll', handleScroll);
            }
        });
        
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('ul.default_nav_style li a');
        navLinks.forEach(link => {
            link.parentElement.classList.remove('current');
        });
        
        if (currentPath.includes('collections')) {
            navLinks.forEach(link => {
                const tempLink = document.createElement('a');
                tempLink.href = link.getAttribute('href') || '';
                const linkPath = tempLink.pathname;
                if (linkPath.includes('products')) {
                    link.parentElement.classList.add('current');
                }
            });
        } else if (currentPath.includes('products')) {
            navLinks.forEach(link => {
                const tempLink = document.createElement('a');
                tempLink.href = link.getAttribute('href') || '';
                const linkPath = tempLink.pathname;
                if (linkPath.includes('products')) {
                    link.parentElement.classList.add('current');
                }
            });
        } else if (currentPath.includes('cases-detail')) {
            navLinks.forEach(link => {
                const tempLink = document.createElement('a');
                tempLink.href = link.getAttribute('href') || '';
                const linkPath = tempLink.pathname;
                if (linkPath.includes('cases')) {
                    link.parentElement.classList.add('current');
                }
            });
        } else {
            navLinks.forEach(link => {
                const tempLink = document.createElement('a');
                tempLink.href = link.getAttribute('href') || '';
                const linkPath = tempLink.pathname;
                if (linkPath.replace(/\/$/, '') === currentPath.replace(/\/$/, '')) {
                    link.parentElement.classList.add('current');
                }
            });
        }
    }
    
    const tagItems = document.querySelectorAll('.ly_header_24 .tag-item');
    tagItems.forEach(item => {
        const pureText = item.textContent.replace(/[\s\u00A0\u3000\n\r\t]/g, '').trim();
        if (pureText) {
            item.style.display = 'block';
            const img = item.querySelector('img');
            if (img) img.style.display = 'inline-block';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>

main.css
<style>
    .ly_header_24 .wide {align-items: flex-start;}
.ly_header_24 .company-info {flex: 1;padding: 10px 20px;margin: 0 15px;z-index: 100;}
.ly_header_24 .company-name {font-size: 18px;font-weight: 600;color: #333;margin: 0 0 5px 0;}
.ly_header_24 .company-basic {font-size: 14px;color: #666;margin: 0 0 5px 0;}
.ly_header_24 .verified-tag {color: #0088cc;font-weight: 500;margin-right: 5px;}
.ly_header_24 .main-categories {font-size: 13px;color: #666;margin: 0 0 8px 0;line-height: 1.4;}
.ly_header_24 .company-tags {display: flex;flex-wrap: wrap;gap: 8px;}
.ly_header_24 .tag-item {font-size: 12px;padding: 3px 8px;background-color: #f0f8ff;border: 1px solid #e0e8f0;border-radius: 4px;color: #333;}
.ly_header_24 .tag-item { display: none; }
.ly_header_24 .tag-item.has-content { display: block; }
.ly_header_24 .tag-item img { display: inline-block; }
.ly_header_24 .themes_global_header{ background-position: center; }

@media screen and (min-width: 1001px) and (max-width: 1200px) {
    .ly_header_24 .company-name {font-size: 16px;}
    .ly_header_24 .company-basic,
    .ly_header_24 .main-categories {font-size: 12px;}
    .ly_header_24 .tag-item {font-size: 11px;padding: 2px 6px;}
}

@keyframes move {
    0% { transform: translateY(-100%);}
    100% { transform: translateY(0%);}
}
@keyframes movenormal {
    0% { transform: translateY(-100%);}
    100% { transform: translateY(0%);}
}


.ly_header_24 .wide{display: flex;align-items: center;justify-content: space-between;max-width: 1200px !important;}/* Cooper */
.ly_header_24 .logo{padding: 10px 0;}
/* .ly_header_24 .nav{padding: 20px 0;flex: 1;} */
.ly_header_24 .nav li{padding: 10px 0;}
.ly_header_24 .nav ul li a{color: var(--ThemesNavTextColor);font-family: var(--ThemesNavFont);}
.ly_header_24 .nav ul li a:hover,
.ly_header_24 .nav ul li.hover a{text-decoration: none;color: var(--ThemesNavTextHoverColor);}
.ly_header_24 .nav{font-family: var(--ThemesNavFont);}
.ly_header_24 .nav .default_nav_style{max-width: 1200px;margin: 0 auto;} /* Cooper */
.ly_header_24 .tool{display: flex;align-items: center;z-index: 100;}
.ly_header_24 .tool a:hover{text-decoration: none;}
.ly_header_24 .tool .tool_search{padding: 0 20px;}
.ly_header_24 .tool .tool_language{ height: 21px; }
.ly_header_24 .tool .tool_language *{ line-height: 21px; }
.ly_header_24 .tool .tool_search .icon-search1{color: var(--ThemesHeaderIconColor);font-size: 20px;}
.ly_header_24 .tool .tool_language .default_language_currency_style{line-height: 25px;}
.ly_header_24 .tool .tool_language .default_language_currency_style dt{color: var(--ThemesHeaderTextColor);font-size: 14px;padding:0 20px}
.ly_header_24 .tool .tool_language .default_language_currency_style i{color: var(--ThemesHeaderIconColor);}
.ly_header_24 .tool .tool_user .tool_member_entrance{display: block; padding: 0 20px;}
.ly_header_24 .tool .tool_user .icon-member2{color: var(--ThemesHeaderIconColor);font-size: 20px;}
.ly_header_24 .tool .tool_inquiry .tool_inquiry_icon{display: block; padding: 0 5px; font-size: 20px; }
.ly_header_24 .tool_inquiry .icon-inquiry1{color: var(--ThemesHeaderIconColor);font-size: 20px;}
.ly_header_24 .tool .tool_inquiry_btn{padding: 12px 18px;margin-left: 30px; border-radius: 25px;}
.ly_header_24 .tool_menu{display: none;color: var(--ThemesHeaderIconColor);font-size: 20px;margin: 0 10px;}
.ly_header_24 .tool_inquiry{position: relative;display: flex;align-items: flex-start;}
.ly_header_24 .tool_inquiry .list_numner{display: flex;  padding:0 10px;line-height: 18px;border-radius: 18px; box-sizing:border-box;align-items: center;justify-content: center;font-size: 12px;}
@media screen and (max-width: 1000px){
    .ly_header_24 .nav{display: none;}
    .ly_header_24 .tool{width: auto;}
    .ly_header_24 .tool_language{display: none;}
    .ly_header_24 .tool .tool_user{display: none;}
    .ly_header_24 .tool .tool_inquiry{padding: 0;margin: 0px;margin-right: 5px;}
    .ly_header_24 .tool .tool_inquiry .tool_inquiry_icon{padding: 0;margin-right: 5px}
    html[lang=ar] .ly_header_24 .tool .tool_inquiry .tool_inquiry_icon{margin: 0 0 0 5px}
    .ly_header_24 .tool .tool_inquiry .icon-inquiry1{font-size: 26px;}
    .ly_header_24 .tool .tool_inquiry_btn{display: none;}
    .ly_header_24 .tool_menu{display: block;margin: 0;}
    .ly_header_24 .tool .tool_search{padding: 0;margin: 0 20px;}
    .ly_header_24 .tool .tool_search .icon-search1{font-size: 26px;}
    .ly_header_24 .tool .tool_menu .icon-mb_menu2{font-size: 26px;}
}
@media screen and (max-width: 1000px) {
	.ly_header_24.header_fixed_top .headerFixed{position:fixed!important}
    .ly_header_24 .headerFixed{position:unset!important}
    .ly_header_24 .header_content_height{display:none!important}
    .ly_header_24.header_fixed_top  .header_content_height{display:block!important}
}

@media screen and (min-width: 1001px) {
    .ly_header_24 .themes_global_header .nav {position: relative;width: 100%;transition: all 0.3s ease;z-index: 99;background: rgb(51, 51, 51);}
    .ly_header_24 .themes_global_header .nav.fixed {position: fixed;top: 0;left: 0;right: 0;z-index: 100;}
    .header_content_height.fixed-nav {padding-top: 60px;}
}

.ly_header_24 .nav li.default_nav_themes {transition: background-color 0.2s ease;}
.ly_header_24 .nav li.default_nav_themes:hover {background-color: rgb(31, 31, 31);}
.ly_header_24 .nav li.default_nav_themes.current {background-color: rgb(31, 31, 31);}
.ly_header_24 .shop-sign-back-img {width: 100%;height: 100%;position: absolute;-o-object-fit: cover;object-fit: cover;}
.ly_header_24 .tag-item>img {width: 13px;height: 12px;margin-right: 4px;}
</style>

config.json
{
    "Blocks": {
        "Board": {
            "BoardSwitch": {
                "type": "switch",
                "linkage": {
                    "1": ["Contact", "BoardSocial", "Content"]
                },
                "value": false
            },
            "Contact": {
                "type": "panel",
                "expand": {
                    "editlink": "/manage/set/basis#company_info",
                    "hint": "tips"
                },
                "value": 1
            },
            "BoardSocial": {
                "type": "switch",
                "expand": {
                    "hint": "goset"
                },
                "value": true
            },
			"Content": {
				"type": "richtext",
				"value": ""
			},
			"ContentFontSizePc": {
				"type": "progress",
				"options": ["12", "30"],
				"suffix": "px",
				"value": "14px"
			},
			"ContentFontSizeMobile": {
				"type": "progress",
				"options": ["12", "30"],
				"suffix": "px",
				"value": "14px"
			},
            "BoardText": {
                "type": "color",
                "value": "#ffffff"
            },
			"ContentColor": {
				"type": "color",
				"value": "#ffffff"
			},
            "BoardContactIcon": {
                "type": "color",
                "value": "#ffffff"
            },
            "BoardShareIcon": {
                "type": "color",
                "value": "#ffffff"
            },
            "BoardBg": {
                "type": "color",
                "value": "#54b9fd"
            },
            "BoardContactShareLayoutPc": {
                "type": "select",
                "options": [
                    "onects",
                    "onestc",
                    "onecst",
                    "onesct",
                    "onetcs",
                    "onetsc"
                ],
                "value": "onestc"
            },
            "BoardContactShareLayoutMobile": {
                "type": "select",
                "options": [
                    "twotb",
                    "towbt",
                    "onelr",
                    "onerl"
                ],
                "value": "towbt"
            }
        },
        "Logo": {
            "Logo": {
                "type": "image",
                "expand": {
                    "width": "201",
                    "height": "45"
                },
                "value": "{CDN_URL_MODE}header/mode_24/index00.png"
            },
            "LogoWidth": {
                "type": "progress",
				"options": ["100", "400"],
                "suffix": "px",
                "value": "201px"
            },
            "MobileLogoWidth": {
                "type": "progress",
				"options": ["60", "200"],
                "suffix": "px",
                "value": "115px"
            },
            "HeightPc": {
                "type": "select",
                "options": ["adapt"],
                "value": "adapt"
            },
            "LogoAlt": {
                "type": "input",
				"expand": {
					"outSyncStyle": true
				},
                "value": ""
            }
        },
        "Menu": {
            "Menu": {
                "type": "panel",
                "expand": {
                    "editlink": "/manage/view/nav",
                    "hint": "tips",
					"fullySync": true
                },
                "value": 1
            },
            "ThemesNavFont": {
                "type": "font",
                "value": "OpenSans-Bold"
            },
            "ThemesNavTextColor": {
                "type": "color",
                "value": "#222222"
            },
            "ThemesNavTextHoverColor": {
                "type": "color",
                "value": "#54b9fd"
            },
            "ThemesNavLevel2TextColor": {
                "type": "color",
                "value": "#000000"
            },
            "ThemesNavLevel2TextHoverColor": {
                "type": "color",
                "value": "#000000"
            },
            "ThemesNavLevel3TextColor": {
                "type": "color",
                "value": "#000000"
            },
            "ThemesNavLevel3TextHoverColor": {
                "type": "color",
                "value": "#000000"
            },
            "ThemesNavLevel4TextColor": {
                "type": "color",
                "value": "#000000"
            },
            "ThemesNavLevel4TextHoverColor": {
                "type": "color",
                "value": "#000000"
            },
            "NavTextAlign": {
                "type": "textalign",
              "options": ["left", "center", "right"],
                "value": "left"
            },
            "NavFontSizePc": {
                "type": "progress",
              "options": ["12", "20"],
                "suffix": "px",
                "value": "16px"
            },
            "SecondLevelNavFontSizePc": {
                "type": "progress",
				"options": ["12", "20"],
				"suffix": "px",
				"value": "14px"
            },
            "ThirdLevelNavFontSizePc": {
                "type": "progress",
				"options": ["12", "20"],
				"suffix": "px",
				"value": "14px"
            },
            "FourthLevelNavFontSizePc": {
                "type": "progress",
				"options": ["12", "20"],
				"suffix": "px",
				"value": "14px"
            },
            "ColumnSpacing": {
                "type": "progress",
              "options": ["0", "100"],
                "suffix": "px",
                "value": "40px"
            },
            "NavAndThemesNavSpacing": {
                "type": "progress",
              "options": ["0", "100"],
                "suffix": "px",
                "value": "10px"
            }
        },
        "Language": {
            "LanguageIcon": {
                "type": "select",
                "options": ["default", "flag", "hidden"],
                "expand": {
                    "optionshint": "tips",
                    "checkoptions": "flag"
                },
                "value": "default"
            },
            "LanguageName": {
                "type": "select",
                "options": ["short", "full", "hidden"],
                "value": "hidden"
            },
            "LanguageEffect": {
                "type": "effect",
                "expand": {
                    "options": [10, 11],
					"fullySync": true
                },
                "value": "10"
            },
            "WebLanguage": {
                "type": "panel",
                "expand": {
                    "editlink": "/manage/set/language",
                    "hint": "tips",
                    "deletebutton": false
                },
                "value": 1
            },
            "LanguageIconColor": {
                "type": "color",
                "value": "#000000"
            },
            "LanguageNameColor": {
                "type": "color",
                "value": "#000000"
            },
            "LanguageNameFontSize": {
                "type": "progress",
				"options": ["12", "20"],
                "suffix": "px",
                "value": "16px"
            }
        },
        "Inquiry": {
            "ProductsInquiryButtonText": {
                "type": "input",
				"expand": {
					"outSyncStyle": true
				},
                "value": "Get A Quote"
            },
            "ProductsInquiryTriggerEffect": {
                "type": "select",
				"options": ["url", "popup"],
                "linkage": {
					"url": ["ProductsInquiryLink", "LinkOpenType"],
					"popup": ["ProductsInquiryPopup", "FormFields"]
                },
                "value": "popup"
            },
            "ProductsInquiryLink": {
                "type": "link",
                "value": ""
            },
            "LinkOpenType": {
                "type": "select",
				"options": ["current", "target"],
                "value": "current"
            },
            "ProductsInquiryPopup": {
                "type": "select",
                "expand": {
                    "associate": "feedback"
                },
                "value": ""
            },
            "FormFields": {
                "type": "panel",
                "expand": {
                    "hint": "tips",
                    "deletebutton": false,
                    "IsPop": true,
					"fullySync": true
                },
                "value": 1
            },
            "ButtonStyleCustom": {
                "type": "select",
				"options": ["style1", "style2", "custom"],
                "linkage": {
					"custom": ["ButtonFontCustom", "ButtonTextColorCustom", "ButtonBgColorCustom", "ButtonBorderColorCustom", "ButtonHoverTextColorCustom", "ButtonBgHoverColorCustom", "ButtonBorderHoverColorCustom", "ButtonTextSizePcCustom", "ButtonWidthPcCustom", "ButtonHeightPcCustom", "ButtonRadiusSizePcCustom", "ButtonTextSizeMobileCustom", "ButtonWidthMobileCustom", "ButtonHeightMobileCustom", "ButtonRadiusSizeMobileCustom"]
                },
                "value": "custom"
            },
            "ButtonFontCustom": {
                "type": "font",
                "value": "OpenSans-Bold"
            },
            "ButtonTextColorCustom": {
                "type": "color",
                "value": "#FFFFFF"
            },
            "ButtonBgColorCustom": {
                "type": "color",
                "value": "#15212d"
            },
            "ButtonBorderColorCustom": {
                "type": "color",
                "value": "#00000000"
            },
            "ButtonHoverTextColorCustom": {
                "type": "color",
                "value": "#000000"
            },
            "ButtonBgHoverColorCustom": {
                "type": "color",
                "value": "#fce542"
            },
            "ButtonBorderHoverColorCustom": {
                "type": "color",
                "value": "#00000000"
            },
            "ButtonTextSizePcCustom": {
                "type": "progress",
                "options": ["12", "40"],
                "suffix": "px",
                "value": "14px"
            },
            "ButtonWidthPcCustom": {
                "type": "input",
                "expand": {
                    "suffix": "px"
                },
                "value": ""
            },
            "ButtonHeightPcCustom": {
                "type": "input",
                "expand": {
                    "suffix": "px"
                },
                "value": ""
            },
            "ButtonRadiusSizePcCustom": {
                "type": "progress",
                "options": ["0", "50"],
                "suffix": "px",
                "value": "32px"
            },
            "ButtonTextSizeMobileCustom": {
                "type": "progress",
                "options": ["12", "30"],
                "suffix": "px",
                "value": "14px"
            },
            "ButtonWidthMobileCustom": {
                "type": "input",
                "expand": {
                    "suffix": "px"
                },
                "value": ""
            },
            "ButtonHeightMobileCustom": {
                "type": "input",
                "expand": {
                    "suffix": "px"
                },
                "value": ""
            },
            "ButtonRadiusSizeMobileCustom": {
                "type": "progress",
                "options": ["0", "50"],
                "suffix": "px",
                "value": "0px"
            }
        }
    },
    "Settings": {
        "Pic": {
            "type": "image",
            "expand": {
                "width": "1920",
                "height": "200"
            },
            "value": "https://ueeshop.ly200-cdn.com/u_file/UPBF/UPBF445/2601/28/photo/bgiconF.png"
        },
        "Pic1": {
            "type": "image",
            "expand": {
                "width": "13",
                "height": "12"
            },
            "value": "https://ueeshop.ly200-cdn.com/u_file/UPBF/UPBF445/2601/28/photo/iconAli.png"
        },
        "Title": {
            "type": "input",
            "expand": {
                "placeholder": "placeholder",
                "outSyncStyle": true
            },
            "value": "Shenzhen Ruixin Glassware Co., Ltd."
        },
        "SubTitle": {
            "type": "input",
            "expand": {
                "placeholder": "placeholder",
                "outSyncStyle": true
            },
            "value": "18yrs · Guangdong, China"
        },
        "Content": {
            "type": "input",
            "expand": {
                "placeholder": "placeholder",
                "outSyncStyle": true
            },
            "value": "Main categories: Custom Household Glassware,Icon Drinking Glass, Glass Candle Jar, Gold Rim Wine Glasses Set, Handmade Wine Glass"
        },
        "Content1": {
            "type": "input",
            "expand": {
                "placeholder": "placeholder",
                "outSyncStyle": true
            },
            "value": "Years in industry(20)"
        },
        "Content2": {
            "type": "input",
            "expand": {
                "placeholder": "placeholder",
                "outSyncStyle": true
            },
            "value": "Minor customization"
        },
        "Content3": {
            "type": "input",
            "expand": {
                "placeholder": "placeholder",
                "outSyncStyle": true
            },
            "value": "Multi-language capability"
        },
        "Content4": {
            "type": "input",
            "expand": {
                "placeholder": "placeholder",
                "outSyncStyle": true
            },
            "value": "ODM services available"
        },
        "SearchEffect": {
            "type": "effect",
            "expand": {
				"options": [8, 9],
				"fullySync": true
            },
            "linkage": {
                "9": "ColorStyle"
            },
            "value": 8
        },
        "Search": {
            "type": "switch",
            "linkage": {
				"1": ["SearchPlaceholder"]
            },
            "value": 1
        },
        "SearchPlaceholder": {
            "type": "input",
            "expand": {
                "placeholder": "placeholder",
                "outSyncStyle": true
            },
            "value": "Search..."
        },
        "RecentlySearch": {
            "type": "switch",
            "expand": {
                "hint": "goset"
            },
            "value": 0
        },
        "HotSearch": {
            "type": "switch",
            "expand": {
                "hint": "goset"
            },
            "value": 0
        },
        "UserEntrance": {
            "type": "switch",
            "value": 1
        },
        "HeaderFixedPc": {
            "type": "switch",
            "value": 0
        },
        "HeaderFixedMobile": {
            "type": "switch",
            "value": 0
        },
        "ColorFont": {
            "type": "word",
            "style": "notice",
            "hint": "hint"
        },
        "ThemesHeaderBgColor": {
            "type": "color",
            "value": "#ffffff"
        },
        "ThemesHeaderTextColor": {
            "type": "color",
            "value": "#222222"
        },
        "ThemesHeaderIconColor": {
            "type": "color",
            "value": "#222222"
        },
        "InquiryListQuantityColor": {
            "type": "color",
            "value": "#000000"
        },
        "InquiryListQuantityBgColor": {
            "type": "color",
            "value": "#fde642"
        }
    },
    "Config": {
        "AllowDelete": false
    },
    "Translation": {
        "Blocks": {
            "Board": [
                "Content"
            ],
            "Logo": [
                "LogoAlt"
            ],
            "Inquiry": [
                "ProductsInquiryButtonText"
            ]
        },
        "Settings": [
            "SearchPlaceholder"
        ]
    }
}

controller.php
<?php
namespace common\widgets\cusvis_mode\header\mode_24;

use common\helps\HelpsHtml;
use common\helps\HelpsJson;
use common\helps\HelpsLanguage;
use common\helps\HelpsVisualV2;
use common\helps\Ly200;
use common\helps\HelpsString;
use common\models\app\AppConfig;
use common\models\products\ProductsCategory;
use Yii;

class Controller
{
    private $PId;

    public function __construct($data)
    {
        $this->PId = $data['PId'];
    }

    public function getData()
    {
        $c = Yii::$app->params;
    
        // 头部样式
        $headerClass = HelpsVisualV2::getHeaderClass($this->PId);

        // logo
        $logoComputeWidth = HelpsVisualV2::computeWidth(HelpsVisualV2::getLogoSetWidth($this->PId));
        $logoComputeRatio = HelpsVisualV2::computeRatio(HelpsVisualV2::getLogoSize($this->PId));
        $logoPath = Ly200::setHeaderLogo($c['web_pack'][$this->PId]['Blocks'], 'pc');

        // 导航
        $navData = $cateidCateAry = [];
        $defaultNavSwitch = $c['web_pack'][$this->PId]['Blocks']['Menu']['Menu'];
        $navConfigData = [];
        if ($defaultNavSwitch) {
            $navData = Ly200::getNavData();
            $navConfigJson = AppConfig::find()->where(['ClassName' => 'nav_themes'])->select(['ConfigData'])->limit(1)->asArray()->oneCache();
            $navConfigData = HelpsJson::decode($navConfigJson['ConfigData'] ?? '');
            $orderBy = array_merge($c['my_order'], ['CateId' => SORT_ASC]);
            $allcateRow = ProductsCategory::find()->where(['IsSoldOut' => 0])->select(['CateId', 'UId', "Category{$c['lang']}", 'SubCateCount', 'PageUrl'])->orderBy($orderBy)->asArray()->allCache();
            foreach((array)$allcateRow as $k => $v){
                $cateidCateAry[$v['CateId']] = $v;
            }
        }

        // 语言
        $languageRow = HelpsLanguage::frontLanguageRow();

        // 询盘按钮样式
		$inquiryBtnStyle = $c['web_pack'][$this->PId]['Blocks']['Inquiry'];

		$inquiryInfo = HelpsVisualV2::getGlobalInquiryInfo($inquiryBtnStyle);
        $labelAttrInfo = HelpsVisualV2::getLabelAttr($inquiryBtnStyle);

        // 样式
        $rootStyle = HelpsVisualV2::getRootStyle($c['web_pack'][$this->PId]);
        //批量询盘数
        $inquirylistNumber = HelpsVisualV2::getInquiryListData();

        $FormFields = '';
        (isset($c['web_pack'][$this->PId]['Blocks']['Inquiry']['ProductsInquiryTriggerEffect']) && $c['web_pack'][$this->PId]['Blocks']['Inquiry']['ProductsInquiryTriggerEffect'] == 'popup') && $FormFields = HelpsString::strCode($c['web_pack'][$this->PId]['Blocks']['Inquiry']['FormFields']);


        return compact(
            'headerClass',
            'logoComputeWidth',
            'logoComputeRatio',
            'logoPath',
            'navData',
            'cateidCateAry',
            'languageRow',
            'inquiryInfo',
            'inquiryBtnStyle',
            'navConfigData',
            'defaultNavSwitch',
            'labelAttrInfo',
            'rootStyle',
            'inquirylistNumber',
            'FormFields'
        );
    }
}
?>


frontend/views/common/header/mobile_header.php 重点是<?=Yii::$app->params['web_pack'][$PId]['Settings']['SubTitle']?>的用法
<?php

use common\helps\HelpsHtml;
use common\helps\HelpsVisualV2;
use common\helps\Ly200;
use yii\bootstrap\Html;

//批量询盘数
$inquirylistNumber = HelpsVisualV2::getInquiryListData();
$ProductsBatchInquiry = Yii::$app->params['web_pack']['Config']['ProductsBatchInquiry'];
$text = $text ?? '';
$inquiryIcon = 'icon-inquiry1';
?>
<div class="menu_box">
    <div class="logo">
        <div class="compute_item_img" style="<?=HelpsVisualV2::computeWidth(HelpsVisualV2::getLogoSetWidth($PId))?>">
            <div class="compute_process_img" style="<?=HelpsVisualV2::computeRatio(HelpsVisualV2::getLogoSize($PId));?>">
               <?=Ly200::setHeaderLogo($visualHeaderData, 'mobile');?>
            </div>
        </div>
    </div>
    <div class="btn_menu">
        <div class="ajax_search global_search"><i class="iconfont icon-Search2025"></i></div>
        <?php 
            if ((int)$ProductsBatchInquiry) { 
            ?>
            <div class="ajax_inquiry">
                <a href="/inquiry.html" class="tool_inquiry_icon" title="<?=Html::encode($text);?>"><i class="iconfont <?=$inquiryIcon?>"></i><?=$text;?></a>
                <a href="/inquiry.html" class="list_numner"><span class="num_text"><?=$inquirylistNumber?></span></a>
            </div>
        <?php } ?>
        <div class="ajax_menu"><i class="iconfont icon-Menu2025"></i></div>
    </div>
</div>
<div class="company-card">
    <div class="company-name"><?=Yii::$app->params['web_pack'][$PId]['Settings']['Title']?></div>
    <div class="info-row">
        <span class="location"><?=Yii::$app->params['web_pack'][$PId]['Settings']['SubTitle']?></span>
    </div>
</div>


