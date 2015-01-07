<?php

class page {

  // Generates the html for a page's header:
  function display_normal_page_header($page_details) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="keywords" content="<?php echo $page_details["keywords"] ?>" />
    <meta http-equiv="description" content="<?php echo $page_details["description"] ?>" />
    <title><?php echo $page_details["title"] ?></title>
    <style type="text/css">
      @import url("styles/styles.css");
    </style>
  </head>
  <body>
<?php
  }

  // Generates the html for a page's footer:
  function display_normal_page_footer() {
?>
  </body>
</html>
<?php
  }

  // Generates the top of the control panel on the screen.
  function display_control_panel_header() {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Content Management Area</title>
    <style type="text/css">
      @import url("styles/control_panel_styles.css");
    </style>
  </head>
  <body>
    <div id="overall">
      <div id="header"></div>
      <div id="navigation">
<?php
  if ($_SESSION["user_name"] == true) {
?>
        <a href="?page=control_panel/log_out" title="Log Out">Log Out</a> |
        <a href="?page=control_panel/list_pages" title="List Pages">List Pages</a> |
        <a href="?page=control_panel/list_users" title="List Users">List Users</a> |
        <a href="?page=control_panel/register_user" title="Register User">Register User</a> |
        <a href="?page=control_panel/add_page" title="Add Page">Add Page</a>
<?php
  }
  else {
    echo "<a href=\"?page=control_panel/log_in\" title=\"Log In\">Log In</a>";
  }
?>
      </div>
      <div id="main">
<?php
  }

  function display_control_panel_main_page() {
    $this -> display_control_panel_header();
    echo "        <h1>Control Panel</h1>\n";
    echo "        Welcome to the Control Panel. Please select an option from the menu above.\n";
    $this -> display_control_panel_footer();
  }

  // Generates the bottom of the control panel on the screen.
  function display_control_panel_footer() {
?>
      </div>
      <div id="footer">
        <p>Powered by Content Management Area 1.0.1. Copyright &copy; <a href="mailto:chris@chrisalley.info?subject=Content Management Area" title="Email Chris Alley">Chris Alley</a>, 2005, 2008.</p>
      </div>
    </div>
  </body>
</html>
<?php
  }

  // Prints out the messages stored in the $messages array on the screen:
  function display_messages($messages) {
    if (count($messages) > 0) {
      echo "        <p>\n";
      foreach ($messages as $message) {
        echo "          " . $message . "<br />\n";
      }
      echo "        </p>\n";
    }
  }

  // Display the Log In page.
  function display_log_in_page($messages, $display_form, $user_name) {
    $this -> display_control_panel_header();
    echo "        <h1>Log In</h1>\n";
    // Prints out the messages stored in $messages on the screen:
    $this -> display_messages($messages);
    // If $display_form is true, display the form:
    if ($display_form == true) {
      // Creates a new form for logging in:
      $log_in_form = new form();
      $log_in_form -> display_log_in_form($user_name);
    }
    $this -> display_control_panel_footer();
  }

  // Display the Log Out page.
  function display_log_out_page($messages) {
    $this -> display_control_panel_header();
    echo "        <h1>Log Out</h1>\n";
    $this -> display_messages($messages);
    $this -> display_control_panel_footer();
  }

  // Displays the Register User page.
  function display_register_user_page($messages, $display_form, $user_details) {
    $this -> display_control_panel_header();
    echo "        <h1>Register User</h1>\n";
    // Prints out the messages stored in $messages on the screen:
    $this -> display_messages($messages);
    // If $display_form is true, display the form:
    if ($display_form == true) {
      // Creates a new form for logging in:
      $register_user_form = new form();
      $register_user_form -> display_register_user_form($user_details);
    }
    $this -> display_control_panel_footer();
  }

  // Displays the View User Profile page.
  function display_view_user_profile_page($messages, $display_profile, $user_details) {
    $this -> display_control_panel_header();
    echo "        <h1>View User Profile</h1>\n";
    $this -> display_messages($messages);
    if ($display_profile == true) {
?>
        <table>
          <tr>
            <td>User Name:</td>
            <td><?php echo $user_details["user_name"] ?></td>
          </tr>
          <tr>
            <td>Email Address:</td>
            <td><?php echo $user_details["email_address"] ?></td>
          </tr>
          <tr>
            <td>Age:</td>
            <td><?php echo $user_details["age"] ?></td>
          </tr>
          <tr>
            <td>Sex:</td>
            <td><?php echo $user_details["sex"] ?></td>
          </tr>
          <tr>
            <td>Location:</td>
            <td><?php echo $user_details["location"] ?></td>
          </tr>
          <tr>
            <td>Profile:</td>
            <td><?php echo $user_details["profile"] ?></td>
          </tr>
          <tr>
            <td>Signed up on:</td>
            <td><?php echo $user_details["formatted_datetime_created"] ?></td>
          </tr>
          <tr>
            <td>Profile last modified on:</td>
            <td><?php echo $user_details["formatted_datetime_last_modified"] ?></td>
          </tr>
        </table>
<?php
    }
    $this -> display_control_panel_footer();
  }

  function display_edit_user_profile_page($messages, $display_form, $user_details) {
    $this -> display_control_panel_header();
    echo "        <h1>Edit User Profile</h1>\n";
    // Prints out the messages stored in $messages on the screen:
    $this -> display_messages($messages);
    // If $display_form is true, display the form:
    if ($display_form == true) {
      // Creates a new form for logging in:
      $edit_user_profile_form = new form();
      $edit_user_profile_form -> display_edit_user_profile_form($user_details);
    }
    $this -> display_control_panel_footer();
  }

  function display_delete_user_page($messages, $display_form, $user_name) {
    $this -> display_control_panel_header();
    echo "        <h1>Delete User</h1>\n";
    // Prints out the messages stored in $messages on the screen:
    $this -> display_messages($messages);
    // If $display_form is true, display the form:
    if ($display_form == true) {
      $delete_user_form = new form();
      $delete_user_form -> display_delete_user_form($user_name);
    }
    $this -> display_control_panel_footer();
  }

  function display_add_page_page($messages, $display_form, $page_details) {
    $this -> display_control_panel_header();
    echo "        <h1>Add Page</h1>\n";
    // Prints out the messages stored in $messages on the screen:
    $this -> display_messages($messages);
    // If $display_form is true, display the form:
    if ($display_form == true) {
      $add_page_form = new form();
      $add_page_form -> display_add_page_form($page_details);
    }
    $this -> display_control_panel_footer();
  }

  function display_edit_page_page($messages, $display_form, $page_details) {
    $this -> display_control_panel_header();
    echo "        <h1>Edit Page</h1>\n";
    // Prints out the messages stored in $messages on the screen:
    $this -> display_messages($messages);
    // If $display_form is true, display the form:
    if ($display_form == true) {
      $edit_page_form = new form();
      $edit_page_form -> display_edit_page_form($page_details);
    }
    $this -> display_control_panel_footer();
  }

  function display_delete_page_page($messages, $display_form, $partial_url) {
    $this -> display_control_panel_header();
    echo "        <h1>Delete Page</h1>\n";
    // Prints out the messages stored in $messages on the screen:
    $this -> display_messages($messages);
    // If $display_form is true, display the form:
    if ($display_form == true) {
      $delete_page_form = new form();
      $delete_page_form -> display_delete_page_form($partial_url);
    }
    $this -> display_control_panel_footer();
  }

  function display_normal_page($page_details) {
    $this -> display_normal_page_header($page_details);
    echo "    <h1>" . $page_details["title"] . "</h1>\n";

    // Format the body with <p> and <br /> tags, with indentation:
    $formatted_body = str_replace("\r\n", "<br />\n    ", $page_details["body"]);
    $formatted_body = str_replace("<br />\n    <br />\n    ", "</p>\n    <p>", $formatted_body);

    // Convert bbcode tags to html:
    $formatted_body = str_replace("[subheading]", "<h2>", $formatted_body);
    $formatted_body = str_replace("[/subheading]", "</h2>", $formatted_body);
    $formatted_body = str_replace("[b]", "<strong>", $formatted_body);
    $formatted_body = str_replace("[/b]", "</strong>", $formatted_body);
    $formatted_body = str_replace("[i]", "<em>", $formatted_body);
    $formatted_body = str_replace("[/i]", "</em>", $formatted_body);
    $formatted_body = $this -> replace_url($formatted_body);

    echo "    <p>" . $formatted_body . "</p>\n";
      $this -> display_normal_page_footer();
  }

  function replace_url($formatted_body) {
    // Make link from [url=http://.... ]text[/url]
    while (strpos($formatted_body, "[url") !== false) {
      $begin_url = strpos($formatted_body, "[url");
      $end_url = strpos($formatted_body, "[/url]");
      $url = substr($formatted_body, $begin_url, $end_url - $begin_url + 6);
      $pos_bracket = strpos($url, "]");

      if ($pos_bracket != null){
        // [url=http://....]text[/url]
        $link = substr($url, 5, $pos_bracket - 5);
        $text = substr($url, $pos_bracket + 1, strpos($url, "[/url]") - $pos_bracket - 1);
        $html_url = "<a href=$link>$text</a>";
      }
      $formatted_body = str_replace($url, $html_url, $formatted_body);
    }
    return $formatted_body;
  }

  function display_error_page($page_details) {
    $this -> display_normal_page_header($page_details);
    echo "    <h1>Page not found.</h1>\n";
    echo "    <p>The page that you selected could not be found.</p>\n";
    $this -> display_normal_page_footer();
  }

}

?>
