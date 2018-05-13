<?php 
include_once('db.inc.php');    //declare DB setting and connecting fuction: cmsc57416_DB

if(empty($_GET['tmdbid'])){
	header('Location: index.php');
    exit();
}else{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_URL,'https://api.themoviedb.org/3/movie/'.$_GET['tmdbid'].'?api_key=167d1296ae186b1bb45d2860caa94d44');
	$result=curl_exec($ch);
	$RESULT = json_decode($result, true);

	curl_setopt($ch, CURLOPT_URL,'https://api.themoviedb.org/3/movie/'.$_GET['tmdbid'].'/credits?api_key=167d1296ae186b1bb45d2860caa94d44');
	$result=curl_exec($ch);
	$CREDITS = json_decode($result, true);

	curl_close($ch);
	$q=movie_fetch();
	$RESULT['Genres']=$q['Genres'];
	$RESULT['Rating']=$q['Rating'];
	$TOPRESULT=movie_fetchalltop();
}
function movie_fetch(){
	global $db;
	$db = cmsc57416_DB();

	$sql = "SELECT Genres,Rating FROM MOVIE WHERE TMDBid=".$_GET['tmdbid'];
	$q = $db->prepare($sql);
	$q->execute();
	$q=$q->fetch();
	return $q;
}

function movie_fetchalltop(){
	global $db;
	$db = cmsc57416_DB();

	$sql = "SELECT TMDBid,Title FROM MOVIE ORDER BY Rating DESC LIMIT 10";
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
		<!-- /.col-lg-3 -->

		<div class="col-lg-9">

			<div class="card mt-4">
				<div class="card-body">
					<table width="100%"><tr valign="center">
						<td width="40%"><img src=https://image.tmdb.org/t/p/w500<?php echo $RESULT['poster_path'] ?> width="80%" alt=""></td>
						<td><h3 class="card-title"><?php echo $RESULT['title']; ?></h3></br><b><?php echo $RESULT['Genres']; ?></b></br></br><small>Rating: <?php echo substr($RESULT['Rating'],0,4); ?>/5.00</small></td>
					</tr></table>
					</br>
					<p class="card-text"><?php echo $RESULT['overview']; ?></p>
				</div>
			</div>
			<!-- /.card -->
			
			<div class="card mt-4">
				<div class="card-header">
					<h4>Cast</h4>
				</div>
				<div class="card-body">
					<table width="100%">
						<tr align="center">
							<td><img src=https://image.tmdb.org/t/p/w500<?php echo $CREDITS['cast'][0]['profile_path'];?> height='200' alt=''></td>
							<td><img src=https://image.tmdb.org/t/p/w500<?php echo $CREDITS['cast'][1]['profile_path'];?> height='200' alt=''></td>
							<td><img src=https://image.tmdb.org/t/p/w500<?php echo $CREDITS['cast'][2]['profile_path'];?> height='200' alt=''></td>
							<td><img src=https://image.tmdb.org/t/p/w500<?php echo $CREDITS['cast'][3]['profile_path'];?> height='200' alt=''></td>
						</tr>
						<tr align="center">
							<td><p class="card-text"><?php echo $CREDITS['cast'][0]['name'];?></p></td>
							<td><p class="card-text"><?php echo $CREDITS['cast'][1]['name'];?></p></td>
							<td><p class="card-text"><?php echo $CREDITS['cast'][2]['name'];?></p></td>
							<td><p class="card-text"><?php echo $CREDITS['cast'][3]['name'];?></p></td>
						</tr>
					</table>
				</div>
			</div>
			<!-- /.card -->
			
			<?php 
				$Director=array();
				$N = count($CREDITS['crew']);
				for($i=0; $i < $N; $i++){
					if($CREDITS['crew'][$i]['job']=='Director'){
						$Director['name']=$CREDITS['crew'][0]['name'];
						$Director['profile_path']=$CREDITS['crew'][0]['profile_path'];
						break;
					}
				}
			?>
			<div class="card mt-4">
				<div class="card-header">
					<h4>Director</h4>
				</div>
				<div class="card-body">
					<table width="100%">
						<tr align="center">
							<td><img src=https://image.tmdb.org/t/p/w500<?php echo $Director['profile_path'];?> height='200' alt=''></td>
						</tr>
						<tr align="center">
							<td><p class="card-text"><?php echo $Director['name'];?></p></td>
						</tr>
					</table>
				</div>
			</div>
			<!-- /.card -->
			
			<div class="card mt-4"><a href=<?php echo (empty($_GET['uid']))?'index.php':'index.php?uid='.$_GET['uid']; ?> class="btn btn-success" align="center">Return to the previous page</a></div></br>

		</div>
		<!-- /.col-lg-9 -->

	</div>

</div>
<!-- /.container -->