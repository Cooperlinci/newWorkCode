frontend/controller/actionController->actionInquiryForm

backup:

Ly200::eJson(['tips' => LangPack::lang('web.global.form_submit_tip'), 'url' => $jumpUrl . "?number={$oid}"], 1);

modify:

Ly200::eJson(['tips' => LangPack::lang('web.global.form_submit_tip'), 'url' => $jumpUrl . "?number={$oid}&email=" . urlencode($email)], 1);

frontend/views/inquiry

backup:

<?php

use frontend\modules\LangPack;
?>
<?=$headerHtml;?>
<?=$googleEvent;?>
<div class="ly_inquiry_list_1">
    <div class="wide">
        <div class="list_container">
            <div class="notice_box">
                <div class="notice_title themes_box_title"><?=LangPack::lang('web.global.sStatusThank');?></div>
                <div class="notice_subtitle themes_box_subtitle"><?=LangPack::lang('web.global.inquiry_success');?></div>
                <a href="/" class="notice_button" title="<?=LangPack::lang('web.global.re_to_shop');?>"><?=LangPack::lang('web.global.re_to_shop');?></a>
            </div>
        </div>
    </div>
</div>
<?=$footerHtml;?>


modify:

<?php

use frontend\modules\LangPack;

// 获取邮箱参数
$email = Yii::$app->request->get('email', '');
if ($email) {
    $email = urldecode($email);
}
?>
<?=$headerHtml;?>
<?=$googleEvent;?>
<div class="ly_inquiry_list_1">
    <div class="wide">
        <div class="list_container">
            <div class="notice_box">
                <div class="notice_title themes_box_title"><?=LangPack::lang('web.global.sStatusThank');?></div>
                <div class="notice_subtitle themes_box_subtitle">
                    <?php if ($email): ?><?= $email ?><br><?php endif; ?>
                    <?=LangPack::lang('web.global.inquiry_success');?>
                </div>
                <a href="/" class="notice_button" title="<?=LangPack::lang('web.global.re_to_shop');?>"><?=LangPack::lang('web.global.re_to_shop');?></a>
            </div>
        </div>
    </div>
</div>
<?=$footerHtml;?>