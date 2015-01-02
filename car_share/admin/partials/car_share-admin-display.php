<?php
/**
* Provide a dashboard view for the plugin
*
* This file is used to markup the public-facing aspects of the plugin.
*
* @link http://example.com
* @since 1.0.0
*
* @package Plugin_Name
* @subpackage Plugin_Name/admin/partials
*/
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
 
<div class="wrap">
<?php screen_icon(); ?>
    <h2>Settings</h2> 
    <form method="post" action="options.php">
    <?php
// This prints out all hidden setting fields
// settings_fields( $option_group )
settings_fields( 'main-settings-group' );
// do_settings_sections( $page )
do_settings_sections( 'test-plugin-main-settings-section' );
    ?>
    <?php submit_button('Save Changes'); ?>
    </form>
 
    <form method="post" action="options.php">
    <?php
// This prints out all hidden setting fields
// settings_fields( $option_group )
settings_fields( 'additional-settings-group' );
// do_settings_sections( $page )
do_settings_sections( 'test-plugin-additional-settings-section' );
    ?>
    <?php submit_button('Save Changes'); ?>
    </form>
</div> 


<?php /* zpracovani formulare pro vytvoreni stranek 
 * 
 * 
 */





 ?>
  





<div class="wrap"> 
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2> 
	<!-- @TODO: Provide markup for your options page here. --> 
	 <div class="section panel">    
      <form method="post" enctype="multipart/form-data">   
        <?php 
         /* settings_fields('cow4a_theme_options');  
          do_settings_sections($this->plugin_slug);*/
        ?>  
        <p class="submit">  
                <input type="submit" class="button button-primary button-hero load-customize hide-if-no-customize" value="<?php _e('Create Page') ?>" />  
        </p>       
      </form>  
      <p>Created by <a href="http://www.web-4-all.cz">web-4-all.cz</a>.</p>
    </div>  
</div>  





   