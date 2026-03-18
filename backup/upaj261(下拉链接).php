<?php
class action_module{

    public static function download(){//下载
        global $c;
        $status=-1;
        $DId=(int)$_GET['DId'];
        $form=$_GET['form'];//通过后台打开
        $pwd=$_GET['pwd'];//密码
        $download_row=db::get_one('download', "DId='$DId'");
        if ($download_row['Password']!=$pwd && $_GET['form']!='manage'){//判断是否需要密码下载，后台下载无需密码
            js::back();
        }
        $is_authorized = false;
        if( ($download_row['IsMember'] && (int)$_SESSION['ly200_user']['UserId']) || $_GET['form']=='manage' || !$download_row['IsMember'] ){
            $is_authorized = true;
        }
        if(!$is_authorized){
            js::back();
        }
        $cdn_domain = 'https://ueeshop-static.ly200-cdn.com/'; 
        $number_prefix = substr($c['Number'], 0, 4);
        $cdn_file_path = str_replace($c['root_path'], '', $download_row['FilePath']);
        if(!strstr($cdn_file_path, 'ly200-cdn.com')){
            $cdn_file_path = str_replace(
                '/u_file/',
                '/static/custom/' . $number_prefix . '/' . $c['Number'] . '/u_file/',
                $cdn_file_path
            );
        }
        $cdn_download_url = $cdn_domain . $cdn_file_path;
        $rename = $download_row['FileName'] ? ($download_row['FileName'].'.'.file::get_ext_name($download_row['FilePath'])): basename($download_row['FilePath']);
        header("Location: {$cdn_download_url}");
        exit();
        db::update('download', "DId='$DId'", array('ViewCount'=>$download_row['ViewCount']+1));
    }
}
