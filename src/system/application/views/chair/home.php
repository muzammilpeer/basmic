<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xml:lang="en-gb" xmlns="http://www.w3.org/1999/xhtml" lang="en-gb">

<head>

<?php $base = "http://localhost/basmic/"; ?>

  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="robots" content="index, follow">
  <meta name="keywords" content="FAST, FAST NUCES, BASMIC">
  <meta name="description" content="BASMIC - the Pakistani and Fastian Conference Management System">
  <meta name="generator" content="BASMIC - Pakistani Conference Management System">
  
  <title>BASMIC</title>
  
  <!--<link href="http://localhost/rollout/index.php?format=feed&amp;type=rss" rel="alternate" type="application/rss+xml" title="RSS 2.0">
  <link href="http://localhost/rollout/index.php?format=feed&amp;type=atom" rel="alternate" type="application/atom+xml" title="Atom 1.0">-->
  
  <link href="favicon2.ico" rel="shortcut icon" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo $base; ?>/Rollout_files/template.css" type="text/css">
  <link rel="stylesheet" href="<?php echo $base; ?>/Rollout_files/slimbox.css" type="text/css">
  
  <script type="text/javascript" src="<?php echo $base; ?>/Rollout_files/mootools.js"></script>
  <script type="text/javascript" src="<?php echo $base; ?>/Rollout_files/caption.js"></script>
  <script type="text/javascript" src="<?php echo $base; ?>/js/chair.js"></script>
  <script type="text/javascript">
var YtSettings = { color: 'lightblue', layout: 'left', fontDefault: 'font-small', widthDefault: 'width-wide', widthThinPx: 780, widthWidePx: 940, widthFluidPx: 0.9, heightToppanel: 320 };
  </script>
  <script type="text/javascript" src="<?php echo $base; ?>/Rollout_files/template.js"></script>

</head>

<?php $base_url = "http://localhost/basmic/"; ?>

<body id="page" class="font-small width-wide layoutleft lightblue">	
	
	<div id="page-body">
		<div class="wrapper floatholder">
		
		<div id="header">
		<div class="floatbox ie_fix_floats">
				
		<a href="<?php echo $base_url; ?>index.php/chair/" title="Home">
		<span id="logo" class="correct-png"></span></a>								
									
			<div class="toolbar1 floatbox">
			<div id="topmenu"></div>
			</div>
			
			<div class="toolbar2 floatbox">
			<!-- TOOL-BAR -->
			<?php  
			
			if ($status)
			{ 
			//echo anchor('home/profile', 'Profile | ');
			//echo anchor('home/logout', 'Logout'); 
			$email = $this->session->userdata('email');
			echo " Welcome, ".$email;
			echo "<table align='right'><tr><td><b>".anchor('chair/conf_reg','Register a Conference')."</b></td></tr></table>";	
			}
			else
			{
			//echo anchor('home/profile', 'Profile | ');			 
			//echo anchor('home/register', 'Register | ');
			//echo anchor('home/login', 'Login');	
			echo "<table align='right'><tr><td><b>".anchor('chair/conf_reg','Register a Conference')."</b></td></tr></table>";		
			}
			?>
			</div>
					
			</div>
		</div>
			
		<div id="middle">
			<div class="background">
				<div id="left">
					<div id="left_container" class="clearingfix">
						<div class="left-m">
							<div class="left-t">
								<div class="left-b">
								<div class="moduletable_menu">
								<h3>Main Menu</h3>
								<ul class="menu">
								<li class="level1 item1 first last active current">
								<a href="<?php echo $base_url; ?>index.php/chair/" class="level1 item1 first last active current">
								<span>Home</span></a></li>
<?php  
			
if ($status)
{ 								
	echo '<li class="level1 item1 first last active current">';
	echo '<a href="'.$base_url.'index.php/chair/profile" class="level1 item1 first last active current">';
	echo '<span>Profile</span></a></li>';
	
	echo '<li class="level1 item1 first last active current">';
	echo '<a href="'.$base_url.'index.php/chair/user" class="level1 item1 first last active current">';
	echo '<span>User Management</span></a></li>';
	
	echo '<li class="level1 item1 first last active current">';
	echo '<a href="'.$base_url.'index.php/chair/paper" class="level1 item1 first last active current">';
	echo '<span>Paper Management</span></a></li>';
	
	echo '<li class="level1 item1 first last active current">';
	echo '<a href="'.$base_url.'index.php/chair/reviewer" class="level1 item1 first last active current">';
	echo '<span>Reviewer Management</span></a></li>';
	
	echo '<li class="level1 item1 first last active current">';
	echo '<a href="'.$base_url.'index.php/chair/att_reg" class="level1 item1 first last active current">';
	echo '<span>Attend Conference</span></a></li>';
	
	echo '<li class="level1 item1 first last active current">';
	echo '<a href="'.$base_url.'index.php/chair/history" class="level1 item1 first last active current">';
	echo '<span>History</span></a></li>';
	
	echo '<li class="level1 item1 first last active current">';
	echo '<a href="'.$base_url.'index.php/chair/logout" class="level1 item1 first last active current">';
	echo '<span>Logout</span></a></li>';
}
else
{
	//echo '<li class="level1 item1 first last active current">';
	//echo '<a href="'.$base_url.'index.php/home/profile" class="level1 item1 first last active current">';
	//echo '<span>Profile</span></a></li>';
	
	echo '<li class="level1 item1 first last active current">';
	echo '<a href="'.$base_url.'index.php/chair/register" class="level1 item1 first last active current">';
	echo '<span>Register</span></a></li>';
	
	echo '<li class="level1 item1 first last active current">';
	echo '<a href="'.$base_url.'index.php/home/att_reg" class="level1 item1 first last active current">';
	echo '<span>Attend Conference</span></a></li>';
	
	echo '<li class="level1 item1 first last active current">';
	echo '<a href="'.$base_url.'index.php/chair/login" class="level1 item1 first last active current">';
	echo '<span>Login</span></a></li>';
	
}
	
?>

								</ul>		
								</div>
								</div>
								</div>
							</div>
							
						</div>
					</div>
								
				<div id="main">
					<div id="main_container" class="clearingfix">							
						<div id="mainmiddle" class="floatbox withoutright">												
							<div id="content">
								<div id="content_container" class="clearingfix">
									<div class="floatbox">
																				
										<div class="componentheading"><!--BASMIC--></div>
										<table class="blog" cellpadding="0" cellspacing="0">
										<tbody>
										<tr><td valign="top">
											<div id="content">
	                								<?php echo $this->session->flashdata('message'); ?>
													<?php echo validation_errors(); ?>
													<?php echo $content."\n" ?>
            										</div>
										</td></tr>
										</tbody>
										</table>
										</div>

									</div>
								</div>
							</div>							
						</div>
					</div>				
				</div>
			</div> <!-- <div class="background"> -->

		</div>
		</div> <!-- <div id="middle"> -->
			
	<div id="page-footer">
		<div class="wrapper floatholder">		
			<div id="footer"></div>
		</div>
	</div>

<div style="visibility: hidden; opacity: 0;" id="lbOverlay"></div>

<div style="width: 250px; height: 250px; margin-left: -125px; display: none;" id="lbCenter">
	<div id="lbImage">
	<a style="display: none;" href="#" id="lbPrevLink"></a>
	<a style="display: none;" href="#" id="lbNextLink"></a>
	</div>
</div>

<div style="display: none;" id="lbBottomContainer">
	<div id="lbBottom">
	<a href="#" id="lbCloseLink"></a>
	<div id="lbCaption"></div>
	<div id="lbNumber"></div>
	<div style="clear: both;"></div>
	</div>
</div>

</body>
</html>
