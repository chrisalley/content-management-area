<?php

class data_module {

  var $connection;
  var $database;

  function data_module() { // Constructor  
    $this -> connect();
  }
  
  function connect() {
  require("config.php");
   
    $this -> connection = mysql_connect($host, $user, $password)
      or die("Error connecting to server: " . mysql_error());
    
    $this -> database = mysql_select_db($dbname, $this -> connection)
      or die("Error connecting to database: " . mysql_error());
  }
  
  // Returns true if the user name and password match.
  function does_user_name_match_password($user_name, $password) {     
    $record_set = mysql_query(
      "SELECT user_name, password " .
      "FROM cma_users " .
      "WHERE user_name = '" . $user_name . "'"
    ) or die("The following error has occurred: " . mysql_error());
    $number_of_rows = mysql_num_rows($record_set);
    $data = mysql_fetch_array($record_set);
    if (sha1($password) == $data["password"]) {
      return true;
    }
    else {
      return false; 
    }
  }
  
  // Returns the number of users that match $user_name in the database.
  function get_number_of_users_matching_user_name($user_name) {
    $record_set = mysql_query(
      "SELECT user_name " .
      "FROM cma_users " .
      "WHERE user_name = '" . $user_name . "'"
    ) or die("The following error has occurred: " . mysql_error());
    $number_of_users = mysql_num_rows($record_set);
    return $number_of_users;
  }
  
  // Returns the total number of users in the users table.
  function get_total_number_of_users() {
    $result = mysql_query("SELECT user_id FROM cma_users");
    $number_of_rows = mysql_num_rows($result);
    return $number_of_rows;
  }
  
  // Returns true if the user details are successfully added to the database.
  function register_user($user_details) {
    mysql_query(
      "INSERT INTO cma_users (" .
        "user_name, " .
        "password, " . 
        "email_address, " .
        "age, " .
        "sex, " . 
        "location, " .
        "profile, " .
        "datetime_created, " .
        "datetime_last_modified" .
      ") " .
      "VALUES (" .
        "'" . $user_details["user_name"] . "', " .
        "'" . sha1($user_details["password"]) . "', " .
        "'" . $user_details["email_address"] . "', " .
        "'" . $user_details["age"] . "', " .
        "'" . $user_details["sex"] . "', " .
        "'" . $user_details["location"] . "', " .
        "'" . $user_details["profile"] . "'," . 
        "'" . date("Y-n-d H-i-s") . "'," . // Sets datetime_created as the current datetime.
        "'" . date("Y-n-d H-i-s") . "'" . // Sets datetime_last_modified as the current datetime.
      ")"
    ) or die("The following error has occurred: " . mysql_error());
    return true;
  }
  
  function edit_user_profile($user_details) {
    mysql_query(
    "UPDATE cma_users " .
    "SET " .
    "password = '" . sha1($user_details["password"]) . "', " .
    "email_address = '" . $user_details["email_address"] . "', " .
    "age = '" . $user_details["age"] . "', " .
        "sex = '" . $user_details["sex"] . "', " . 
        "location = '" . $user_details["location"] . "', " .
        "profile = '" . $user_details["profile"] . "', " .
        "datetime_last_modified = '" . date("Y-n-d H-i-s") . "' " . // Sets datetime_last_modified as the current datetime.
    "WHERE user_name = '" . $user_details["user_name"] . "'"
  ) or die("The following error has occurred: " . mysql_error());
    return true;
  }
  
  function does_user_name_exist($user_name) {
    $record_set = mysql_query(
      "SELECT user_name " .
      "FROM cma_users " .
      "WHERE user_name = '" . $user_name . "'"
    ) or die("The following error has occurred: " . mysql_error());
    $number_of_rows = mysql_num_rows($record_set);
    if ($number_of_rows == 1) {
      return true;
    }
    else {
      return false;
    }
  }
  
  function get_user_details($user_name) {
    $record_set = mysql_query(
      "SELECT " . 
        "user_name, " .
        "email_address, " .
        "age, " .
        "sex, " .
        "location, " .
        "profile, " .
        "date_format(datetime_created,'%d %M %Y') as formatted_datetime_created, " .
        "date_format(datetime_last_modified,'%d %M %Y') as formatted_datetime_last_modified " .
      "FROM cma_users " . 
      "WHERE user_name = '" . $user_name . "'"
    ) or die("The following error has occurred: " . mysql_error());
    $user_details = mysql_fetch_array($record_set);
    return $user_details;
  }
  
  function delete_user($user_name) {
    mysql_query(
    "DELETE FROM cma_users " .
    "WHERE user_name = '" . $user_name . "'"    
  ) or die("The following error has occurred: " . mysql_error());
  return true;
  }
  
  function does_page_exist($partial_url) {
    $record_set = mysql_query(
      "SELECT * " . 
      "FROM cma_pages " .
      "WHERE partial_url = '" . $partial_url . "'"
    ) or die("The following error has occurred: " . mysql_error());
    // Sets $parent_page_id to the above query's result.
    $number_of_rows = mysql_num_rows($record_set);
    if ($number_of_rows > 0) {
      return true;
    }
    else {
      // Returns false if the partial url is not found in the database.
      return false;
    }
  }

  function get_page_details($partial_url) {
    $record_set = mysql_query(
      "SELECT " . 
        "title, " .
        "keywords, " .
        "description, " .
        "partial_url, " .
        "body " .
      "FROM cma_pages " . 
      "WHERE partial_url = '" . $partial_url . "'"
    ) or die("The following error has occurred: " . mysql_error());
    $page_details = mysql_fetch_array($record_set);
    return $page_details;
  }
  
  function get_total_number_of_pages() {
    $result = mysql_query("SELECT page_id FROM cma_pages");
    $number_of_rows = mysql_num_rows($result);
    return $number_of_rows;
  }
  
  function get_user_id($user_name) {
    $record_set = mysql_query(
      "SELECT user_id " .
      "FROM cma_users " .
      "WHERE user_name = '" . $user_name . "'
    ") or die("The following error has occurred: " . mysql_error());
    $data = mysql_fetch_array($record_set);
    $user_id = $data["user_id"];
    return $user_id;
  }
  
  function add_page($page_details) {
    $user_id = $this -> get_user_id($_SESSION["user_name"]);
    $record_set = mysql_query(
      "INSERT INTO cma_pages (" .
        "title, " .
        "keywords, " .
        "description, " .
        "partial_url, " .
        "body, " .
        "user_id" .
      ") " .
      "VALUES (" . 
        "'" . addslashes($page_details["title"]) . "', " .
          "'" . addslashes($page_details["keywords"]) . "', " .
          "'" . addslashes($page_details["description"]) . "', " .
          "'" . addslashes($page_details["partial_url"]) . "', " .
          "'" . addslashes($page_details["body"]) . "', " .
          $user_id .
      ")"
    ) or die("The following error has occurred: " . mysql_error());
    return true;
  }
  
  function edit_page($page_details) {
    $record_set = mysql_query(
      "UPDATE cma_pages " .
      "SET " .
      "title = '" . addslashes($page_details["title"]) . "', " .
      "keywords = '" . addslashes($page_details["keywords"]) . "', " .
      "description = '" . addslashes($page_details["description"]) . "', " .
          "body = '" . $page_details["body"] . "' " .
      "WHERE partial_url = '" . $page_details["partial_url"] . "'"
    ) or die("The following error has occurred: " . mysql_error());
    return true;
  }
  
  function delete_page($partial_url) {
    mysql_query(
      "DELETE FROM cma_pages " .
      "WHERE partial_url = '" . $partial_url . "'"    
    ) or die("The following error has occurred: " . mysql_error());
    return true;
  }

}

?>