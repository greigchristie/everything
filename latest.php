<?php 
include('functions.php');
include('header.php');
?>
<div class="row">
		<div class="col-xs-10 col-md-6 col-lg-4">
		<label>Collection</label>
	</div>
	</div>
 		<div class="row">
  				<form action="spread.php" method="post">
  				<div class="col-xs-8 col-md-6 col-lg-4">
					  
						<select class="form-control" name="collection">
		    				<option value="dlibrary">CD Collection</option>
		    				<option value="cdsingle">CD Single Collection</option>
		   					<option value="coverdisc">Coverdisc Collection</option>
		   					<option value="itunes">Digital Collection</option>
						</select>
						
				</div>
			</div>
<div class="row">
		<div class="col-xs-10 col-md-6 col-lg-4">
		<label>Limit</label>
	</div>
	</div>
 		<div class="row">

  				<div class="col-xs-8 col-md-6 col-lg-4">
					  
						<select class="form-control" name="limit">
		    				<option value="1">1</option>
		    				<option value="2">2</option>
		   					<option value="3">3</option>
		   					<option value="4">4</option>
		   					<option value="5">5</option>
		   					<option value="6">6</option>
		   					<option value="7">7</option>
		   					<option value="8">8</option>
		   					<option value="9">9</option>
		   					<option value="10">10</option>
		   					<option value="25">25</option>
		   					<option value="50">50</option>
						</select>
						<input type="hidden" name="sort" value="albumtitle">	
				</div>
				<div class="col-xs-4 col-md-2 col-lg-2">	
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search</button>  
				</div>
					</form>
			</div>
<?php
include('footer.php');
?>