<?php
	define('INCLUDED',1);
	include('includes/green_test.php');
	include('includes/config.php');
	include('includes/functions.php');
	include('admin/session.php');
	include('includes/html_form.php');
	$page = new stranka;
	$page->header();
?>
<div id="obsah">
	<div id="hlavicka">
		<div id="hlavicka-obsah">
			<?php $page->show_page_title() ?>
			
			<div id="language-menu">
				<?php $page->show_language_menu() ?>
			</div>
			
		</div>
	</div>
	<?php
	/*
	<div id="navbar">
		$page->show_navbar();
	</div>
	*/
	?>
	<div id="hlavnipanel">
	    	<div id="levypanel">
				<?php $page->show_menu(); ?>
			</div>

        	<div id="hlavnipanel-obsah">
        		<?php
					//print_r($_COOKIE);
					$page->show_content();
				?>
			</div>
	
			<div class="cleaner"></div>
	</div>
</div>
<div id="paticka">
	<div id="paticka-obsah">
		<?php $page->footer(); ?>
	</div>
</div>

</body>
</html>
