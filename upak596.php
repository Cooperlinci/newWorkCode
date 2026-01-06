<?php

upak596  t232 不更新  添加在线留言和订阅加验证码

backup:

订阅验证码
<?php

backup:
    //订阅提交
	public static function newsletter(){//订阅提交
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$status=-1;

		if(!preg_match('/^[a-z0-9][a-z\.0-9-_]+@[a-z0-9_-]+(?:\.[a-z]{0,3}\.[a-z]{0,2}|\.[a-z]{0,3}|\.[a-z]{0,2})$/i', $p_Email)){
			exit(str::json_data(array('status'=>$status, 'msg'=>$c['lang_pack']['user']['error']['Email'])));
		}
		
		if(!db::get_row_count('newsletter', "Email='{$p_Email}'")){
			$status=1;
			db::insert('newsletter', array(
					'Email'		=>	$p_Email,
					'AccTime'	=>	$c['time']
				)
			);
		}
		exit(str::json_data(array('status'=>$status, 'msg'=>$p_Email)));
	}

modify: 

	//订阅提交
	public static function newsletter(){
		global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
		$status = -1;
		switch($c['lang']){
			case 'cn':
				$vcode_tips = '验证码错误，请正确填写验证码！';
				break;
			case 'es':
				$vcode_tips = 'Lo siento, por favor, escriba los caracteres que ve en la imagen！';
				break;
			case 'ru':
				$vcode_tips = 'Прости,пожалуйста, введите символы в картину вижу тебя!';
				break;
			case 'jp':
				$vcode_tips = '申し訳ありませんが、タイプしてください、あなたが絵の中で見る文字！';
				break;
			case 'de':
				$vcode_tips = 'Tut Mir leid, bitte geben sie die Zeichen in den bildern sehen SIE！';
				break;
			case 'fr':
				$vcode_tips = "Désolé, saisissez le caractère dans l'image de vous voir！";
				break;
			default:
				$vcode_tips = 'Sorry, Please type the characters you see in the picture!';
				break;
		}
		@session_start();
		if(strtoupper($p_verify_code) != strtoupper($_SESSION['Global']['v_code'][md5('newsletter')]) 
		|| empty($_SESSION['Global']['v_code'][md5('newsletter')]) 
		|| empty($p_verify_code)){
			unset($_SESSION['Global']['v_code'][md5('newsletter')]);
			ob_clean(); 
			exit(str::json_data(array('status' => -2, 'msg' => $vcode_tips)));
		}
		unset($_SESSION['Global']['v_code'][md5('newsletter')]);
		if(!preg_match('/^[a-z0-9][a-z\.0-9-_]+@[a-z0-9_-]+(?:\.[a-z]{0,3}\.[a-z]{0,2}|\.[a-z]{0,3}|\.[a-z]{0,2})$/i', $p_Email)){
			exit(str::json_data(array('status' => $status, 'msg' => $c['lang_pack']['user']['error']['Email'])));
		}
		if(!db::get_row_count('newsletter', "Email='{$p_Email}'")){
			$status = 1;
			db::insert('newsletter', array(
					'Email'     =>  $p_Email,
					'AccTime'   =>  $c['time']
				)
			);
		}
		exit(str::json_data(array('status'=>$status, 'msg'=>$p_Email)));
	}

backup：

<div class="search">
    <form class="newsletter" id="newsletter" method="post">
        <input type="text" name="Email" class="text " placeholder="<?=$c['lang_pack']['letter_text']; ?>"  notnull format="Email"  />
        <input type="submit" class="newsletter_submit sub" value="<?=$c['lang_pack']['letter_sub']; ?>" />
    </form>
</div>

				<input type="text" class="newsletter_input" name="Email" placeholder="<?=$c['lang_pack']['letter_text'];?>" notnull />
				<input type="submit" class="newsletter_submit" value="" />

			<form id="newsletter" class="newsletter_form">
				<input type="text" name="Email" class="text " placeholder="<?=$c['lang_pack']['letter_text']; ?>"  notnull format="Email"  />
        		<input type="submit" class="newsletter_submit sub" value="<?=$c['lang_pack']['letter_sub']; ?>" />
				<div class="rows vcode" style="display: none;">
					<div class="fl_vcode" >
						<input type="text" class="text verify_code" size="4" maxlength="4" placeholder="<?=$c['lang_pack']['review']['vcode'];?>" notnull /> 
					</div>
					<div class="fl_vcode">
						<?=v_code::create('newsletter');?>
					</div>
					<div class="clear"></div>
				</div>
			</form>

modify:

<div class="search">
    <form class="newsletter" id="newsletter" method="post">
        <input type="text" name="Email" class="text " placeholder="<?=$c['lang_pack']['letter_text']; ?>"  notnull format="Email"  />
        <div class="rows vcode" style="margin: 10px 0;display: flex;align-items: center;">
            <div class="fl_vcode" style="width: 57%;">
                <input style="width: 80%;border-right: 1px solid #333333;" name="verify_code" style="border-right: 1px solid #333333;" type="text" class="text verify_code" size="4" maxlength="4" placeholder="<?=$c['lang_pack']['review']['vcode'];?>" notnull /> 
            </div>
            <div class="fl_vcode">
                <?=v_code::create('newsletter');?>
            </div>
            <div class="clear"></div>
        </div>
        <input type="submit" class="newsletter_submit sub" value="<?=$c['lang_pack']['letter_sub']; ?>" />
    </form>
</div>


body .footer_258_1 #footer .config_box .search form {height: 170px;}
body .footer_258_1 #footer .config_box .search form .text {width: 93%;border-right: 1px solid #333333;color: #d9d9d9;}
body .footer_258_1 #footer .config_box .search form .sub {width: 100% ;height: 46px; border: none; text-align: center; line-height: 40px; font-size: 16px; font-family: "Oswald-Regular"; font-weight: bold; background: #ffb615; position: absolute;cursor: pointer; -webkit-appearance:none;  border-radius:0px;}


backup:
<form id="newsletter" class="newsletter_form">
    <input type="text" class="newsletter_input" name="Email" placeholder="<?=$c['lang_pack']['letter_text'];?>" notnull />
    <input type="submit" class="newsletter_submit" value="" />
    <div class="rows vcode">
        <div class="fl_vcode" >
            <input type="text" style="width: 50%;" class="text verify_code" size="4" maxlength="4" placeholder="<?=$c['lang_pack']['review']['vcode'];?>" notnull /> 
        </div>
        <div class="fl_vcode">
            <?=v_code::create('newsletter');?>
        </div>
        <div class="clear"></div>
    </div>
</form>
<style>
#footer .copy form{padding: 26px 0 14px 0;overflow: hidden;}
#footer .copy form input[type=text]{border: none;background:url('../images/newletter_emailIco.png') no-repeat left 15px center #fff;width: 275px;height: 45px;font-size: 12px;color: #918f9a;padding: 0 15px 0 48px;float: left;border-radius: 22.5px 0 0 22.5px;border: 1px solid transparent;}
#footer .copy form input[type=submit]{width: 60px;height: 47px;border:none;text-transform: uppercase;font-size: 12px;color: #272c4c;float: left;background:url('../images/newletter_butIco.png') no-repeat center #fff;border-radius: 0 22.5px 22.5px 0; border: 1px solid transparent;}

@media screen and (max-width: 1280px) {
    #nav{max-width:610px;}
    
	#footer .copy p{width: 300px;}
	#footer .copy form input[type=text]{width: 130px;}
}
</style>


modify:
<form id="newsletter" class="newsletter_form">
    <div class="input-group">
        <input type="email" class="newsletter_input" name="Email" 
               placeholder="<?=$c['lang_pack']['letter_text'];?>" 
               notnull required />
        <input type="submit" class="newsletter_submit" value="→" />
    </div>
    <div class="rows vcode">
        <div class="fl_vcode">
            <input type="text" class="text verify_code" 
                   placeholder="<?=$c['lang_pack']['review']['vcode'];?>" 
                   size="4" maxlength="4" notnull required /> 
        </div>
        <div class="fl_vcode captcha-image">
            <?=v_code::create('newsletter');?>
        </div>
        <div class="clear"></div>
    </div>
</form>

<style>
#footer .copy form {padding: 26px 0 14px 0;overflow: hidden;max-width: 500px;margin: 0 auto;}
#footer .copy form .input-group {display: flex;margin-bottom: 15px;}
#footer .copy form input[type=email] {border: 1px solid #e0e0e0;background: #fff url(../images/newletter_emailIco.png) no-repeat left 15px center;flex: 1;height: 50px;font-size: 14px;color: #333;padding: 0 15px 0 48px;border-radius: 25px 0 0 25px;transition: all 0.3s ease;box-shadow: 0 2px 4px rgba(0,0,0,0.05);}
#footer .copy form input[type=email]:focus {outline: none;border-color: #4a90e2;box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);}
#footer .copy form input[type=submit] {width: 60px;height: 50px;border: none;font-size: 18px;color: #fff;background: #4a90e2;border-radius: 0 25px 25px 0;cursor: pointer;transition: all 0.3s ease;}
#footer .copy form input[type=submit]:hover {background: #3a80d2;transform: translateY(-2px);}
#footer .copy form .vcode {display: flex;align-items: center;gap: 10px;}
#footer .copy form .verify_code {height: 45px;padding: 0 15px;border: 1px solid #e0e0e0;border-radius: 22px;font-size: 14px;transition: all 0.3s ease;box-shadow: 0 2px 4px rgba(0,0,0,0.05);}
#footer .copy form .verify_code:focus {outline: none;border-color: #4a90e2;box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);}
#footer .copy form .captcha-image {border-radius: 22px;overflow: hidden;box-shadow: 0 2px 4px rgba(0,0,0,0.1);}
@media (max-width: 480px) {
    #footer .copy form input[type=email] {width: 100%;border-radius: 25px 25px 0 0;}
    #footer .copy form input[type=submit] {width: 100%;border-radius: 0 0 25px 25px;} 
    #footer .copy form .input-group {flex-direction: column;}
    #footer .copy form .vcode {flex-direction: column;align-items: stretch;}
    #footer .copy form .verify_code {width: 100% !important;}
}
</style>


			<form id="newsletter" class="newsletter_form">
				<input type="text" class="newsletter_input" name="Email" placeholder="<?=$c['lang_pack']['letter_text'];?>" notnull />
				<input type="submit" class="newsletter_submit" value="" />
				<div class="rows vcode">
					<div class="fl_vcode" >
						<input type="text" style="margin-top: 10px;width: 50%;background: #fff;padding: 0 15px;" class="text verify_code" size="4" maxlength="4" placeholder="<?=$c['lang_pack']['review']['vcode'];?>" notnull /> 
					</div>
					<div class="fl_vcode" style="margin-top: 10px;width: 129px;height: 45px;border: none;text-transform: uppercase;font-size: 12px;color: #272c4c;float: left;background: #fff;border-radius: 0 22.5px 22.5px 0;border: 1px solid transparent;display: grid;align-items: center;">
						<?=v_code::create('newsletter');?>
					</div>
					<div class="clear"></div>
				</div>
			</form>