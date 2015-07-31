<?php
if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}
/* The folder path of the index.php file from the domain root
 * For example if you install standings at www.example.com/standings/ the value below would be '/standings/'
 */
$strLocation = '/dev/eval/';

// Database Details
$strHost="localhost";     // DB Location 
$strUser="";   // Username 
$strPass="";     // Password 
$strDb="";    // DB Name 

// Database Tables
define("ADMIN_USERS_TABLE", "admin_users");
define("COMMENT_TYPES_TABLE", "comment_types");
define("COMMENT_SUBTYPES_TABLE", "comment_subtypes");
define("COMMENTS_TABLE", "comments");
define("COMPONENTS_TABLE", "components");
define("EVALUATIONS_TABLE", "evaluations");
define("EVALUATIONS_TO_COMMENTS_TABLE", "evaluations_to_comments");
define("EVALUATIONS_TO_COMPONENTS_TABLE", "evaluations_to_components");