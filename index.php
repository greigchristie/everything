<?php 
include("functions.php");
include("header.php");

//echo "<p>$here</p>";
//echo $_SERVER['HTTP_USER_AGENT'];
?>
<div class="row">
	<div class="col-md-2 col-lg-3"></div>
	<div class="col-xs-12 col-md-8 col-lg-6">
<h2>Search everything</h2> 
</div>
</div>
	<div class="row">
		<div class="col-md-2 col-lg-3"></div>
	<div class="col-xs-12 col-md-8 col-lg-6">
		<label>Artist Search</label>
		<form class="well form-search" action="search.php" method="get">  
			<div class="input-group">
		  <input type="text" class="form-control" name="artistquery">  
		  <input type="hidden" name="sort" value="artist_sort_name">
		  <span class="input-group-btn"> 
		  <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>  
		  		</span>
	</div>
		</form>
	</div>  
	</div>
	<div class="row">
		<div class="col-md-2 col-lg-3"></div>
  	<div class="col-xs-12 col-md-8 col-lg-6">
		<label>Track Search</label>
		<form class="well form-search" action="search.php" method="get">  
			<div class="input-group">
		  <input type="text" class="form-control" name="trackquery">  
		  <input type="hidden" name="sort" value="track_title">
		  <span class="input-group-btn"> 
		  <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>  
		</span>
	</div>
		</form>
	</div> 
	</div>
	<div class="row">
		<div class="col-md-2 col-lg-3"></div>
	<div class="col-xs-12 col-md-8 col-lg-6">
		<label>Album Search</label>
		<form class="well form-search" action="search.php" method="get">  
			<div class="input-group">
		  <input type="text" class="form-control" name="albumquery">  
		  <input type="hidden" name="sort" value="album_title">
		  <span class="input-group-btn"> 
		  <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>  
		</span>
	</div>		  
		</form>
	</div>
	</div>
	<div class="row">
		<div class="col-md-2 col-lg-3"></div>
	<div class="col-xs-12 col-md-8 col-lg-6">
		<label>Album Artist Search</label>
		<form class="well form-search" action="search.php" method="get">  
			<div class="input-group">
		  <input type="text" class="form-control" name="albumartistquery">  
		  <input type="hidden" name="sort" value="artist_sort_name">
		  <span class="input-group-btn"> 
		  <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>  
		</span>
		</div>
		</form>
	</div>  
	</div>	


	<div class="row">
		<div class="col-md-2 col-lg-3"></div>
		<div class="col-xs-10 col-md-6 col-lg-4">
		<label>Collection Search</label>
	</div>
	</div>
 		<div class="row">
 			<div class="col-md-2 col-lg-3"></div>
  				<form action="search.php" method="get">
  				<div class="col-xs-8 col-md-6 col-lg-4">
					  
						<select class="form-control" name="collquery">
		    				<option value="dlibrary">CD Collection</option>
		    				<option value="cdsingle">CD Single Collection</option>
		   					<option value="coverdisc">Coverdisc Collection</option>
		   					<option value="itunes">Digital Collection</option>
		   					<option value="vinyl">Vinyl Collection</option>
						</select>
						<input type="hidden" name="sort" value="album_sort_title">	
				</div>
				<div class="col-xs-4 col-md-2 col-lg-2">	
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>  
				</div>
					</form>
			</div>
		
	
<?php
include("footer.php");
?>