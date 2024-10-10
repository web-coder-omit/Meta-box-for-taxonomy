<?php
/**
 * Plugin Name: Meta box for taxonomy
 * Plugin URI:  Plugin URL Link
 * Author:      Plugin Author Name
 * Author URI:  Plugin Author Link
 * Description: This plugin make for pratice wich is "Meta box for taxonomy".
 * Version:     0.1.0
 * License:     GPL-2.0+
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: mb_t
 */
// Languages file loaded
function plugin_file_function(){
    load_plugin_textdomain('mb_t', false, dirname(__FILE__) . "/languages");
}
add_action('plugins_loaded', 'plugin_file_function');
function txnome_function(){
    $arguments = array(
        'type' => 'string',
        'sanitize_callback'=> 'sanitize_text_field',
        'single'=>true,
        'description'=>'sample mata field for category tax',
        'show_in_rest'=>true
    );
    register_meta('term','taxm_extra_info',$arguments);
}
add_action('init', 'txnome_function');


function taxm_category_form_field(){
    ?>
    <div class="form-field form-required term-name-wrap">
	    <label for="tag-name"><?php _e('Extra information:',"mb_t"); ?></label>
	    <input name="extra-info" id="extra-info" type="text" value="" size="40" aria-required="true" aria-describedby="name-description">
	    <p id="name-description"><?php_e('Give me some information','mb_t'); ?></p>
    </div>
    <?php
}
add_action('category_add_form_fields','taxm_category_form_field');
add_action('post_tag_add_form_fields','taxm_category_form_field');

function taxm_category_edit_form_field($term){
    $extra_info = get_term_meta($term->term_id,'taxm_extra_info',true);
    ?>
    <tr class="form-field form-required term-name-wrap">
			<th scope="row">
            <label for="tag-name"><?php _e('Extra information:',"mb_t"); ?></label>
            </th>
			<td>
            <input name="extra-info" id="extra-info" type="text" value="<?php echo esc_attr($extra_info); ?>" size="40" aria-required="true" aria-describedby="name-description">
	        <p id="name-description"><?php _e('Give me some information','mb_t'); ?></p>
            </td>
	</tr>
    <?php
}
add_action('category_edit_form_fields','taxm_category_edit_form_field');
add_action('post_tag_edit_form_fields','taxm_category_edit_form_field');
// Save data in dataBase
function taxm_data_save($term_id){
    if(wp_verify_nonce($_POST['_wpnonce_add-tag'],'add-tag')){
        $extra_info = sanitize_text_field($_POST['extra-info']);
        update_term_meta($term_id,'taxm_extra_info',$extra_info);
    }
}
 add_action('create_category','taxm_data_save');
 add_action('create_post_tag','taxm_data_save');

function taxm_updata_save($term_id){
   if(wp_verify_nonce($_POST['_wpnonce'],"update-tag_{$term_id}")){
    //if (isset($_POST['taxm_meta_nonce']) && wp_verify_nonce($_POST['taxm_meta_nonce'], 'add-category-meta')) {
        $extra_info = sanitize_text_field($_POST['extra-info']);
        update_term_meta($term_id,'taxm_extra_info',$extra_info);
    }
}
add_action('edit_category','taxm_updata_save');
add_action('edit_post_tag','taxm_updata_save');


?>