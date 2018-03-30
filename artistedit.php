<?php
include("functions.php");
include("connected.php");
include("header.php");
// include("includes/spotify.php");
$getartist = $_GET['artist'];
if (isset($_GET['id'])) {
$getid = $_GET['id'];
$getedit = $_GET['edit'];
} else {
  $getid = "";
  $getedit = "";
}
$sql = "select * from artists";
$sql = $sql . " where id = $getartist";
		$result = mysqli_query($con,$sql);
		while ($row = mysqli_fetch_array($result))
		{
			$artist_name = $row['artist_name'];
			$artist_sort_name = $row['artist_sort_name'];
		}
			echo "<h4 class='row alert-info'>Edit artist details</h4>";
			echo "<p class='row'><label>Artist name:&nbsp;&nbsp;</label><span data-editable id='artistname'>$artist_name</span>&nbsp;<i class=\"fa fa-pencil\" style='font-size: 12pt;'  onclick='editNames(\"$getartist|artistname\")'></i><span id='sucartistname'></span></p>";
			echo "<p class='row'><label>Artist sort name:&nbsp;&nbsp;</label><span data-editable id='artistsortname'>$artist_sort_name</span>&nbsp;<i class=\"fa fa-pencil\" style='font-size: 12pt;'  onclick='editNames(\"$getartist|artistsortname\")'></i><span id='sucartistsortname'></span></p>";
			echo "";
			echo "<h4 class='row alert-danger'>Select artist</h4>";
?>
<script>
$(function() {
    $( "#albumArtist" ).autocomplete({
        source: 'autoc.php',
        minLength: 2,
        focus: function(event, ui) {
          event.preventDefault();
          $(this).val(ui.item.value);
          $('#aa').val(ui.item.name);
          $("#newId").val(ui.item.id);
        },
        select: function (event, ui) {
          event.preventDefault();
          $(this).val(ui.item.name);
          $("#hdnId").val(ui.item.id);
          // return false;
        }
    });
});
</script>
<script>
function consolidateArtist() {
  console.log('in consolidate function');

      var nameData = $("#buildForm").serialize();
      console.log('form data: '+nameData);
      $.post( "gates/not-edit.php", $("#buildForm").serialize())
  .done(function( data ) {
      $("#consuc").toggleClass("hidden");
  document.getElementById("consuc").innerHTML = data;
    console.log( "Data Loaded: " + data );
  });

    
}
</script>
<script>
function reassignArtist() {
  console.log('in reassign function');

      var nameData = $("#reassignForm").serialize();
      console.log('form data: '+nameData);
      $.post( "gates/not-edit.php", $("#reassignForm").serialize())
  .done(function( data ) {
      $("#asssuc").toggleClass("hidden");
  document.getElementById("asssuc").innerHTML = data;
    // console.log( "Data Loaded: " + data );
  });

    
}
</script>

<script type="text/javascript" src="js/dbjs.js"></script>

<div class="row">
  <div class="form-group  col-md-4">
    <form id="reassignForm" name="reassignForm">
    <input type="text" class="form-control input-medium" id="albumArtist" name="albumArtist" placeholder="Enter album artist" value="">
    <input type="hidden" id="newId" name="newId" value="">
    <input type="hidden" id="itemId" name="itemId" value="<?php echo $getid ?>">
    <input type="hidden" id="reassign" name="reassign" value="reassign">
    <input type="hidden" id="mode" name="mode" value="<?php echo $getedit; ?>">
      <button type="button" class="btn" id="assignSubmit" onclick="reassignArtist()">Reassign</button>
      <span id="asssuc"></span>
    </form>
    <form id="buildForm" name="buildForm">
    <input type="hidden" id="hdnId" name="newId" value="">
    <input type="hidden" id="artistId" name="artistId" value="<?php echo $getartist; ?>">
    <input type="hidden" id="consolidate" name="consolidate" value="consolidate">
    <input type="hidden" id="aa" name="aa" value="">
    <button type="button" onclick="consolidateArtist()" class="btn alert-info" id="consolidateSubmit">Consolidate</button>  <span id="consuc"></span>
    </form>
  </div>
</div>
<p><a href="artistview.php?artist=<?php echo $getartist; ?>">View</a></p>


  <script>
/**
  We're defining the event on the `body` element, 
  because we know the `body` is not going away.
  Second argument makes sure the callback only fires when 
  the `click` event happens only on elements marked as `data-editable`
*/
$('body').on('click', '[data-editable]', function(){
  
  var $el = $(this);
  var $fieldId = $(this).attr('id');              
  var $input = $('<input/>').val( $el.text() );
  $el.replaceWith( $input );
  
  var save = function(){
    var $p = $('<span data-editable />').text( $input.val() ).attr('id', $fieldId);
    $input.replaceWith( $p );
  };
  
  /**
    We're defining the callback with `one`, because we know that
    the element will be gone just after that, and we don't want 
    any callbacks leftovers take memory. 
    Next time `p` turns into `input` this single callback 
    will be applied again.
  */
  $input.one('blur', save).focus();
  
});
</script>	
<?php
include("footer.php");
?>
