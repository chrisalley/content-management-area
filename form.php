<?php

class form {

  function display_log_in_form($user_name) {
?>
        <form id="log_in_form" action="?page=control_panel/log_in" method="post">
          <table>
            <tr>
              <td class="field_label"><label for="user_name" title="User Name">User Name:</label></td>
              <td class="field_input"><input type="text" name="user_name" value="<?php echo $user_name ?>" />*</td>
            </tr>
            <tr>
              <td class="field_label"><label for="password" title="Password">Password:</label></td>
              <td class="field_input"><input type="password" name="password" />*</td>
            </tr>
            <tr>
              <td class="field_label"></td>
              <td class="field_input">
                <input type="submit" name="log_in" value="Log In" /> 
              </td>
            </tr>
          </table>
        </form>
<?php  
  } // End of display_log_in_form()
  
  function display_register_user_form($user_details) {
?>
        <form id="register_user_form" action="?page=control_panel/register_user" method="post">
          <table>
            <tr>
              <td class="field_label"><label for="user_name" title="User Name">User Name:</label></td>
              <td class="field_input"><input type="text" name="user_name" value="<?php echo $user_details["user_name"]; ?>" />*</td>
            </tr>
            <tr>
              <td class="field_label"><label for="password" title="Password">Password:</label></td>
              <td class="field_input"><input type="password" name="password" />*</td>
            </tr>
            <tr>
              <td class="field_label"><label for="confirm_password" title="Confirm Password">Confirm Password:</label></td>
              <td class="field_input"><input type="password" name="confirm_password" />*</td>
            </tr>
            <tr>
              <td class="field_label"><label for="email_address" title="Email Address">Email Address:</label></td>
              <td class="field_input"><input type="text" name="email_address" value="<?php echo $user_details["email_address"]; ?>" />*</td>
            </tr>
            <tr>
              <td class="field_label"><label for="age" title="Age">Age:</label></td>
              <td class="field_input"><input type="text" name="age" value="<?php echo $user_details["age"]; ?>" /></td>
            </tr>
            <tr>
              <td class="field_label"><label for="sex" title="Sex">Sex:</label></td>
              <td class="field_input"><input type="text" name="sex" value="<?php echo $user_details["sex"]; ?>" /></td>
            </tr>
            <tr>
              <td class="field_label"><label for="location" title="Location">Location:</label></td>
              <td class="field_input"><input type="text" name="location" value="<?php echo  $user_details["location"]; ?>" /></td>
            </tr>
            <tr>
              <td class="field_label"><label for="profile" title="Profile">Profile:</label></td>
              <td class="field_input"><textarea name="profile" cols="40" rows="10"><?php echo $user_details["profile"]; ?></textarea></td>
            </tr>
            <tr>
              <td class="field_label"></td>
              <td class="field_input">
                <input type="submit" name="register_user" value="Register User" />
              </td>
            </tr>
          </table>
        </form>
<?php
  } // End of display_register_user_form()
  
  function display_edit_user_profile_form($user_details) {
?>
        <form id="edit_user_profile_form" action="?page=control_panel/edit_user_profile/<?php echo $user_details["user_name"]; ?>" method="post">
		  <input type="hidden" name="user_name" value="<?php echo $user_details["user_name"]; ?>" />
          <table>
            <tr>
              <td class="field_label"><label for="password" title="Password">Password:</label></td>
              <td class="field_input"><input type="password" name="password" />*</td>
            </tr>
            <tr>
              <td class="field_label"><label for="confirm_password" title="Confirm Password">Confirm Password:</label></td>
              <td class="field_input"><input type="password" name="confirm_password" />*</td>
            </tr>
            <tr>
              <td class="field_label"><label for="email_address" title="Email Address">Email Address:</label></td>
              <td class="field_input"><input type="text" name="email_address" value="<?php echo $user_details["email_address"]; ?>" />*</td>
            </tr>
            <tr>
              <td class="field_label"><label for="age" title="Age">Age:</label></td>
              <td class="field_input"><input type="text" name="age" value="<?php echo $user_details["age"]; ?>" /></td>
            </tr>
            <tr>
              <td class="field_label"><label for="sex" title="Sex">Sex:</label></td>
              <td class="field_input"><input type="text" name="sex" value="<?php echo $user_details["sex"]; ?>" /></td>
            </tr>
            <tr>
              <td class="field_label"><label for="location" title="Location">Location:</label></td>
              <td class="field_input"><input type="text" name="location" value="<?php echo $user_details["location"]; ?>" /></td>
            </tr>
            <tr>
              <td class="field_label"><label for="profile" title="Profile">Profile:</label></td>
              <td class="field_input"><textarea name="profile" cols="40" rows="10"><?php echo $user_details["profile"]; ?></textarea></td>
            </tr>
            <tr>
              <td class="field_label"></td>
              <td class="field_input">
                <input type="submit" name="edit_user_profile" value="Edit User Profile" />
              </td>
            </tr>
          </table>
        </form>
<?php
  } // End of display_edit_user_profile_form()
  
  function display_delete_user_form($user_name) {
?>
        <form id="delete_user_form" action="?page=control_panel/delete_user/<?php echo $user_name; ?>" method="post">
          <table>
            <tr>
              <td>
              Yes <input type="radio" name="can_delete_user" value="yes"  /> 
              No <input type="radio" name="can_delete_user" value="no" checked="checked" />
              </td>
            </tr>
            <tr>
              <td>
                <input type="submit" name="delete_user" value="Confirm" />
              </td>
            </tr>
          </table>
        </form>
<?php
  } // End of display_delete_user_form()
  
  function display_add_page_form($page_details) {
?>
        <form id="add_page_form" action="?page=control_panel/add_page" method="post">
          <table>
            <tr>
              <td class="field_label"><label for="title" title="Title">Title:</label></td>
              <td class="field_input"><input type="text" name="title" value="<?php echo $page_details["title"]; ?>" />*</td>
            </tr>
            <tr>
              <td class="field_label"><label for="keywords" title="Keywords">Keywords: (seperate with commas)</label></td>
              <td class="field_input"><textarea name="keywords"><?php echo $page_details["keywords"]; ?></textarea></td>
            </tr>
            <tr>
              <td class="field_label"><label for="description" title="Description">Description:</label></td>
              <td class="field_input"><textarea name="description"><?php echo $page_details["description"]; ?></textarea></td>
            </tr>
            <tr>
              <td class="field_label"><label for="partial_url" title="Partial URL">Partial URL:</label></td>
              <td class="field_input"><input type="text" name="partial_url" value="<?php echo $page_details["partial_url"]; ?>" />*</td>
            </tr>
            <tr>
	          <td class="field_label"><label for="body" title="Body">Body:</label></td>
	          <td class="field_input">
                <p><em>BBCode:</em><br />
	              [subheading]Sub Heading[/subheading]<br />
                  [b]Bold Text[/b]<br />
                  [i]Italicised Text[/i]<br />
                  [url=http://www.example.com]Hyperlink[/url]
                </p>
                <textarea name="body" cols="40" rows="10"><?php echo $page_details["body"]; ?></textarea>*
              </td>
            </tr>
            <tr>
              <td class="field_label"></td>
              <td class="field_input">
                <input type="submit" name="add_page" value="Add Page" /> 
              </td>
            </tr>
          </table>
        </form>
<?php  	
  }
  
  function display_edit_page_form($page_details) {
?>
        <form id="add_page_form" action="?page=control_panel/edit_page/<?php echo $page_details["partial_url"]; ?>" method="post">
          <input type="hidden" name="partial_url" value="<?php echo $page_details["partial_url"]; ?>" />
            <table>
              <tr>
                <td class="field_label"><label for="title" title="Title">Title:</label></td>
                <td class="field_input"><input type="text" name="title" value="<?php echo $page_details["title"]; ?>" />*</td>
              </tr>
              <tr>
                <td class="field_label"><label for="keywords" title="Keywords">Keywords: (seperate with commas)</label></td>
                <td class="field_input"><textarea name="keywords"><?php echo $page_details["keywords"]; ?></textarea></td>
              </tr>
              <tr>
                <td class="field_label"><label for="description" title="Description">Description:</label></td>
                <td class="field_input"><textarea name="description"><?php echo $page_details["description"]; ?></textarea></td>
              </tr>
              <tr>
                <td class="field_label"><label for="body" title="Body">Body:</label></td>
	            <td class="field_input"><textarea name="body" cols="40" rows="10"><?php echo $page_details["body"]; ?></textarea>*</td>
              </tr>	
              <tr>
                <td class="field_label"></td>
                <td class="field_input">
                  <input type="submit" name="edit_page" value="Edit Page" /> 
                </td>
              </tr>
            </table>
          </form>
<?php  
  } // End of display_edit_page_form() method.
  
  function display_delete_page_form($partial_url) {
?>
        <form id="delete_user_form" action="?page=control_panel/delete_page/<?php echo $partial_url; ?>" method="post">
          <table>
            <tr>
              <td>
              Yes <input type="radio" name="can_delete_page" value="yes"  /> 
              No <input type="radio" name="can_delete_page" value="no" checked="checked" />
              </td>
            </tr>
            <tr>
              <td>
                <input type="submit" name="delete_page" value="Confirm" />
              </td>
            </tr>
          </table>
        </form>
<?php
  } // End of display_delete_page_form()  method.
  
}
?>