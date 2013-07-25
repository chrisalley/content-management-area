<?php

class user {

  var $is_logged_in = false;
  var $user_name = "";
  
  function user() {
  	
  	// Sets user properties if a session exists:
  	if ($_SESSION["user_name"] == true) {
  	  $this -> user_name = $_SESSION["user_name"];
  	  $this -> is_logged_in = true;  
  	}
  }
	
  function log_in() {
  	// An array of messages to print at the top of the page.
  	$messages = array();
  	// A variable that tells the script if it needs to display the form.
  	$display_form = true;
  	if ($_SESSION["user_name"] == true) {
  	  array_push($messages, "You are already logged in.");
  	  $display_form = false;
  	}
  	else {
      if ($_POST["log_in"] == false) {
      	array_push($messages, "Please type in your user name and password to continue.");
  	  }
      else {
      	$data_module = new data_module();
  	    $user_name = trim($_POST["user_name"]);
  	    $password = trim($_POST["password"]);
  	    // If the user_name field is blank:
  	    if ($user_name == "") {
  	      array_push($messages, "The user name field must not be blank.");
  	    }
  	    else {
  	      // If $user_name is not found in the database:
  	      if ($data_module -> get_number_of_users_matching_user_name($user_name) != 1) {
  	        array_push($messages, "The user name that you typed in does not exist.");
  	      }	
  	    }
  	    // If the password field is blank:
  	  	if ($password == "") {
  	  	  array_push($messages, "The password field must not be blank.");
  	  	}
  	  	else {
  	  	  // If the password does not match the one in the database:
  	      if ($data_module -> does_user_name_match_password($user_name, $password) == false) {
  	        array_push($messages, "The password that you typed in is not correct.");
  	      }
  	  	}  	  
  	  }
  	}
  	if (count($messages) == 0) {
      $_SESSION["user_name"] = $user_name;
  	  $this -> is_logged_in = true;
  	  array_push($messages, "You are now logged in as " . $_SESSION["user_name"] . ".");
  	  $display_form = false;
  	}
  	$log_in_page = new page();
  	$log_in_page -> display_log_in_page($messages, $display_form, $user_name);
  } // End of log_in() method.
  
  function log_out() {
  	// An array of messages to print at the top of the page.
  	$messages = array();
  	if ($this -> is_logged_in == false) {
  	  array_push($messages, "You are not logged in, therefore you can not log out.");
  	}
  	else {
  	  $_SESSION = array();
  	  session_destroy();
  	  $this -> is_logged_in = false;
  	  $this -> user_name = "";
  	  array_push($messages, "You are now logged out.");
  	}
  	$log_out_page = new page();
  	$log_out_page -> display_log_out_page($messages);
  } // End of log_out() method.
  
  function list_pages() {
    $list_pages_page = new page();
    $list_pages_page -> display_control_panel_header(); 
  
    echo "      <h1>List Pages</h1>\n";
  
    // An array of messages to print at the top of the page.
  	$messages = array();
  	// A variable that tells the script if there is a profile to display.
  	$display_page_list = false;
	
    // If page_number hasn't been typed into the address bar, set the page number to 1:
    if (!$page_number) {
   	  $page_number = 1;
    }
  
    // Sets the number of users to appear on the page, and what user to start at.
    $rows_per_page = 10;
    $starting_row = ($page_number * $rows_per_page) - $rows_per_page;
  
    $data_module = new data_module();
    
    // Gets the number of rows in the table and stores it in $number_of_rows.
    $number_of_rows = $data_module -> get_total_number_of_pages();
  
    // Sets the number of pages.
    $number_of_pages = ceil($number_of_rows / $rows_per_page);
	
    echo "      Pages: ";
    
    // Adds a "Previous" link to the start of the page number list.
    if ($page_number > 1) {
  	  echo "<a href=\"?page=control_panel/list_pages/" . ($page_number - 1) .
  	    "\" title=\"Previous\">Previous</a> |\n";
    }
  
    // Outputs a list of page numbers, such as 1 | 2 |3 | 4
    for ($i = 1; $i <= $number_of_pages; $i++) {
  	  echo "<a href=\"?page=control_panel/list_pages/". $i . 
  	    "\" title=\"Page Number " . $i . "\">" . $i . "</a>\n";
  	  if ($i != $number_of_pages) {
  	    echo " | ";
      }
    }
    
    // Adds a "Next" link to the end of the page number list.
    if ($page_number < $number_of_pages) {
  	  echo " | <a href=\"?page=control_panel/list_pages/" . ($page_number + 1) .
  	    "\" title=\"Next\">Next</a>\n"; 
    }
    
    echo "<br />\n";
    
    // If the user types in a page number that doesn't in exist in the address bar.
    if ($page_number < 1 or $page_number > $number_of_pages) {
      array_push($messages, "You typed in an page number that does not exist or there are no pages in the database.");
    }
    else {
      $record_set = mysql_query("SELECT partial_url " .
        "FROM cma_pages " .
        "LIMIT " . $starting_row . ", " . $rows_per_page);
      if (mysql_num_rows($record_set) == 0) {
        echo "<p>There are currently no pages in the database.</p>\n";
      }
      else {
	    echo "<br />\n";
        while ($data = mysql_fetch_array($record_set)) {
          echo $data["partial_url"] . " | " .
            "<a href=\"?page=" . $data["partial_url"] . "\">View Page</a> | " .
            "<a href=\"?page=control_panel/edit_page/" . $data["partial_url"] . "\">Edit Page</a> | " .
            "<a href=\"?page=control_panel/delete_page/" . $data["partial_url"] . "\">Delete Page</a>\n" .
            "<br />\n";
        }
        echo "<br />\n";
      }
    }
	
    $list_pages_page -> display_messages($messages);
    $list_pages_page -> display_control_panel_footer();
  }
  
  function list_users($page_number) {
    $list_users_page = new page();
    $list_users_page -> display_control_panel_header(); 
  
    echo "      <h1>List Users</h1>\n";
  
    // An array of messages to print at the top of the page.
  	$messages = array();
  	// A variable that tells the script if there is a profile to display.
  	$display_user_list = false;
	
    // If page_number hasn't been typed into the address bar, set the page number to 1:
    if (!$page_number) {
   	  $page_number = 1;
    }
  
    // Sets the number of users to appear on the page, and what user to start at.
    $rows_per_page = 10;
    $starting_row = ($page_number * $rows_per_page) - $rows_per_page;
  
    $data_module = new data_module();
    
    // Gets the number of rows in the table and stores it in $number_of_rows.
    $number_of_rows = $data_module -> get_total_number_of_users();
  
    // Sets the number of pages.
    $number_of_pages = ceil($number_of_rows / $rows_per_page);
	
    echo "      Pages: ";
    
    // Adds a "Previous" link to the start of the page number list.
    if ($page_number > 1) {
  	  echo "      <a href=\"?page=control_panel/list_users/" . ($page_number - 1) .
  	    "\" title=\"Previous\">Previous</a> |\n";
    }
  
    // Outputs a list of page numbers, such as 1 | 2 |3 | 4
    for ($i = 1; $i <= $number_of_pages; $i++) {
  	  echo "      <a href=\"?page=control_panel/list_users/". $i . 
  	    "\" title=\"User Number " . $i . "\">" . $i . "</a>";
  	  if ($i != $number_of_pages) {
  	    echo " | ";
      }
    }
    
    // Adds a "Next" link to the end of the page number list.
    if ($page_number < $number_of_pages) {
  	  echo " | <a href=\"?page=control_panel/list_users/" . ($page_number + 1) .
  	    "\" title=\"Next\">Next</a>\n"; 
    }
    
    echo "      <br />\n";
    
    // If the user types in a page number that doesn't in exist in the address bar.
    if ($page_number < 1 or $page_number > $number_of_pages) {
      array_push($messages, "You typed in an page number that does not exist or there are no users in the database.");
    }
    else {
      $record_set = mysql_query("SELECT user_name " .
        "FROM cma_users " .
        "LIMIT " . $starting_row . ", " . $rows_per_page);
      if (mysql_num_rows($record_set) == 0) {
        echo "<p>There are currently no users in the database.</p>\n";
      }
      else {
        echo "<br />\n";
        while ($data = mysql_fetch_array($record_set)) {
          echo $data["user_name"] . " | " .
            "<a href=\"?page=control_panel/view_user_profile/" . $data["user_name"] . "\">View Profile</a> | " .
            "<a href=\"?page=control_panel/edit_user_profile/" . $data["user_name"] . "\">Edit Profile</a> | " .
			"<a href=\"?page=control_panel/delete_user/" . $data["user_name"] . "\">Delete User</a>" .
			"<br />\n";
        }
        echo "<br />\n";
      }
    }
	
  	$list_users_page -> display_messages($messages);
    $list_users_page -> display_control_panel_footer();
  }
  
  // User Methods:
  function get_user_details_from_form() {
    // Get user details from form:
    $user_details["user_name"] = trim($_POST["user_name"]);
  	$user_details["password"] = trim($_POST["password"]);
  	$user_details["confirm_password"] = trim($_POST["confirm_password"]);
  	$user_details["email_address"] = trim($_POST["email_address"]);
  	$user_details["age"] = trim($_POST["age"]);
  	$user_details["sex"] = trim($_POST["sex"]);
  	$user_details["location"] = trim($_POST["location"]);
  	$user_details["profile"] = trim($_POST["profile"]);
  	$user_details["display_permissions"] = false;
  	$user_details["site_permission_id"] = 1;
    return $user_details;
  } // End of get_user_details_from_form() method.
  
  function get_editing_user_messages($messages, $user_details) {
    // Assign regular expressions to variables:
  	$user_name_expression = "/^[a-zA-Z0-9\_\'\s]+$/";
  	$password_expression = "/^[a-zA-Z0-9]+$/";
  	$email_address_expression = "/^[0-9a-zA-Z-_\.]+@[0-9a-zA-Z-_\.]+\.[a-z]{2}/";
	
  	$data_module = new data_module();
	
    // If the user name is a new user, not one being edited:  
    if ($_POST["register_user"] == true) {
  	  // Checks that the user name chosen is valid:
  	  if (preg_match($user_name_expression, $user_details["user_name"]) == false) {
  	    array_push($messages, "User names must only contain letters, numbers, underscores, apostrophes, and spaces.");
      }
	    if ($user_details["user_name"] == "") {
        array_push($messages, "User names must be one or more characters long.");
   	  }
  	  if ($data_module -> get_number_of_users_matching_user_name($user_details["user_name"]) != 0) {
  	    array_push($messages, "There is already someone with the user name " . $user_details["user_name"] . ".");
  	  } 
	}
  	  
  	// Checks that the password chosen is valid:
    if (preg_match($password_expression, $user_details["password"]) == false) {
  	  array_push($messages, "Passwords must only contain letters and numbers.");
    }
    if ($user_details["password"] != $user_details["confirm_password"]) {
      array_push($messages, "Your passwords did not match.");
    }
    if ($user_details["password"] == "") {
      array_push($messages, "Passwords must be one or more characters long.");
    }
      
    // Checks that the email address chosen is valid:
    if (preg_match($email_address_expression, $user_details["email_address"]) == false) {
      array_push($messages, "The email address that you entered is in an invalid format.");
    }
	
	return $messages;
  } // End of get_editing_user_messages() method.
  
  function register_user() {
  	// Resets $user_details, just in case it contains some values.
  	$user_details = array();
 	  // An array of messages to print at the top of the page.
  	$messages = array();
  	// A variable that tells the script if it needs to display the form.
  	$display_form = true;
  	if ($_POST["register_user"] == false) {
  	  array_push($messages, "Enter the details of the user that you wish to register into the form below.");
  	}
  	else {
      $user_details = $this -> get_user_details_from_form();
      $messages = $this -> get_editing_user_messages($messages, $user_details);
      // If there are no error messages, add the new user to the database:
      if (count($messages) == 0) {
        $data_module = new data_module();
  	    if ($data_module -> register_user($user_details) == true) {
  	  	  array_push($messages, "The new user " . $user_details["user_name"] . " was successfully added to the database.");
  	  	  $display_form = false;
          // Reset $user_details array as a security measure:
          $user_details = array();
  	  	}
      }
  	}
    $register_user_page = new page();
  	$register_user_page -> display_register_user_page($messages, $display_form, $user_details);
  } // End of register_user() method.
  
  function view_user_profile($user_name) {
  	// Resets $user_details, just in case it contains some values.
  	$user_details = array();
 	  // An array of messages to print at the top of the page.
  	$messages = array();
  	// A variable that tells the script if there is a profile to display.
  	$display_profile = false;
  	// Strips any html tags from $user_name for security.
  	$user_name = strip_tags($user_name);
  	$data_module = new data_module();
  	if ($data_module -> does_user_name_exist($user_name) == true) {
  	  $user_details = $data_module -> get_user_details($user_name);
      array_push($messages, "The following information is for the user " . $user_details["user_name"] . ":");
      $display_profile = true;
  	}
  	else {
  	  array_push($messages, "The user " . $user_name . " could not be found in the database.");
  	}
  	$view_user_profile_page = new page();
  	$view_user_profile_page -> display_view_user_profile_page($messages, $display_profile, $user_details);
  } // End of view_user_profile() method.
  
  function edit_user_profile($user_name) {
  	// Resets $user_details, just in case it contains some values.
  	$user_details = array();
 	  // An array of messages to print at the top of the page.
  	$messages = array();
  	// A variable that tells the script if it needs to display the form.
  	$display_form = true;
	
    $data_module = new data_module();
	// If the user already exists in the database, then get the user's details:
	if ($data_module -> does_user_name_exist($user_name) == true) {
  	  if ($_POST["edit_user_profile"] == false) {
  	    array_push($messages, "Enter the details of the user that you wish to update into the form below.");
        // Gets the user's details from the database:
	    $user_details = $data_module -> get_user_details($user_name);
  	  }
  	  else {
	    // Gets the user's details from the form:
	    $user_details = $this -> get_user_details_from_form();
	    $messages = $this -> get_editing_user_messages($messages, $user_details);
	  }
	}
	else {
	  array_push($messages, "The user " . $user_name . " does not exist in the database.");
	}

    // If there are no error messages, edit the user's profile:
	if (count($messages) == 0) {
  	  if ($data_module -> edit_user_profile($user_details) == true) {
        array_push($messages, "The user profile for " . $user_details["user_name"] . " was successfully edited.");
  	    $display_form = false;
		// Reset $user_details array as a security measure:
		$user_details = array();
      }
    }

    $edit_user_profile_page = new page();
    $edit_user_profile_page -> display_edit_user_profile_page($messages, $display_form, $user_details);
  } // End of edit_user_profile() method.
  
  function delete_user($user_name) {
    // An array of messages to print at the top of the page.
  	$messages = array();
  	// A variable that tells the script if it needs to display the form.
  	$display_form = true;
	
    $data_module = new data_module();
  	if ($data_module -> does_user_name_exist($user_name) == true) {
      if ($_POST["delete_user"] == true) {
        if ($_POST["can_delete_user"] == "yes") {
          // Deletes the user:
          if ($data_module -> delete_user($user_name) == true) {
            array_push($messages, "You have successfully deleted '" . $user_name . "' from the database.");
            $display_form = false;
          }
        }
        else {
          array_push($messages, "You have selected not to delete the user '" . $user_name . "'.");
          $display_form = false;
        }
      }
      else {
        array_push($messages, "Do you really want to delete the user '" . $user_name . "'?");
      }
    }
    else {
      array_push($messages, "The user that you specified does not exist in the database.");
      $display_form = false;
    }
    $delete_user_page = new page();
    $delete_user_page -> display_delete_user_page($messages, $display_form, $user_name);
  } // End of delete_user() method.
  
  // Page Methods:
  function get_page_details_from_form() {
    $page_details["title"] = stripslashes(trim($_POST["title"]));
    $page_details["keywords"] = stripslashes(trim($_POST["keywords"]));
    $page_details["description"] = stripslashes(trim($_POST["description"]));
    $page_details["partial_url"] = stripslashes(trim($_POST["partial_url"]));
    $page_details["body"] = strip_tags(stripslashes(trim($_POST["body"])));
    return $page_details;
  } // End of get_page_details_from_form() method.
  
  function get_editing_page_messages($messages, $page_details) {
    // Assign regular expressions to variables:
    $partial_url_expression = "/^[a-zA-Z0-9\_\-]+$/";
    $keywords_expression = "/^[a-zA-Z0-9\_\-\'\,\s]+$/";
    $title_expression = "/^[a-zA-Z0-9\_\-\'\,\s\.]+$/"; // Doubles as an expression for the page description field.
	
  	$data_module = new data_module();
	
    // If the page being dealt with is a new page:
   	if ($_POST["add_page"] == true) {
      if (preg_match($partial_url_expression, $page_details["partial_url"]) == false) {
        array_push($messages, "URLs may only contain letters, numbers, underscores, and dashes.");
      }
      if ($page_details["partial_url"] == "") {
        array_push($messages, "The partial url must be one or more characters long.");
  	  }
      if ($page_details["body"] == "") {
        array_push($messages, "The page body must be one or more characters long.");
  	  }
      if ($data_module -> does_page_exist($partial_url) == true) {
        array_push($messages, "The partial url that you specified already exists in the database.");
      }
	}
	
    // Checks that the page's title is valid:
    if (preg_match($title_expression, $page_details["title"]) == false) {
      array_push($messages, "Titles may only contain letters, numbers, 
	    underscores, dashes, apostrophes, commas, spaces, and full stops.");
	}
	
	// Checks that the page's keywords are valid:
    if ($page_details["keywords"] != "") {
      if (preg_match($keywords_expression, $page_details["keywords"]) == false) {
        array_push($messages, "The keywords field may only contain letters, 
	      numbers, underscores, dashes, apostrophes, commas, and spaces.");
	  }
	}
	
    // Checks that the page's description is valid:
    if ($page_details["description"] != "") {
      if (preg_match($title_expression, $page_details["description"]) == false) {
	    array_push($messages, "Page descriptions may only contain letters, numbers, 
	      underscores, dashes, apostrophes, commas, spaces, and full stops.");
      }
    }

    return $messages;
  } // End of get_editing_page_messages() method.
  
  function add_page() {
    // Resets $page_details, just in case it contains some values.
  	$page_details = array();
    // An array of messages to print at the top of the page.
  	$messages = array();
    // A variable that tells the script if it needs to display the form.
  	$display_form = true;
   	if ($_POST["add_page"] == false) {
  	  array_push($messages, "Enter the details of the page that you wish to add into the form below.");
  	}
  	else {
      $page_details = $this -> get_page_details_from_form();
	  $messages = $this -> get_editing_page_messages($messages, $page_details);
	  
	  // If there are no error messages, add the new page to the database:
      if (count($messages) == 0) {
	    $data_module = new data_module();
  	    if ($data_module -> add_page($page_details) == true) {
  	  	  array_push($messages, "The new page titled '" . $page_details["title"] . "' was added to the database.");
  	  	  $display_form = false;
		  // Reset $page_details array as a security measure:
		  $page_details = array();
  	  	}
      }
    }
  	$add_page_page = new page();
  	$add_page_page -> display_add_page_page($messages, $display_form, $page_details);
  }

  function edit_page($partial_url) {
    // Resets $page_details, just in case it contains some values.
  	$page_details = array();
 	  // An array of messages to print at the top of the page.
  	$messages = array();
    // A variable that tells the script if it needs to display the form.
  	$display_form = true;
	
	$data_module = new data_module();
	
	if ($data_module -> does_page_exist($partial_url) == true) {
      if ($_POST["edit_page"] == false) {
        array_push($messages, "Enter the page information that you wish to update into the form below.");
        // Gets the page's details from the database:
        $page_details = $data_module -> get_page_details($partial_url);
  	  }
  	  else {
        // Gets the page's details from the form:
        $page_details = $this -> get_page_details_from_form();
        $messages = $this -> get_editing_page_messages($messages, $page_details);
	  }
	}
    else {
      array_push($messages, "The page that you specified does not exist in the database.");
      $display_form = false;
	}
	
    // If there are no error messages, edit the page:
    if (count($messages) == 0) {
      if ($data_module -> edit_page($page_details) == true) {
        array_push($messages, "The page was successfully edited.");
        $display_form = false;
        // Reset $page_details array as a security measure:
        $page_details = array();
      }
    }
	
    $edit_page_page = new page();
    $edit_page_page -> display_edit_page_page($messages, $display_form, $page_details);
  }
  
  function delete_page($partial_url) {
 	// An array of messages to print at the top of the page.
  	$messages = array();
  	// A variable that tells the script if it needs to display the form.
  	$display_form = true;
	
    $data_module = new data_module();
  	if ($data_module -> does_page_exist($partial_url) == true) {
	  if ($_POST["delete_page"] == true) {
	    if ($_POST["can_delete_page"] == "yes") {
		  // Deletes the page:
		  if ($data_module -> delete_page($partial_url) == true) {
		    array_push($messages, "You have successfully deleted the page from the database.");
		    $display_form = false;
	      }
		}
		else {
		  array_push($messages, "You have selected not to delete the page.");
		  $display_form = false;
		}
	  }
	  else {
        array_push($messages, "Do you really want to delete the page with the partial url '" . $partial_url . "'?");
      }
	}
	else {
	  array_push($messages, "The page that you specified does not exist in the database.");
	  $display_form = false;
	}
    $delete_page_page = new page();
	$delete_page_page -> display_delete_page_page($messages, $display_form, $partial_url);  	
  }
  
  function view_normal_page($partial_url) {
    $data_module = new data_module();
	
	// Gets the page's details and stores them in an array:
	$page_details = $data_module -> get_page_details($partial_url);
	
  	$page = new page();
	if ($data_module -> does_page_exist($partial_url) == true) { 
	  $page -> display_normal_page($page_details);
	}
	else {
	  $page_details = array();
	  $page -> display_error_page($page_details);
	}
  }
  
  function do_user_function($sub_page, $sub_sub_page) {
    switch ($sub_page) {
  	  case "log_in":
  	    $this -> log_in();
        break;
      case "log_out":
        $this -> log_out();
        break;
      case "register_user":
        $this -> register_user();
        break;
      case "add_page":
        $this -> add_page();
        break;
	  case "edit_page":
        $this -> edit_page($sub_sub_page);
        break;
	  case "delete_page":
        $this -> delete_page($sub_sub_page);
        break;
      case "add_post":
        $this -> add_post();
        break;
      case "view_user_profile":
        $this -> view_user_profile($sub_sub_page);
        break;
	  case "edit_user_profile":
        $this -> edit_user_profile($sub_sub_page);
        break;
	  case "delete_user":
        $this -> delete_user($sub_sub_page);
        break;
      case "list_users":
        $this -> list_users($sub_sub_page);
        break;
      case "list_pages":
        $this -> list_pages($sub_sub_page);
        break;
      default:
        echo "The page that you typed in was invalid.";
        break;
  	}
  }
  
  // Main function that is called when user goes to physical index.php page:
  function view_page() {
    // Gets the value of page and splits it at every forward slash.
  	$partial_url = strip_tags($_GET["page"]);
  	$exploded_partial_url = explode("/", $partial_url);
  	
    // Sets the page to default if no page is specified:
    if ($_GET["page"] == false) {
      $exploded_partial_url[0] = "index";
    }
		
  	// Create a new page object if the first part of "page" is equal to "control_panel".
  	if ($exploded_partial_url[0] == "control_panel") {
  	  if ($partial_url == "control_panel" or $partial_url == "control_panel/") {
        $control_panel_main_page = new page();
  	  	$control_panel_main_page -> display_control_panel_main_page();
  	  }
  	  else {
        $sub_page = $exploded_partial_url[1];
        $sub_sub_page = $exploded_partial_url[2];
        if ($sub_page != "log_in" and $sub_page != "log_out") {
          if ($_SESSION["user_name"] != "") {
            $this -> do_user_function($sub_page, $sub_sub_page);
          }
          else {
            echo "You must be logged in to view the control panel.";
          }
        }
        else {
          $this -> do_user_function($sub_page, $sub_sub_page);
        }
  	  } 
  	}
  	else {
      $this -> view_normal_page($exploded_partial_url[0]);
  	}  	
  }

}

?>
