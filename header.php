<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<title>Everything - <?php echo $heres ?></title>
	<style type="text/css" media="all">
		@import "css/bootstrap.css";
	</style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/evjq.js"></script>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<!-- <link rel="stylesheet" href="/css/scss.css"> -->
</head>

<body>
 <div class="container">
	<div class="row hidden-print">
		<div class="col-xs-12">
		<ul class="nav navbar-nav">
			<li><a href="index.php">SEARCH</a></li>
			<li><a href="artist.php">ARTISTS</a></li>
			<li><a href="album.php">ALBUMS</a></li>
			<li><a href="albumartist.php">ALBUM ARTISTS</a></li>
			<li><a href="tracks.php">TRACKS</a></li>
			<li><a href="recent.php">RECENT TRACKS</a></li>
			<li><a href="recentalbums.php">RECENT ALBUMS</a></li>
			<li><a href="about.php">ABOUT</a></li>
		</ul>
	</div>
	</div>

<div class="row hidden-print">
<div class="col-xs-12 col-md-8 col-lg-8"><h1>EVERYTHING <small>CDs, Downloads and Coverdiscs</small></h1></div>
<div class="col-xs-12 col-md-4 col-lg-4 well well-sm text-right">
<form action="search.php" method="get">
	<div class="input-group">
  <input type="text" class="form-control" name="requery" placeholder="Keyword search">
  	<span class="input-group-btn">  
  <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>  
</span>
</div>
</form>  
</div>
</div>
