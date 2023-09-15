<?php
include('functions.php');
include('includes/dbinsert.php');
include('header.php');
?>
<?php
	if (isset($_POST['addArtist'])) {
		$artistName = $_POST['artistName'];
		$artistSortName = $_POST['artistSortName'];

		$createArtist = addArtist($artistName, $artistSortName);
		echo "<h2>$artistName added</h2>";
		echo "<p><a href='golden.php?name=$artistName&id=$createArtist'>Use as Golden Artist</a>";
		}
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="createartist" id="createartist">
	<div class="col-12">
		<div class="row">
		<label>Artist Name</label>
		</div>
		<div class="row">
			<div class="input-group col-6">
		  		<input type="text" class="form-control" name="artistName">
			</div>
		</div>
		<div class="row">
		<label>Artist Sort Name</label>
		</div>
		<div class="row">
			<div class="input-group col-6">
				<input type="text" class="form-control" name="artistSortName">
			</div>
		</div>
		<p>&nbsp;</p>
		<div class="row">
	<div class="input-group">
			<div class="input-group input-group-btn col-2"> 
			<button type="submit" class="btn btn-primary" name="addArtist" id="addArtist">Add</button>  
			</div>
		</div>
	</div>
</div>
</form>
<?php
include('footer.php');
?>