<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<?php if (isset($_GET['requery'])) { 
$query = $_GET['requery'];
echo "<title>$heres for $query</title>";

} else { ?> 
<title>Everything - <?php echo $heres ?></title>
<?php } ?>
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
		
		<!-- <ul class="nav navbar-nav"> -->
		<nav class="navbar navbar-expand-md">
			<div class="container-fluid">
				<div class="navbar-header">
<!--      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse-1" aria-expanded="false">-->
<!--        <span class="sr-only">Toggle navigation</span>-->
<!--        <span class="icon-bar"></span>-->
<!--        <span class="icon-bar"></span>-->
<!--        <span class="icon-bar"></span>-->
<!--      </button>-->

      <a class="navbar-brand" href="index.php"><img src="images/e7-2-40.png"></a>

    </div>
    <div class="collapse navbar-collapse" id="collapse-1">
		<ul class="navbar-nav">
		<li class="nav-item"><a href="index.php" class="nav-link">SEARCH</a></li>
		<li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">BROWSE <span class="caret"></span></a>
          
          	<div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  	<a href="artist.php" class="dropdown-item">ARTISTS</a>
			<a href="album.php" class="dropdown-item">ALBUMS</a>
			<a href="albumartist.php" class="dropdown-item">ALBUM ARTISTS</a>
			<a href="tracks.php" class="dropdown-item">TRACKS</a>
         	</div>
        </li> 
        <li class="dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">RECENT <span class="caret"></span></a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			<a href="recent.php" class="dropdown-item">RECENT TRACKS</a>
			<a href="recentalbums.php" class="dropdown-item">RECENT ALBUMS</a>
          </div>
        </li> 
        <li class="dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">ADMIN <span class="caret"></span></a>
          <div class="dropdown-menu">
          	<a href="discsearch.php" class="dropdown-item">ADD NEW MUSIC</a>
          	<a href="createartist.php" class="dropdown-item">CREATE ARTIST</a>
          	<a href="build.html" class="dropdown-item">CREATE ALBUM</a>
          </div>
        </li> 


			<li class="nav-item"><a href="about.php" class="nav-link">ABOUT</a></li>    

		</ul>
	</div>
			</div>
	</nav>
	
	</div>

<div class="row hidden-print">
<div class="col-xs-12 col-md-8 col-lg-8"><h1><!--<small>CDs, Downloads and Coverdiscs</small>--><span style="font-size: 1.45em;">e</span>very-Thing</h1></div>
<?php if ($heres != "index") { ?>
<div class="col-xs-12 col-md-4 col-lg-4 well well-sm text-right">
<form action="search.php" method="get">
	<div class="input-group">
  <input type="text" class="form-control" name="requery" placeholder="Keyword search">
  	<span class="input-group-btn">  
  <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Search</button>  
</span>
</div>
</form>  
</div>
<?php } ?>
</div>
