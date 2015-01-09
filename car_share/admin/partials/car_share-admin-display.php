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




<?php
/* 
 * form for create the page and the 
 */  
if (isset($_POST['createpage'])){

        $new_page_title = array('Search for a car', 'Pick a car', 'Choose your extras', 'Review your booking', 'Checkout');
        $new_page_content = array('[sc-search_for_car]', '[sc-pick_car]', '[sc-extras]', '[sc-review]', '[sc-checkout]');
        $new_page_template = array('','','','','',); //ex. template-custom.php. Leave blank if you don't want a custom page template.
        $new_page_key = array('search_for_car', 'pick_car', 'extras', 'review', 'checkout');

        /*MultipleIterator::MIT_NEED_ANY
         * - array nemusi mit vsechny hodnoty - muze se hodit
         */

        $mi = new MultipleIterator();
        $mi->attachIterator(new ArrayIterator($new_page_title));
        $mi->attachIterator(new ArrayIterator($new_page_content));
        $mi->attachIterator(new ArrayIterator($new_page_template));
        $mi->attachIterator(new ArrayIterator($new_page_key));

        $sc_pages = array();

        foreach( $mi as $value ){
            list($new_page_title, $new_page_content, $new_page_template, $new_page_key) = $value;
            //don't change the code bellow, unless you know what you're doing
            $page_check = get_page_by_title($new_page_title);

            $new_page = array(
                    'post_type' => 'page',
                    'post_title' => $new_page_title,
                    'post_content' => $new_page_content,
                    'post_status' => 'publish',
                    'post_author' => 1,
                );

            if(!isset($page_check->ID)){
                    $new_page_id = wp_insert_post($new_page);
                    if(!empty($new_page_template)){
                            update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
                    }

                    $sc_pages[$new_page_key] = $new_page_id;
            }
        }

        if(!empty($sc_pages)){
            update_option( 'sc-pages', $sc_pages );
        }
    }
?>
 
<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <div class="section panel">
    <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI'];?>">  
        <input type="hidden" name="createpage" />
        <p class="submit">
            <input type="submit" class="button button-primary button-hero load-customize hide-if-no-customize" value="<?php _e('Create Page') ?>" />
        </p>
    </form>
    <p>Created by <a href="http://www.web-4-all.cz">web-4-all.cz</a>.</p>
    </div>
</div>