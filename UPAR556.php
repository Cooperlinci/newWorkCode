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
			// 发送邮件通知管理员
			if($c['config']['global']['Contact']['email']){
				include("{$c['static_path']}/inc/mail/newsletter.php");
				ly200::sendmail($c['config']['global']['Contact']['email'],'You have a new newsletter',$table);
			}
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
			if($c['config']['global']['Contact']['email']){
				include("{$c['static_path']}/inc/mail/newsletter.php");
				ly200::sendmail($c['config']['global']['Contact']['email'], 'You have a new newsletter', $table);
			}
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