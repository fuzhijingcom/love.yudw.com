<?php
/*******************************
 PHP5以后时间纠正方法
********************************/
if(date_default_timezone_get() != "1Asia/Shanghai") date_default_timezone_set("Asia/Shanghai");
/**************************************************************
 去除版本提示功能 // kill the admin nag
***************************************************************/
add_action('init', create_function('$a', "remove_action('init', 'wp_version_check');"), 2);
add_filter('pre_option_update_core', create_function('$a', "return null;"));

/*******************************
Plugin Name: 去掉作者链接
********************************/
function remove_comment_links() {
    global $comment;
	$url = get_comment_author_url();
	$author = get_comment_author();
	if ( empty( $url ) || 'http://' == $url )
		$return = $author;
	else
		$return = $author;
	return $return;
}
add_filter('get_comment_author_link', 'remove_comment_links');
/*******************************
Plugin Name: 自定义头像
********************************/
//头像地址, %s表示图像号码
$LoversGardenFace_url = get_bloginfo('template_directory').'/face/%s.gif';
//单独指定头像的大小, false or integer
$LoversGardenFace_size = false;

add_filter('get_avatar', 'LoversGardenFace', 10, 3);
function LoversGardenFace($a, $i, $size) {
	global $LoversGardenFace_url, $LoversGardenFace_size;
	if ( !is_object($i) )
		return $a;
	global $boy_info,$girl_info,$boy_ID,$girl_ID;
	if($i->comment_author == $boy_info->display_name){
		return $a;
	}elseif($i->comment_author == $girl_info->display_name){
		return $a;
	}elseif ( isset($i->comment_author_url) && preg_match('/^(http:\/\/)?[1-9][0-9]*$/i', $i->comment_author_url) ) {
		$qq = preg_replace('|\D*|', '', $i->comment_author_url);
		$a = preg_replace('/src=\'[^\']*\'/',
			'src=\'' . str_replace('%s', $qq, $LoversGardenFace_url) . '\'',
			$a);
		if( $LoversGardenFace_size )
			$a = str_replace('\'' . $size . '\'', '\'' . $LoversGardenFace_size . '\'', $a);
		return $a;
	}
/*
	if ( isset($i->comment_author_url) && preg_match('/^(http:\/\/)?[1-9][0-9]*$/i', $i->comment_author_url) ) {
		$qq = preg_replace('|\D*|', '', $i->comment_author_url);
		$a = preg_replace('/src=\'[^\']*\'/',
			'src=\'' . str_replace('%s', $qq, $LoversGardenFace_url) . '\'',
			$a);
		if( $LoversGardenFace_size )
			$a = str_replace('\'' . $size . '\'', '\'' . $LoversGardenFace_size . '\'', $a);
		return $a;
	}
*/
	return $a;
}

/*******************************
 文章浏览计数器（显示文章浏览次数）
 需要显示的位置添加：echo getPostViews(get_the_ID());
 每篇文章的主循环加：setPostViews(get_the_ID());
********************************/
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}
 
function setPostViews($postID) {
    $count_key = 'post_views_count';
	$ViewedIDlist = $_COOKIE['ThisIDisViewed'];
	$ViewidIsNull = False; //文章是否已阅读变量，为True时表示需要涮新阅读量
	if(empty($ViewedIDlist)){
		$ViewidIsNull = True;
	}else{
		$ViewidIsNull = True;
		$ViewedIDarr =  explode("[+]",$ViewedIDlist);
		for($i=0; $i<count($ViewedIDarr); $i++){
		    if($ViewedIDarr[$i] == $postID)
			    $ViewidIsNull = False;
		}
	}
    if($ViewidIsNull){
		$count = get_post_meta($postID, $count_key, true);
	    if($count==''){
	        $count = 1;
	        delete_post_meta($postID, $count_key);
	        add_post_meta($postID, $count_key, $count);
	    }else{
	        $count++;
	        update_post_meta($postID, $count_key, $count);
	    }
		if(empty($ViewedIDlist))
		    setcookie('ThisIDisViewed',$postID,time()+21600);
		else
		    setcookie('ThisIDisViewed',$ViewedIDlist.'[+]'.$postID,time()+21600);
	}
}

/*******************************
 MENUS SUPPORT （导航菜单）
********************************/
if ( function_exists( 'wp_nav_menu' ) ){
	if (function_exists('add_theme_support')) {
		add_theme_support('nav-menus');
		add_action( 'init', 'register_my_menus' );
		function register_my_menus() {
			register_nav_menus(array('main-menu' => __( '导航菜单' )));
		}
	}
}

/* CallBack functions for menus in case of earlier than 3.0 Wordpress version or if no menu is set yet*/

function primarymenu(){ ?>
    <div id="mainMenu" class="ddsmoothmenu">
	    <ul id="primarymenu" class="menu">
		    <li class="menu-item"><a title="爱情花园情侣博客主题设置详细信息" href="http://www.ilovejia.com/?cat=13" target="_blank">主题设置</a></li>
		</ul>
	</div>
<?php }

/*******************************
 THUMBNAIL SUPPORT (缩略图)
********************************/
/*
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
}
/* 实现可以指定两种不同的缩略图尺寸：
add_image_size('thumbnail', 140, 100, true);
add_image_size('show', 400, 248, true);
显示代码：

if (has_post_thumbnail()) { the_post_thumbnail(); } 
if (has_post_thumbnail()) { the_post_thumbnail('thumbnail'); } 
if (has_post_thumbnail()) { the_post_thumbnail('show'); } 

the_post_thumbnail();                  // without parameter -&gt; Thumbnail
the_post_thumbnail('thumbnail');       // Thumbnail (default 150px x 150px max)
the_post_thumbnail('medium');          // Medium resolution (default 300px x 300px max)
the_post_thumbnail('large');           // Large resolution (default 640px x 640px max)
the_post_thumbnail( array(100,100) );  // Other resolutions 
*/ 

/*******************************
 自动获取文章第1张图为前台缩略图
********************************/
function get_first_image($post, $seximg){
	$PostContent = $post->post_content;
	preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i', $PostContent, $PostImg);
	$ImgNumber = count($PostImg[0]);
	$ImgShowDefault = 1;
	if($seximg != 'boy' && $seximg != 'girl') $seximg = 'boy';

	$output .=  '<div class="archive_thumbnail"><a href="'.get_permalink($post->ID).'" title="'.wptexturize($post->post_title).'"><img src="';
    if($ImgNumber > 0){
    	for($i=0;$i<=$ImgNumber;$i++){
    		$img_src=$PostImg[1][$i];
    		if(img_exists($img_src)){ //第一个有效图片
    			if (eregi("flickr.com",$img_src)){ $img_url = str_replace(".jpg", "_s.jpg", $img_src); }else{ $img_url=$img_src; }
    			$output .=  $img_url;
				$ImgShowDefault = 0;
				break;//退出循环
				//continue;//终止当前循环
    		}
    	}
	}
	if($ImgShowDefault){
	    $output .= get_bloginfo('template_directory') . '/images/'.$seximg.'.gif';
	}
	$output .=  '"/></a></div>';
	return $output;
} 
//PHP判断远程图片是否存在
function img_exists($url){
	$head=@get_headers($url);
	if(!is_array($head)) return false;
	if(file_get_contents($url,0,null,0,1))
		return 1;
	else
		return 0;
}


/*******************************
最新日志 get_My_posts( $orderby = 'date', $plusmsg = 'post_date' );
热评日志 get_My_posts( $orderby = 'comment_count', $plusmsg = 'commentcount' );
随机日志 get_My_posts( $orderby = 'rand', $plusmsg = 'post_date' );
********************************/
function get_My_posts($orderby = '', $plusmsg = '') {
    $get_My_posts = query_posts('showposts=9&ignore_sticky_posts=1&orderby='.$orderby);
    foreach ($get_My_posts as $get_post) {
            $output = '';
            $post_date = mysql2date('y年m月d日', $get_post->post_date);
            $commentcount = $get_post->comment_count.' 条评论';
            $post_title = htmlspecialchars(stripslashes($get_post->post_title));
            $permalink = get_permalink($get_post->ID);
            $output .= '<li><a href="' . $permalink . '" title="'.$post_title.'">' . $post_title . '</a>（'.$$plusmsg.'）</li>';
            echo $output;
        }
    wp_reset_query();
}

/*******************************
 PAGINATION（分页功能2）
********************************/
function wp_pagenavi($before='', $after='', $prelabel='上一页', $nxtlabel='下一页', $pages_to_show=9, $always_show=false) {
    global $request, $posts_per_page, $wpdb, $paged;
	if(empty($prelabel)) {$prelabel = '&laquo;';}
	if(empty($nxtlabel)) {$nxtlabel = '&raquo;';} 
	$half_pages_to_show = round($pages_to_show/2);
	if (!is_single()) {
		if(!is_category()) {
			preg_match('#FROM\s(.*)\sORDER BY#siU', $request, $matches); 
		}else{
			preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches); 
		}
		$fromwhere = $matches[1];
		$numposts = $wpdb->get_var("SELECT COUNT(DISTINCT ID) FROM $fromwhere");
		$max_page = ceil($numposts /$posts_per_page);
		if(empty($paged)) {$paged = 1;}
		if($max_page > 1 || $always_show) {
			echo"$before<span class='pre_link'>"; 
//			if ($paged >= ($pages_to_show-1)) {
//				echo'<a href="'.get_pagenum_link(1).'">首页</a> ' ;  
//			}
			previous_posts_link($prelabel); 
			echo"</span>";
			$page_past_right = false;
			for($i = $paged - $half_pages_to_show; $i <= $paged + $half_pages_to_show; $i++) {
				if ($i >= 1 && $i <= $max_page/2) {
					if($i == $paged) {
						echo "<span class='List_currentpage'>$i</span>";
						$page_past_right = true;
					}else{
						if($page_past_right){
						    echo'<a href="'.get_pagenum_link($i).'"><span class="List_page_2">'.$i.'</span></a>';
						}else{
						    echo'<a href="'.get_pagenum_link($i).'"><span class="List_page_1">'.$i.'</span></a>';
						}
					}
				}
			}
			echo"<span class='next_link'>";
			next_posts_link($nxtlabel, $max_page/2);
//			if (($paged+$half_pages_to_show) < ($max_page)) {
//				echo ' <a href="'.get_pagenum_link($max_page).'">尾页</a>'; 
//			}
			echo "</span>$after";
		}
	}
}

/**************************************************************
 用户下拉表单<option>选项
***************************************************************/
function Users_dropdown($user_select){
   $blogusers = get_users();
   $output = '';
   foreach ($blogusers as $user) {
        $output .= '
		<option value="' . $user->ID .'"';
		if($user_select == $user->ID) $output .= ' selected ';
		 $output .= '>' . $user->display_name . '</option>';
   }
   return $output;
}

/*******************************
  THEME OPTIONS PAGE（主题选项）
********************************/

add_action('admin_menu', 'LoversGarden_theme_page');
function LoversGarden_theme_page ()
{
	if ( count($_POST) > 0 && isset($_POST['LoversGarden_settings']) )
	{
		$options = array ('boy_ID', 'girl_ID', 'Img_boy', 'Img_girl', 'Ico_boy', 'Ico_girl', 'bgmusic', 'bgmusic_show', 'bgmusic_showmode', 'analytics', 'copyright');

		foreach ( $options as $opt ){
			delete_option ( 'LoversGarden_'.$opt, $_POST[$opt] );
			add_option ( 'LoversGarden_'.$opt, $_POST[$opt] );	
		}			
		 
	}
	add_menu_page(__('花园设置'), __('花园设置'), 'edit_themes', basename(__FILE__), 'LoversGarden_settings');
	add_submenu_page(__('花园设置'), __('花园设置'), 'edit_themes', basename(__FILE__), 'LoversGarden_settings');
}
function LoversGarden_settings()
{?>
<div class="wrap">
	<h2>爱情花园主题（LoversGarden）控制面版</h2>
<form method="post" action="">
	<fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
	<legend style="margin-left:5px; padding:0 5px;color:#2481C6; text-transform:uppercase;"><strong>个性化设置</strong></legend>
	<table class="form-table">
		<!-- General settings -->
		<tr valign="top">
			<th scope="row"><label for="boy_ID">男主人（*）</label></th>
			<td>
				<select name="boy_ID" id="boy_ID" class="regular-select"><option> - 选择 - </option><?php echo Users_dropdown(get_option('LoversGarden_boy_ID')); ?></select>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="Ico_boy">头像网址（男）</label></th>
			<td>
				<input name="Ico_boy" type="text" id="Ico_boy" value="<?php echo get_option('LoversGarden_Ico_boy'); ?>" class="regular-text" style="width:520px;"/>（可以不填）<br />页面顶部男主人头像( 60 x 60 )
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="Img_boy">图片网址（男）</label></th>
			<td>
				<input name="Img_boy" type="text" id="Img_boy" value="<?php echo get_option('LoversGarden_Img_boy'); ?>" class="regular-text" style="width:520px;"/>（可以不填）<br />首页和分类页显示在男主人文章顶部的图片( 336 x 252 )
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="girl_ID">女主人（*）</label></th>
			<td>
				<select name="girl_ID" id="girl_ID" class="regular-select"><option> - 选择 - </option><?php echo Users_dropdown(get_option('LoversGarden_girl_ID')); ?></select>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="Ico_girl">头像网址（女）</label></th>
			<td>
				<input name="Ico_girl" type="text" id="Ico_girl" value="<?php echo get_option('LoversGarden_Ico_girl'); ?>" class="regular-text" style="width:520px;"/>（可以不填）<br />页面顶部女主人头像( 60 x 60 )
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="Img_girl">图片网址（女）</label></th>
			<td>
				<input name="Img_girl" type="text" id="Img_girl" value="<?php echo get_option('LoversGarden_Img_girl'); ?>" class="regular-text" style="width:520px;"/>（可以不填）<br />首页和分类页显示在女主人文章顶部的图片( 336 x 252 )
			</td>
		</tr>
	</table>
	</fieldset>
	
	<fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
	<legend style="margin-left:5px; padding:0 5px;color:#2481C6; text-transform:uppercase;"><strong>背景音乐设置</strong></legend>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="bgmusic">背景音乐网址</label></th>
			<td>
				<input name="bgmusic" type="text" id="bgmusic" value="<?php echo get_option('LoversGarden_bgmusic'); ?>" class="regular-text" style="width:520px;"/> * 请填写音乐文件完整链接，只支持MP3格式的音乐！
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="bgmusic_show">是否开启</label></th>
			<td>
				<input name="bgmusic_show" type="radio" id="bgmusic_show" value="show" class="regular-radio" <?php if(get_option('LoversGarden_bgmusic_show'))echo 'checked'; ?>/> 开启背景音乐功能&nbsp;
				<input name="bgmusic_show" type="radio" id="bgmusic_show" value="" class="regular-radio" <?php if(!get_option('LoversGarden_bgmusic_show'))echo 'checked'; ?>/> 关闭背景音乐功能
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="bgmusic_showmode">播放模式</label></th>
			<td>
				<input name="bgmusic_showmode" type="radio" id="bgmusic_showmode" value="" class="regular-radio" <?php if(!get_option('LoversGarden_bgmusic_showmode'))echo 'checked'; ?>/> 首页自动播放&nbsp;
				<input name="bgmusic_showmode" type="radio" id="bgmusic_showmode" value="all" class="regular-radio" <?php if(get_option('LoversGarden_bgmusic_showmode')=='all')echo 'checked'; ?>/> 全站自动播放&nbsp;
				<input name="bgmusic_showmode" type="radio" id="bgmusic_showmode" value="none" class="regular-radio" <?php if(get_option('LoversGarden_bgmusic_showmode')=='none')echo 'checked'; ?>/> 全站手动播放
			</td>
		</tr>
	</table>
	</fieldset>

    <fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
	<legend style="margin-left:5px; padding:0 5px; color:#2481C6;text-transform:uppercase;"><strong>优化设置</strong></legend>
		<table class="form-table">
        <tr>
			<th><label for="copyright">版权说明【CopyRight】</label></th>
			<td>
				<textarea name="copyright" id="copyright" rows="4" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('LoversGarden_copyright')); ?></textarea><br />
				<em>允许使用HTML代码！</em>
			</td>
		</tr>
		<tr>
			<th><label for="analytics">统计代码</label></th>
			<td>
				<textarea name="analytics" id="analytics" rows="7" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('LoversGarden_analytics')); ?></textarea>
			</td>
		</tr>
	</table>
	</fieldset>
	<p class="submit">
		<input type="submit" name="Submit" class="button-primary" value="保存更改" />
		<input type="hidden" name="LoversGarden_settings" value="save" style="display:none;" />
	</p>
</form>
</div>
<?php }?>