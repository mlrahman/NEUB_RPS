<?php
	try{
		require("../includes/faculty/logged_out_auth.php");
	}
	catch(Exception $e)
	{
		header("location:index.php");
		die();
	}
?>
			<!-- Footer -->
			<div class="w3-container w3-center">
				<p class="w3-cursor w3-hide-medium w3-hide-small w3-large w3-margin">Copyright &copy <?php echo DATE("Y"); ?> <a href="https://<?php echo $web; ?>" title="NEUB" target="_blank" class="w3-hover-text-teal w3-decoration-null">North East University Bangladesh.</a></p>
				<p class="w3-cursor w3-hide-large w3-hide-small w3-medium w3-margin">Copyright &copy <?php echo DATE("Y"); ?> <a href="https://<?php echo $web; ?>" title="NEUB" target="_blank" class="w3-hover-text-teal w3-decoration-null">North East University Bangladesh.</a></p>
				<p class="w3-cursor w3-hide-medium w3-hide-large w3-small w3-margin">Copyright &copy <?php echo DATE("Y"); ?> <a href="https://<?php echo $web; ?>" title="NEUB" target="_blank" class="w3-hover-text-teal w3-decoration-null">North East University Bangladesh.</a></p>
			</div>
			
			
		</div>
		
		
	</body>
</html>		
		
<?php session_write_close(); ?>		