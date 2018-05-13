<?php 
include_once('db.inc.php');    //declare DB setting and connecting fuction: cmsc57416_DB

if(empty($_POST['formGenre'])){
	echo 'while(1);' . json_encode(array('failed'=>'noSelect'));
}else{
	$RESULT=array();
	$MOVIE=movie_fetchall();
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
    echo 'while(1);' . json_encode(array('success' => $RESULT));
}


function movie_fetchall(){
	global $db;
	$db = cmsc57416_DB();

	$sql = 'SELECT TMDBid,Genres,Rating FROM MOVIE WHERE ';
	$N = count($_POST['formGenre']);
    for($i=0; $i < $N; $i++)
    {
		$x=$_POST['formGenre'][$i];
		$sql=$sql."Genres LIKE '%".$x."%' AND ";
    }
    $sql=substr($sql,0,-4).'ORDER BY Rating DESC LIMIT 20';
	$q = $db->prepare($sql);
	$q->execute();
	$q=$q->fetchAll();
	return $q;
}

?>
