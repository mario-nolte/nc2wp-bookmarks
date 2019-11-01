<?php
function nc2wpbm_configuration_page(){

//if-else only for checking nonce as described here: https://codex.wordpress.org/Function_Reference/wp_nonce_field
if ( ! empty( $_POST ) && check_admin_referer('nc2wpbm_submit_configuration', 'nc2wpbm_nonce') ) {

    if (isset($_POST['info_update']))
    {
        echo '<div id="message" class="updated fade"><p><strong>';

        update_option('nc2wpbm_op_type', (string)sanitize_text_field($_POST["nc2wpbm_op_type"]));
        update_option('nc2wpbm_nc_server', (string)esc_url_raw($_POST["nc2wpbm_nc_server"]));
        update_option('nc2wpbm_nc_user', (string)sanitize_user($_POST["nc2wpbm_nc_user"]));
        if ((string)$_POST["nc2wpbm_nc_password"]!='Password') update_option('nc2wpbm_nc_passwordEn', nc2wpbm_encryptPassword((string)$_POST[sanitize_text_field("nc2wpbm_nc_password")] , AUTH_KEY));
        update_option('nc2wpbm_sql_server', (string)esc_url_raw($_POST["nc2wpbm_sql_server"]));
        update_option('nc2wpbm_sql_user', (string)sanitize_user($_POST["nc2wpbm_sql_user"]));
        if ((string)$_POST["nc2wpbm_sql_password"]!='Password')update_option('nc2wpbm_sql_passwordEn', nc2wpbm_encryptPassword((string)$_POST[sanitize_text_field("nc2wpbm_sql_password")] , AUTH_KEY));
        update_option('nc2wpbm_sql_database', (string)sanitize_text_field($_POST["nc2wpbm_sql_database"]));
        update_option('nc2wpbm_sql_bmOwner', (string)sanitize_user($_POST["nc2wpbm_sql_bmOwner"]));
        update_option('nc2wpbm_table_styling', (string)sanitize_text_field($_POST["nc2wpbm_table_styling"]));
        update_option('nc2wpbm_table_number_display', ($_POST['nc2wpbm_table_number_display']=='1') ? '1':'-1' );
        update_option('nc2wpbm_table_number_label', sanitize_text_field($_POST["nc2wpbm_table_number_label"]));
        update_option('nc2wpbm_table_title_display', ($_POST['nc2wpbm_table_title_display']=='1') ? '1':'-1' );
        update_option('nc2wpbm_table_title_label', sanitize_text_field($_POST["nc2wpbm_table_title_label"]));
        update_option('nc2wpbm_table_description_label', sanitize_text_field($_POST["nc2wpbm_table_description_label"]));
        update_option('nc2wpbm_table_description_display', ($_POST['nc2wpbm_table_description_display']=='1') ? '1':'-1' );
        update_option('nc2wpbm_table_tags_label', sanitize_text_field($_POST["nc2wpbm_table_tags_label"]));
        update_option('nc2wpbm_table_tags_display', ($_POST['nc2wpbm_table_tags_display']=='1') ? '1':'-1' );
        update_option('nc2wpbm_table_lastmodified_label', sanitize_text_field($_POST["nc2wpbm_table_lastmodified_label"]));
        update_option('nc2wpbm_table_lastmodified_display', ($_POST['nc2wpbm_table_lastmodified_display']=='1') ? '1':'-1' );
                                
        echo 'Options Updated!';
        echo '</strong></p></div>';
    }
}
    $nc2wpbm_op_type = stripslashes(get_option('nc2wpbm_op_type'));
									  
?>


<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" id="nc2wpoptions" class="validate">
<input type="hidden" name="info_update" id="info_update" value="true" />
 
<script language="javascript" type="text/javascript">
  function toggleDisableNC(radio) {
    var toggle1 = document.getElementById("ncAppOptions");
    radio.checked ? toggle1.disabled = false : toggle1.disabled = true;
    var toggle2 = document.getElementById("sqlOptions");
    radio.checked ? toggle2.disabled = true : toggle2.disabled = false;
  }
    function toggleDisableSQL(radio) {
    var toggle1 = document.getElementById("ncAppOptions");
    radio.checked ? toggle1.disabled = true : toggle1.disabled = false;
    var toggle2 = document.getElementById("sqlOptions");
    radio.checked ? toggle2.disabled = false : toggle2.disabled = true;
  }
</script>


<h2>Nextcloud2WordPress Bookmarks sharing options</h2>
     <p>
    <h3>Plugin Usage:</h3>

    <p>To make use of this plugin please consider the following steps:</p>
    <ol>
    <li>Chose the operation mode:
    <ol>
      <li> NC App mode is recommended and for those that have the <a href="https://github.com/nextcloud/Bookmarks" target="_blank"> ownCoud Bookmark App supporting REST (> version 8.0) </a> running on their Nextcloud.</li>
      <li> MySQL mode is for those who have access to the MySQL Database of their Nextcloud instance and that wish to make use of bookmarks of several users.</li>
    </li></ol>
    <li>Enter the data to connect to the Nextcloud Bookmarks App or to the MySQL Database. </li>
    <li>Add the shortcode <strong>[nc2wpbm]</strong> to a post or page that should contain a table with those bookmarks that have the tag 'public' or add the shortcode <strong>[nc2wpbm tags="public, example"]</strong> to display Bookmarks that have one of those tags. Bookmarks that have both tags can be selected via <strong>[nc2wpbmtags=”public, example” connector=”AND”]</strong>
    <li>Configure the design of the table e. g. like explained <a href="http://www.nolte-netzwerk.de/nc2wp-bookmarks-configuration/#configure the table layout" target="_blank"> in this tutorial </a>.</li>
    <li>Make use of the widget like explained <a href="http://www.nolte-netzwerk.de/nc2wp-bookmarks-configuration/#widget" target="_blank"> here </a>.</li>
    </ol>
    </p>
  <br>
  <HR>
  <br>
  

<fieldset>
<legend><h3>Operation mode</h3></legend>
<p>Please chose if you use the Nextcloud APP or if Bookmarks should be retrieved by using the MySQL database of Nextcloud.</p>
<table width="100%" border="0" cellspacing="0" cellpadding="6">
<tr valign="top">
    <td width="25%" align="right">
      NC App:
    </td>
    <td align="left">
    <?php _e('<input type="radio" name="nc2wpbm_op_type" value="ncApp" onchange="toggleDisableNC(this);" id="opNcApp"') ?>
    <?php if ($nc2wpbm_op_type == "ncApp") echo " checked " ?>
    <?php _e('/>') ?>
  <tr valign="top">
    <td width="25%" align="right">
      MySQL:
    </td>
    <td align="left">
    <?php _e('<input type="radio" name="nc2wpbm_op_type" value="sql" onchange="toggleDisableSQL(this);" id="opSQL"') ?>
    <?php if ($nc2wpbm_op_type == "sql") echo " checked "  ?>
    <?php _e('/>') ?>
</td>
</tr>
</table>
</fieldset>

<?php _e('<fieldset id="ncAppOptions"') ?>
<?php if ($nc2wpbm_op_type == "sql") echo " disabled" ?>
<?php _e('/>') ?>

<legend><h3>Nextcloud App Options</h3></legend>

<table width="100%" border="0" cellspacing="0" cellpadding="6">
    
<tr valign="top">
    <td width="25%" align="right">
      NC App URL:
    </td>
    <td align="left">
      <input name="nc2wpbm_nc_server" type="text" size="100" value="<?php echo get_option('nc2wpbm_nc_server'); ?>"/>
    </td>
</tr>
<tr valign="top">
    <td width="25%" align="right">
      User:
    </td>
    <td align="left">
      <input name="nc2wpbm_nc_user" type="text" size="25" value="<?php echo get_option('nc2wpbm_nc_user'); ?>"/>
    </td>
</tr>
<tr valign="top">
    <td width="25%" align="right">
      Password:
    </td>
    <td align="left">
      <input name="nc2wpbm_nc_password" type="password" size="25" value="<?php if (!empty(nc2wpbm_decryptPassword(get_option('nc2wpbm_nc_passwordEn'), AUTH_KEY))) echo 'Password' ; ?>"/>
    </td>
</tr>
</tr>
<tr>
<td>
</td>
</tr>
</table>
</fieldset>

        
<?php _e('<fieldset id="sqlOptions"') ?>
<?php if ($nc2wpbm_op_type == "ncApp") echo " disabled" ?>
<?php _e('/>') ?>

<label> <h3>SQL-Options</h3></label>
<p>To access the Nextcloud database it is highly recommended to create an own user that has limited access to the database like described in this  tutorial. Please fill the following fields to enter the access data for the database. </p>
<table width="100%" border="0" cellspacing="0" cellpadding="6">

<tr valign="top">
    <td width="25%" align="right">
      SQL server:
    </td>
    <td align="left">
      <input name="nc2wpbm_sql_server" type="text" size="25" value="<?php echo get_option('nc2wpbm_sql_server'); ?>"/>
    </td>
</tr>

<tr valign="top">
    <td width="25%" align="right">
      SQL user:
    </td>
    <td align="left">
      <input name="nc2wpbm_sql_user" type="text" size="25" value="<?php echo get_option('nc2wpbm_sql_user'); ?>"/>
    </td>
</tr>

<tr valign="top">
    <td width="25%" align="right">
      SQL password:
    </td>
    <td align="left">
      <input name="nc2wpbm_sql_password" type="password" size="25" value="<?php if (!empty(nc2wpbm_decryptPassword(get_option('nc2wpbm_nc_passwordEn'), AUTH_KEY))) echo 'Password' ; ?>"/>
    </td>
</tr>

<tr valign="top">
    <td width="25%" align="right">
      Name of database:
    </td>
    <td align="left">
      <input name="nc2wpbm_sql_database" type="text" size="25" value="<?php echo get_option('nc2wpbm_sql_database'); ?>"/>
    </td>
</tr>

<tr valign="top">
    <td width="25%" align="right">
      Bookmark owner:
    </td>
    <td align="left">
      <input name="nc2wpbm_sql_bmOwner" type="text" size="25" value="<?php echo get_option('nc2wpbm_sql_bmOwner'); ?>"/><br>
      <i>To display only the bookmarks of a certain owner please enter the username here. Otherwise please enter "all": Bookmarks of all users containing the specified tag will be displayed. </i>
    </td>
    </tr>

</table>
</fieldset>

<fieldset>
<legend><h3>Table layout options</h3></legend>
<table width="100%" border="0" cellspacing="0" cellpadding="6">

<tr valign="top">
    <td width="25%" align="right">
      Table styling options:
    </td>
    <td align="left">
      <input name="nc2wpbm_table_styling" type="text" size="100" value="<?php echo stripslashes(get_option('nc2wpbm_table_styling')); ?>" />
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="6">


<tr valign="top">
    <td width="25%" align="right">
      Display:
    </td>
    <td>
      <input name="nc2wpbm_table_number_display" type="checkbox"<?php if(get_option('nc2wpbm_table_number_display')!='-1') echo ' checked="checked"'; ?> value="1"/>
    </td>
    <td>
      <input name="nc2wpbm_table_title_display" type="checkbox"<?php if(get_option('nc2wpbm_table_title_display')!='-1') echo ' checked="checked"'; ?> value="1"/>
    </td>
        <td>
      <input name="nc2wpbm_table_description_display" type="checkbox"<?php if(get_option('nc2wpbm_table_description_display')!='-1') echo ' checked="checked"'; ?> value="1"/>
    </td>
        <td>
      <input name="nc2wpbm_table_tags_display" type="checkbox"<?php if(get_option('nc2wpbm_table_tags_display')!='-1') echo ' checked="checked"'; ?> value="1"/>
    </td>
        <td>
      <input name="nc2wpbm_table_lastmodified_display" type="checkbox"<?php if(get_option('nc2wpbm_table_lastmodified_display')!='-1') echo ' checked="checked"'; ?> value="1"/>
    </td>
</tr>

<tr valign="top">
    <td width="25%" align="right">
      Labeling:
    </td>
    
    <td align="left" style="width:20px;">
      <input name="nc2wpbm_table_number_label" type="text" size="15" value="<?php echo get_option('nc2wpbm_table_number_label'); ?>"/><br>
      <i>Number</i>
    </td>

    <td align="left" style="width:100px;">
      <input name="nc2wpbm_table_title_label" type="text" size="15" value="<?php echo get_option('nc2wpbm_table_title_label'); ?>"/><br>
      <i>Title</i>
    </td>

    <td align="left" style="width:100px;">
      <input name="nc2wpbm_table_description_label" type="text" size="15" value="<?php echo get_option('nc2wpbm_table_description_label'); ?>"/><br>
      <i>Description</i>
    </td>
    <td align="left" style="width:100px;">
      <input name="nc2wpbm_table_tags_label" type="text" size="15" value="<?php echo get_option('nc2wpbm_table_tags_label'); ?>"/><br>
      <i>Tags</i>
    </td>
    <td align="left" style="width:100px;">
      <input name="nc2wpbm_table_lastmodified_label" type="text" size="15" value="<?php echo get_option('nc2wpbm_table_lastmodified_label'); ?>"/><br>
      <i>Date last modified</i>
    </td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="6">
<tr valign="top">
    <td width="25%" align="right">
      Table script:
    </td>

</tr>

</table>
</fieldset>    

  <p class="submit"><input type="submit" name="inf_update" id="submit" class="button" value="<?php _e('Update options'); ?> &raquo;"></p>
  
  <?php 
  //generates nonce in accordance to https://codex.wordpress.org/Function_Reference/wp_nonce_field
  wp_nonce_field( 'nc2wpbm_submit_configuration', 'nc2wpbm_nonce'); ?>
   </form>
   Please visit<a href="http://www.nolte-netzwerk.de/nc2wp-bookmarks-configuration/" target="_blank"> the documentation </a> to read more about the use and configuration of this plugin.<br/>


<?php


} 
