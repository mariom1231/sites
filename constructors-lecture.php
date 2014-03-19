<?php

class Conversation {

    // Property to hold name
    public $name = '';

    // Allow name to be set on instantiation
    function __construct($name = '')
    {
        $this->name = $name;
    }

    // Method to say hello to name
    function say_hello($new_line = FALSE) 
    {
        // Set the greeting name
        $greeting = "Hello {$this->name}";

        // Return the greeting, checking for newline
        return $new_line == TRUE ? "$greeting\n" : $greeting;
    }

}

// Create a new instance of Conversation
// Set the $name to 'Codeup'
$chat = new Conversation('Codeup');

// Output greeting to $name, with trailing newline
echo $chat->say_hello(TRUE);