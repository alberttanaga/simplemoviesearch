<?php

// set constant variable
define('API_URL', 'http://www.omdbapi.com/');
define('API_KEY', '95527afa');

// data (array) is parameter e.g (param => value) = ?param=value
function callAPI($url, $data = false) {
    $curl = curl_init();

    if ($data) {
        $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = json_decode(curl_exec($curl));

    curl_close($curl);

    return $result;
}

$result = array();

if ($_GET) {
    $data = [
        'apikey' => API_KEY,
        't'      => $_GET['search'] 
    ];
    
    $search_result = callAPI(API_URL, $data);
    
    $result = [
        'title'   => $search_result->Title,
        'year'    => $search_result->Year,
        'runtime' => $search_result->Runtime,
        'poster'  => $search_result->Poster
    ];
}

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {
  font-family: Helvetica, Arial;
}

* {
  box-sizing: border-box;
}

.header {
  height:100px;
  vertical-align:middle;
  padding: 10px;
  text-align: center;
}

form.searchBox input[type=text] {
  padding: 10px;
  font-size: 17px;
  border: 1px solid grey;
  float: left;
  width: 80%;
  background: #f1f1f1;
}

form.searchBox button {
  float: left;
  width: 20%;
  padding: 10px;
  background: #2196F3;
  color: white;
  font-size: 17px;
  border: 1px solid grey;
  border-left: none;
  cursor: pointer;
}

form.searchBox button:hover {
  background: #0b7dda;
}

form.searchBox::after {
  content: "";
  clear: both;
  display: table;
}

.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}

ul {
  list-style: none;
  padding-left: 0px;
}

li {
  text-align: center; 
  vertical-align: middle;
}

.table {
  display: table;   
  margin: 0 auto;
}

.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: teal;
   color: white;
   text-align: center;
}

</style>
<title>Search</title>
</head>
<body>

    <div class="header">
        <h1>Movie Search</h1>
    </div>

    <form class="searchBox" action="<?php echo $_SERVER['PHP_SELF'] ?>" style="margin:auto;max-width:300px" method="get">
        <input type="text" placeholder="Search.." name="search" required>
        <button type="submit"><i class="fa fa-search"></i></button>
    </form>

    <?php if($result) { ?>

    <br><br>

    <div class="searchResult" style="margin:auto;max-width:450px">
        <div><img src="<?= $result['poster'] ?>" class="center"></div>
        <div class="table">
            <ul>
                <li><h1 style="text-decoration:underline;text-decoration-color:<?=$_GET['search']?>"><?= $result['title'] ?></h1></li>
                <li><h4><?= $result['year'] ?></h4></li>
                <li><h4><?= $result['runtime'] ?></h4></li>
            </ul>
        </div>
    </div>

    <?php } ?>

    <div class="footer">
        <p>Albert Tanaga 2021</p>
    </div>
</body>
</html> 
