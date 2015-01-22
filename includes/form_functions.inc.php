<?php
define('UPLOAD_DIR', 'images/'); // Define the upload directory
// The size is defined in bytes; 1 kilobyte = 1024 bytes 
define ('MAX_FILE_SIZE', 3000000); // set file size to  kb


function check_required_fields($required_array) {
    $field_errors = array();
    foreach($required_array as $fieldname) {
        if (isset($_POST[$fieldname]) && empty($_POST[$fieldname])) { 
            $field_errors[] = ucfirst($fieldname). " is required"; 
        }
    }
    return $field_errors;
}



function check_max_field_lengths($field_length_array) {
    $field_errors = array();
    foreach($field_length_array as $fieldname => $maxlength ) {
        if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) { $field_errors[] = $fieldname; }
    }
    return $field_errors;
}


function display_errors($error_array) {
    echo "<p class=\"errors\">";
    echo "Please review the following fields:<br />";
    foreach($error_array as $error) {
        echo " - " . $error . "<br />";
    }
    echo "</p>";
}



function display_xml_error($error, $objXML) {    // http://www.php.net/manual/en/function.libxml-get-errors.php
    $return  = $objXML[$error->line - 1] . "\n";
    $return .= str_repeat('-', $error->column) . "^\n";

     switch ($error->level) {
        case LIBXML_ERR_WARNING:
        $return .= "Warning $error->code: ";
        break;
        case LIBXML_ERR_ERROR:
        $return .= "Error $error->code: ";
        break;
        case LIBXML_ERR_FATAL:
        $return .= "Fatal Error $error->code: ";
        break;
     }

    $return .= trim($error->message) ."\n  Line: $error->line" . "\n  Column: $error->column";

    if ($error->file) {
        $return .= "\n  File: $error->file";
    }

    return "$return\n\n---\n\n";
}


?>