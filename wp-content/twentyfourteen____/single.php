<?php get_header(); ?>
<div class="pagehead"> </div>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php setPostViews(get_the_ID()); //添加文章浏览计数器 ?>
	<?php if ($post->post_author == $boy_ID) { ?>
        <div id="boy_body">
		    <!-- Begin #colLeft -->
		    <div class="body_left">
	<?php }else{ ?>
        <div id="girl_body">
		    <!-- Begin #colLeft -->
		    <div class="body_left">
		        <?php get_sidebar(); ?>
			</div>
			<div class="body_right">
	<?php }?>
    <div class="page_nav_Title">当前位置：<a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo( 'name');?>, <?php bloginfo( 'description'); ?>">首页</a> <span>&raquo;</span> <?php $categorys = get_the_category(); $category = $categorys[0];echo(get_category_parents($category->term_id,true,'  <span>&raquo;</span>  ')); ?>正文</div>
	<ul class="Article_content">
	    <li class="Title"><h1><?php the_title(); ?></h1></li>
		<li class="Art_info"><?php the_author(); ?>&nbsp;/&nbsp;<?php the_date('Y年m月d日'); ?>&nbsp;/&nbsp;浏览：<?php echo getPostViews($post->ID); ?> 人次&nbsp;/&nbsp;<span><?php comments_popup_link('发表评论', '1条评论', '%条评论'); ?></span></li>
	<li class="bdshare"><!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
        <a class="bds_qzone"></a>
        <a class="bds_tsina"></a>
        <a class="bds_tqq"></a>
        <a class="bds_renren"></a>
        <span class="bds_more">更多</span>
		<a class="shareCount"></a>
    </div>
    <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=38631" ></script>
    <script type="text/javascript" id="bdshell_js"></script>
    <script type="text/javascript">
        document.getElementById("bdshell_js").src = "http://share.baidu.com/static/js/shell_v2.js?t=" + new Date().getHours();
    </script>
<!-- Baidu Button END --></li>
		<li class="Content"><?php the_content(__('read more')); ?><p class="postTags"><?php the_tags(); ?></p></li>
	</ul>
	<div class="Comment_list"><?php comments_template('',true); ?></div>

    </div>
	<?php if ($post->post_author == $boy_ID) { ?>
		<div class="body_right">
		    <?php get_sidebar(); ?>
		</div>
	<?php }?>
	</div>
<?php endwhile; else: ?>
    <p>Sorry, 您查看的内容不存在或者已经删除！</p>
<?php endif; ?>

<?php get_footer(); ?>