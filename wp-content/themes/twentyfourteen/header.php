<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php global $FunctionalClass;
    $FunctionalClass = $_GET["FunctionalClass"]?$_GET["FunctionalClass"]:"nothing";
	if ( is_home() || is_front_page() ){
		$site_description = get_bloginfo( 'description', 'display' );
		echo "$site_description - ";
	}else{
		wp_title( ' - ', true, 'right' );
	}

	global $page, $paged;
	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) echo sprintf( __( '第%s页', 'LoversGarden' ), max( $paged, $page ) ) .' - ';

	// Add the blog name.
	bloginfo( 'name' );

	?></title>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link href="<?php echo get_bloginfo('template_directory'); ?>/images/lover.ico" type="image/x-icon" rel="shortcut icon">
<?php if ( is_home() || is_front_page() ){ ?>
<base target="blank"/>
<?php }?>
</head>

<?php global $boy_info,$girl_info,$boy_ID,$girl_ID;
$err_msg = '';
$LoversGarden_updated = get_option('LoversGarden_updated');
if( !$LoversGarden_updated && current_user_can('level_10') ){
	if( !function_exists('wp_insert_user') ) include_once( ABSPATH . WPINC . '/registration.php' );
	function get_user_by_login($user_login) {
	  global $wpdb;
	  $sql = "SELECT ID FROM $wpdb->users WHERE user_login = '%s'";
	  return $wpdb->get_var($wpdb->prepare($sql, $user_login));
	}
	$userdata_boy = array(
		'user_pass' => wp_generate_password(),
		'user_login' => 'lovers_boy',
		'display_name' => '爱情花园_男主人',
		'user_email' => wp_generate_password().'@biosubway.com'
	);
	$wpuid = get_user_by_login('lovers_boy');
	if(!$wpuid){
		$wpuid = wp_insert_user($userdata_boy);
		if( is_numeric($wpuid) ){
			add_option( 'LoversGarden_boy_ID', $wpuid );
		}else{
			$err_msg .= '<p>添加男主人帐号信息失败!</p>';
		}
	}
	$userdata_girl = array(
		'user_pass' => wp_generate_password(),
		'user_login' => 'lovers_girl',
		'display_name' => '爱情花园_女主人',
		'user_email' => wp_generate_password().'@biosubway.com'
	);
	$wpuid = get_user_by_login('lovers_girl');
	if(!$wpuid){
		$wpuid = wp_insert_user($userdata_girl);
		if( is_numeric($wpuid) ){
			add_option( 'LoversGarden_girl_ID', $wpuid );
		}else{
			$err_msg .= '<p>添加女主人帐号信息失败!</p>';
		}
	}

	echo '<body><div style="width:960px;padding:60px auto;overflow:hidden;background:#fff;text-align:center;">';
	if( $err_msg ){
		die($err_msg);
	}else{
		delete_option( 'LoversGarden_updated' );
		add_option( 'LoversGarden_updated', '1' );
	    echo '<p>&nbsp;</p>
		<p style="font-size:14px;font-weight:bold;">成功生成情侣账号!</p>
		<p>男主人帐号: lovers_boy</p>
		<p>男主人密码: '.$userdata_boy['user_pass'].'</p>
		<p>&nbsp;</p>
		<p>女主人帐号: lovers_girl</p>
		<p>女主人密码: '.$userdata_girl['user_pass'].'</p>
		<p>&nbsp;</p>';
	}
	echo '</div></body></html>';
	die();
}

$boy_ID = get_option('LoversGarden_boy_ID');
$girl_ID = get_option('LoversGarden_girl_ID');
if($boy_ID != null && $boy_ID > 0){
    $boy_info = get_userdata($boy_ID); 
}
if($girl_ID != null && $girl_ID > 0){
    $girl_info = get_userdata($girl_ID); 
}
?>
<body>
<div class="topbar">
    <div class="topbar1"><p><span>男主人</span><strong><?php echo $boy_info->display_name ."</strong><br />". $boy_info->user_description; ?></p></div>
    <div class="topbar2">
    	<div class="topbar21"><img src="<?php if( get_option('LoversGarden_Ico_boy') ){
		    echo get_option('LoversGarden_Ico_boy');
		}else{
			echo get_bloginfo('template_directory').'/images/boy.gif'; 
		}?>" alt="男主人头像" /></div>
    	<div class="topbar22"><img src="<?php if( get_option('LoversGarden_Ico_girl') ){
		    echo get_option('LoversGarden_Ico_girl');
		}else{
			echo get_bloginfo('template_directory').'/images/girl.gif'; 
		}?>" alt="男主人头像" /></div>
    </div>
    <div class="topbar3"><p><strong><?php echo $girl_info->display_name ."</strong><span>女主人</span><br />". $girl_info->user_description; ?></p></div>
	<div class="topbar4"><script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/date.js"></script></div>
</div>