
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

function category_filter_init() {
	// 初始化分类筛选
	initCategoryFilter();
	
	// 监听一级分类变化
	$('#category_level1').on('change', function() {
		let level1Id = $(this).val();
		// 清空二级和三级分类
		$('#category_level2').html('<option value="0">' + langPack.categoryLevel2 + '</option>');
		$('#category_level3').html('<option value="0">' + langPack.categoryLevel3 + '</option>');
		
		// 生成二级分类选项
		if(level1Id != 0) {
			let level2Key = '0,' + level1Id + ',';
			if(categoryData[level2Key] && categoryData[level2Key].length > 0) {
				$.each(categoryData[level2Key], function(index, item) {
					let categoryName = item['Category' + currentLang] || item['Category' + 'en'] || 'Unknown';
					$('#category_level2').append('<option value="' + item.CateId + '">' + categoryName + '</option>');
				});
			}
			
			// 执行页面跳转或筛选操作
			let url = window.location.href;
			// 移除现有的分类参数
			url = url.replace(/[?&]CateId=\d+/g, '');
			// 添加新的分类参数
			if(url.indexOf('?') > -1) {
				url += '&CateId=' + level1Id;
			} else {
				url += '?CateId=' + level1Id;
			}
			// 跳转到新的 URL
			window.location.href = url;
		}
	});
	
	// 监听二级分类变化
	$('#category_level2').on('change', function() {
		let level1Id = $('#category_level1').val();
		let level2Id = $(this).val();
		// 清空三级分类
		$('#category_level3').html('<option value="0">' + langPack.categoryLevel3 + '</option>');
		
		// 生成三级分类选项
		if(level1Id != 0 && level2Id != 0) {
			let level3Key = '0,' + level1Id + ',' + level2Id + ',';
			if(categoryData[level3Key] && categoryData[level3Key].length > 0) {
				$.each(categoryData[level3Key], function(index, item) {
					let categoryName = item['Category' + currentLang] || item['Category' + 'en'] || 'Unknown';
					$('#category_level3').append('<option value="' + item.CateId + '">' + categoryName + '</option>');
				});
			}
			
			// 执行页面跳转或筛选操作
			let url = window.location.href;
			// 移除现有的分类参数
			url = url.replace(/[?&]CateId=\d+/g, '');
			// 添加新的分类参数
			if(url.indexOf('?') > -1) {
				url += '&CateId=' + level2Id;
			} else {
				url += '?CateId=' + level2Id;
			}
			// 跳转到新的 URL
			window.location.href = url;
		}
	});
	
	// 监听三级分类变化
	$('#category_level3').on('change', function() {
		let level3Id = $(this).val();
		if(level3Id != 0) {
			// 执行页面跳转或筛选操作
			let url = window.location.href;
			// 移除现有的分类参数
			url = url.replace(/[?&]CateId=\d+/g, '');
			// 添加新的分类参数
			if(url.indexOf('?') > -1) {
				url += '&CateId=' + level3Id;
			} else {
				url += '?CateId=' + level3Id;
			}
			// 跳转到新的 URL
			window.location.href = url;
		}
	});
}

// 初始化分类筛选器
function initCategoryFilter() {
	// 获取当前分类 ID
	let currentCateId = parseInt($('#CateId').val()) || 0;
	if(currentCateId == 0) return;
	
	// 遍历分类数据，查找当前分类的层级关系
	let level1Id = 0, level2Id = 0, level3Id = 0;
	let found = false;
	
	// 查找三级分类
	for(let level1Key in categoryData) {
		if(categoryData.hasOwnProperty(level1Key)) {
			let level1Items = categoryData[level1Key];
			$.each(level1Items, function(index, level1Item) {
				if(level1Item.CateId == currentCateId) {
					level1Id = currentCateId;
					found = true;
					return false;
				}
				
				// 查找二级分类
				let level2Key = level1Key + level1Item.CateId + ',';
				if(categoryData[level2Key]) {
					$.each(categoryData[level2Key], function(index, level2Item) {
						if(level2Item.CateId == currentCateId) {
							level1Id = level1Item.CateId;
							level2Id = currentCateId;
							found = true;
							return false;
						}
						
						// 查找三级分类
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
	
	// 设置一级分类
	if(level1Id != 0) {
		$('#category_level1').val(level1Id);
		
		// 生成二级分类选项
		let level2Key = '0,' + level1Id + ',';
		if(categoryData[level2Key] && categoryData[level2Key].length > 0) {
			$('#category_level2').html('<option value="0">' + langPack.categoryLevel2 + '</option>');
			$.each(categoryData[level2Key], function(index, item) {
				let categoryName = item['Category' + currentLang] || item['Category' + 'en'] || 'Unknown';
				$('#category_level2').append('<option value="' + item.CateId + '">' + categoryName + '</option>');
			});
			
			// 设置二级分类
			if(level2Id != 0) {
				$('#category_level2').val(level2Id);
				
				// 生成三级分类选项
				let level3Key = '0,' + level1Id + ',' + level2Id + ',';
				if(categoryData[level3Key] && categoryData[level3Key].length > 0) {
					$('#category_level3').html('<option value="0">' + langPack.categoryLevel3 + '</option>');
					$.each(categoryData[level3Key], function(index, item) {
						let categoryName = item['Category' + currentLang] || item['Category' + 'en'] || 'Unknown';
						$('#category_level3').append('<option value="' + item.CateId + '">' + categoryName + '</option>');
					});
					
					// 设置三级分类
					if(level3Id != 0) {
						$('#category_level3').val(level3Id);
					}
				}
			}
		}
	}
}

// 获取当前语言
function getCurrentLang() {
	// 根据实际情况修改获取当前语言的逻辑
	// 这里假设当前语言存储在全局变量 c.lang 中
	return typeof c !== 'undefined' && c.lang ? c.lang : 'en';
}