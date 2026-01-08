<?php
// 自定义301重定向规则,写在了/static/static/inc/init.php
// 原代码中$c['http_type']定义后
$c['http_type']=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on')?'https://':'http://';

$c['where']=array(...); // 原查询条件

// ↓↓↓ 插入上述重定向代码 ↓↓↓
$redirect_rules = array(
    '/products/-' => '/products/passenger-elevator',
    '/products/-1' => '/products/home-lift',
    '/products/-1-1' => '/products/hospital-lift',
    '/products/-1-95' => '/products/goods-lift',
    '/products/-1-2' => '/products/panoramic-lift',
    '/products/-1-97' => '/products/escalator',
    '/products/--98' => '/products/moving-walk',
    '/products/--99' => '/products/dumbwaiter',
    '/products/--100' => '/products/parking-system',
    '/products/--101' => '/products/wheelchair-platform'
);

$current_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$current_uri_trimmed = trim($current_uri, '/');

foreach ($redirect_rules as $old_path => $new_path) {
    $old_path_trimmed = trim($old_path, '/');
    if ($current_uri_trimmed === $old_path_trimmed) {
        $target_url = $c['http_type'] . $_SERVER['HTTP_HOST'] . $new_path;
        header("HTTP/1.1 301 Moved Permanently");
        js::location($target_url);
        exit;
    }
}
// ↑↑↑ 重定向代码结束 ↑↑↑

// 原代码后续逻辑（$do_action等）




https://www.wellselevator.com/products/-     --->       https://www.wellselevator.com/products/passenger-elevator

https://www.wellselevator.com/products/-1     --->     https://www.wellselevator.com/products/home-lift

https://www.wellselevator.com/products/-1-1   --->   https://www.wellselevator.com/products/hospital-lift

https://www.wellselevator.com/products/-1-95       --->      https://www.wellselevator.com/products/goods-lift

https://www.wellselevator.com/products/-1-2          --->     https://www.wellselevator.com/products/panoramic-lift

https://www.wellselevator.com/products/-1-97       --->         https://www.wellselevator.com/products/escalator

https://www.wellselevator.com/products/--98       --->        https://www.wellselevator.com/products/moving-walk

https://www.wellselevator.com/products/--99         --->       https://www.wellselevator.com/products/dumbwaiter

https://www.wellselevator.com/products/--100        --->      https://www.wellselevator.com/products/parking-system

https://www.wellselevator.com/products/--101      --->        https://www.wellselevator.com/products/wheelchair-platform


    '/products/-' => '/products/passenger-elevator',
    '/products/-1' => '/products/home-lift',
    '/products/-1-1' => '/products/hospital-lift',
    '/products/-1-95' => '/products/goods-lift',
    '/products/-1-2' => '/products/panoramic-lift',
    '/products/-1-97' => '/products/escalator',
    '/products/--98' => '/products/moving-walk',
    '/products/--99' => '/products/dumbwaiter',
    '/products/--100' => '/products/parking-system',
    '/products/--101' => '/products/wheelchair-platform'



UPAP664  t264  不更新  产品链接301重定向