<?php
/* 
Plugin Name: NC2WP Bookmarks
Version: 1.3.2
Plugin URI: http://www.nolte-netzwerk.de/nc2wp-bookmarks-configuration/
Description: Use bookmarks that are managed by Nextcloud in WordPress posts and pages as table or as list in widgets
Author: Mario Nolte
Author URI: http://www.nolte-netzwerk.de/
Licence:  GPLv2
*/ 

/* set some default options */
function nc2wpbm_plugin_install ()
{
	add_option('nc2wpbm_dbversion', '1.3.2');
	add_option('nc2wpbm_table_title_display', '1');
	add_option('nc2wpbm_table_title_label', 'Title');
	add_option('nc2wpbm_table_number_display', '-1');
	add_option('nc2wpbm_table_number_label', 'Entry');
	add_option('nc2wpbm_table_description_display', '1');
	add_option('nc2wpbm_table_description_label', 'Description');
	add_option('nc2wpbm_table_tags_display', '-1');
	add_option('nc2wpbm_table_tags_label', 'Tags');
	add_option('nc2wpbm_table_lastmodified_display', '-1');
	add_option('nc2wpbm_table_lastmodified_label', 'Last change');
	add_option('nc2wpbm_op_type', 'ncApp');
	add_option('nc2wpbm_nc_server', 'https://REPLACE-THIS-WHITH-YOUR-SERVER.com/nextcloud/');
	add_option('nc2wpbm_nc_user', 'user');
	add_option('nc2wpbm_nc_passwordEn', '');
    add_option('nc2wpbm_sql_database');
    add_option('nc2wpbm_sql_bmOwner');
    add_option('nc2wpbm_table_script');
	}
	
register_activation_hook(__FILE__,'nc2wpbm_plugin_install');

/* deleting passwords for security reasons while deactivating the plugin */
function nc2wpbm_plugin_deactivate ()
{
delete_site_option('nc2wpbm_nc_passwordEn');
delete_site_option('nc2wpbm_sql_passwordEn');
}
register_deactivation_hook( __FILE__, 'nc2wpbm_plugin_deactivate' );

/* Delete all settings while uninstalling the plugin */
function nc2wpbm_plugin_uninstall ()
{
	// All Values
      delete_site_option('nc2wpbm_op_type');
      delete_site_option('nc2wpbm_nc_server');
      delete_site_option('nc2wpbm_nc_user');
      delete_site_option('nc2wpbm_nc_passwordEn');
      delete_site_option('nc2wpbm_sql_server');
      delete_site_option('nc2wpbm_sql_user');
      delete_site_option('nc2wpbm_sql_passwordEn');
      delete_site_option('nc2wpbm_sql_database');
      delete_site_option('nc2wpbm_sql_bmOwner');
      delete_site_option('nc2wpbm_table_styling');
      delete_site_option('nc2wpbm_table_number_display');
      delete_site_option('nc2wpbm_table_number_label');
      delete_site_option('nc2wpbm_table_title_display');
      delete_site_option('nc2wpbm_table_title_label');
      delete_site_option('nc2wpbm_table_description_display');
      delete_site_option('nc2wpbm_table_description_label');
      delete_site_option('nc2wpbm_table_tags_display');
      delete_site_option('nc2wpbm_table_tags_label');
      delete_site_option('nc2wpbm_table_lastmodified_display');
      delete_site_option('nc2wpbm_table_lastmodified_label');
      delete_site_option('nc2wpbm_table_script');
      delete_site_option('nc2wpbm_dbversion');


	}
register_uninstall_hook(__FILE__,'nc2wpbm_plugin_uninstall');

/* check if database needs to be updated and add a version number for executing a systematic update process*/
add_action('plugins_loaded', 'nc2wpbm_update');

function nc2wpbm_update(){
 if(get_option('oc2wpbm_op_type')=='ocApp' OR get_option('oc2wpbm_op_type')=='sql'){
    nc2wpbm_plugin_install ();
    
    if(get_option('oc2wpbm_op_type')=='ocApp'){update_option('nc2wpbm_op_type','ncApp');}
    if(get_option('oc2wpbm_op_type')=='sql'){update_option('nc2wpbm_op_type','sql');}
    update_option('nc2wpbm_nc_server', get_option('oc2wpbm_oc_server'));
    update_option('nc2wpbm_nc_user', get_option('oc2wpbm_oc_user'));
    update_option('nc2wpbm_nc_passwordEn', nc2wpbm_encryptPassword((string)get_option('oc2wpbm_oc_password'), AUTH_KEY));
    update_option('nc2wpbm_sql_server', get_option('oc2wpbm_sql_server'));
    update_option('nc2wpbm_sql_user', get_option('oc2wpbm_sql_user'));
    update_option('nc2wpbm_sql_passwordEn', nc2wpbm_encryptPassword((string)get_option('oc2wpbm_oc_password'), AUTH_KEY));
    update_option('nc2wpbm_sql_database', get_option('oc2wpbm_sql_database'));
    update_option('nc2wpbm_sql_bmOwner', get_option('oc2wpbm_sql_bmOwner'));
    update_option('nc2wpbm_table_styling', get_option('oc2wpbm_table_styling'));
    update_option('nc2wpbm_table_number_display', get_option('oc2wpbm_table_number_display'));
    update_option('nc2wpbm_table_number_label', get_option('oc2wpbm_table_number_label'));
    update_option('nc2wpbm_table_title_display', get_option('oc2wpbm_table_title_display'));
    update_option('nc2wpbm_table_title_label', get_option('oc2wpbm_table_title_label'));
    update_option('nc2wpbm_table_description_display', get_option('oc2wpbm_table_description_display'));
    update_option('nc2wpbm_table_description_label', get_option('oc2wpbm_table_description_label'));
    update_option('nc2wpbm_table_tags_display', get_option('oc2wpbm_table_tags_display'));
    update_option('nc2wpbm_table_tags_label', get_option('oc2wpbm_table_tags_label'));
    update_option('nc2wpbm_table_lastmodified_display', get_option('oc2wpbm_table_lastmodified_display'));
    update_option('nc2wpbm_table_lastmodified_label', get_option('oc2wpbm_table_lastmodified_label'));
    update_option('nc2wpbm_table_script', get_option('oc2wpbm_table_script'));
    
    delete_site_option('oc2wpbm_oc_server');
    delete_site_option('oc2wpbm_oc_user');
    delete_site_option('oc2wpbm_oc_password');
    delete_site_option('oc2wpbm_sql_server');
    delete_site_option('oc2wpbm_sql_user');
    delete_site_option('oc2wpbm_sql_password');
    delete_site_option('oc2wpbm_sql_database');
    delete_site_option('oc2wpbm_sql_bmOwner');
    delete_site_option('oc2wpbm_table_styling');
    delete_site_option('oc2wpbm_table_number_display');
    delete_site_option('oc2wpbm_table_number_label');
    delete_site_option('oc2wpbm_table_title_display');
    delete_site_option('oc2wpbm_table_title_label');
    delete_site_option('oc2wpbm_table_description_display');
    delete_site_option('oc2wpbm_table_description_label');
    delete_site_option('oc2wpbm_table_tags_display');
    delete_site_option('oc2wpbm_table_tags_label');
    delete_site_option('oc2wpbm_table_lastmodified_display');
    delete_site_option('oc2wpbm_table_lastmodified_label');
    delete_site_option('oc2wpbm_table_script');
    delete_site_option('oc2wpbm_op_type');
    delete_site_option('oc2wpbm_table_script');
    }
}

/*import the class file for Bookmark Class*/
require_once( plugin_dir_path( __FILE__ ) . 'bookmark.inc.php' );
require_once( plugin_dir_path( __FILE__ ) . 'config_page.inc.php' );
require_once( plugin_dir_path( __FILE__ ) . 'widget.inc.php' );

/* get bookmarks in accordance to the defined tag and the specified user (as owner of the bookmarks) out of the database and return an array of bookmarks*/
function nc2wpbm_getBMfromSQL($tags, $order){
  /*configure SQL Server connection data*/
  $sql_server=get_option('nc2wpbm_sql_server');
  $sql_user =$sqlserver=get_option('nc2wpbm_sql_user');
  $sql_password =$sqlserver=nc2wpbm_decryptPassword(get_option('nc2wpbm_sql_passwordEn'), AUTH_KEY) ;
  $nc_database=$sqlserver=get_option('nc2wpbm_sql_database');
  

  $bm_term= implode("','", $tags);
  /* Filter bookmarks of a certain user or display all bookmarks of the database*/
  if (get_option('nc2wpbm_sql_bmOwner')=='all'){
      $bm_user='%';}
  else {$bm_user=get_option('nc2wpbm_sql_bmOwner');};

  /* connect to MySQL*/
  /* Instead of using the PHP SQL connection (following comment) the WordPress WPDB connection is used to sanitise the query.
  /*	mysql_connect($sql_server, $sql_user, $sql_password);
      mysql_query("SET NAMES 'utf8'");
      mysql_select_db($nc_database);*/
  
  $NCdb = new wpdb($sql_user, $sql_password, $nc_database, $sql_server); 
  /* Sanitise the query to avoid code & SQL injection. COLLATE UTF8_GENERAL_CI is used so that tags are used caseinsensitive*/
  $query=$NCdb->prepare("select b.url, b.title, b.description, GROUP_CONCAT(t.tag SEPARATOR ', ') as tags, b.lastmodified from nc2wpBM b LEFT JOIN nc2wpBMT t on b.id=t.bookmark_id WHERE t.tag COLLATE UTF8_GENERAL_CI IN (%s) AND b.user_id LIKE %s group by id ORDER BY b.lastmodified ASC", $bm_term, $bm_user);
  if (strcasecmp($order,'desc')==0){
  /* Due to the prepare() function sorting cannot be handeld as variable */
  $query=$NCdb->prepare("select b.url, b.title, b.description, GROUP_CONCAT(t.tag SEPARATOR ', ') as tags, b.lastmodified from nc2wpBM b LEFT JOIN nc2wpBMT t on b.id=t.bookmark_id WHERE t.tag COLLATE UTF8_GENERAL_CI IN (%s) AND b.user_id LIKE %s group by id ORDER BY b.lastmodified DESC", $bm_term, $bm_user);
  }
  $query=stripslashes($query);
  $res = $NCdb->get_results($query);
      
  /*create array containing BM objects*/
  for ($i=0; $i<count($res); $i++){
	$bookmarks[$i]=new NC2WP_Bookmark($res[$i] ->title, $res[$i] ->url, $res[$i] ->description, explode(', ', $res[$i] ->tags), $res[$i] ->lastmodified);
	}
	
  
    return $bookmarks;
}

/* get bookmarks in accordance to the defined tag out of Nextcloud via the Bookmarks App*/
/* TODO: 
 * Abfrage je tag, folgende Fälle
 * - 1 tag --> ein Durchlauf
 * - >= 2 tag mit UND --> ein Durchlauf
 * - >= 2 tag mit OR --> Durchlauf je Tag
 * Ergo: nc2wpbm_getBMfromNC($tag, $order) - nur noch für einen Tag
 * */
function nc2wpbm_getBMfromNC($tags, $order){

    // setting the tags
    $tagsURL="";
    for($i=0; $i<count($tags);$i++){$tagsURL .="&tags[]=" . $tags[$i];};
    
    // for basic auth as required by api v2
    $url = get_option('nc2wpbm_nc_server') .'/index.php/apps/bookmarks/public/rest/v2/bookmark?&page=-1&conjunction=or'.$tagsURL;
    print($url);
    echo '<hr>';
    
    $args = array(
        'headers' => array(
            'Authorization' => 'Basic ' . base64_encode( get_option('nc2wpbm_nc_user') . ':' . nc2wpbm_decryptPassword(get_option('nc2wpbm_nc_passwordEn'), AUTH_KEY))
        )
    );

    $request = wp_remote_request($url, $args);
    $response = wp_remote_retrieve_body( $request );
    $result = json_decode($response, true);
    

   foreach($result['data'] as $item){
     $bookmarks[] = new NC2WP_Bookmark($item['title'], $item['url'], $item['description'], $item['tags'], $item['lastmodified']);
     }
    return $bookmarks;  
}

/* Generates the HTML Code for a table containing bookmark information*/
function nc2wpbm_tablegenerator($bookmarks){

$tablepre=stripslashes(get_option('nc2wpbm_table_styling'));
$table_number=get_option('nc2wpbm_table_number_label');
$table_title=get_option('nc2wpbm_table_title_label');
$table_description=get_option('nc2wpbm_table_description_label');
$table_tags=get_option('nc2wpbm_table_tags_label');
$table_lastmodified = get_option('nc2wpbm_table_lastmodified_label');

$tableoutput ="";

$tableoutput .= "<table " . $tablepre .">";
$tableoutput .= "<thead> <tr> ";
if(get_option('nc2wpbm_table_number_display')=='1'){
  $tableoutput .= "<th class='column-1'> ".$table_number ." </th>"; 
  }
if(get_option('nc2wpbm_table_title_display')=='1'){
  $tableoutput .= "<th class='column-2'>" .$table_title ." </th>";
  }
if(get_option('nc2wpbm_table_description_display')=='1'){
  $tableoutput .= "<th class='column-3'> ".$table_description. " </th>";
  }
if(get_option('nc2wpbm_table_tags_display')=='1'){
  $tableoutput .= "<th class='column-4'> ".$table_tags. " </th>";
  }
if(get_option('nc2wpbm_table_lastmodified_display')=='1'){
  $tableoutput .= "<th class='column-5'> ".$table_lastmodified. " </th>";
  }
$tableoutput .= "</tr></thead>";
$tableoutput .= "<tbody>";

if (is_array($bookmarks)) {

//set allowed values for wp_kses (sanitizing description and title coming from nc bookmarks
$allowed_html = array(
	'a' => array(
		'href' => array(),
		'title' => array(),
	),
	'br' => array(),
	'em' => array(),
	'strong' => array(),
);

$allowed_protocols = array(
	'http' => array(),
	'https' => array(),
	'ftp' => array(),
	'mailto' => array()
);
	  
    for ($i=0; $i<count($bookmarks); $i++){
        
    $tableoutput .= "<tr>";
        if(get_option('nc2wpbm_table_number_display')=='1'){
        $tableoutput .= "<td class='column-1'>" . ($i+1) . "</td>";
        }
        if(get_option('nc2wpbm_table_title_display')=='1'){
        $tableoutput .= "<td class='column-2'> <a href ='" . esc_url($bookmarks[$i]->link) . "' target='_blank'> ". wp_kses($bookmarks[$i]->title, $allowed_html, $allowed_protocols) . "</a> </td>";
        }
        if(get_option('nc2wpbm_table_description_display')=='1'){
        $tableoutput .= "<td class='column-3'>" . wp_kses($bookmarks[$i]->description, $allowed_html, $allowed_protocols) . " </td>";
        }
        if(get_option('nc2wpbm_table_tags_display')=='1'){
        $tableoutput .= "<td class='column-4'>"; 
        $tableoutput .= esc_html(nc2wpbm_arrayToTagstext($bookmarks[$i] ->tags));
        $tableoutput .= " </td>";
        }
        if(get_option('nc2wpbm_table_lastmodified_display')=='1'){
        $tableoutput .= "<td class='column-5'>" . esc_html(date("Y-m-d", $bookmarks[$i]->dateLastModified)) . " </td>";
        }
    $tableoutput .= "</tr>";
    }
    }
$tableoutput .= "</tbody>";
$tableoutput .= "</table>";
$tableoutput .= $tablescript;

return $tableoutput;
}

/* copies those Bookmarks out of $bookmarks into a new array that have not all tags contained in $tagArray. Unfortunatley unset() left articfacts in the array so that this copy-into-a-new-array-approach was chosen. */
function nc2wpbm_filterBookmarks($bookmarks, $tagArray) {
  $j=0;
  for ($i=0; $i<count($bookmarks); $i++){
    if(array_diff($tagArray, $bookmarks[$i]->tags)==null){
      $newBookmarks[$j]=$bookmarks[$i];
      $j=$j+1;      
     };
  }
return $newBookmarks;
}
/* transforming the tags entered by users to an array by relieving it from spaces between commata */
function nc2wpbm_textToTagsArray($tagsText){
  $tagsText = str_replace (', ', ',', $tagsText);
  $tagsText = str_replace (' , ', ',', $tagsText);
  $tagsText = str_replace (' ,', ',', $tagsText);
  //...  and transform the commata separated tags into an array  
  $tagArray = explode(',', $tagsText);
  return $tagArray;
}

/* transforming an array containing tags to a text without the tag 'public' */
function nc2wpbm_arrayToTagstext($tagArray){
  if (in_array('public', $tagArray)) {
    unset($tagArray[array_search('public',$tagArray)]);
  }
  $tagText = implode(', ', $tagArray);
  return $tagText;
}

/* Coordinates the mehod call related to the operation mode & the connector and returns the HTML code which replaces the shortcode in pages and posts
   Parameter: $tags = tags the Bookmark should contain
	      $connector: AND = Bookmarks that have one of the given tags (default case) | OR = Bookmarks that contain the set of given tags
	      $order: ASC = List of Bookmarks is ordered by 'last modified date' ascending (default case) | DESC = List of Bookmarks is ordered by 'last modified date' descending

*/
/* TODO 
 * if connector==AND
 * {$bookmarks = nc2wpbm_getBMfromSQL($tagArray,}
 * 
 * if connector==OR
 * {for each tag: $bookmarks append $bookmarks}*/

function nc2wpbm_shortcode($atts) {
  $shortcodeArray = shortcode_atts( array('tags' => 'public', 'connector' => 'OR','order' => 'asc',), $atts );
  print('Parameter connector: '. $shortcodeArray['connector'] . '<br>');
 
  $tagArray = nc2wpbm_textToTagsArray($shortcodeArray['tags']);

  if(get_option('nc2wpbm_op_type')=='sql'){
    $bookmarks = nc2wpbm_getBMfromSQL($tagArray, $shortcodeArray['order']);
  }
  
  if(get_option('nc2wpbm_op_type')=='ncApp'){
    $bookmarks = nc2wpbm_getBMfromNC($tagArray, $shortcodeArray['order']);
  }
  
  //while the OR connector needs no further operations (all Bookmarks can be deployed in the table), the AND connector requires to delete within the $bookmark array all those bookmarks that contain not all Bookmarks
  if(strcasecmp($shortcodeArray['connector'],'AND')==0){
  $bookmarks = nc2wpbm_filterBookmarks($bookmarks, $tagArray);
  }
  
      $output = nc2wpbm_tablegenerator($bookmarks);
  return $output;
}

/* Encrypt the passwords used for NC or SQL Access */
function nc2wpbm_encryptPassword($data, $key) {
    // Remove the base64 encoding from our key
    $encryption_key = base64_decode($key);
    // Generate an initialization vector
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
    return base64_encode($encrypted . '::' . $iv);
}

/* Decrypt the passwords used for NC or SQL Access */
function nc2wpbm_decryptPassword($data, $key) {
    // Remove the base64 encoding from our key
    $encryption_key = base64_decode($key);
    // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}

/* Hooks shortcode nc2wpbm into WordPress */
/* the second shortcode oc2wpbm is for lagacy configurations since the plugin was nameed in accordance to OwnCloud (oc) before */
add_shortcode('nc2wpbm', 'nc2wpbm_shortcode');
add_shortcode('oc2wpbm', 'nc2wpbm_shortcode');

/* hook configuration page and widget into the wordpress backend */
function nc2wpbm_plugin_menu() {
      add_options_page('Nextcloud 2 WordPress Bookmarks', 'NC2WP Bookmarks', 'manage_options', __FILE__, 'nc2wpbm_configuration_page');
  }

function nc2WPBM_register_widget() {
     register_widget( 'nc2wpBMwidget' );
 }

add_action('admin_menu', 'nc2wpbm_plugin_menu');
add_action( 'widgets_init', 'nc2WPBM_register_widget' );
?>
