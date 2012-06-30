<?php
add_action('admin_menu', 'any_mobile_create_menu');

if ($_POST['am_license_submit']){
	$license_key_return = wp_remote_fopen('http://dineshkarki.com.np/license/validate_key.php?license_key='.$_POST['am_license_key']);
	$license_key_return = json_decode($license_key_return);
	if (!empty($license_key_return)){
		if ($license_key_return->status == 'success'){
			update_option('am_license_key_status', 'activated');
			update_option('am_license_key_valid_till', $license_key_return->valid_till);
			update_option('am_license_key_code', $_POST['am_license_key']);
		}
		$license_message = $license_key_return->msg;
		$license_status	 = $license_key_return->status;
	} else {
		$license_status	 = 'error';
		$license_message = 'Sorry there was an error. Please try again.';
	}
	
	if ($license_status	== 'error'){
		$lic_notice_class	= 'error';
	} else {
		$lic_notice_class	= 'updated';
	}	
}

$am_license_key_status		= get_option('am_license_key_status');
$am_license_key_valid_till	= get_option('am_license_key_valid_till');

switch ($am_license_key_status){
	case 'trial':
		if (strtotime($am_license_key_valid_till) <= strtotime(date('Y-m-d'))){
			add_action('admin_notices', 'am_license_notice_trial_expired');
			update_option('am_license_key_status', 'trial_expired');
		} else {
			add_action('admin_notices', 'am_license_notice_trial');
		}	
	break;
	
	case 'trial_expired':
		add_action('admin_notices', 'am_license_notice_trial_expired');
	break;
	
	case 'activated':
		if (strtotime($am_license_key_valid_till) < strtotime(date('Y-m-d'))){
			add_action('admin_notices', 'am_license_notice_expired');
			update_option('am_license_key_status', 'expired');
		}
	break;
	
	case 'expired':
		add_action('admin_notices', 'am_license_notice_expired');
	break;
	
	default:
		update_option('am_license_key_status', 'trial');
		$trial_valid_till = date('Y-m-d', strtotime("+31 days"));
		update_option('am_license_key_valid_till', $trial_valid_till);
		update_option('am_license_key_code', '');
		add_action('admin_notices', 'am_license_notice_trial');
	break;	
}
$am_license_key_status		= get_option('am_license_key_status');

function am_license_notice_expired(){
    echo '<div class="error">
       <p>Your License Key of <b>Any Mobile Theme Swticher</b> has been expired. Offer your price ($0 - $100) and get the license key from <a href="http://dineshkarki.com.np/license/" target="_blank">Dnesscarkey</a>. If you already have the license key click <a href="options-general.php?page=any-mobile-theme-switcher/plugin_interface.php">here</a> to activate.</p></div>';
}


function am_license_notice_trial(){
    $am_license_key_valid_till	= get_option('am_license_key_valid_till');
	$today_date 				= time();
    $expire_date 				= strtotime($am_license_key_valid_till);
    $datediff 					= $expire_date - $today_date;
    $remainingDays 				= floor($datediff/(60*60*24));
	echo '<div class="error">
       <p>You are using <b>Any Mobile Theme Swticher</b> as a trial. Offer your price ($0 - $100) and get the license key from <a href="http://dineshkarki.com.np/license/" target="_blank">Dnesscarkey</a>. If you already have the license key click <a href="options-general.php?page=any-mobile-theme-switcher/plugin_interface.php">here</a> to activate.</p>
	   <p><strong>Remaining Days :</strong> '.$remainingDays.' </p></div>';
}

function am_license_notice_trial_expired(){
    echo '<div class="error">
       <p>Your Trial Period of <b>Any Mobile Theme Swticher</b> has been expired. Offer your price ($0 - $100) and get the license key from <a href="http://dineshkarki.com.np/license/" target="_blank">Dnesscarkey</a>. If you already have the license key click <a href="options-general.php?page=any-mobile-theme-switcher/plugin_interface.php">here</a> to activate.</p>
    </div>';
}

function any_mobile_create_menu() {
	add_options_page('Any Mobile Theme', 'Any Mobile Theme', 'administrator', __FILE__, 'am_settings_page');
	add_action('admin_init', 'register_mysettings_theme');
}


function register_mysettings_theme() {
	register_setting('am-settings-group', 'iphone_theme');
	register_setting('am-settings-group', 'ipad_theme');
	register_setting('am-settings-group', 'android_theme');
	register_setting('am-settings-group', 'blackberry_theme');
	register_setting('am-settings-group', 'windows_theme');
	register_setting('am-settings-group', 'opera_theme');
	register_setting('am-settings-group', 'parm_os_theme');
	register_setting('am-settings-group', 'other_theme');
	register_setting('am-settings-group', 'mobile_view_theme_link_text');
	register_setting('am-settings-group', 'desktop_view_theme_link_text');
	register_setting('am-settings-group', 'show_switch_link_for_desktop');
}

function am_settings_page() {
	global $am_license_key_status;
	global $license_message;
	global $lic_notice_class;
	
	$iphoneTheme 		= get_option('iphone_theme');
	$ipadTheme			= get_option('ipad_theme');
	$androidTheme		= get_option('android_theme');
	$blackberryTheme	= get_option('blackberry_theme');
	$windowsTheme		= get_option('windows_theme');
	$operaTheme			= get_option('opera_theme');
	$palmTheme			= get_option('parm_os_theme');
	$otherTheme			= get_option('other_theme');	
	$mobileThemeText	= get_option('mobile_view_theme_link_text');
	$desktopThemeText	= get_option('desktop_view_theme_link_text');	
	$desktopSwitchLink	= get_option('show_switch_link_for_desktop');
	
	
	if (empty($mobileThemeText)){
		update_option('mobile_view_theme_link_text', 'Switch To Mobile Version');
		$mobileThemeText	= get_option('mobile_view_theme_link_text');
	}
	
	if (empty($desktopThemeText)){
		update_option('desktop_view_theme_link_text', 'Switch To Desktop Version');
		$desktopThemeText	= get_option('desktop_view_theme_link_text');	
	}
	
	if (empty($desktopSwitchLink)){
		update_option('show_switch_link_for_desktop', 'no');
		$desktopSwitchLink	= get_option('show_switch_link_for_desktop');	
	}
	
	$themeList 		= get_themes();
	$themeNames 	= array_keys($themeList); 
	$defaultTheme 	= get_current_theme();
	natcasesort($themeNames);
?>
<div class="wrap">
<h2>Any Mobile Theme Switcher</h2>
<style>
fieldset.license_key { border:1px solid #060; padding:5px;-webkit-border-radius: 5px;border-radius: 5px; padding-bottom:10px;}
fieldset.license_key legend{ color:#060; font-size:15px; font-weight:bold; padding-left:5px; padding-right:5px;}
fieldset.license_key input[type=text]{ margin-right:20px;}
</style>
<?php


if (!empty($license_message)){
	echo '<div class="'.$lic_notice_class.'"><p>'.$license_message.'</p></div>';
}
?>

<fieldset class="license_key">
<legend>License Key</legend>
<form method="post" action="">
<table class="form-table">
        <tr valign="top">
        <td>Status : </td><td><strong><?php echo ucfirst(str_replace('_',' ', $am_license_key_status)); ?></strong></td>
        </tr>
        
		<?php if ($am_license_key_status != 'activated'): ?>
        <tr valign="top">
        <td>Key</td>
        <td>
        <input type="text" maxlength="40" style="width:300px;" name="am_license_key" /><input name="am_license_submit" class="button-primary" type="submit" value="Activate" />
        </td>
        </tr>
        <?php endif; ?>
        
        
</table>
</form>
</fieldset>

<br/>


    <h3>Select Theme For Devices</h3>
    <form method="post" action="options.php">
	<?php settings_fields( 'am-settings-group' ); ?>
    <table class="form-table">
         <tr valign="top">
        <th scope="row">iPhone/iPod Touch Theme:</th>
        <td>
        	<select name="iphone_theme">
     <?php 
      foreach ($themeNames as $themeName) {              
          if (($iphoneTheme == $themeName) || (($iphoneTheme == '') && ($themeName == $defaultTheme))) {
              echo '<option value="' . $themeName . '" selected="selected">' . htmlspecialchars($themeName) . '</option>';
          } else {
              echo '<option value="' . $themeName . '">' . htmlspecialchars($themeName) . '</option>';
          }
      }
     ?>
        	</select>
        </td>
        </tr>
         
        <tr valign="top">
        <th scope="row">iPad Theme</th>
        <td>
        	<select name="ipad_theme">
     <?php 
      foreach ($themeNames as $themeName) {              
          if (($ipadTheme == $themeName) || (($ipadTheme == '') && ($themeName == $defaultTheme))) {
              echo '<option value="' . $themeName . '" selected="selected">' . htmlspecialchars($themeName) . '</option>';
          } else {
              echo'<option value="' . $themeName . '">' . htmlspecialchars($themeName) . '</option>';
          }
      }
     ?>
        	</select>
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Android Theme</th>
        <td>
        	<select name="android_theme">
     <?php 
      foreach ($themeNames as $themeName) {              
          if (($androidTheme == $themeName) || (($androidTheme == '') && ($themeName == $defaultTheme))) {
              echo '<option value="' . $themeName . '" selected="selected">' . htmlspecialchars($themeName) . '</option>';
          } else {
              echo'<option value="' . $themeName . '">' . htmlspecialchars($themeName) . '</option>';
          }
      }
     ?>
        	</select>
        </td>
        </tr>
		
		
		<tr valign="top">
        <th scope="row">Blackberry Theme</th>
        <td>
        	<select name="blackberry_theme">
     <?php 
      foreach ($themeNames as $themeName) {              
          if (($blackberryTheme == $themeName) || (($blackberryTheme == '') && ($themeName == $defaultTheme))) {
              echo '<option value="' . $themeName . '" selected="selected">' . htmlspecialchars($themeName) . '</option>';
          } else {
              echo'<option value="' . $themeName . '">' . htmlspecialchars($themeName) . '</option>';
          }
      }
     ?>
        	</select>
        </td>
        </tr>
        
        
        <tr valign="top">
        <th scope="row">Windows Mobile Theme</th>
        <td>
        	<select name="windows_theme">
			 <?php 
              foreach ($themeNames as $themeName) {              
                  if (($windowsTheme == $themeName) || (($windowsTheme == '') && ($themeName == $defaultTheme))) {
                      echo '<option value="' . $themeName . '" selected="selected">' . htmlspecialchars($themeName) . '</option>';
                  } else {
                      echo'<option value="' . $themeName . '">' . htmlspecialchars($themeName) . '</option>';
                  }
              }
             ?>
        	</select>
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Opera Mini Theme</th>
        <td>
        	<select name="opera_theme">
			 <?php 
              foreach ($themeNames as $themeName) {              
                  if (($operaTheme == $themeName) || (($operaTheme == '') && ($themeName == $defaultTheme))) {
                      echo '<option value="' . $themeName . '" selected="selected">' . htmlspecialchars($themeName) . '</option>';
                  } else {
                      echo'<option value="' . $themeName . '">' . htmlspecialchars($themeName) . '</option>';
                  }
              }
             ?>
        	</select>
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Parm Os Theme</th>
        <td>
        	<select name="parm_os_theme">
			 <?php 
              foreach ($themeNames as $themeName) {              
                  if (($palmTheme == $themeName) || (($palmTheme == '') && ($themeName == $defaultTheme))) {
                      echo '<option value="' . $themeName . '" selected="selected">' . htmlspecialchars($themeName) . '</option>';
                  } else {
                      echo'<option value="' . $themeName . '">' . htmlspecialchars($themeName) . '</option>';
                  }
              }
             ?>
        	</select>
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Other Mobile Device Theme</th>
        <td>
        	<select name="other_theme">
			 <?php 
              foreach ($themeNames as $themeName) {              
                  if (($otherTheme == $themeName) || (($otherTheme == '') && ($themeName == $defaultTheme))) {
                      echo '<option value="' . $themeName . '" selected="selected">' . htmlspecialchars($themeName) . '</option>';
                  } else {
                      echo'<option value="' . $themeName . '">' . htmlspecialchars($themeName) . '</option>';
                  }
              }
             ?>
        	</select>
        </td>
        </tr>
		
    </table>
    
    <br/>
    <h3>Other Settings (Optional)</h3>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Switch Mobile Theme Link Text</th>
        <td>
        <input name="mobile_view_theme_link_text" style="width:300px;"  value="<?php echo $mobileThemeText; ?>" type="text" />
        </td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Switch Desktop Theme Link Text</th>
        <td>
        <input name="desktop_view_theme_link_text" style="width:300px;" value="<?php echo $desktopThemeText; ?>" type="text" />
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Do you want to show Switch Mobile Theme link even the vistor is viewing from desktop ?</th>
        <td>
        	<input name="show_switch_link_for_desktop" type="radio" value="yes" <?php echo $desktopSwitchLink == 'yes'?'checked="checked"':''; ?> /> Yes &nbsp;&nbsp;&nbsp;
            <input name="show_switch_link_for_desktop" type="radio" value="no" <?php echo $desktopSwitchLink == 'no'?'checked="checked"':''; ?> /> No <br/><span class="description">Normally, it is <b>NO</b>. It is usually useless to force the visitor to switch to mobile theme when s/he is in desktop.</span>
        </td>
        </tr>
        
    </table>
    
    <br/>
    <h3>Read Me Please</h3>
    <p>
	Use the following shortcode <strong>[show_theme_switch_link]</strong> in templates to show the theme switch link.    
    <br/>Example: <strong>&lt;?php echo do_shortcode('[show_theme_switch_link]'); ?&gt;</strong>
    <br/><br/>
	You can also add Switch Mobile Theme link to your Menus from Custom Links section under Appearance > Menus.<br />
	Example:<br />
	Url : <strong>http://yoursitename.com/?am_force_theme_layout=desktop</strong> (For Mobile Theme)<br/>
    Url : <strong>http://yoursitename.com/?am_force_theme_layout=mobile</strong>  (For Desktop Theme)<br/>
    Label :  As you wish :)    
    </p>
    
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>
<?php } ?>
