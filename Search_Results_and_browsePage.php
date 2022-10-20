
<!DOCTYPE html>
<html lang=en>
<head>
    <title>COMP 3512 Assign1-Search Results</title>
    <meta charset=utf-8>
    <p class="subtitle" align="right">Hussein Abuqadous & Justin Savenko</p>
    <link rel="stylesheet" href="./css/Search_Results_andbrowsePage.css">
</head>
<body>
<section>
    
</section>
<h1>Search Results</h1>
<?php
    session_start();
    require_once('config.inc.php');
    require_once 'includes/asg1-db-classes.inc.php'; 
    if(isset($_GET["search"])){
    if(empty($_GET ["title"]) && $_GET["artist"]=="0" 
    && $_GET["genre"] =="0" && empty($_GET["less_Year"]) 
    && empty($_GET["Greater_Year"]) && empty($_GET["Less_Popularity"]) && empty($_GET['Greater_Popularity'])){
     echo "You have not searched anything go back to the previous page";
    }
    elseif (isset($_GET ["title"]) && $_GET["artist"]=="0" 
        && $_GET["genre"] =="0" && empty($_GET["less_Year"]) 
        && empty($_GET["Greater_Year"]) && empty($_GET["Less_Popularity"]) && empty($_GET['Greater_Popularity'])){
      $title = findbytitle($_GET["title"]);
      output($title);
    }
    elseif(isset($_GET["artist"]) && empty($_GET["less_Year"]) 
        && empty($_GET["Greater_Year"]) && empty($_GET["Less_Popularity"]) 
        && empty($_GET["Greater_Popularity"]) && empty($_GET ["title"]) && $_GET["genre"] =="0"){
        if (is_numeric($_GET["artist"])) {
        $artist = findbyartist(intval($_GET["artist"]));
        output($artist);
        }
    }
    elseif(isset($_GET["genre"]) && $_GET["artist"]=="0"  && empty($_GET["less_Year"]) 
         && empty($_GET["Greater_Year"]) && empty($_GET["Less_Popularity"]) 
        && empty($_GET["Greater_Popularity"]) && empty($_GET ["title"])){
            if (is_numeric($_GET["genre"])) {
            $genre =  findbygenre(intval($_GET["genre"]));
            output($genre );
            }
    }
    else if(isset($_GET["less_Year"])&& empty($_GET["Greater_Year"]) && $_GET["artist"]=="0"
    && empty($_GET["Less_Popularity"])  && empty($_GET["Greater_Popularity"]) 
    && empty($_GET ["title"])  && $_GET["genre"] =="0" ){ 
    if (is_numeric($_GET["less_Year"])) {
        $less_year = intval($_GET["less_Year"]);
        output(findbylessyear($less_year)) ;
    }
    }
    elseif(isset($_GET["Greater_Year"]) && $_GET["artist"]=="0" 
        && $_GET["genre"] =="0" && empty($_GET["less_Year"]) && empty($_GET["Less_Popularity"])  
        && empty($_GET["Greater_Popularity"]) && empty($_GET ["title"]) ){
        if (is_numeric($_GET["Greater_Year"])) {
            $greater_year = intval($_GET["Greater_Year"]);
            output(findbygreateryear($greater_year));
        }
    }
    elseif(isset($_GET["Less_Popularity"])  && $_GET["artist"]=="0" 
    && $_GET["genre"] =="0" && empty($_GET["less_Year"]) 
    && empty($_GET["Greater_Year"]) && empty($_GET["Greater_Popularity"])&& empty($_GET ["title"])){
    if(is_numeric($_GET["Less_Popularity"])){
        $less_popularity = intval($_GET["Less_Popularity"]);
    output(findbylesspopularity($less_popularity));
    }
    }
    elseif(isset($_GET["Greater_Popularity"])  && $_GET["artist"]=="0"
        && $_GET["genre"] =="0" && empty($_GET["less_Year"]) 
        && empty($_GET["Greater_Year"]) && empty($_GET["Less_Popularity"])&& empty($_GET ["title"]) ){
        if(is_numeric($_GET["Greater_Popularity"])){
        $greaterpopularity = intval($_GET["Greater_Popularity"]);
        output(findbygreaterpopularity ($greaterpopularity));
        }
    }
    else {
        echo "only one feild can have a input";
    }
}

    function findbytitle($songtitle){
        try{
            $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
            $titleGateway = new BrowseByTitleDB($conn);
            $titles = $titleGateway->getAll($songtitle);
            $titleGateway = null;
            return $titles;
        }
        catch(PDOException $e){
            die($e->getMessage()); 
        }
        } 
        
    
    function findbyartist ($artist){
        try{
            $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
            $artistGateway = new BrowseByArtistDB($conn);
            $artists = $artistGateway->getAll($artist);
            $artistGateway = null;
            return $artists;
        }
        catch(PDOException $e){
            die($e->getMessage()); 
    
        }
        }
    

    function findbygenre($genre){
        try{
            $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
            $genreGateway = new BrowseByGenreDB($conn);
            $genres = $genreGateway->getAll($genre);
            $genreGateway = null;
            return $genres;
        }
        catch(PDOException $e){
            die($e->getMessage()); 
    
        } 
    }
   
    function findbylessyear($less_year){
        try{
            $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
            $lessYearGateway = new BrowseByLessYearDB($conn);
            $lessYears = $lessYearGateway->getAll($less_year);
            $lessYearGateway = null;
            return $lessYears;
        }
        catch(PDOException $e){
            die($e->getMessage()); 
    
        } 
    }
    
    function findbygreateryear($greater_year){
        try{
            $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
            $greaterYearGateway = new BrowseByGreatYearDB($conn);
            $greatYears = $greaterYearGateway->getAll($greater_year);
            $greaterYearGateway = null;
            return $greatYears;
        }
        catch(PDOException $e){
            die($e->getMessage()); 
    
        } 
    }
   // Neither of the popularity work trying to find out why (SQLSTATE error)
    function findbylesspopularity($less_popularity){
        try{
            $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
            $lessPopularityGateway = new BrowseByLessPopularityDB($conn);
            $lessPopularities = $lessPopularityGateway->getAll($less_popularity);
            $lessPopularityGateway = null;
            return $lessPopularities;
        }
        catch(PDOException $e){
            die($e->getMessage()); 
    
        } 
    }
    
    function findbygreaterpopularity($greaterpopularity){
        try{
            $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
            $greaterPopularityGateway = new BrowseByGreatPopularityDB($conn);
            $greaterPopularities = $greaterPopularityGateway->getAll($greaterpopularity);
            $greaterPopularityGateway = null;
            return $greaterPopularities;
        }
        catch(PDOException $e){
            die($e->getMessage()); 
    
        } 
    }

?>
<?php 
    if (!isset($_GET["search"])) {
        echo '<form  method="post">';
        echo '<input id="showall" type="submit" name="showall"value="Show All">';
        echo '</form>';

            if(isset($_POST["showall"])){
            try{ 
                $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
                $dataGateway = new AllDB($conn);
                $data = $dataGateway->getAll();
                $dataGateway = null;
                    output($data);
            }
            catch(PDOException $e){
                die($e->getMessage()); 
        
            } 
        }
        
    }
    ?>
    <br>
    <?php
    function output($data){
    echo "<table>";
    echo "<tr>";
    echo "<th>Title</th>";
    echo "<th class='artist'>Artist</th>";
    echo "<th class='year'>Year</th>";
    echo "<th class='genre'>Genre</th>";
    echo "<th class='popularity'>Populartiy</th>";
    echo"<th> </th>";
    echo"<th>  </th>";
    echo "</tr>";
    foreach ($data as $row) {

           echo "<tr>";
           echo "<td id='title'>".$row['title']."</td>";
           echo "<td class='artist'>".$row['artist_name']."</td>";
           echo "<td class='year'>".$row['year']."</td>";
           echo "<td class='genre'>".$row['genre_name']."</td>";
           echo "<td class='popularity'>".$row['popularity']."</td>";
           echo '<td class="favorites"><a href="addFavourites.php?song_id=' . $row['song_id'] . '&title=' . $row['title'] . '&artist=' . $row['artist_name'] . '&year=' . $row['year'] . '&genre=' . $row['genre_name'] . '&popularity=' . $row['popularity'] . '">' . "Add to Favourites" . '</a></td>';
           echo "<td class='favorites'> <a href=' singleSongPage.php?song_id=". $row['song_id']. "' > View  </td>";
           echo "</tr>";
    }
    echo "</table>";
    }

    
    ?>
    
    <footer>
  <div>COMP 3512 Fall 2022</div>
  <div>Hussein Abuqadous & Justin Savenko &#169</div>
  <div><a href ="https://github.com/theonlyhussein/Ass1-WEB2-Hussein-Abuqadous_Justin-Savenko">Github Repo</a></div>
  <div><a href ="https://github.com/theonlyhussein">Hussein Github</a></div>
  <div><a href ="https://github.com/Jsavy">Justin Github</a></div>
</footer>
</body>
</html>