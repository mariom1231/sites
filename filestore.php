<?php

class UnexpectedTypeException extends Exception {}



class Filestore {

    public $filename = '';

    private $is_csv = FALSE;


// Set list items and optional filename
    public function __construct($filename = '') {
        $this->filename = strtolower($filename);

        if ((substr($filename, -3)) == 'csv') {
            $this->is_csv = TRUE;
        }
    }

// // Setter for $name. Filters and prepares $name
//     private function set_name($filename) {
// // Check if $name is a string
//         if (is_string($filename)) {
// // Set the name property. Trim all leading and trailing whitespace
//             $this->name = trim(strip_tags($filename));
//         } else {
//             $type = gettype($filename);
//         }throw new UnexpectedTypeException('$filename must be a string, {$type} given');
//     }

// // Return the name property in a descriptive string
//     public function get_name($filename) {
// // Return name with some fluff
//         return "The name property on this instance of this class is '{$this->filename}'";
        
//     }

    public function read() {
        if ($this->is_csv == TRUE) {
            return $this->read_csv();
        } else {
            return $this->read_file();
        }

    }

    public function write($contents) {
        if ($this->is_csv == TRUE) {
            return $this->write_csv($contents);
        } else {
            return $this->write_file($contents);
        }

    }

// Returns array of lines in $this->filename
    private function read_file() {
        $handle = fopen($this->filename, "r");
        if (filesize($this->filename) > 0) {
            $contents = fread($handle, filesize($this->filename));
            return explode("\n", $contents);
        } else {
            return array();
        }
        fclose($handle);
    }

// Writes each element in $array to a new line in $this->filename
    private function write_file($contents) {
        $handle = fopen($this->filename, "w");
        $writeList = implode("\n", $contents);
        fwrite($handle, $writeList);
        fclose($handle);
    }

// Reads contents of csv $this->filename, returns an array
    private function read_csv() {
        $contents = [];
        $handle = fopen($this->filename, "r");
        while (($data = fgetcsv($handle)) !== FALSE) {
            $contents[] = $data;
        }
            fclose($handle);
            return $contents;
    }

// Writes contents of $array to csv $this->filename
    private function write_csv($contents) {
        $handle = fopen($this->filename, "w");
        foreach ($contents as $row) {
            fputcsv($handle, $row);
        }
            fclose($handle);
    }

}