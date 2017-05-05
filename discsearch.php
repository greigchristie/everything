<?php 
include('functions.php');
include("header.php");
//include("formvars.php");

?>
<script>
 $(window).load(function() {
         $('form').get(0).reset(); //clear form data on page load
     });
 </script>
 <script>
$(function() {
    // $( "#albumArtist" ).autocomplete({
    //     source: 'autoc.php',
    //     minLength: 2
    //   });
    $( "#titleAlbum" ).autocomplete({
        source: 'autodisc.php',
        minLength: 5,
        delay: 1000,
        focus: function(event, ui) {
          event.preventDefault();
          $(this).val(ui.item.value);
        },
        select: function (event, ui) {
          event.preventDefault();
          $(this).val(ui.item.value);
          $("#hdnId").val(ui.item.id);//Put Id in a hidden field
          // return false;
        }
    });
});
</script>
<h2>Search for tracks @ discogs</h2> 
	<div class="row">
<div class="col-xs-12 col-md-8 col-lg-6">

		<label>Barcode Search</label>  
		<form class="well form-search" action="checkalbum.php" method="post">  
		<div class="input-group">
		<input type="text" class="form-control" name="barcode" autofocus>  
		  <span class="input-group-btn">
		  <button type="submit" class="btn">Search</button>  
		  </span>
		</div>
		</form>
	</div>
</div>  

	<div class="row">
<div class="col-xs-12 col-md-8 col-lg-6">

		<label>Catalogue No. Search</label>  
		<form class="well form-search" action="checkalbum.php" method="post">  
		<div class="input-group">
		<input type="text" class="form-control" name="catno">  
		  <span class="input-group-btn">
		  <button type="submit" class="btn">Search</button>  
		  </span>
		</div>
		</form>
	</div>
</div>  

<div class="row">
<div class="col-xs-12 col-md-8 col-lg-6">

		<label>Artist - Title Search</label>  
		<form class="well form-search" action="checkalbum.php" method="post">  
		<div class="input-group">
		<input type="text" class="form-control" id="titleAlbum" name="title">  
		    <input type="hidden" id="hdnId" name="hdnId" value="">
		  <span class="input-group-btn">
		  <button type="submit" class="btn">Search</button>  
		  </span>
		</div>
		</form>
	</div>
</div> 

<?php 
include("footer.php");
?>