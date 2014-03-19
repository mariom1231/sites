
 
<?php

// var_dump($_POST);
// var_dump($_GET);

    // Array of todos
    $items = array();

    //Set default file name and location
    $filename = 'todo_list.txt';
    

    function loadFile($filename) {
        $setFile = filesize($filename);
        if ($setFile > 0) {
            $handle = fopen($filename, "r");
            $item = fread($handle, filesize($filename));
            fclose($handle);
            return explode("\n", $item);
        } else {
            echo "You have no items in your TODO list at this time.";
            return array();
        }
    }
    
    function saveFile($filename, $item) {
        $itemstr = implode("\n", $item);
        $handle = fopen($filename, "w");
        fwrite($handle, $itemstr);
        fclose($handle);
    }

    // function addFile($filename, $item) {
    //     $beg_or_end = get_input();
        
    //         if ($beg_or_end == 'B') {
    //         array_unshift($items, $addTo);
            
    //         } else {
    //         array_push($items, $addTo);
    // }

    

    // Load $titems array with file contents
    $items = loadFile($filename);



    if (isset($_POST['newitem']))
    {
        $item = $_POST['newitem'];
        array_push($items, $item);
        saveFile($filename, $items);
        header('Location: todo-list.php');
    }
    if (isset($_GET['remove']))
    {
        $itemID = $_GET['remove'];
        unset($items[$itemID]);
        saveFile($filename, $item);
        header('Location: todo-list.php');
        exit(0);
    }

?>


<!DOCTYPE html>
<html>

<head>
        <title>TODO List</title>
</head>
<body>

 <h3> TODO List Items
    </h3>
<ul>   

<?php 

    foreach ($items as $key => $item) {
        echo "<li>$item<p><a href=\"?remove=$key\">Remove item.</a></p></li>";
    }
?>

</ul>


<h3> Menu Options
    </h3>
	<p> 
        <form method="POST" action="">
        <label for="newitem">New Item:</label>
        <input id="newitem" name="newitem" type="text" autofocus="autofocus" placeholder="Enter text here.">
        <input type="submit" value="ADD">

    </p>
    <!-- <p>
        <label for="new">NEW:</label>
        <input type="radio" id="new" name="new" value="New Item">
    </p>
    <p>
        <label for="save">SAVE:</label>
        <input type="radio" id="save" name="save" value="Save Item">
    </p>
    <p>
        <label for="open">OPEN:</label>
        <input type="radio" id="open" name="open" value="Open Item">
    </p>

    <label for="remove">REMOVE: </label>
    <select id="remove" name="remove">
    <option value="F">First</option>
    <option value="L">Last</option>
    </select>
    <p>
        <label for="sort">SORT: </label>
    <select id="sort" name="sort">
    <option value="A">A to Z</option>
    <option value="Z">Z to A</option>
    </select>

    </p> -->

    <p>
        <!-- <button type="submit">SUBMIT</button>
 -->    </p>

	</form>

</body>

</html>