<?php 
include("connected.php");
include("functions.php");
include("header.php");

//echo "<p>$here</p>";
//echo $_SERVER['HTTP_USER_AGENT'];
?>

<div class="row">
<div class="col-xs-12 col-6">
<h2>Search everything (Advanced)</h2> 
	<div class="row">
	<div class="col-12">
		<label>Artist Search</label>
		<form class="well form-search" action="search.php" method="get">  
			<div class="input-group">
		  <input type="text" class="form-control" name="artistquery">  
		  <input type="hidden" name="sort" value="artist_sort_name">
		  <span class="input-group-btn"> 
		  <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Search</button>  
		  		</span>
	</div>
		</form>
	</div>  
	</div>
	<div class="row">
  	<div class="col-12">
		<label>Keyword Search</label>
		<form class="well form-search" action="keysearch.php" method="get">  
			<div class="input-group">
		  <input type="text" class="form-control" name="requery">  
		  <input type="hidden" name="sort" value="track_title">
		  <span class="input-group-btn"> 
		  <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Search</button>  
		</span>
	</div>
		</form>
	</div> 
	</div>	
	<div class="row">
  	<div class="col-12">
		<label>Track Search</label>
		<form class="well form-search" action="search.php" method="get">  
			<div class="input-group">
		  <input type="text" class="form-control" name="trackquery">  
		  <input type="hidden" name="sort" value="track_title">
		  <span class="input-group-btn"> 
		  <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Search</button>  
		</span>
	</div>
		</form>
	</div> 
	</div>
	<div class="row">
	<div class="col-12">
		<label>Album Search</label>
		<form class="well form-search" action="search.php" method="get">  
			<div class="input-group">
		  <input type="text" class="form-control" name="albumquery">  
		  <input type="hidden" name="sort" value="album_sort_title">
		  <span class="input-group-btn"> 
		  <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Search</button>  
		</span>
	</div>		  
		</form>
	</div>
	</div>
	<div class="row">
	<div class="col-12">
		<label>Album Artist Search</label>
		<form class="well form-search" action="search.php" method="get">  
			<div class="input-group">
		  <input type="text" class="form-control" name="albumartistquery">  
		  <input type="hidden" name="sort" value="artist_name">
		  <span class="input-group-btn"> 
		  <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Search</button>  
		</span>
		</div>
		</form>
	</div>  
	</div>	


	<div class="row">

		<div class="col-xs-10 col-md-6 col-lg-4">
		<label>Collection Search</label>
	</div>
	</div>

 			
  				<form action="search.php" method="get">
  				<div class="row">
  				<div class="col-6 form-group">
					  
						<select class="form-control" name="collquery">
		    				<option value="dlibrary">CD Collection</option>
		    				<option value="cdsingle">CD Single Collection</option>
		   					<option value="coverdisc">Coverdisc Collection</option>
		   					<option value="itunes">Digital Collection</option>
		   					<option value="vinyl">Vinyl Collection</option>
						</select>
						<input type="hidden" name="sort" value="artist_sort_name, album_sort_title">	
				</div>
					
				<div class="col-4">	
					<button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Search</button>  
				</div>
				</div>
					</form>
	
</div>
<div class="col-xs-12 col-md-1 col-lg-1">
</div>
<div class="col-xs-12 col-md-3 col-lg-5">
<div class="row">
<div class="col-12 hidden-md-up d-md-none">
<br><hr><br>
</div>
<div class="row text-center">
<h3>Recently Added</h3>
</div>
<div class="row text-center"">
<?php
	$sql = "select * from albums";
	$sql = $sql . " where album_cover <> ''";
	$sql = $sql . " order by id desc limit 6";
	
		$result = mysqli_query($con,$sql);
		while ($row = mysqli_fetch_array($result))
		{
			$cover = $row['album_cover'];
			$albumid = $row['id'];
			$albumartist = $row['album_artist_name'];
			$albumtitle = $row['album_title'];
			echo "<span class='recentcovers'><a href='albumview.php?req=albumid&query=$albumid' title='$albumtitle by $albumartist'><img src='$cover' width='220'></a></span>";
		}
?>
</div>
</div>
</div>	
	</div>
<?php
include("footer.php");
?>