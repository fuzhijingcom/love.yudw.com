<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
      if ( post_password_required() ) { ?>
		<p class="nocomments">您需要输入密码后才能访问.</p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->
<?php if ( have_comments() ) : ?>
    <h3 id="comments"> <?php comments_number('网友', '现有1条', '现有%条' );?>留言</h3>
	<ol class="commentlist">
	    <?php wp_list_comments('type=comment&avatar_size=50'); ?>
	</ol>
	<div class="comnavi">
	    <div class="alignleft"><?php previous_comments_link('上一页') ?></div>
		<div class="alignright"><?php next_comments_link('下一页') ?></div>
	</div>

	<?php if ( !empty($comments_by_type['pings']) ) :  ?>
	    <div id="pings">
		    <h3>Trackbacks / Pingback</h3>
			<ol class="commentlist">
			    <?php wp_list_comments('type=pings&callback=pings'); ?>
			</ol>
		</div>
	<?php endif; ?>
<?php else : // this is displayed if there are no comments so far ?>
    <?php if ('open' == $post->comment_status) : ?>
	    <!-- If comments are open, but there are no comments. -->
	<?php else : // comments are closed ?>
	    <!-- If comments are closed. -->
	    <p class="nocomments">留言功能已关闭.</p>
	<?php endif; ?>
<?php endif; ?>

<?php if ('open' == $post->comment_status) : ?>
    <div id="respond">
	<h3 id="leave">发表留言</h3>
	<div class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></div>
	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	    <p>您必须<a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">登录</a> 后才可留言.</p>
	<?php else : ?>
	    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		<?php if ( $user_ID ) : ?>
		    <p>用户<a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>已登录. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">退出 &raquo;</a></p>
		<?php else : ?>
		    <?php if ( $comment_author != "" ) : ?>
			    <script type="text/javascript">function setStyleDisplay(id, status){document.getElementById(id).style.display = status;}</script>
				<div class="form_row">
				    <?php printf(__('欢迎再次光临 <strong>%s</strong>.'), $comment_author) ?>
					<span id="show_author_info"><a href="javascript:setStyleDisplay('author_info','');setStyleDisplay('show_author_info','none');setStyleDisplay('hide_author_info','');">更改用户名</a></span>
					<span id="hide_author_info"><a href="javascript:setStyleDisplay('author_info','none');setStyleDisplay('show_author_info','');setStyleDisplay('hide_author_info','none');">取消更改</a></span>
				</div>
		    <?php endif; ?>
			<div id="author_info">
			    <div class="author_left" id="author_left">
				    <p><label for="author">昵称 <?php if ($req) echo "(*)"; ?></label><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> /></p>
		    		<p><label for="email">Mail <?php if ($req) echo "(*)"; ?></label><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> /></p>
		    	</div>
		    	<div class="author_right">
		    	    <script language="javascript">var MENUID=1;var ImgValue="";function TAB(){if(MENUID<12){MENUID=MENUID+1;ImgValue=""+MENUID}else{MENUID=1;ImgValue="1"}eval("document.getElementById('faceImg').src='<?php bloginfo('template_directory'); ?>/face/"+ImgValue+".gif';");eval("document.getElementById('url').value='"+ImgValue+"';")}</script>
		    		<img src="<?php bloginfo('template_directory'); ?>/face/1.gif" alt="表情/头像" id="faceImg" onclick="TAB()" title="点击图片可更换（表情/头像）!"/>点击头像可更换！<input name="url" id="url" value="1" style="display:none;"/>
		    	</div>
		    </div>

		    <?php if ( $comment_author != "" ) : ?>
			    <script type="text/javascript">setStyleDisplay('hide_author_info','none');setStyleDisplay('author_info','none');</script>
		    <?php endif; ?>
		<?php endif; ?>

		<p><label for="comment">内容</label><textarea name="comment" id="comment" cols="45" rows="15" tabindex="4"></textarea></p>
		<p><input name="submit" type="submit" id="submit" tabindex="5" value="提交 Ctrl+Enter" /><?php comment_id_fields(); ?></p>
		<?php do_action('comment_form', $post->ID); ?>
	    </form>
		<script type="text/javascript">document.getElementById("comment").onkeydown = function (moz_ev) { var ev = null; if (window.event){ ev = window.event;     }else{ev = moz_ev;} if (ev != null && ev.ctrlKey && ev.keyCode == 13){document.getElementById("submit").click();} }</script>
	</div>
<?php endif; // If registration required and not logged in ?>
<?php endif; // if you delete this the sky will fall on your head ?>