<?php
$plugins_config = $c['web_pack'][$WId];
$plugins_data = $plugins_config['Data'];
$plugins_count = count((array)$plugins_data);
?>
<div class="<?=$plugins_config['CssName']?> <?=$plugins_config['CssExt']?>" visualWId="<?=$plugins_config['WId']?>" style="<?=$plugins_config['PluginStyle'];?>">    
    <div plugins_pos="0" plugins_mod="Pic">
        <div class="header-title-container">
            <section class="title-content">
                <p class="main-title"><?= $c['web_pack'][$WId]['Data'][0]['Title']; ?></p>
                <p class="subtitle"><?= $c['web_pack'][$WId]['Data'][0]['SubTitle']; ?></p>
            </section>
        </div>
        <div class="main-layout-container">
            <div class="left-nav-container" aria-label="Main Navigation">
                <div class="project-title">
                    <p class="content-title">Project</p>
                </div>
                <div class="country-nav">
                    <div>
                        <a href="#" class="active" aria-current="page" data-country="<?= $c['web_pack'][$WId]['Data'][1]['SubTitle']; ?>"><?= $c['web_pack'][$WId]['Data'][1]['SubTitle']; ?></a>
                    </div>
                    <div>
                        <a href="#" data-country="<?= $c['web_pack'][$WId]['Data'][2]['SubTitle']; ?>"><?= $c['web_pack'][$WId]['Data'][2]['SubTitle']; ?></a>
                    </div>
                    <div>
                        <a href="#" data-country="<?= $c['web_pack'][$WId]['Data'][3]['SubTitle']; ?>"><?= $c['web_pack'][$WId]['Data'][3]['SubTitle']; ?></a>
                    </div>
                    <div>
                        <a href="#" data-country="<?= $c['web_pack'][$WId]['Data'][4]['SubTitle']; ?>"><?= $c['web_pack'][$WId]['Data'][4]['SubTitle']; ?></a>
                    </div>
                    <div>
                        <a href="#" data-country="<?= $c['web_pack'][$WId]['Data'][5]['SubTitle']; ?>"><?= $c['web_pack'][$WId]['Data'][5]['SubTitle']; ?></a>
                    </div>
                    <div>
                        <a href="#" data-country="<?= $c['web_pack'][$WId]['Data'][6]['SubTitle']; ?>"><?= $c['web_pack'][$WId]['Data'][6]['SubTitle']; ?></a>
                    </div>
                </div>
            </div>
            <main id="main-content">
                <div class="content-wrapper">
                    <!-- 轮播内容区域 -->
                    <article class="story-section active" id="content-<?= $c['web_pack'][$WId]['Data'][1]['SubTitle']; ?>">
                        <p class="story-header" plugins_mod="Title"><?= $c['web_pack'][$WId]['Data'][1]['Title']; ?></p>
                        <div class="story-content-wrapper">
                            <div class="story-text">
                                <p plugins_mod="Content"><?= $c['web_pack'][$WId]['Data'][1]['Content']; ?></p>
                            </div>
                            <div class="story-image">
                                <img plugins_mod="Pic" class="trans loading_img" data-src="<?=$c['web_pack'][$WId]['Data'][1]['Pic'];?>" alt="<?=$c['web_pack'][$WId]['Data'][1]['SubTitle'];?>"><em></em>
                            </div>
                        </div>
                    </article>
                    <article class="story-section" id="content-<?= $c['web_pack'][$WId]['Data'][2]['SubTitle']; ?>">
                        <p class="story-header" plugins_mod="Title"><?= $c['web_pack'][$WId]['Data'][2]['Title']; ?></p>
                        <div class="story-content-wrapper">
                            <div class="story-text">
                                <p plugins_mod="Content"><?= $c['web_pack'][$WId]['Data'][2]['Content']; ?></p>
                            </div>
                            <div class="story-image">
                                <img plugins_mod="Pic" class="trans loading_img" data-src="<?=$c['web_pack'][$WId]['Data'][2]['Pic'];?>" alt="<?=$c['web_pack'][$WId]['Data'][2]['SubTitle'];?>"><em></em>
                            </div>
                        </div>
                    </article>
                    <article class="story-section" id="content-<?= $c['web_pack'][$WId]['Data'][3]['SubTitle']; ?>">
                        <p class="story-header" plugins_mod="Title"><?= $c['web_pack'][$WId]['Data'][3]['Title']; ?></p>
                        <div class="story-content-wrapper">
                            <div class="story-text">
                                <p plugins_mod="Content"><?= $c['web_pack'][$WId]['Data'][3]['Content']; ?></p>
                            </div>
                            <div class="story-image">
                                <img plugins_mod="Pic" class="trans loading_img" data-src="<?=$c['web_pack'][$WId]['Data'][3]['Pic'];?>" alt="<?=$c['web_pack'][$WId]['Data'][3]['SubTitle'];?>"><em></em>
                            </div>
                        </div>
                    </article>
                    <article class="story-section" id="content-<?= $c['web_pack'][$WId]['Data'][4]['SubTitle']; ?>">
                        <p class="story-header" plugins_mod="Title"><?= $c['web_pack'][$WId]['Data'][4]['Title']; ?></p>
                        <div class="story-content-wrapper">
                            <div class="story-text">
                                <p plugins_mod="Content"><?= $c['web_pack'][$WId]['Data'][4]['Content']; ?></p>
                            </div>
                            <div class="story-image">
                                <img plugins_mod="Pic" class="trans loading_img" data-src="<?=$c['web_pack'][$WId]['Data'][4]['Pic'];?>" alt="<?=$c['web_pack'][$WId]['Data'][4]['SubTitle'];?>"><em></em>
                            </div>
                        </div>
                    </article>
                    <article class="story-section" id="content-<?= $c['web_pack'][$WId]['Data'][5]['SubTitle']; ?>">
                        <p class="story-header" plugins_mod="Title"><?= $c['web_pack'][$WId]['Data'][5]['Title']; ?></p>
                        <div class="story-content-wrapper">
                            <div class="story-text">
                                <p plugins_mod="Content"><?= $c['web_pack'][$WId]['Data'][5]['Content']; ?></p>
                            </div>
                            <div class="story-image">
                                <img plugins_mod="Pic" class="trans loading_img" data-src="<?=$c['web_pack'][$WId]['Data'][5]['Pic'];?>" alt="<?=$c['web_pack'][$WId]['Data'][5]['SubTitle'];?>"><em></em>
                            </div>
                        </div>
                    </article>
                    <article class="story-section" id="content-<?= $c['web_pack'][$WId]['Data'][6]['SubTitle']; ?>">
                        <p class="story-header" plugins_mod="Title"><?= $c['web_pack'][$WId]['Data'][6]['Title']; ?></p>
                        <div class="story-content-wrapper">
                            <div class="story-text">
                                <p plugins_mod="Content"><?= $c['web_pack'][$WId]['Data'][6]['Content']; ?></p>
                            </div>
                            <div class="story-image">
                                <img plugins_mod="Pic" class="trans loading_img" data-src="<?=$c['web_pack'][$WId]['Data'][6]['Pic'];?>" alt="<?=$c['web_pack'][$WId]['Data'][6]['SubTitle'];?>"><em></em>
                            </div>
                        </div>
                    </article>
                </div>
            </main>
        </div>
        <div class="pagination-dots">
            <div class="dots-container">
                <button class="dot active" aria-label="Go to <?= $c['web_pack'][$WId]['Data'][1]['SubTitle']; ?> section" data-index="0" data-country="<?= $c['web_pack'][$WId]['Data'][1]['SubTitle']; ?>"></button>
                <button class="dot" aria-label="Go to <?= $c['web_pack'][$WId]['Data'][2]['SubTitle']; ?> section" data-index="1" data-country="<?= $c['web_pack'][$WId]['Data'][2]['SubTitle']; ?>"></button>
                <button class="dot" aria-label="Go to <?= $c['web_pack'][$WId]['Data'][3]['SubTitle']; ?> section" data-index="2" data-country="<?= $c['web_pack'][$WId]['Data'][3]['SubTitle']; ?>"></button>
                <button class="dot" aria-label="Go to <?= $c['web_pack'][$WId]['Data'][4]['SubTitle']; ?> section" data-index="3" data-country="<?= $c['web_pack'][$WId]['Data'][4]['SubTitle']; ?>"></button>
                <button class="dot" aria-label="Go to <?= $c['web_pack'][$WId]['Data'][5]['SubTitle']; ?> section" data-index="4" data-country="<?= $c['web_pack'][$WId]['Data'][5]['SubTitle']; ?>"></button>
                <button class="dot" aria-label="Go to <?= $c['web_pack'][$WId]['Data'][6]['SubTitle']; ?> section" data-index="5" data-country="<?= $c['web_pack'][$WId]['Data'][6]['SubTitle']; ?>"></button>
            </div>
        </div>
    </div>
</div>