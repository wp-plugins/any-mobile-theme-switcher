<?php
// create custom plugin settings menu
add_action('admin_menu', 'any_mobile_create_menu');

function any_mobile_create_menu() {
	add_options_page('Any Mobile Theme', 'Any Mobile Theme', 'administrator', __FILE__, 'am_settings_page');
	add_action('admin_init', 'register_mysettings_theme');
	//add_options_page('Mobile Theme', 'Mobile Theme', 'administrator', __FILE__, 'am_settings_page');
	//add_action('admin_init', 'register_mysettings_theme');
}


function register_mysettings_theme() {
	register_setting('am-settings-group', 'iphone_theme');
	register_setting('am-settings-group', 'ipad_theme');
	register_setting('am-settings-group', 'android_theme');
	register_setting('am-settings-group', 'blackberry_theme');
	register_setting('am-settings-group', 'windows_theme');
	register_setting('am-settings-group', 'opera_theme');
	register_setting('am-settings-group', 'palm_theme');
	register_setting('am-settings-group', 'other_theme');
	register_setting('am-settings-group', 'mobile_view_theme_link_text');
	register_setting('am-settings-group', 'desktop_view_theme_link_text');
	register_setting('am-settings-group', 'show_switch_link_for_desktop');
}

function am_settings_page() {
	$iphoneTheme 		= get_option('iphone_theme');
	$ipadTheme			= get_option('ipad_theme');
	$androidTheme		= get_option('android_theme');
	$blackberryTheme	= get_option('blackberry_theme');
	$windowsTheme		= get_option('windows_theme');
	$operaTheme			= get_option('opera_theme');
	$palmTheme			= get_option('palm_theme');
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

<br/>
<div style="-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px; border:1px solid #e9e9e9; padding:10px;-webkit-box-shadow: 0px 0px 1px 2px #969696;-moz-box-shadow: 0px 0px 1px 2px #969696;box-shadow: 0px 0px 1px 2px #969696; text-align:center; font-size:14px;"> 
<em><b>This Plugin is FREE and always will be. Support this plugin by <a href="http://dineshkarki.com.np/donate" target="_blank">DONATING</a>. Any Amount is Appreciated.</b></em>
</div>
    
	<br/>
    <h3>Select Theme For Devices</h3>
    <form method="post" action="options.php">
	<?php settings_fields( 'am-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">iPhone/iPod Touch Theme:</th>
        <td>
        	<select name="iphone_theme"  />
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
        	<select name="ipad_theme"  />
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
        	<select name="android_theme"  />
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
        	<select name="blackberry_theme"  />
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
        	<select name="windows_theme"  />
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
        	<select name="opera_theme"  />
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
        	<select name="parm_theme"  />
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
        	<select name="other_theme"  />
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
	You can also add Switch Mobile Theme link to your theme from Custom Links section under Appearance > Menus.<br />
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
