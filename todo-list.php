<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>To-Do List</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/cyborg-bootstrap.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

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
      <a class="navbar-brand" href="#">My To-Do List</a>
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

// var_dump($_GET);

// var_dump($_POST);

$errorMessage = null;
$successMessage = null;
$itemsPerPage = 4;

// Connect to the database
$mysqli = new mysqli('127.0.0.1', 'codeup', 'password', 'todo_list_db');

// Check for errors
if ($mysqli->connect_errno) {
    throw new Exception('Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (!empty($_POST)) {
// Check for new todo list item
    if (isset($_POST['todo'])) {

        if ($_POST['todo'] != "") {
            $todo = substr($_POST['todo'], 0,200);

// Add todo list item to database.
// Create a new prepared statement.
        $stmt = $mysqli->prepare("INSERT INTO todo_list (item) VALUES (?);");
// Bind a new parameter to the ?
        $stmt->bind_param("s", $todo);
// Execute the prepared query
        $stmt->execute();
        $successMessage = "ToDo item successfully added.";
        } else {
// Show error message
        $errorMessage = "Please input a ToDo item.";
        }
    } elseif (!empty($_POST['remove'])) {

// Remove item for database
        $stmt = $mysqli->prepare("DELETE FROM todo_list WHERE id = ?;");
// Bind a new parameter to the ?
        $stmt->bind_param("i", $_POST['remove']);
// Execute the prepared query
        $stmt->execute();

        $successMessage = "Todo list item was removed successfully.";  
    }

}

$currentPage = !empty($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($currentPage - 1) * $itemsPerPage;
 
$todos = $mysqli->query("SELECT * FROM todo_list LIMIT $itemsPerPage OFFSET $offset;");
$allTodos = $mysqli->query("SELECT * FROM todo_list;");
 
$maxPage = ceil($allTodos->num_rows / $itemsPerPage);
 
$prevPage = $currentPage > 1 ? $currentPage - 1 : null;
$nextPage = $currentPage < $maxPage ? $currentPage + 1 : null;

// // Close connection
//     $mysqli->close();

?>

<!DOCTYPE html>
<html>

<head>
        <title>To-Do List</title>
       
</head>
<body>

<div class="container">
 
    <? if (!empty($successMessage)): ?>
        <div class="alert alert-success"><?= $successMessage; ?></div>
    <? endif; ?>
    <? if (!empty($errorMessage)): ?>
        <div class="alert alert-danger"><?= $errorMessage; ?></div>
    <? endif; ?>

 <h3>To-Do List Items</h3>
 
    <table class="table table-striped">
    <? while ($todo = $todos->fetch_assoc()): ?>
        <tr>
            <td><?= $todo['item']; ?></td>
            <td><button class="btn btn-danger btn-sm pull-right" onclick="removeById(<?= $todo['id']; ?>)">Remove</button></td>
        </tr>
    <? endwhile; ?>
    </table>


    <div class="clearfix">
        <? if ($prevPage != null): ?>
            <a href="?page=<?= $prevPage; ?>" class="pull-left btn btn-default btn-sm">&lt; Previous</a> 
        <? endif; ?>
 
        <? if ($nextPage != null): ?>
            <a href="?page=<?= $nextPage; ?>" class="pull-right btn btn-default btn-sm">Next &gt;</a> 
        <? endif; ?>
    </div>


<h3>Menu Options</h3>
    <form class="form-inline" role="form" action="todo-list.php" method="POST">
        <div class="form-group">
            <label class="sr-only" for="todo">To-Do Item</label>
            <input type="text" name="todo" id="todo" class="form-control" placeholder="Enter list item here.">
        </div>
        <button type="submit" class="btn btn-default">Add To-Do</button>
    </form>
 
</div>
 
<form id="removeForm" action="todo-list.php" method="post">
    <input id="removeId" type="hidden" name="remove" value="">
</form>
 
<script>
    
    var form = document.getElementById('removeForm');
    var removeId = document.getElementById('removeId');
 
    function removeById(id) {
        if (confirm('Are you sure you want to remove item ' + id + '?')) {
            removeId.value = id;
            form.submit();
        }
    }
 
</script>
 
</body>
</html>