<?php

var_dump($_FILES);


require_once('address_data_store.php');

$newbook = new AddressDataStore('address_book.csv');
$address_book = $newbook->read();

// validation.  
if (!empty($_POST)) {
// insert TRY/CATCH HERE!
    try {

        $name = $_POST['name1'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];
        $phone = $_POST['phone'];
        $entry = [$name, $address, $city, $state, $zip, $phone];

        foreach ($entry as $key => $value) {
            if (empty($value)) {
                throw new InvalidInputException ('$key is empty');
            } elseif (strlen($value) > 125) {
                    throw new InvalidInputException('$key must be less than 125 chars.');
            }
        }

        foreach ($_POST as $key => $value) {
            $_POST[$key] = htmlspecialchars(strip_tags($value));
        }


        array_push($address_book, array_values($entry));
        $newbook->write($address_book);

    }   catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage(), '\n';
    }

}

// code to remove item from address book
if (isset($_GET['remove'])) {
        $entry = $_GET['remove'];
        unset($address_book[$_GET['remove']]);
        $newbook->write($address_book);
        header('Location: address_book.php');
        exit(0);
    }

$errorMessage = '';

// Verify there were uploaded files and no errors
if (count($_FILES) > 0 && $_FILES['uploadedfile']['error'] == 0) {
        $errorMessage = "Error uploading the file.";
// Set the destination directory for uploads
    } else {
        $upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
        // Grab the filename from the uploaded file by using basename
        $filename = basename($_FILES['uploadedfile']['name']);
        // Create the saved filename using the file's original name and our upload directory
        $saved_filename = $upload_dir . $filename;
        // Move the file from the temp location to our uploads directory
        move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $saved_filename);
        $newbook = new AddressDataStore($saved_filename);
        
        if (isset($_POST['overwrite']) && ($_POST['overwrite']) == 'yes') {
            $address_book = $newbook; 
                 
            } else {
                $address_book = array_merge($address_book, $newbook);
           
            }
            
            $newbook->write($address_book);
    }


?>



<!DOCTYPE html>
<html>

<body>


<table>

    <h3> Address Book Entry</h3>
<? foreach ($address_book as $key => $row): ?>
    <tr>
		<? foreach ($row as $entry): ?>
			<td><?= $entry; ?></td>
			<? endforeach; ?>
			<td><a href='?remove=<?= $key; ?>'>Remove item.</a></td>
		<? endforeach; ?>
	</tr>

</table>
<form method="POST" action="">
	<h3> Add New Entry</h3>
    	<p>
        	<label for="name1">Name</label>
       		<input id="name1" name="name1" type="text" autofocus="autofocus" placeholder="Enter name">
    	</p>
    	<p>
        	<label for="address">Address</label>
        	<input id="address" name="address" type="text" placeholder="Enter address">
    	</p>
    	<p>
        	<label for="city">City</label>
        	<input id="city" name="city" type="text" placeholder="Enter city">
    	</p>
    	<p>
        	<label for="state">State</label>
        	<input id="state" name="state" type="text" placeholder="Enter state">
    	</p>
    	<p>
        	<label for="zip">Zip</label>
        	<input id="zip" name="zip" type="text" placeholder="Enter zip">
    	</p>
    	<p>
        	<label for="phone">Phone</label>
        	<input id="phone" name="phone" type="text" placeholder="Enter phone">
    	</p>
    	<p>
        	<button type="submit">Submit</button>
    	</p>
</form>

<form method="POST" enctype="multipart/form-data" action="">
		<p>
        	<label for="uploadedfile">File to Add:</label>
        	<input id="uploadedfile" name="uploadedfile" type="file">
        	<input type="submit" value="Upload">
    	</p>
</form>

</body>

</html>