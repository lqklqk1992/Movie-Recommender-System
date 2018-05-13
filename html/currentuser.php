<?php
include_once('db.inc.php');    //declare DB setting and connecting fuction: cmsc57416_DB

if(empty($_GET['uid'])){
	header('Location: index.php');
    exit();
}else{
	if(!is_numeric($_GET['uid'])){
		header('Location: index.php');
    	exit();
	}
	$RESULT=array();
	$MOVIE=movie_fetchusertop();
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$N = count($MOVIE);
	$count=0;
	for($i=0; $i < $N; $i++){
    	curl_setopt($ch, CURLOPT_URL,'https://api.themoviedb.org/3/movie/'.$MOVIE[$i]["TMDBid"].'?api_key=167d1296ae186b1bb45d2860caa94d44');
		$result=curl_exec($ch);
		$resjson = json_decode($result, true);
		if (array_key_exists('status_code', $resjson))
    		continue;

    	$resjson['Genres'] = $MOVIE[$i]["Genres"];
    	$resjson['Rating'] = $MOVIE[$i]["Rating"];

		$RESULT[] = $resjson;
		$count=$count+1;
		if($count==9)
			break;
    }
	curl_close($ch);

	$TOPRESULT=movie_fetchalltop();
}


function movie_fetchusertop(){
	global $db;
	$db = cmsc57416_DB();

	$sql = "SELECT TMDBid,Genres,Rating FROM (SELECT MLid,TMDBid,Genres,Rating FROM MOVIE) AS M INNER JOIN (SELECT MLid,Est_R FROM RATING WHERE Uid=".$_GET['uid']." AND Est_R<>'') AS R ON M.MLid=R.MLid ORDER BY R.Est_R DESC LIMIT 20";
	$q = $db->prepare($sql);
	$q->execute();
	$q=$q->fetchAll();
	return $q;
}

function movie_fetchalltop(){
	global $db;
	$db = cmsc57416_DB();

	$sql = "SELECT TMDBid,Title FROM MOVIE ORDER BY Rating DESC LIMIT 20";
	$q = $db->prepare($sql);
	$q->execute();
	$q=$q->fetchAll();
	return $q;
}
?>

<!-- Page Content -->
<div class="container">

	<div class="row">
		
		<div class="col-lg-3">
			<h1 class="my-4">TOP 10 list</h1>
			<div class="list-group">
				<a href=<?php echo "index.php?job=detail&tmdbid=".$TOPRESULT[0]['TMDBid']; ?> class="list-group-item"><?php echo $TOPRESULT[0]['Title']; ?></a>
				<a href=<?php echo "index.php?job=detail&tmdbid=".$TOPRESULT[1]['TMDBid']; ?> class="list-group-item"><?php echo $TOPRESULT[1]['Title']; ?></a>
				<a href=<?php echo "index.php?job=detail&tmdbid=".$TOPRESULT[2]['TMDBid']; ?> class="list-group-item"><?php echo $TOPRESULT[2]['Title']; ?></a>
				<a href=<?php echo "index.php?job=detail&tmdbid=".$TOPRESULT[3]['TMDBid']; ?> class="list-group-item"><?php echo $TOPRESULT[3]['Title']; ?></a>
				<a href=<?php echo "index.php?job=detail&tmdbid=".$TOPRESULT[4]['TMDBid']; ?> class="list-group-item"><?php echo $TOPRESULT[4]['Title']; ?></a>
				<a href=<?php echo "index.php?job=detail&tmdbid=".$TOPRESULT[5]['TMDBid']; ?> class="list-group-item"><?php echo $TOPRESULT[5]['Title']; ?></a>
				<a href=<?php echo "index.php?job=detail&tmdbid=".$TOPRESULT[6]['TMDBid']; ?> class="list-group-item"><?php echo $TOPRESULT[6]['Title']; ?></a>
				<a href=<?php echo "index.php?job=detail&tmdbid=".$TOPRESULT[7]['TMDBid']; ?> class="list-group-item"><?php echo $TOPRESULT[7]['Title']; ?></a>
				<a href=<?php echo "index.php?job=detail&tmdbid=".$TOPRESULT[8]['TMDBid']; ?> class="list-group-item"><?php echo $TOPRESULT[8]['Title']; ?></a>
				<a href=<?php echo "index.php?job=detail&tmdbid=".$TOPRESULT[9]['TMDBid']; ?> class="list-group-item"><?php echo $TOPRESULT[9]['Title']; ?></a>
			</div>
		</div>

		<div class="col-lg-9">	
			</br>
			<h1 class="my-4">You may want to watch</h1>
			<div class="row">
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="card h-100">
						<a href=<?php echo "index.php?job=detail&uid=".$_GET['uid']."&tmdbid=".$RESULT[0]['id']; ?>><img class="card-img-top" src=https://image.tmdb.org/t/p/w500<?php echo $RESULT[0]['poster_path'] ?> alt=""></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href=<?php echo "index.php?job=detail&uid=".$_GET['uid']."&tmdbid=".$RESULT[0]['id']; ?>><?php echo $RESULT[0]['title']; ?></a>
							</h4>
							<small class="card-genres"><?php echo $RESULT[0]['Genres']; ?></small>
							<!--<p class="card-text"><?php echo $RESULT[0]['overview']; ?></p>-->
						</div>
						<div class="card-footer">
							<small>Rating: <?php echo substr($RESULT[0]['Rating'],0,4); ?>/5.00</small>
							<!--<small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>-->
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="card h-100">
						<a href=<?php echo "index.php?job=detail&uid=".$_GET['uid']."&tmdbid=".$RESULT[1]['id']; ?>><img class="card-img-top" src=https://image.tmdb.org/t/p/w500<?php echo $RESULT[1]['poster_path'] ?> alt=""></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href=<?php echo "index.php?job=detail&uid=".$_GET['uid']."&tmdbid=".$RESULT[1]['id']; ?>><?php echo $RESULT[1]['title']; ?></a>
							</h4>
							<small class="card-genres"><?php echo $RESULT[1]['Genres']; ?></small>
							<!--<p class="card-text"><?php echo $RESULT[1]['overview']; ?></p>-->
						</div>
						<div class="card-footer">
							<small>Rating: <?php echo substr($RESULT[1]['Rating'],0,4); ?>/5.00</small>
							<!--<small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>-->
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="card h-100">
						<a href=<?php echo "index.php?job=detail&uid=".$_GET['uid']."&tmdbid=".$RESULT[2]['id']; ?>><img class="card-img-top" src=https://image.tmdb.org/t/p/w500<?php echo $RESULT[2]['poster_path'] ?> alt=""></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href=<?php echo "index.php?job=detail&uid=".$_GET['uid']."&tmdbid=".$RESULT[2]['id']; ?>><?php echo $RESULT[2]['title']; ?></a>
							</h4>
							<small class="card-genres"><?php echo $RESULT[2]['Genres']; ?></small>
							<!--<p class="card-text"><?php echo $RESULT[2]['overview']; ?></p>-->
						</div>
						<div class="card-footer">
							<small>Rating: <?php echo substr($RESULT[2]['Rating'],0,4); ?>/5.00</small>
							<!--<small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>-->
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="card h-100">
						<a href=<?php echo "index.php?job=detail&uid=".$_GET['uid']."&tmdbid=".$RESULT[3]['id']; ?>><img class="card-img-top" src=https://image.tmdb.org/t/p/w500<?php echo $RESULT[3]['poster_path'] ?> alt=""></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href=<?php echo "index.php?job=detail&uid=".$_GET['uid']."&tmdbid=".$RESULT[3]['id']; ?>><?php echo $RESULT[3]['title']; ?></a>
							</h4>
							<small class="card-genres"><?php echo $RESULT[3]['Genres']; ?></small>
							<!--<p class="card-text"><?php echo $RESULT[3]['overview']; ?></p>-->
						</div>
						<div class="card-footer">
							<small>Rating: <?php echo substr($RESULT[3]['Rating'],0,4); ?>/5.00</small>
							<!--<small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>-->
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="card h-100">
						<a href=<?php echo "index.php?job=detail&uid=".$_GET['uid']."&tmdbid=".$RESULT[4]['id']; ?>><img class="card-img-top" src=https://image.tmdb.org/t/p/w500<?php echo $RESULT[4]['poster_path'] ?> alt=""></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href=<?php echo "index.php?job=detail&uid=".$_GET['uid']."&tmdbid=".$RESULT[4]['id']; ?>><?php echo $RESULT[4]['title']; ?></a>
							</h4>
							<small class="card-genres"><?php echo $RESULT[4]['Genres']; ?></small>
							<!--<p class="card-text"><?php echo $RESULT[4]['overview']; ?></p>-->
						</div>
						<div class="card-footer">
							<small>Rating: <?php echo substr($RESULT[4]['Rating'],0,4); ?>/5.00</small>
							<!--<small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>-->
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="card h-100">
						<a href=<?php echo "index.php?job=detail&uid=".$_GET['uid']."&tmdbid=".$RESULT[5]['id']; ?>><img class="card-img-top" src=https://image.tmdb.org/t/p/w500<?php echo $RESULT[5]['poster_path'] ?> alt=""></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href=<?php echo "index.php?job=detail&uid=".$_GET['uid']."&tmdbid=".$RESULT[5]['id']; ?>><?php echo $RESULT[5]['title']; ?></a>
							</h4>
							<small class="card-genres"><?php echo $RESULT[5]['Genres']; ?></small>
							<!--<p class="card-text"><?php echo $RESULT[5]['overview']; ?></p>-->
						</div>
						<div class="card-footer">
							<small>Rating: <?php echo substr($RESULT[5]['Rating'],0,4); ?>/5.00</small>
							<!--<small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>-->
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-6 mb-4">
					<div class="card h-100">
						<a href=<?php echo "index.php?job=detail&uid=".$_GET['uid']."&tmdbid=".$RESULT[6]['id']; ?>><img class="card-img-top" src=https://image.tmdb.org/t/p/w500<?php echo $RESULT[6]['poster_path'] ?> alt=""></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href=<?php echo "index.php?job=detail&uid=".$_GET['uid']."&tmdbid=".$RESULT[6]['id']; ?>><?php echo $RESULT[6]['title']; ?></a>
							</h4>
							<small class="card-genres"><?php echo $RESULT[6]['Genres']; ?></small>
							<!--<p class="card-text"><?php echo $RESULT[6]['overview']; ?></p>-->
						</div>
						<div class="card-footer">
							<small>Rating: <?php echo substr($RESULT[6]['Rating'],0,4); ?>/5.00</small>
							<!--<small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>-->
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-6 mb-4">
					<div class="card h-100">
						<a href=<?php echo "index.php?job=detail&uid=".$_GET['uid']."&tmdbid=".$RESULT[7]['id']; ?>><img class="card-img-top" src=https://image.tmdb.org/t/p/w500<?php echo $RESULT[7]['poster_path'] ?> alt=""></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href=<?php echo "index.php?job=detail&uid=".$_GET['uid']."&tmdbid=".$RESULT[7]['id']; ?>><?php echo $RESULT[7]['title']; ?></a>
							</h4>
							<small class="card-genres"><?php echo $RESULT[7]['Genres']; ?></small>
							<!--<p class="card-text"><?php echo $RESULT[7]['overview']; ?></p>-->
						</div>
						<div class="card-footer">
							<small>Rating: <?php echo substr($RESULT[7]['Rating'],0,4); ?>/5.00</small>
							<!--<small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>-->
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-6 mb-4">
					<div class="card h-100">
						<a href=<?php echo "index.php?job=detail&uid=".$_GET['uid']."&tmdbid=".$RESULT[8]['id']; ?>><img class="card-img-top" src=https://image.tmdb.org/t/p/w500<?php echo $RESULT[8]['poster_path'] ?> alt=""></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href=<?php echo "index.php?job=detail&uid=".$_GET['uid']."&tmdbid=".$RESULT[8]['id']; ?>><?php echo $RESULT[8]['title']; ?></a>
							</h4>
							<small class="card-genres"><?php echo $RESULT[8]['Genres']; ?></small>
							<!--<p class="card-text"><?php echo $RESULT[8]['overview']; ?></p>-->
						</div>
						<div class="card-footer">
							<small>Rating: <?php echo substr($RESULT[8]['Rating'],0,4); ?>/5.00</small>
							<!--<small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>-->
						</div>
					</div>
				</div>
			
			</div>
			<!-- /.row -->
	
		</div>
		<!-- /.col-lg-9 -->

	</div>
	<!-- /.row -->

</div>
<!-- /.container -->