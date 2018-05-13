<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	
	<title>Movie Recommendation</title>
	
	<!-- Bootstrap core CSS -->
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Custom styles for this template -->
	<link href="css/shop-homepage.css" rel="stylesheet">
	
	<!-- Bootstrap core JavaScript -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body>
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
		<div class="container">
			<?php
				if(!empty($_GET['uid'])) {
					echo '<a class="navbar-brand" href="index.php?uid='.$_GET['uid'].'">';
				} else {
					echo '<a class="navbar-brand" href="index.php">';
				}
			?>
			Interactive Movie Recommender System</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav ml-auto">
					<?php
						if(!empty($_GET['uid'])) {
							echo '<li class="nav-item active"><button type="button" class="btn btn-danger" onclick="userlogout()">Logout</button></li>';
						} else {
							echo '<li class="nav-item"><input type="text" class="form-control" id="usr" placeholder="User ID" required="true" /></li><li class="nav-item">&nbsp;<button type="button" class="btn btn-success" onclick="userlogin()">Login</button></li>';
						}
					?>
				</ul>
			</div>
		</div>
	</nav>
	
	<?php
		if(empty($_GET['job'])) {
			if(!empty($_GET['uid'])) {
				include('currentuser.php');
			} else {
				include('newuser.php');
			}
		} else {
			include('detail.php');
		}
	?>
	
	<script type="text/javascript">

	function userlogin(){
		var str=document.getElementById("usr").value;
		if(/^\+?(0|[1-9]\d*)$/.test(str)){
			window.location.replace("index.php?uid="+str);
		}else{
			alert('Uid should be a positive integer!');
		}
	}

	function userlogout() {
		window.location.href = "index.php";
	}

	</script>
	
	<!-- Footer -->
	<footer class="py-5 bg-dark">
		<div class="container">
			<p class="m-0 text-center text-white">Copyright &copy; 2017-2018 CMSC5702 Liu Qiankun</br></p>
		</div>
		<!-- /.container -->
	</footer>
	

	
</body>
</html>
