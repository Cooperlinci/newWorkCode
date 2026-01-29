邮箱检测
<?php
后端
	/**
     * 新增：SMTP邮箱配置检测方法
     * 用于验证SMTP服务器配置是否有效
     */
    public static function check_config(){
        global $c;

		$config_row = array(
			'SmtpHost'      =>  isset($_POST['SmtpHost']) ? trim($_POST['SmtpHost']) : '',
			'SmtpPort'      =>  isset($_POST['SmtpPort']) ? trim($_POST['SmtpPort']) : '',
			'SmtpUserName'  =>  isset($_POST['SmtpUserName']) ? trim($_POST['SmtpUserName']) : '',
			'SmtpPassword'  =>  isset($_POST['SmtpPassword']) ? trim($_POST['SmtpPassword']) : ''
		);

        manage::check_permit('email.config', 2);

		$post = array(
			'Action'		=>	'ueeshop_web_smtp_verification',
			'Number'		=>	$c['Number'],
			'SmtpHost'		=>	$config_row['SmtpHost'],
			'SmtpPort'		=>	$config_row['SmtpPort'],
			'SmtpUserName'	=>	$config_row['SmtpUserName'],
			'SmtpPassword'	=>	$config_row['SmtpPassword']
		);

		if($config_row['SmtpUserName']!='' && $config_row['SmtpPassword']!=''){
			$result = ly200::api($post,$c['ApiKey'], $c['api_url']);
		}
		
		$status = 'failed';
		$ret = 0;
		if ($result) {
			if (($result['msg'][0]) == 1) {
				$status = 'normal';
				$ret = 1;
			}
		}

        $return_data = array(
            'ret' => $ret,
            'status' => $status
        );
        
        ly200::e_json($return_data);
    }
?>

前端
<?php 
!isset($c) && exit();
manage::check_permit('email.config', 2);//检查权限

$row=db::get_one('config', 'GroupId="email" and Variable="Config"');
$config_row=str::json_data($row['Value'], 'decode');
?>
<!-- 新增 -->
<script>
$(function(){
    email_obj.config_init();
    $('#check_email_btn').click(function(){
        var SmtpHost = $('input[name="SmtpHost"]').val().trim();
        var SmtpPort = $('input[name="SmtpPort"]').val().trim();
        var SmtpUserName = $('input[name="SmtpUserName"]').val().trim();
        var SmtpPassword = $('input[name="SmtpPassword"]').val().trim();
        if(!SmtpUserName || !SmtpPassword || !SmtpHost || !SmtpPort){
            alert('请先填写完整的配置信息！');
            return false;
        }
        $('#check_status').html(SmtpUserName + '：检测中').css('color', '#666');   
        $.ajax({
            url: './?do_action=email.check_config',
            type: 'POST',
			dataType: 'json',
            data: {
                do_action: 'email.check_config',
                SmtpHost: SmtpHost,
                SmtpPort: SmtpPort,
                SmtpUserName: SmtpUserName,
                SmtpPassword: SmtpPassword
            },
            success: function(res){
                // console.log('后端返回数据：', res);
                var data = res.msg || {};
                var checkRet = data.ret || res.ret || 0;
                var email = data.email || SmtpUserName;
                var tipText = email + '：' + (checkRet == 1 ? '检测成功' : '检测失败');
                $('#check_status').html(tipText);
                $('#check_status').css('color', checkRet == 1 ? 'green' : 'red');
            },
            error: function(xhr, status, error){
                console.error('检测请求失败：', status, error);
                $('#check_status').html(SmtpUserName + '：检测请求失败').css('color', 'red');
            }
        });
    });
});
</script>
<!-- 新增结束 -->
<div id="email" class="r_con_wrap">
	<div class="center_container">
		<div class="big_title">{/module.email.config/}</div>
		<form id="email_form" name="email_form" class="global_form">
			<div class="rows_box">
				
				<!-- 新增 -->
				<div class="rows clean">
					<label>检测状态：</label>
					<div class="input">
						<span id="check_status">
							<?php 
							if($config_row['SmtpUserName']){ 
								echo $config_row['SmtpUserName'] . '：未检测'; 
							}else{ 
								echo '请先填写邮箱配置信息'; 
							} 
							?>
						</span>
						<input type="button" id="check_email_btn" class="btn_global btn_submit" style="margin-left:10px;" value="检测">
					</div>
				</div>
				<!-- 新增结束 -->

				<!-- 基本信息 -->
				<div class="rows clean" style="display:none;"><?php /*?> 隐藏自定义选项 <?php */?>
					<label>{/email.config.method/}</label>
					<div class="input"><input type="radio" value="0" name="Module" <?=!$config_row['Module']?'checked="checked"':'';?> />{/email.config.default/} <input type="radio" value="1" name="Module" <?=$config_row['Module']?'checked="checked"':'';?> /> {/email.config.custom_set/}</div>
				</div>
				<div class="rows clean">
					<label>{/email.config.from_email/}</label>
					<div class="input"><input name="FromEmail" value="<?=$config_row['FromEmail'];?>" type="text" class="box_input" size="30" maxlength="100" notnull /></div>
				</div>
				<div class="rows clean">
					<label>{/email.config.from_name/}</label>
					<div class="input"><input name="FromName" value="<?=$config_row['FromName'];?>" type="text" class="box_input" size="30" maxlength="100" notnull /></div>
				</div>
				<div class="rows clean module1">
					<label>{/email.config.smtp/}</label>
					<div class="input"><input name="SmtpHost" value="<?=$config_row['SmtpHost'];?>" type="text" class="box_input" size="30" maxlength="100" /></div>
				</div>
				<div class="rows clean module1">
					<label>{/email.config.port/}</label>
					<div class="input"><input name="SmtpPort" value="<?=$config_row['SmtpPort'];?>" type="text" class="box_input" size="20" maxlength="100" /></div>
				</div>
				<div class="rows clean module1">
					<label>{/email.config.email/}</label>
					<div class="input"><input name="SmtpUserName" value="<?=$config_row['SmtpUserName'];?>" type="text" class="box_input" size="30" maxlength="100" /></div>
				</div>
				<div class="rows clean module1">
					<label>{/email.config.password/}</label>
					<div class="input"><input name="SmtpPassword" value="<?=$config_row['SmtpPassword'];?>" type="password" class="box_input" size="30" maxlength="100" /></div>
				</div>
				<div class="rows clean">
					<label></label>
					<div class="input">
						<input type="button" name="submit_button" class="btn_global btn_submit" value="{/global.submit/}">
					</div>
				</div>
				<input type="hidden" name="do_action" value="email.config" />
			</div>
		</form>
	</div>
</div>


新版
<?php
	/**
     * 新增：SMTP邮箱配置检测方法
     * 用于验证SMTP服务器配置是否有效
     */
    public static function check_config(){
        global $c;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');
        manage::check_permit('email.config', 2);

		$post = array(
			'Action'		=>	'ueeshop_web_smtp_verification',
			'Number'		=>	$c['Number'],
			'SmtpHost'		=>	$p_SmtpHost,
			'SmtpPort'		=>	$p_SmtpPort,
			'SmtpUserName'	=>	$p_SmtpUserName,
			'SmtpPassword'	=>	$p_SmtpPassword
		);
		$result = ly200::api($post,$c['ApiKey'], $c['api_url']);
		
		$status = 'failed';
		$ret = 0;
		if ($result) {
			if (($result['msg'][0]) == 1) {
				$status = 'normal';
				$ret = 1;
			}
		}

        ly200::e_json(array('status'=>$status),$ret);
    }
?>
<script>
		config_init:function(){
			frame_obj.submit_form_init($('#email_form'));

			$('#check_email_btn').click(function(){
				if(global_obj.check_form($('#email_form').find('*[notnull]'), $('#email_form').find('*[format]'))){return false;} 
				$.post('./?do_action=email.check_config',$('#email_form').serialize(),function(data){
					var tipText = (data.ret == 1 ? '检测成功' : '检测失败');
					$('#check_status').html(tipText);
					$('#check_status').css('color', data.ret == 1 ? 'green' : 'red');
				},'json' )
			});
		}
</script>



<?php 
!isset($c) && exit();
manage::check_permit('email.config', 2);//检查权限

$row=db::get_one('config', 'GroupId="email" and Variable="Config"');
$config_row=str::json_data($row['Value'], 'decode');
?>
<script type="text/javascript">$(function(){email_obj.config_init();})</script>
<div id="email" class="r_con_wrap">
	<div class="center_container">
		<div class="big_title">{/module.email.config/}</div>
		<form id="email_form" name="email_form" class="global_form">
			<div class="rows_box">
				
				<!-- 新增 -->
				<div class="rows clean">
					<label>检测状态：</label>
					<div class="input">
						<span id="check_status">
							<?php 
							if($config_row['SmtpUserName']){ 
								echo $config_row['SmtpUserName'] . '：未检测'; 
							}else{ 
								echo '请先填写邮箱配置信息'; 
							} 
							?>
						</span>
						<input type="button" id="check_email_btn" class="btn_global btn_submit" style="margin-left:10px;" value="检测">
					</div>
				</div>
				<!-- 新增结束 -->

				<!-- 基本信息 -->
				<div class="rows clean" style="display:none;"><?php /*?> 隐藏自定义选项 <?php */?>
					<label>{/email.config.method/}</label>
					<div class="input"><input type="radio" value="0" name="Module" <?=!$config_row['Module']?'checked="checked"':'';?> />{/email.config.default/} <input type="radio" value="1" name="Module" <?=$config_row['Module']?'checked="checked"':'';?> /> {/email.config.custom_set/}</div>
				</div>
				<div class="rows clean">
					<label>{/email.config.from_email/}</label>
					<div class="input"><input name="FromEmail" value="<?=$config_row['FromEmail'];?>" type="text" class="box_input" size="30" maxlength="100" notnull /></div>
				</div>
				<div class="rows clean">
					<label>{/email.config.from_name/}</label>
					<div class="input"><input name="FromName" value="<?=$config_row['FromName'];?>" type="text" class="box_input" size="30" maxlength="100" notnull /></div>
				</div>
				<div class="rows clean module1">
					<label>{/email.config.smtp/}</label>
					<div class="input"><input name="SmtpHost" value="<?=$config_row['SmtpHost'];?>" type="text" class="box_input" size="30" maxlength="100" /></div>
				</div>
				<div class="rows clean module1">
					<label>{/email.config.port/}</label>
					<div class="input"><input name="SmtpPort" value="<?=$config_row['SmtpPort'];?>" type="text" class="box_input" size="20" maxlength="100" /></div>
				</div>
				<div class="rows clean module1">
					<label>{/email.config.email/}</label>
					<div class="input"><input name="SmtpUserName" value="<?=$config_row['SmtpUserName'];?>" type="text" class="box_input" size="30" maxlength="100" /></div>
				</div>
				<div class="rows clean module1">
					<label>{/email.config.password/}</label>
					<div class="input"><input name="SmtpPassword" value="<?=$config_row['SmtpPassword'];?>" type="password" class="box_input" size="30" maxlength="100" /></div>
				</div>
				<div class="rows clean">
					<label></label>
					<div class="input">
						<input type="button" name="submit_button" class="btn_global btn_submit" value="{/global.submit/}">
					</div>
				</div>
				<input type="hidden" name="do_action" value="email.config" />
			</div>
		</form>
	</div>
</div>

