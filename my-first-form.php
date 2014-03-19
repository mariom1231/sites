<?php

echo "<p>GET:</p>";
var_dump($_GET);

echo "<p>POST:</p>";
var_dump($_POST);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>My First HTML Form!</title>
    </head>
<form method="GET" action="">
    <h3> User Login
    </h3>
    <p>
        <label for="username">Username</label>
        <input id="username" name="username" type="text" placeholder="Enter your username">
    </p>
    <p>
        <label for="password">Password</label>
        <input id="password" name="password" type="password" placeholder="Enter your password">
    </p>
    <p>
        <button type="submit">Submit</button>
    </p>
</form>

<form method="GET" action="">
    <h3> Compose An Email
    </h3>
    <p>
        <label for="to">TO:</label>
        <input id="to" name="to" type="text" placeholder="Enter email recipient">
    </p>
    <p>
        <label for="from">FROM:</label>
        <input id="from" name="from" type="text" placeholder="Enter your email address">
    </p>
    <p>
        <label for="subject">SUBJECT:</label>
        <input id="subject" name="subject" type="text" placeholder="Enter subject here">
    </p>
    <p>
        <label for="body">BODY:</label>
        <textarea id="body" name="body" rows="5" cols="40" placeholder="Enter text here"></textarea>
    </p>
    <p>
        <button type="send">SEND</button>
    </p>

        
    
</form>

</html>