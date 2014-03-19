<?php

class Conversation {

    // Property to hold name
    public $name = '';

    public $lastname = '';
    // Method to say hello to name
    function say_hello() 
    {
        $greeting = "Hello {$this->name} {$this->lastname}";

        if ($paragraph == TRUE) {
        	return "<p>{$greeting}</p>";
        } else {
        	return $greeting;
        }
    }
    function say_goodbye() {
    	return "Goodbye {$this->name} {$this->lastname}";
    }
}

// Create a new instance of Conversation
$chat = new Conversation();

// Set the $name variable
$chat->name = 'Codeup';
$chat->lastname = 'Cohort';

// Output greeting to $name
echo $chat->say_hello();

?>

<html>
<head>
		<title><?= chat->say_hello(FALSE); ?></title>
</head>
<body>
		<?= $chat->say_hello(); ?>
		<hr>
		<p><?= chat->say_goodbye(); ?></p>
</body>
</html>

