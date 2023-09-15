<?php
include ('connected.php');
    
    //connect with the database

    $data = array();
    $data_row = array();
    //get search term
    $searchTerm = $_GET['term'];
    // $searchTerm = "paul";
    $searchTerm = mysqli_real_escape_string($con, $searchTerm);
    //get matched data from skills table
    $query = $con->query("SELECT artist_name, artist_sort_name, id FROM artists WHERE artist_name LIKE '%".$searchTerm."%' and artist_visible = 1 group by artist_name, id order by artist_name limit 15");
    while ($row = $query->fetch_assoc()) {
        $artistid = $row['id'];
        $artistname = $row['artist_name'];
        $artistnameid = $row['artist_name']." ".$artistid;
        $artistsort = $row['artist_sort_name'];
     // array_push($data,$artistid,$artistname);
        $data_row["id"] = $artistid;
        $data_row["sort"] = $artistsort;
        $data_row["label"] = $artistnameid;
        $data_row["name"] = $artistname;

        array_push($data,$data_row);
        
        // $data[] = $artistname;
        // print_r($data);
    }
    
    //return json data
    echo json_encode($data);
?>