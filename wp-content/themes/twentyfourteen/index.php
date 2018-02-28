<?php get_header();?>

<div class="head"> </div>
<div class="index_body">
	<div class="index_left">
	    <div class="Left_img"><img src="<?php if(get_option('LoversGarden_Img_boy')){echo get_option('LoversGarden_Img_boy'); }else{echo get_bloginfo('template_directory').'/images/spring.jpg';}?>" alt="<?php bloginfo( 'name' );?> - <?php bloginfo( 'description' );?>男主人专区"/></div>
		<?php global $query_string,$boy_info,$girl_info;
		query_posts($query_string.'&author='.$boy_info->ID);
		if (have_posts()) : while (have_posts()) : the_post(); ?>
		    <ul class="indexlist">
			    <li class="title"><h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title();?></a></h2><?php if( is_sticky() ) echo '&nbsp;&nbsp;<span class="T_recom">（置顶）</span>'; ?></li>
				<li class="content">
				    <?php if (function_exists('get_first_image'))echo get_first_image($post,'boy');?>
					<?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 99,"…"); ?>
				</li>
				<li class="link"><span style="float:left;"><?php the_time('Y-m-d l'); ?></span><span style="float:right;"><?php echo getPostViews($post->ID); ?>次浏览 / <?php comments_popup_link('发表评论', '1条评论', '%条评论'); ?></span></li>
			</ul>
		<?php endwhile; else: ?>
		    <p><strong>[<?php bloginfo( 'name' );?>] 男主人的自留地!</strong></p>
			<p>男主人温馨提示：这儿没有任何内容可以展示给您!</p>
		<?php endif; ?>
		<?php wp_reset_query(); ?>
	</div>
	<div class="index_mid">
		<?php get_sidebar(); ?>
	</div>
	<div class="index_right">
	    <div class="Right_img"><img src="<?php if(get_option('LoversGarden_Img_girl')){echo get_option('LoversGarden_Img_girl'); }else{echo get_bloginfo('template_directory').'/images/Wedding.jpg';}?>" alt="<?php bloginfo( 'name' );?> - <?php bloginfo( 'description' );?>女主人专区"/></div>
		<?php query_posts($query_string.'&author='.$girl_info->ID);
		if (have_posts()) : while (have_posts()) : the_post(); ?>
		    <ul class="indexlist">
			    <li class="title"><h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title();?></a></h2><?php if( is_sticky() ) echo '&nbsp;&nbsp;<span class="T_recom">（置顶）</span>'; ?></li>
				<li class="content">
				    <?php if (function_exists('get_first_image'))echo get_first_image($post,'girl');?>
					<?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 99,"…"); ?>
				</li>
				<li class="link"><span style="float:left;"><?php the_time('Y-m-d l'); ?></span><span style="float:right;"><?php echo getPostViews($post->ID); ?>次浏览 / <?php comments_popup_link('发表评论', '1条评论', '%条评论'); ?></span></li>
			</ul>
		<?php endwhile; else: ?>
		    <p><strong>[<?php bloginfo( 'name' );?>] 女主人的自留地!</strong></p>
			<p>女主人温馨提示：这儿没有任何内容可以展示给您!</p>
		<?php endif; ?>
		<?php wp_reset_query(); ?>
	</div>
</div>
<div class="bottom_line"> </div>
<div class="Page_list">
	<?php $boy_postcount = count_user_posts( $boy_info->ID );
	$girl_postcount = count_user_posts( $girl_info->ID );
	if($boy_postcount > $girl_postcount){
		$total_postcont = $boy_postcount;
	}else{
		$total_postcont = $girl_postcount;
	}
	global $posts_per_page, $paged;
	$half_pages_to_show = 5;

	$max_page = ceil($total_postcont /$posts_per_page);
	if(empty($paged)) {$paged = 1;}
	$page_past_right = false;
	if($paged > 1) echo '<span class="pre_link"><a href="'.get_pagenum_link($paged-1).'">上一页</a></span>';
	for($i = 1; $i <= $max_page; $i++) {
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
	if($paged < $max_page) echo '<span class="next_link"><a href="'.get_pagenum_link($paged+1).'">下一页</a></span>';?>
</div>

<?php get_footer(); ?>