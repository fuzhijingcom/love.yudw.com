<div class="bottom_line2"> </div>
<div class="bottom">
    <div id="copyright">
   
<?php if (get_option('LoversGarden_copyright') <> ""){
			echo stripslashes(stripslashes(get_option('LoversGarden_copyright')));
		}else{
			echo '<p></p>';
		}?>
<a target="_blank" href="http://yudw.com/home.php?mod=space&uid=1&do=wall">申请一个我自己的爱情花园</a>
		
	</div>
	

	<?php if (get_option('LoversGarden_analytics') <> "") echo stripslashes(stripslashes(get_option('LoversGarden_analytics'))); ?>
</div>

</body>
</html>