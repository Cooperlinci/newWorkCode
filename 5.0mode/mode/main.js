document.addEventListener('DOMContentLoaded', function() {
    // 获取所有导航链接和轮播内容
    const navLinks = document.querySelectorAll('.country-nav a');
    const storySections = document.querySelectorAll('.story-section');
    const dots = document.querySelectorAll('.dot');
    const mainContent = document.getElementById('main-content');
    
    // 当前活动的索引
    let currentIndex = 0;
    
    // 创建导航小角元素
    function createNavIndicator() {
        const indicator = document.createElement('div');
        indicator.className = 'nav-indicator';
        mainContent.appendChild(indicator);
        return indicator;
    }
    
    const navIndicator = createNavIndicator();
    
    // 计算并设置导航小角的位置
    function updateNavIndicatorPosition(index) {
        if (navLinks[index]) {
            const navLink = navLinks[index];
            const linkRect = navLink.getBoundingClientRect();
            const mainContentRect = mainContent.getBoundingClientRect();
            
            // 计算小角的垂直位置（居中对齐导航项）
            const verticalPosition = linkRect.top + linkRect.height / 2 - mainContentRect.top - 15; // 10是小角高度的一半
            
            // 设置小角位置
            navIndicator.style.top = `${verticalPosition}px`;
        }
    }
    
    // 更新活动状态函数
    function updateActiveState(index) {
        // 更新导航链接
        navLinks.forEach((link, i) => {
            if (i === index) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
        
        // 更新轮播内容
        storySections.forEach((section, i) => {
            if (i === index) {
                section.classList.add('active');
                // 确保图片加载后显示正确
                const image = section.querySelector('.story-image img');
                if (image) {
                    // 触发图片加载
                    if (image.complete) {
                        // 如果图片已经加载完成
                        section.style.opacity = 1;
                    } else {
                        // 如果图片还未加载完成，等待加载完成后显示
                        image.addEventListener('load', function() {
                            section.style.opacity = 1;
                        }, { once: true });
                    }
                }
            } else {
                section.classList.remove('active');
                section.style.opacity = 0;
            }
        });
        
        // 更新分页指示器
        dots.forEach((dot, i) => {
            if (i === index) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
        
        // 更新导航小角位置
        updateNavIndicatorPosition(index);
        
        // 更新当前索引
        currentIndex = index;
    }
    
    // 导航链接点击事件
    navLinks.forEach((link, index) => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            updateActiveState(index);
        });
    });
    
    // 分页指示器点击事件
    dots.forEach((dot, index) => {
        dot.addEventListener('click', function() {
            updateActiveState(index);
        });
    });
    
    // 键盘导航支持
    document.addEventListener('keydown', function(e) {
        // 左箭头键或PageUp键
        if (e.key === 'ArrowLeft' || e.key === 'PageUp') {
            e.preventDefault();
            const newIndex = (currentIndex - 1 + navLinks.length) % navLinks.length;
            updateActiveState(newIndex);
        }
        // 右箭头键或PageDown键
        else if (e.key === 'ArrowRight' || e.key === 'PageDown') {
            e.preventDefault();
            const newIndex = (currentIndex + 1) % navLinks.length;
            updateActiveState(newIndex);
        }
        // Home键
        else if (e.key === 'Home') {
            e.preventDefault();
            updateActiveState(0);
        }
        // End键
        else if (e.key === 'End') {
            e.preventDefault();
            updateActiveState(navLinks.length - 1);
        }
    });
    
    // 触摸滑动支持
    let touchStartX = 0;
    let touchEndX = 0;
    
    function handleSwipe() {
        const threshold = 50; // 最小滑动距离
        if (touchEndX < touchStartX - threshold) {
            // 向左滑动
            const newIndex = (currentIndex + 1) % navLinks.length;
            updateActiveState(newIndex);
        } else if (touchEndX > touchStartX + threshold) {
            // 向右滑动
            const newIndex = (currentIndex - 1 + navLinks.length) % navLinks.length;
            updateActiveState(newIndex);
        }
    }
    
    document.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    }, false);
    
    document.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, false);
    
    // 初始化时确保第一个内容区域显示正确
    // 等待DOM完全渲染后再设置初始位置
    setTimeout(() => {
        updateActiveState(0);
    }, 100);
});