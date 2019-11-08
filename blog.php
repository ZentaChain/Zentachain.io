<?php
	define("BASEPATH", gethostbyaddr($_SERVER['REMOTE_ADDR']));
	require("connect.php");
	error_reporting(0);

	if($_GET['year'] != NULL && $_GET['month'] != NULL){
		$yr = preg_replace("/[^0-9]/", "", $_GET['year']);
		$mt = preg_replace("/[^0-9]/", "", $_GET['month']);
		if(is_numeric($yr) && is_numeric($mt)){
			if($mt > 12){
				header("location: blog.php");
			}else{
				$query="SELECT * FROM articles WHERE YEAR(postdate) = $yr AND MONTH(postdate) = $mt ORDER BY postdate DESC";
			}
		}else{
			header("location: blog.php");
		}
	}else if($_GET['category'] != NULL){
		$cate = preg_replace("/[^a-zA-Z0-9]/", "", $_GET['category']);
		$query = "SELECT * FROM articles WHERE status='publish' AND category LIKE '%$cate%' ORDER BY postdate DESC";
	}else if($_GET['searchbox'] != NULL){
		$datatitle = $_GET['searchbox'];
		$query = "SELECT * FROM articles WHERE status='publish' AND title LIKE '%$datatitle%' ORDER BY postdate DESC";
	}else{
		$query = "SELECT * FROM articles WHERE status='publish' ORDER BY postdate DESC";
	}

	$getData = mysqli_query($db,$query);
	$per_page =10;
	$count = mysqli_num_rows($getData);
	$pages = ceil($count/$per_page);

	if($_GET['page'] != NULL){
		$page=preg_replace("/[^0-9]/", "", $_GET['page']);
		if(!is_numeric($page)){
			header("location: blog.php");
		}
	}else{
		$page=1;
	}
	$start = ($page - 1 ) * $per_page;
	$query = $query." LIMIT $start,$per_page";

	$query2=mysqli_query($db,$query);

?>
<!DOCTYPE html>

<html class="no-js" lang="en">

<head>

	<?php
		$title = "Zentachain news - full of stuff";
		$publisher = "Harun Kacemer";
		$description = "(ζ)Zentachain is a decentralized high-throughput blockchain ecosystem, designed for secure with anonymous communication and data storage.(ζ)";
		$copyright = "Zentachain";
		$pagetopic = "Blockchain Services";
		$language = "English";
		$coverage = "Worldwide";
		$pagetype = "Blockchain";
		$keywords = "Zentachain, Zenta, Blockchain, Ethereum, Cloud, Zentalk, Zentavault, Crypto, Polkadot, Bitcoin, Dpos, Whatsapp";
		$ogtitle = "The Future of Blockchain for Data protection and Communication";
		$ogurl = "https://zentachain.io";
		$ogtype = "website";
		$ogimg = "https://zentachain.io/News-Images/og-image.jpg";

		$twnamedescription = "Zentachain";
		$twnamesite = "https://twitter.com/Zentachain";
		
		require "meta.php";
	?>
	<!-- Web Fonts 
	================================================== -->
	<link href="https://fonts.googleapis.com/css?family=Muli:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;subset=latin-ext,vietnamese" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
	
	<!-- CSS
	================================================== -->
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="css/font-awesome.min.css"/>
	<link rel="stylesheet" href="css/animsition.min.css"/>
	<link rel="stylesheet" href="css/swiper.min.css"/>
	<link rel="stylesheet" href="css/style.css"/>
			
	<link rel="icon" type="image/png" href="favicon-zentachain.png">
	<link rel="apple-touch-icon" href="zentachain-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="zentachain-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="zentachain-touch-icon-114x114.png">
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-123666404-1"></script>

	
</head>
<!-- <body></body> -->
<body>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v4.0&appId=355393081283908&autoLogAppEvents=1"></script>


	<!-- Page preloader wrap
	================================================== -->

	<div class="animsition">	
		
		<!-- Nav and Logo
		================================================== -->

		<header class="cd-header">
			<div class="header-wrapper">
				<div class="logo-wrap">
					<a href="index.html" class="hover-target animsition-link"><img src="img/logo.png" alt=""></a>
				</div>
				<div class="nav-but-wrap">
					<div class="menu-icon hover-target">
						<span class="menu-icon__line menu-icon__line-left"></span>
						<span class="menu-icon__line"></span>
						<span class="menu-icon__line menu-icon__line-right"></span>
					</div>					
				</div>					
			</div>				
		</header>

		<div class="nav">
			<div class="nav__content">
				<div class="curent-page-name-shadow">Z-News</div>
				<ul class="nav__list">
					<li class="nav__list-item"><a data-toggle="collapse" href="#collapseSub" class="hover-target" role="button" aria-expanded="false" aria-controls="collapseSub">Products</a>
						<ul class="sub-links collapse" id="collapseSub">
							<li><a href="http://www.zentalk.chat/" class="hover-target animsition-link">Zentalk-Web</a></li>
							<li><a href="https://zentachain.io/zentaswap" class="hover-target animsition-link">Zentaswap</a></li>
							<li><a href="zentalkApp.html" class="hover-target animsition-link">Zentalk-Mobile</a></li>
							<li><a href="https://zentachain.io/zentawallet.html" class="hover-target animsition-link">Zentawallet</a></li>
						</ul>
					</li>
					<li class="nav__list-item"><a href="kyc.html" class="hover-target animsition-link">KYC-Point</a></li>
					<li class="nav__list-item"><a href="index.html" class="hover-target animsition-link">Our Partners</a></li>
					<li class="nav__list-item active-nav"><a href="blog.php" class="hover-target animsition-link">News</a></li>
					<li class="nav__list-item"><a href="contact.html" class="hover-target animsition-link">Contact</a></li>
				</ul>
			</div>
		</div>	

		<!-- Primary Page Layout
		================================================== -->

		<?php
			$check = mysqli_num_rows($getData);
			$check2 = mysqli_num_rows($query2);
			if($check <= 0 || $check2 <= 0){
		?>
		
		<div class="shadow-title parallax-top-shadow">Ups-:)</div>
		
		<div class="section padding-page-top padding-bottom over-hide z-bigger">
			<div class="container z-bigger">
				<div class="row page-title px-5 px-xl-2">
					<header>
						<h1 class="glitch" data-text="404">404</h1>
					</header>
					<div class="col-11 parallax-fade-top mt-2 mt-sm-3">
						<h2>Not Found</h2>
					</div>
				</div>
			</div>
		</div>

		<?php }else{ ?>

		<div class="shadow-title parallax-top-shadow">Latest News</div>
		
		<div class="section padding-page-top padding-bottom over-hide z-bigger">
			<div class="container z-bigger">
				<div class="row page-title px-5 px-xl-2">
					<div class="col-12 parallax-fade-top">
						<h1>Our News</h1>
					</div>
					<div class="offset-1 col-11 parallax-fade-top mt-2 mt-sm-3">
						<p>full of stuff</p>
					</div>
				</div>
			</div>
		</div>

			<?php } ?>
		
		<div class="section padding-bottom-big z-bigger over-hide">
			<div class="container z-bigger">
				<div class="row page-title px-5 px-xl-2">

					<div class="col lg-8 md-8 sm-12">
						<ul class="case-study-wrapper vertical-blog">

							<?php
								while($dataFetch = mysqli_fetch_array($query2)){
							?>

							<li class="case-study-name mb-5">
								<a href="articles.php?p_id=<?php echo $dataFetch['p_id']; ?>" class="hover-target animsition-link">
									<h4><?php echo $dataFetch['title']; ?></h4>
								<div class="row">
									<div class="col-lg-6">
										<p class="pl-0 pl-md-5 mb-4 mt-3">
											<?php
												$string = (strlen($dataFetch['content']) > 100) ? substr($dataFetch['content'],0,99).'...' : $dataFetch['content'];
												echo $string;
											?>
										</p>
										<div class="row">
											<div class="col-8">
												<p class="pl-0 pl-md-5"><em>
												<?php
													$newDate = date("F j, Y", strtotime($dataFetch['postdate']));
													echo $newDate;
												?>
												</em></p>
											</div>
											<div class="col-4">
												<a href="articles.php?p_id=<?php echo $dataFetch['p_id']; ?>" class="hover-target animsition-link"><div class="go-to-post"></div></a>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<?php if($dataFetch['imgname'] != NULL){ ?>
										<img src="https://zentachain.io/News-Images/<?php echo $dataFetch['imgname']; ?>" class="img-thumbnail" width="280" height="180"/>
										<?php } ?>
									</div>
								</div>	
							</li>
							
							<?php } ?>

						</ul>
					</div>

					<div class="col-lg-4 md-4 d-none d-sm-none d-md-block">
						<div class="sidebar-box background-dark drop-shadow rounded">
							<div class="subscribe-box ajax-form">
								<form method="get" action="">
									<input type="text" name="searchbox" placeholder="type here" class="hover-target" />
									
									<button class="subscribe-1 hover-target" type="submit">
										search
									</button>
								</form>
							</div>	
							<div class="separator-wrap my-5">	
								<span class="separator"><span class="separator-line dashed"></span></span>
							</div>
							<h6 class="mb-3">Categories</h6>
							<ul class="list-style circle pl-4 pb-0">
							
								<?php
									$cg = "SELECT * FROM category_master";
									$ffg = mysqli_query($db,$cg);
									while($cate = mysqli_fetch_array($ffg)){
								?>	
							
								<li>
									<a href="?category=<?php echo $cate['name']; ?>" class="btn-link btn-primary hover-target pl-0"><?php echo $cate['name']; ?></a>
								</li>
								
								<?php } ?>

							</ul>	
							<div class="separator-wrap my-5">	
								<span class="separator"><span class="separator-line dashed"></span></span>
							</div>
							<h6 class="mb-3">Latest News</h6>
							<ul class="list-style circle-o pl-4 pb-0">
								
								<?php
									$query3 = "SELECT * FROM articles WHERE status='publish' ORDER BY postdate DESC LIMIT 5";
									$getData1 = mysqli_query($db,$query3);
									while($lastNews = mysqli_fetch_array($getData1)){
								?>	

								<li>
									<a href="articles.php?p_id=<?php echo $lastNews['p_id']; ?>" class="btn-link btn-primary hover-target pl-0"><?php echo $lastNews['title']; ?></a>
								</li>
								
								<?php } ?>
							</ul>	
							<div class="separator-wrap my-5">	
								<span class="separator"><span class="separator-line dashed"></span></span>
							</div>	
							<h6 class="mb-3">Archives</h6>
							<ul class="list-style circle-o pl-4 pb-0">

								<?php
									$query4 = "SELECT DISTINCT YEAR(postdate) AS 'year', MONTH(postdate) AS 'month' FROM articles ORDER BY postdate DESC";
									$getDate = mysqli_query($db,$query4);
									while($lastdate = mysqli_fetch_array($getDate)){
								?>	

								<li>
									<a href="?year=<?php echo $lastdate['year']; ?>&month=<?php echo $lastdate['month']; ?>" class="btn-link btn-primary hover-target pl-0"><?php $monthToText = date("F", mktime(0, 0, 0, $lastdate['month'], 10)); echo $monthToText." ".$lastdate['year']; ?></a>
								</li>	

								<?php } ?>

							</ul>				
						</div>
					</div>

				</div>
			</div>
		</div>
		
		<div class="section padding-top-bottom over-hide z-bigger background-black footer">
			<div class="shadow-on-footer" data-scroll-reveal="enter bottom move 30px over 0.5s after 0.1s">Our Stories</div>
				<div class="container" data-scroll-reveal="enter bottom move 20px over 0.5s after 0.4s">
					<div class="row">
						<div class="col-12 text-center z-bigger py-5">
							<div class="footer-lines row justify-content-center">
								<?php if($page > 1){ ?>
									<div class="col-6">
										<a href="blog.php?page=<?php echo $page-1 ?>" class="hover-target animsition-link"><h4>Newest News</h4></a>
									</div>
								<?php }?>

								<?php if(($count - $start) > 10){ ?>
									<div class="col-6">
										<a href="blog.php?page=<?php echo $page+1 ?>" class="hover-target animsition-link"><h4>Older News</h4></a>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>			
		</div>
		

		<div class="copyr">
			2019 © <a href="https://zentachain.io" class="hover-target">Zentachain</a>
		</div>
		
		<div class="scroll-to-top hover-target"></div>
		
		<!-- Page cursor
		================================================== -->
		
        <div class='cursor' id="cursor"></div>
        <div class='cursor2' id="cursor2"></div>
        <div class='cursor3' id="cursor3"></div>

	</div>

	
	<!-- JAVASCRIPT
    ================================================== -->
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script> 
	<script src="js/bootstrap.min.js"></script>
	<script src="js/plugins.js"></script> 
	<script src="js/custom.js"></script>  
<!-- End Document
================================================== -->
</body>
</html>
