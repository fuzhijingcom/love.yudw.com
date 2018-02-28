<?php if(get_option('LoversGarden_bgmusic_show')) {
if(get_option('LoversGarden_bgmusic_showmode')=='all'){
	$bgmusic_showmode = 'yes';
}elseif(get_option('LoversGarden_bgmusic_showmode')=='none'){
	$bgmusic_showmode = 'no';
}elseif(is_home() && ($paged < 2)){
	$bgmusic_showmode = 'yes';
}else{
	$bgmusic_showmode = 'no';
}
if(!get_option('LoversGarden_bgmusic')){
    $bgmusic_url = 'http://www.kmfhsj.com/fish-photo/music/xiaochenggushi.mp3';
}else{
    $bgmusic_url = get_option('LoversGarden_bgmusic');
}
?>
<div class="bgsound">
    <object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' width='180' height='30' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0'>
		<param name='quality' value='high' />
		<param name='wmode' value='transparent'/>
		<param name='menu' value='false'/>
		<param name='src' value='<?php bloginfo('template_directory'); ?>/js/bgmusic/player.swf?soundFile=<?php echo $bgmusic_url; ?>&amp; amp;bg=0xCDDFF3&amp;leftbg=0xff006c&amp;lefticon=0xF2F2F2&amp;rightbg=0xff006c&amp;rightbghover=0x4499EE&amp;righticon=0xF2F2F2&amp;righticonhover=0xFFFFFF&amp;text=0x017ca5&amp;slider=0xff006c&amp;track=0xFFFFFF&amp;border=0xFFFFFF&amp;loader=0x8EC2F4&amp;autostart=<?php echo $bgmusic_showmode;?>&amp;loop=yes'/>
		<embed type='application/x-shockwave-flash' width='180' height='30' src='<?php bloginfo('template_directory'); ?>/js/bgmusic/player.swf?soundFile=<?php echo $bgmusic_url; ?>&amp; amp;bg=0xCDDFF3&amp;leftbg=0xff006c&amp;lefticon=0xF2F2F2&amp;rightbg=0xff006c&amp;rightbghover=0x4499EE&amp;righticon=0xF2F2F2&amp;righticonhover=0xFFFFFF&amp;text=0x017ca5&amp;slider=0xff006c&amp;track=0xFFFFFF&amp;border=0xFFFFFF&amp;loader=0x8EC2F4&amp;autostart=<?php echo $bgmusic_showmode;?>&amp;loop=yes' wmode='transparent' quality='high'/>
	</object>
</div>
<?php } ?>

<img src='<?php bloginfo('template_directory'); ?>/sysLogo/mid<?php echo(mt_rand(1,36));?>.jpg' alt="爱情花园情侣博客随机图片"/>

<script language="javascript" type="text/javascript">
document.writeln("<iframe src=\"http://m.weather.com.cn/m/pn4/weather.htm \" width=\"160\" height=\"20\" marginwidth=\"0\" marginheight=\"0\" hspace=\"0\" vspace=\"0\" frameborder=\"0\" scrolling=\"no\"></iframe>");
</script>

<?php if(is_home() && ($paged < 2)){?>
<!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare" style="margin-left:21px;">
        <a class="bds_qzone"></a>
        <a class="bds_tsina"></a>
        <a class="bds_tqq"></a>
        <a class="bds_renren"></a>
        <span class="bds_more"></span>
		<a class="shareCount"></a>
    </div>
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;mini=1&amp;uid=224514" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
	document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?t=" + new Date().getHours();
</script>
<!-- Baidu Button END -->
<?php }?>

<div class="sidebar">
    <h2><strong>导航菜单</strong></h2>
	<div id="mainMenu" class="ddsmoothmenu">
	    <ul id="primarymenu" class="menu">
		    <li class="menu-item"><a title="<?php bloginfo('description'); ?>" href="<?php bloginfo('wpurl'); ?>/">博客首页</a></li>
		    <li class="menu-item"><a title="聚划算-精选宝贝大全" href="http://www.taobao.com/go/chn/tbk_channel/jkwt.php?pid=mm_13715572_2228389_10078497&eventid=102405" target="_blank" rel="nofollow">博客商城</a></li>
		</ul>
	</div>
	<?php if ( function_exists( 'wp_nav_menu' ) ){wp_nav_menu( array( 'theme_location' => 'main-menu', 'container_id' => 'mainMenu', 'container_class' => 'ddsmoothmenu', 'fallback_cb'=>'primarymenu') );}else{primarymenu();}?>
</div>

<div class="sidebar">
    <?php global $user_ID, $user_identity, $user_level ?>
	<?php if ( $user_ID ) : ?>
	    <h2><strong>登陆成功</strong></h2>
		<div id="mainMenu">
		<ul class="menu">
		    <li style="width:100%;clear:both;text-align:left;"><strong><?php echo $user_identity ?></strong> 成功登陆秘密花园</li>
			<?php if ( $user_level >= 1 ) : ?>
			    <li><a href="<?php bloginfo('url') ?>/wp-admin/index.php">控制面板</a></li>
				<li><a href="<?php bloginfo('url') ?>/wp-admin/post-new.php">发布文章</a></li>
			<?php endif // $user_level >= 1 ?>
			<li class="menu-item"><a href="<?php bloginfo('url') ?>/wp-admin/profile.php">个人资料</a></li>
			<li><a href="<?php echo esc_url( wp_logout_url( $_SERVER['REQUEST_URI'] ) ); ?>">安全退出</a></li>
		</ul>
		</div>
	<?php else: ?>
	    <h2><strong>登陆入口</strong></h2>
		<form action="<?php bloginfo('url') ?>/wp-login.php" method="post">
		<ul class="login">
		    <li><label for="log">园主帐户：</label><input type="text" name="log" id="log" value="<?php echo wp_specialchars(stripslashes($user_login), 1) ?>" /></li>
			<li><label for="pwd">登陆密码：</label><input type="password" name="pwd" id="pwd" /></li>
			<li><input type="submit" name="submit" value="确 定"  class="submit1">&nbsp; &nbsp;<input type="reset" value="取 消" name="Submit2" class="submit2"><input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/></li>
		</ul>
		</form>
<?php endif // get_option('users_can_register') ?>
</div>
<?php if ( is_single() ) : ?>
    <div class="sidebar">
	    <h2><strong>同类文章</strong></h2>
		<ul class="articlelist">
		    <?php $categories = get_the_category();?>
            <?php $posts = get_posts('numberposts=9&category='. $categorys[0]->term_id); foreach($posts as $post) : ?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>（<?php echo mysql2date('y年m月d日', $post->post_date); ?>）</li><?php endforeach; ?>
		</ul>
	</div>
	<div class="sidebar">
        <h2><strong>最新内容</strong></h2>
        <ul class="articlelist"><?php get_My_posts( $orderby = 'date', $plusmsg = 'post_date' ); ?></ul>
    </div>
<?php else : ?>
	<div class="sidebar">
	    <h2><strong>热点排行</strong></h2>
		<ul class="articlelist">
		<?php get_My_posts( $orderby = 'comment_count', $plusmsg = 'commentcount' ); ?>
	</div>
    <div class="sidebar">
	    <h2><strong>推荐内容</strong></h2>
		<ul class="articlelist"><?php get_My_posts( $orderby = 'rand', $plusmsg = 'post_date' ); ?></ul>
	</div>
	<div class="sidebar">
	    <h2><strong>最新评论</strong></h2>
		<ul class="Comment_list">
			<?php global $wpdb; $sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author_email, comment_author, comment_date_gmt, comment_approved, comment_type,comment_author_url,SUBSTRING(comment_content,1,30) AS com_excerpt
			FROM $wpdb->comments
			LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID)
			WHERE comment_approved = '1' AND comment_type = '' AND
			post_password = '' AND post_type = 'post'
			ORDER BY comment_date_gmt DESC
			LIMIT 6";
			$comments = $wpdb->get_results($sql);
			foreach ($comments as $comment) {?>
			    <li class='com_title'><?php echo strip_tags($comment->comment_author); ?></li>
				<li class='com_content'><?php
				global $boy_info,$girl_info,$boy_ID,$girl_ID;
				if($comment->comment_author == $boy_info->display_name){
					echo get_avatar( $boy_ID, '52', get_bloginfo('template_directory').'/face/boy.jpg', get_bloginfo( 'name' ).'男主人留言' );
				}elseif($comment->comment_author == $girl_info->display_name){
					echo get_avatar( $girl_ID, '52', get_bloginfo('template_directory').'/face/girl.jpg', get_bloginfo( 'name' ).'女主人留言' );
				}else{
					echo '<img src="'.get_bloginfo('template_directory').'/face/';
					$face_ID = preg_replace('|\D*|', '', $comment->comment_author_url);
					if(is_numeric($face_ID))
						echo $face_ID.'.gif';
					else
						echo '1.gif';
					echo '" style="width:52px;height:52px;" alt="爱情花园_自定义表情"/>';
				}?> <p><a href='<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID;?> ' title="关于: <?php echo $comment->post_title; ?>"><?php echo mb_strimwidth(strip_tags($comment->com_excerpt), 0, 52,"……");//echo strip_tags($comment->com_excerpt);?></a></p></li>
			<?php }?>
        </ul>
    </div>
<?php endif ?>
<div class="sidebar">
    <h2><strong>友情链接</strong></h2>
	<ul class="articlelist">
		<?php wp_list_bookmarks('title_li=&before=<li class="list">&categorize=0&category_name=链接表&show_images=0'); //必须在链接分类中设置“链接表”类，只有属于该分类的链接才会在首页显示…?>
	</ul>
</div>
<div class="vline" style='margin-top:12px;'>　</div>