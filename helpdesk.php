<?php
/**
 * @package Jitbit_Helpdesk
 * @version 0.1
 */
/*
Plugin Name: Jitbit Help Desk for Wordpress
Plugin URI: http://www.jitbit.com/hosted-helpdesk/
Description: This plugin inserts Jitbit Help Desk widget on every page of your Wordpress blog.
Author: Jitbit
Version: 0.1
Author URI: http://jitbit.com/
*/


// This just echoes the chosen line, we'll position it later
function get_widget() {
	$jitbit_hd_url = rtrim(get_option("jitbit_hd_url"), "/");
    if(!empty($jitbit_hd_url)){
    $path = "/js/support-widget-light.js";
		echo "<script type='text/javascript' src='".$jitbit_hd_url.$path."'></script>";
	}
}

// Now we set that function up to execute when the admin_notices action is called
add_action( 'wp_footer', 'get_widget' );


function setup_admin_menus() {
      add_submenu_page('plugins.php',
        'Helpdesk Settings', 'Jitbit Helpdesk', 'manage_options',
        'hd-elements', 'hd_settings');
}

function hd_settings() {
	if (!current_user_can('manage_options')) {
    wp_die('You do not have sufficient permissions to access this page.');
	}

	if (isset($_POST["update_settings"])) {
    // Do the saving
    $url = esc_attr($_POST["url"]);
		update_option("jitbit_hd_url", $url);
		?>
    <div id="message" class="updated">Settings saved</div>
		<?php
	}

	$jitbit_hd_url = get_option("jitbit_hd_url");
 ?>
 <div class="wrap">
        <?php screen_icon('plugins'); ?> <h2>Jitbit Help Desk Settings</h2>

        <form method="POST" action="">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                            <label for="url">
												        Your Helpdesk URL:
												    </label>
                    </th>
                    <td>
                            <input type="text" name="url" value="<?php echo $jitbit_hd_url;?>" placeholder="https://support.jitbit.com/helpdesk">
                            <p class="description">Make sure you enter the full URL like this https://%your_company_name%.jitbit.com<b>/helpdesk</b>"</p>
                            <input type="hidden" name="update_settings" value="Y" />
                    </td>
                </tr>
            </table>
            <p>
					    <input type="submit" value="Save settings" class="button-primary"/>
						</p>
        </form>
    </div>



<?php
}
// This tells WordPress to call the function named "setup_admin_menus"
// when it's time to create the menu pages.
add_action("admin_menu", "setup_admin_menus");
?>
