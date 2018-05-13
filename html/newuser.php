<?php
include_once('db.inc.php');    //declare DB setting and connecting fuction: cmsc57416_DB

$TOPRESULT=movie_fetchalltop();

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

<style>
	.hidden { display : none }
	.display_area { display : block }
</style>

<!-- Page Content -->
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="my-4">Welcome, please tick the genre(s) you like</h1>
			<form action="newuser-process.php" method="post">
				<table width="100%">
					<tr>
						<td><input type="checkbox" name="formGenre[]" value="Action" width="16%"/>&nbsp;Action</td>
						<td><input type="checkbox" name="formGenre[]" value="Adventure" width="16%"/>&nbsp;Adventure</td>
						<td><input type="checkbox" name="formGenre[]" value="Animation" width="16%"/>&nbsp;Animation</td>
						<td><input type="checkbox" name="formGenre[]" value="Children" width="16%"/>&nbsp;Children</td>
						<td><input type="checkbox" name="formGenre[]" value="Comedy" width="16%"/>&nbsp;Comedy</td>
						<td><input type="checkbox" name="formGenre[]" value="Crime" width="16%"/>&nbsp;Crime</td>
					</tr>
					<tr>
						<td><input type="checkbox" name="formGenre[]" value="Documentary" />&nbsp;Documentary</td>
						<td><input type="checkbox" name="formGenre[]" value="Drama" />&nbsp;Drama</td>
						<td><input type="checkbox" name="formGenre[]" value="Fantasy" />&nbsp;Fantasy</td>
						<td><input type="checkbox" name="formGenre[]" value="Film-Noir" />&nbsp;Film-Noir</td>
						<td><input type="checkbox" name="formGenre[]" value="Horror"/>&nbsp;Horror</td>
						<td><input type="checkbox" name="formGenre[]" value="Musical"/>&nbsp;Musical</td>
					</tr>
					<tr>
						<td><input type="checkbox" name="formGenre[]" value="Mystery"/>&nbsp;Mystery</td>
						<td><input type="checkbox" name="formGenre[]" value="Romance"/>&nbsp;Romance</td>
						<td><input type="checkbox" name="formGenre[]" value="Sci-Fi"/>&nbsp;Sci-Fi</td>
						<td><input type="checkbox" name="formGenre[]" value="Thriller"/>&nbsp;Thriller</td>
						<td><input type="checkbox" name="formGenre[]" value="War"/>&nbsp;War</td>
						<td><input type="checkbox" name="formGenre[]" value="Western"/>&nbsp;Western</td>
					</tr>
				</table>
				</br>
				<button type="submit" class="btn btn-primary" name="formSubmit" value="Submit">Submit</button>
			</form>
		</div>
	</div>
	<hr>

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

		<div id="recommend" class="col-lg-9 hidden">
			<h1 class="my-4">You may want to watch</h1>
			<div class="row">
				<div id="1" class="col-lg-4 col-md-6 mb-4 hidden">
					<div class="card h-100">
						<a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href="#">Item One</a>
							</h4>
							<small class="card-genres"></small>
							<p class="card-text"></p>
						</div>
						<div class="card-footer">
							<small class="card-rating"></small>
						</div>
					</div>
				</div>
				
				<div id="2" class="col-lg-4 col-md-6 mb-4 hidden">
					<div class="card h-100">
						<a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href="#">Item Two</a>
							</h4>
							<small class="card-genres"></small>
							<p class="card-text"></p>
						</div>
						<div class="card-footer">
							<small class="card-rating"></small>
						</div>
					</div>
				</div>
				
				<div id="3" class="col-lg-4 col-md-6 mb-4 hidden">
					<div class="card h-100">
						<a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href="#">Item Three</a>
							</h4>
							<small class="card-genres"></small>
							<p class="card-text"></p>
						</div>
						<div class="card-footer">
							<small class="card-rating"></small>
						</div>
					</div>
				</div>
				
				<div id="4" class="col-lg-4 col-md-6 mb-4 hidden">
					<div class="card h-100">
						<a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href="#">Item Four</a>
							</h4>
							<small class="card-genres"></small>
							<p class="card-text"></p>
						</div>
						<div class="card-footer">
							<small class="card-rating"></small>
						</div>
					</div>
				</div>
				
				<div id="5" class="col-lg-4 col-md-6 mb-4 hidden">
					<div class="card h-100">
						<a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href="#">Item Five</a>
							</h4>
							<small class="card-genres"></small>
							<p class="card-text"></p>
						</div>
						<div class="card-footer">
							<small class="card-rating"></small>
						</div>
					</div>
				</div>
				
				<div id="6" class="col-lg-4 col-md-6 mb-4 hidden">
					<div class="card h-100">
						<a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href="#">Item Six</a>
							</h4>
							<small class="card-genres"></small>
							<p class="card-text"></p>
						</div>
						<div class="card-footer">
							<small class="card-rating"></small>
						</div>
					</div>
				</div>

				<div id="7" class="col-lg-4 col-md-6 mb-4 hidden">
					<div class="card h-100">
						<a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href="#">Item Seven</a>
							</h4>
							<small class="card-genres"></small>
							<p class="card-text"></p>
						</div>
						<div class="card-footer">
							<small class="card-rating"></small>
						</div>
					</div>
				</div>

				<div id="8" class="col-lg-4 col-md-6 mb-4 hidden">
					<div class="card h-100">
						<a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href="#">Item Eight</a>
							</h4>
							<small class="card-genres"></small>
							<p class="card-text"></p>
						</div>
						<div class="card-footer">
							<small class="card-rating"></small>
						</div>
					</div>
				</div>

				<div id="9" class="col-lg-4 col-md-6 mb-4 hidden">
					<div class="card h-100">
						<a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
						<div class="card-body">
							<h4 class="card-title">
								<a href="#">Item Nine</a>
							</h4>
							<small class="card-genres"></small>
							<p class="card-text"></p>
						</div>
						<div class="card-footer">
							<small class="card-rating"></small>
						</div>
					</div>
				</div>
			
			</div>
			<!-- /.row -->
	
		</div>
		<!-- /.col-lg-12 -->

	</div>
	<!-- /.row -->

</div>
<!-- /.container -->

<script type="text/javascript">

$('form').submit(function() {
	$(".display_area").removeClass("display_area");
	$.ajax({type: 'POST', url:'newuser-process.php', data:$(this).serialize(), success:function(output){
//remove "while(1);"
    	if(output.substr(0,9) == 'while(1);'){ output=output.substring(9);}
// to decode the xhr.responseText and turns it to an object
		var json = JSON.parse(output);
		if (json.success) {
			if(json.success[0]==null){
				alert('No result found!');
			}else{
				for (var i = 0, record; record = json.success[i]; i++) {
					var container = document.getElementById((i+1).toString());
					container.className += " display_area";
					var img = container.getElementsByClassName("card-img-top")[0];
					img.src = "https://image.tmdb.org/t/p/w500"+record['poster_path'];
					var title = container.getElementsByClassName("card-title")[0].getElementsByTagName("a")[0];
					title.innerHTML=record['title'];
					var genres = container.getElementsByClassName("card-genres")[0];
					genres.innerHTML=record['Genres'];
					var text = container.getElementsByClassName("card-text")[0];
					//text.innerHTML=record['overview'];
					var rating = container.getElementsByClassName("card-rating")[0];
					rating.innerHTML='Rating: '+record['Rating'].substr(0,4)+'/5.00';
					//alert(record['genres'][0]['name']);
					var phref = container.getElementsByTagName("a")[0];
					phref.href = "index.php?job=detail&tmdbid="+record['id'];
					var thref = container.getElementsByTagName("a")[1];
					thref.href = "index.php?job=detail&tmdbid="+record['id'];
				}
				$("#recommend").addClass("display_area");
			}
		} else alert('No genre selected!');
	}});
    return false; // return false to cancel form action
});

</script>