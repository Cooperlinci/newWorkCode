// 注意：使用此代码前请确保已引入jQuery库
// <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

$(document).ready(function() {
    
    // 国家导航切换功能
    const $countryLinks = $('.country-nav a');
    const $storySections = $('.story-section');
    
    // 修复导航中的重复美国条目（如果需要）
    if ($countryLinks.length > 1 && $countryLinks.eq(1).text() === $countryLinks.eq(2).text()) {
        // 可以在这里添加代码来处理重复的美国条目
        // 例如更改第二个为其他国家或添加地区标识
    }
    
    // 为可访问性添加键盘导航到国家列表
    $countryLinks.each(function(index, link) {
        $(link).on('keydown', function(e) {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                const nextIndex = (index + 1) % $countryLinks.length;
                $countryLinks.eq(nextIndex).focus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                const prevIndex = (index - 1 + $countryLinks.length) % $countryLinks.length;
                $countryLinks.eq(prevIndex).focus();
            }
        });
    });
    
    // 切换内容函数
    function switchContent(country) {
        // 隐藏所有内容区块
        $storySections.hide().removeClass('active');
        
        // 显示选中的内容区块
        const $selectedSection = $(`#content-${country}`);
        if ($selectedSection.length) {
            $selectedSection.show().addClass('active');
        }
        
        // 更新导航链接状态
        $countryLinks.each(function() {
            if ($(this).data('country') === country) {
                $(this).addClass('active').attr('aria-current', 'page');
            } else {
                $(this).removeClass('active').removeAttr('aria-current');
            }
        });
    }
    
    // 添加国家导航点击事件
    $countryLinks.on('click', function(e) {
        e.preventDefault();
        const country = $(this).data('country');
        switchContent(country);
    });
    
    // 键盘导航增强 - 添加Enter和Space键支持
    $countryLinks.on('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            const country = $(this).data('country');
            switchContent(country);
        }
    });
    
    // 底部导航圆点功能
    const $dots = $('.dot');
    if ($dots.length > 0) {
        // 切换导航圆点状态
        function setActiveDot(index) {
            $dots.each(function(i, dot) {
                if (i === index) {
                    $(dot).addClass('active').attr('aria-current', 'page');
                } else {
                    $(dot).removeClass('active').removeAttr('aria-current');
                }
            });
            
            // 根据圆点索引切换到对应的国家内容
            const countries = ['kazakhstan', 'american1', 'american2', 'germany', 'chinese', 'vinda'];
            if (index < countries.length) {
                switchContent(countries[index]);
            }
        }
        
        // 点击导航圆点
        $dots.each(function(index, dot) {
            $(dot).on('click', function() {
                setActiveDot(index);
            });
            
            // 键盘导航
            $(dot).on('keydown', function(e) {
                if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    const nextIndex = (index + 1) % $dots.length;
                    $dots.eq(nextIndex).focus();
                    setActiveDot(nextIndex);
                } else if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    const prevIndex = (index - 1 + $dots.length) % $dots.length;
                    $dots.eq(prevIndex).focus();
                    setActiveDot(prevIndex);
                } else if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    setActiveDot(index);
                }
            });
        });
    }
});