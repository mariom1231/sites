<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>National Parks</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
  	<link href="css/cyborg-bootstrap.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">National Parks of the United States</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


  </head>
  <body>
    
 <?php

 // Get new instance of MySQLi object
$mysqli = new mysqli('127.0.0.1', 'codeup', 'password', 'codeup_mysqli_test_db');

// Check for errors
if ($mysqli->connect_errno) {
    throw new Exception('Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Write if statement here
// Query to get the parks.

if (isset($_GET['sort_column']) && ($_GET['sort_order'])) {
  $sortCol = $_GET['sort_column'];
  $sortOrder = $_GET['sort_order'];

  $result = $mysqli->query("SELECT * FROM national_parks order by $sortCol $sortOrder");
}
else
  {
  $result = $mysqli->query("SELECT * FROM national_parks");
}

?>

<div class="table-responsive">
  <table class="table cellpadding="10">
  <tr>
  <th>
    Name
    <a href="?sort_column=name&amp;sort_order=asc"><i class="fa fa-arrow-up"></i></a>
    <a href="?sort_column=name&amp;sort_order=desc"><i class="fa fa-arrow-down"></i></a>
  </th>
  <th>Location
    <a href="?sort_column=location&amp;sort_order=asc"><i class="fa fa-arrow-up"></i></a>
    <a href="?sort_column=location&amp;sort_order=desc"><i class="fa fa-arrow-down"></i></a>
  </th>
  <th>Date Established
   <a href="?sort_column=date&amp;sort_order=asc"><i class="fa fa-arrow-up"></i></a>
    <a href="?sort_column=date&amp;sort_order=desc"><i class="fa fa-arrow-down"></i></a> 
  </th>
  <th>Area (in Acres)
    <a href="?sort_column=area_in_acres&amp;sort_order=asc"><i class="fa fa-arrow-up"></i></a>
    <a href="?sort_column=area_in_acres&amp;sort_order=desc"><i class="fa fa-arrow-down"></i></a>
  </th>
  <th>Description
  </th>
  </tr>
 
<?php
$rows = array();
// Populate results array
while ($parks = $result->fetch_assoc()): ?>
        <tr>
              <td> <?= $parks['name']; ?> </td>
              <td> <?= $parks['location']; ?> </td>
              <td> <?= $parks['date_established']; ?> </td>
              <td> <?= $parks['area_in_acres']; ?> </td>
              <td> <?= $parks['description']; ?> </td>
          </tr>
    <? 
     // $rows[]=$row;
    endwhile;

// while ($row = $result->fetch_assoc()) {

 
// }
// var_dump($rows);

if ((isset($_POST['park_name'])) && (isset($_POST['location'])) && (isset($_POST['date_established'])) && (isset($_POST['area_in_acres'])) && (isset($_POST['description'])))
{

$name = $_POST['park_name'];
$location = $_POST['location'];
$date_established = $_POST['date_established'];
$area_in_acres = $_POST['area_in_acres'];
$description = $_POST['description'];

  // Create a new prepared statement.
  $stmt = $mysqli->prepare("INSERT INTO national_parks (name, location, date_established, area_in_acres, description) VALUES (?,?,?,?,?)");

  // Bind a new parameter to the ?
  $stmt->bind_param("sssds", $name, $location, $date_established, $area_in_acres, $description);

  // Execute the prepared query
  $stmt->execute();

  // // Bind result vars
  // $stmt->bind_result($name, $location, $date_established, $area_in_acres, $description);

}
// Get all parks
// $result = $mysqli->query('SELECT * FROM national_parks');

// Create an empty array for results



// Close connection
    $mysqli->close();

?>


  </table>

  <form method="POST" action="">
    <h3> Create a new National Park entry:
    </h3>
    <p>
        <label for="park_name">PARK NAME:</label>
        <input id="park_name" name="park_name" type="text" autofocus="autofocus" required>
    </p>
    <p>
        <label for="location">LOCATION:</label>
        <input id="location" name="location" type="text">
    </p>
    <p>
        <label for="date_established">DATE ESTABLISHED:</label>
        <input id="date_established" name="date_established" type="text" placeholder="YYYY-MM-DD">
    </p>
    <p>
        <label for="area_in_acres">AREA (IN ACRES):</label>
        <input id="area_in_acres" name="area_in_acres" type="text" placeholder="Do not enter commas">
    </p>
    <p>
        <label for="description">DESCRIPTION:</label>
        <textarea id="description" name="description" rows="5" cols="40" placeholder="Enter park description here"></textarea>
    </p>
    <p>
        <button type="submit">Submit</button>
    </p>
    
</form>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
