function editNames(str) {
  console.log('in edit function' + str);
    if (str == "") {
       console.log('str empty');
        document.getElementById(elId+str).value = "oops";
        return;
    } else {
      var ar = str.split('|');
      var str = ar[0];
      var elId = ar[1];
      // console.log("elId: "+elId+" str:"+str);
       var innerData = document.getElementById(elId).innerHTML;
       // console.log(innerData);
       var elData = elId + "|" + innerData;
      var postValues = { elId: elData, 
        postId: str,
        method: "update"};
         console.log(postValues);
        console.log('form data: ' +innerData);
      $.post("not-edit.php", postValues)
  .done(function( data ) {
//      $("#suc"+str).toggleClass("hidden");
  document.getElementById("suc"+elId).innerHTML = data;
      console.log( "Data Loaded: " + data );
  });

    }
}

function deleteNames(str) {
  // console.log('in edit function' + str);
    if (str == "") {
      // console.log('str empty');
        document.getElementById(elId+str).value = "oops";
        return;
    } else {
      var ar = str.split('|');
      var str = ar[0];
      var elId = ar[1];
      // console.log("elId: "+elId+" str:"+str);
       var innerData = document.getElementById(elId).innerHTML;
       // console.log(innerData);
       var elData = elId + "|" + innerData;
      var postValues = { elId: elData, 
        postId: str,
        method: "delete"};
        // console.log(postValues);
    //    console.log('form data: ' +innerData);
      $.post("not-edit.php", postValues)
  .done(function( data ) {
//      $("#suc"+str).toggleClass("hidden");
  document.getElementById("suc"+elId).innerHTML = data;
     // console.log( "Data Loaded: " + data );
  });

    }
}

function deleteAlbum(str) {
   console.log('in delete album function' + str);
    if (str == "") {
      // console.log('str empty');
        document.getElementById(sucAlbum).value = "oops";
        return;
    } else {
       console.log("str:"+str);
      var postValues = { 
        postId: str,
        method: "deletealbum"};
        // console.log(postValues);
    //    console.log('form data: ' +innerData);
      $.post("not-edit.php", postValues)
  .done(function( data ) {
//      $("#suc"+str).toggleClass("hidden");
  document.getElementById("sucAlbum").innerHTML = data;
      console.log( "Data Loaded: " + data );
  });

    }
}