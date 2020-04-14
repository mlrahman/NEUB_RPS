
<?php
	try{
		require("../includes/super_admin/logged_out_auth.php");
	}
	catch(Exception $e)
	{
		header("location:index.php");
		die();
	}
?>
<!-- Left Column -->
<div class="w3-third w3-margin-top">
	<div class="w3-white w3-text-grey w3-card-4  w3-border w3-border-black w3-round-large" style="height:auto;max-height:603px;min-height:603px;overflow:auto;">
		
		<div class="w3-bar w3-black w3-card w3-padding">
			<a href="https://<?php echo $web; ?>" class="w3-bar-item" target="_blank" style="padding: 8px 5px;">
				<image src="../images/system/<?php echo $logo; ?>" alt="NEUB LOGO" class="w3-image" style="width:100%;max-width:30px;" id="site_logo">
			</a>
			<a href="sa_index.php" class="w3-bar-item w3-xlarge w3-decoration-null" style="padding: 8px 3px;" id="site_title"><?php echo $title; ?></a>
			
		</div>
		
		<!-- admin ID info -->
		<?php
			$stmt = $conn->prepare("select * from nr_admin where nr_admin_id=:admin_id and nr_admin_email=:admin_email and nr_admin_status='Active' and (nr_admin_type='Admin' or nr_admin_type='Super Admin') ");
			$stmt->bindParam(':admin_id', $_SESSION['admin_id']);
			$stmt->bindParam(':admin_email', $_SESSION['admin_email']);
			$stmt->execute();
			$result = $stmt->fetchAll();
			if(count($result)!=1)
				die();
			
			$photo=$result[0][5];
			$gender=$result[0][11];
			$designation=$result[0][7];
			
		?>
		<div class="w3-container w3-row w3-border w3-round-large w3-leftbar w3-rightbar" style="height: auto;margin: 20px 25px;padding: 10px 10px;">
			<p class="w3-align-left w3-text-black w3-margin-0">Welcome, </p>
			<div class="w3-col s3">
				<?php if($photo=="" && $gender=="Male"){ ?>
					<img src="../images/system/male_profile.png" id="admin_profile_image" class="w3-circle w3-margin-right w3-margin-top" style="width:100%;max-width:70px;">
				<?php } else if($photo==""){ ?>
					<img src="../images/system/female_profile.png" id="admin_profile_image" class="w3-circle w3-margin-right w3-margin-top" style="width:100%;max-width:70px;">
				<?php } else { ?>
					<img src="../images/admin/<?php echo $photo; ?>" id="admin_profile_image" class="w3-circle w3-margin-right w3-margin-top" style="width:100%;max-width:70px;">
				<?php } ?>
			</div>
			<div class="w3-col s8">
				<p class="w3-align-left w3-text-black">
					<strong><?php echo $_SESSION['admin_name']; ?></strong>
					</br><?php echo $designation; ?>
				</p>
			</div>
		</div>
		
		<div class="w3-bar-block w3-text-black" style="height: 326px;overflow:auto;margin: 20px 25px;">
			<p class="w3-bold w3-xlarge w3-text-teal w3-bottombar w3-white" style="margin:0px 0px 15px 0px;position: -webkit-sticky;   position: sticky;  top: 0; z-index:99999;"><i class="fa fa-folder-open-o"></i> Menu</p>
			<a onclick="get_page(1)" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-cursor"><i class="fa fa-dashboard"></i> Dashboard</a>
			<a onclick="get_page(2)" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top w3-cursor"><i class="fa fa-cube"></i> Departments</a>
			<a onclick="get_page(3)" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top w3-cursor"><i class="fa fa-cubes"></i> Programs</a>
			<a onclick="get_page(4)" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top w3-cursor"><i class="fa fa-book"></i> Course List</a> 
			<a onclick="get_page(5)" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top w3-cursor"><i class="fa fa-sitemap"></i> Course Offer List</a> 
			<?php if($_SESSION['admin_type']=='Super Admin'){ ?>
				<a onclick="get_page(15)" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top w3-cursor"><i class="fa fa-key"></i> Admins</a>
			<?php } ?>
			<a onclick="get_page(6)" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top w3-cursor"><i class="fa fa-id-card-o"></i> Moderators</a>
			<a onclick="get_page(7)" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top w3-cursor"><i class="fa fa-id-badge"></i> Faculties</a>
			<a onclick="get_page(8)" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top w3-cursor"><i class="fa fa-users"></i> Students</a>
			<a onclick="get_page(9)" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top w3-cursor"><i class="fa fa-database"></i> Results</a>
			<?php if($_SESSION['admin_type']=='Super Admin'){ ?>
				<a onclick="get_page(10)" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top w3-cursor"><i class="fa fa-cogs"></i> System Components</a> 
			<?php } ?>
			<a onclick="get_page(11)" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top w3-cursor"><i class="fa fa-history"></i> Result Search Records</a>
			<a onclick="get_page(12)" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top w3-cursor"><i class="fa fa-ticket"></i> Transcript Print Records</a>
			<a onclick="get_page(13)" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top w3-cursor"><i class="fa fa-unlock-alt"></i> User Login Records</a>
			<a onclick="get_page(14)" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top w3-cursor"><i class="fa fa-edit"></i> Edit Profile</a>
			<a href="log_out.php?log_out=yes" class="w3-bar-item w3-bold w3-decoration-null w3-hover-black w3-round-large w3-border-teal w3-bottombar w3-leftbar w3-margin-top"><i class="fa fa-sign-out"></i> Sign Out</a>
		</div>
		<script>
			function get_page(a)
			{
				document.getElementById('page1').style.display='none';
				document.getElementById('page2').style.display='none';
				document.getElementById('page3').style.display='none';
				document.getElementById('page4').style.display='none';
				document.getElementById('page5').style.display='none';
				document.getElementById('page6').style.display='none';
				document.getElementById('page7').style.display='none';
				document.getElementById('page8').style.display='none';
				document.getElementById('page9').style.display='none';
				<?php if($_SESSION['admin_type']=='Super Admin'){ ?>
					document.getElementById('page10').style.display='none';
				<?php } ?>
				document.getElementById('page11').style.display='none';
				document.getElementById('page12').style.display='none';
				document.getElementById('page13').style.display='none';
				document.getElementById('page14').style.display='none';
				<?php if($_SESSION['admin_type']=='Super Admin'){ ?>
					document.getElementById('page15').style.display='none';
				<?php } ?>
				if(a==1)
				{
					document.getElementById('page_title').innerHTML='<i class="fa fa-dashboard"></i> <?php echo $_SESSION["admin_type"]; ?> Dashboard';
					document.getElementById('page1').style.display='block';	
				}
				else if(a==2)
				{
					document.getElementById('page_title').innerHTML='<i class="fa fa-cube"></i> Departments';
					document.getElementById('page2').style.display='block';
				}
				else if(a==3)
				{
					document.getElementById('page_title').innerHTML='<i class="fa fa-cubes"></i> Programs';
					document.getElementById('page3').style.display='block';
				}
				else if(a==4)
				{
					document.getElementById('page_title').innerHTML='<i class="fa fa-book"></i> Course List';
					document.getElementById('page4').style.display='block';
				}
				else if(a==5)
				{
					document.getElementById('page_title').innerHTML='<i class="fa fa-sitemap"></i> Course Offer List';
					document.getElementById('page5').style.display='block';
				}
				else if(a==6)
				{
					document.getElementById('page_title').innerHTML='<i class="fa fa-id-card-o"></i> Moderators';
					document.getElementById('page6').style.display='block';
				}
				else if(a==7)
				{
					document.getElementById('page_title').innerHTML='<i class="fa fa-id-badge"></i> Faculties';
					document.getElementById('page7').style.display='block';
				}
				else if(a==8)
				{
					document.getElementById('page_title').innerHTML='<i class="fa fa-users"></i> Students';
					document.getElementById('page8').style.display='block';
				}
				else if(a==9)
				{
					document.getElementById('page_title').innerHTML='<i class="fa fa-database"></i> Results';
					document.getElementById('page9').style.display='block';
				}
				<?php if($_SESSION['admin_type']=='Super Admin'){ ?>
				else if(a==10)
				{
					document.getElementById('page_title').innerHTML='<i class="fa fa-cogs"></i> System Components';
					document.getElementById('page10').style.display='block';
				}
				<?php } ?>
				else if(a==11)
				{
					document.getElementById('page_title').innerHTML='<i class="fa fa-history"></i> Result Search Records';
					document.getElementById('page11').style.display='block';
				}
				else if(a==12)
				{
					document.getElementById('page_title').innerHTML='<i class="fa fa-ticket"></i> Transcript Print Records';
					document.getElementById('page12').style.display='block';
				}
				else if(a==13)
				{
					document.getElementById('page_title').innerHTML='<i class="fa fa-unlock-alt"></i> User Login Records';
					document.getElementById('page13').style.display='block';
				}
				else if(a==14)
				{
					document.getElementById('page_title').innerHTML='<i class="fa fa-edit"></i> Edit Profile';
					document.getElementById('page14').style.display='block';
				}
				<?php if($_SESSION['admin_type']=='Super Admin'){ ?>
				else if(a==15)
				{
					document.getElementById('page_title').innerHTML='<i class="fa fa-key"></i> Admins';
					document.getElementById('page15').style.display='block';
				}
				<?php } ?>
			}
		</script>
		
		
		
	</div>

</div>