<?php
/*
Template Name: Guestbook
*/
?>
<?php get_header(); ?>
<div class="pagehead"> </div>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
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
    <div class="page_nav_Title">当前位置：<a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo( 'name');?>, <?php bloginfo( 'description'); ?>">首页</a> <span>&gt;&gt;</span> 留言簿</div>
	<div class="Comment_list"><?php comments_template('/guestcomments.php',true); ?></div>

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