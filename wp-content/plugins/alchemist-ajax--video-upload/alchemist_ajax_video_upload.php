<?php
/*
Plugin Name: Alchemist Ajax Video Upload
Plugin URI: http://www.tandukar.com
Description: Front-end ajax image upload. Add sohrtcode [AAIVU] any where in post,page or in your custom form. For theme insert the code ' echo do_shortcode('[AAIVU theme="true"]'); ' in your theme.
Version:  1.1
Author: Rajesh Tandukar
Author URI: http://www.tandukar.com
License: GPL2
*/

/*  2013  Rajesh Tandukar  (email : rtandukar@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('AAIVU_BASENAME', trailingslashit(basename(dirname(__FILE__))));
define('AAIVU_DIR', WP_CONTENT_DIR . '/plugins/' . AAIVU_BASENAME);
define('AAIVU_URL', WP_CONTENT_URL . '/plugins/' . AAIVU_BASENAME);

class Aaivu_Alchimest__Ajax_Image_Upload
{
    public $option = 'aaivu-options';
    public $options = null;

    public function aaivu_register()
    {
        register_setting('aaivu_plugin_option', $this->option, array($this, 'aaivu_validate_options'));
    }

    public function aaivu_initialize_default_options()
    {
        $default_options = array(
            "max_upload_size" => "100 ",
            "max_upload_no" => "2",
            "allow_ext" => "jpg,gif,png"
        );
        update_option($this->option, $default_options);

    }

    public function aaivu_display($atts = null)
    {
        if (isset($atts)) {
            if ($atts['theme'] == true) {
                $this->aaivu_enquee(true);
            }
        }
        include_once (AAIVU_DIR . '/html.php');

    }

    public function aaivu_validate_options($input)
    {
        return $input;
    }

    public function aaivu_enquee($theme = false)
    {
        if ($theme) {
            $this->aaivu_add_script();
        } elseif ($this->aaivu_has_shortcode('AAIVU')) {
            $this->aaivu_add_script();

        }
    }

    public function aaivu_add_script()
    {
        $this->options = get_option('aaivu-options');

        wp_enqueue_script('jquery');
        wp_enqueue_script('plupload-handlers');

        $max_file_size = intval($this->options['max_upload_size']) * 1000 * 1000;
        $max_upload_no = intval($this->options['max_upload_no']);
        $allow_ext = $this->options['allow_ext'];

        wp_enqueue_script('aaivu_upload', AAIVU_URL . 'js/aaivu_upload.js', array('jquery'));

        wp_localize_script('aaivu_upload', 'aaivu_upload', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('aaivu_upload'),
            'remove' => wp_create_nonce('aaivu_remove'),
            'number' => $max_upload_no,
            'upload_enabled' => true,
            'confirmMsg' => __('Are you sure you want to delete this?'),
            'plupload' => array(
                'runtimes' => 'html5,flash,html4',
                'browse_button' => 'aaivu-uploader',
                'container' => 'aaivu-upload-container',
                'file_data_name' => 'aaivu_upload_file',
                'max_file_size' => $max_file_size . 'b',
                'url' => admin_url('admin-ajax.php') . '?action=aaivu_upload&nonce=' . wp_create_nonce('aaivu_allow'),
                'flash_swf_url' => includes_url('js/plupload/plupload.flash.swf'),
                'filters' => array(array('title' => __('Allowed Files'), 'extensions' => $allow_ext)),
                'multipart' => true,
                'urlstream_upload' => true,
            )
        ));

    }

    public function aaivu_upload()
    {
        check_ajax_referer('aaivu_allow', 'nonce');

        $file = array(
            'name' => $_FILES['aaivu_upload_file']['name'],
            'type' => $_FILES['aaivu_upload_file']['type'],
            'tmp_name' => $_FILES['aaivu_upload_file']['tmp_name'],
            'error' => $_FILES['aaivu_upload_file']['error'],
            'size' => $_FILES['aaivu_upload_file']['size']
        );
        $file = $this->aaivu_fileupload_process($file);
    }

    public function aaivu_fileupload_process($file)
    {
        $attachment = $this->aaivu_handle_file($file);
        if (is_array($attachment)) {
            $html = $this->aaivu_getHTML($attachment);
            $response = array(
                'success' => true,
                'html' => $html,
            );
            echo json_encode($response);
            exit;
        }

        $response = array('success' => false);
        echo json_encode($response);
        exit;
    }

    function aaivu_handle_file($upload_data)
    {
        $return = false;
        $uploaded_file = wp_handle_upload($upload_data, array('test_form' => false));
        if (isset($uploaded_file['file'])) {
            $file_loc = $uploaded_file['file'];
            $file_name = basename($upload_data['name']);
            $file_type = wp_check_filetype($file_name);
			$wp_upload_dir = wp_upload_dir();
            $attachment = array(
				'guid'           => $wp_upload_dir['url'] . '/' . basename( $file_name ), 
                'post_mime_type' => $file_type['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($file_name)),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attach_id = wp_insert_attachment($attachment, $file_loc);
            $attach_data = wp_generate_attachment_metadata($attach_id, $file_loc);
            wp_update_attachment_metadata($attach_id, $attach_data);
            $return = array('data' => $attach_data, 'id' => $attach_id);
            return $return;
        }
        return $return;
    }

	function aaivu_getHTML($attachment)
	{
		$attach_id = $attachment['id'];
        
        $bitrate = intval( $attachment['data']['bitrate'] /1024 );
        $bitrate.' is bitrate <br><br>';
        if ( $bitrate >= 192 ) {
			wp_delete_attachment($attach_id, true);
			$html = '';
			$html .= '<li class="aaivu-uploaded-files-to-delete">';
			$html .= sprintf('Please upload MP3 file upto 192kbps');
			$html .= '</li>';
		} else {
			//echo 'good with bitrate';
			$file = explode('/', $attachment['data']['file']);
			$file = array_slice($file, 0, count($file) - 1);
			$path = implode('/', $file);
			$image = $attachment['data']['sizes']['thumbnail']['file'];
			$post = get_post( $attach_id );
			$dir = wp_upload_dir();
			$path = $dir['baseurl'] . '/' . $path;

			$html = '';
			$html .= '<li class="aaivu-uploaded-files">';
			$html .= sprintf('Upload Complete');
			$html .= sprintf('<br /><a href="#" class="action-delete" data-upload_id="%d">%s</a></span>', $attach_id, __('Delete'));
			$html .= sprintf('<input type="hidden" name="aaivu_image_id" id= "aaivu_image_id"  value="%d" />', $attach_id);
			$html .= '</li>';
			}

        return $html;
    }


    function aaivu_has_shortcode($shortcode = '', $post_id = false)
    {
        global $post;

        if (!$post) {
            return false;
        }

        $post_to_check = ($post_id == false) ? get_post(get_the_ID()) : get_post($post_id);

        if (!$post_to_check) {
            return false;
        }
        $return = false;

        if (!$shortcode) {
            return $return;
        }

        if (stripos($post_to_check->post_content, '[' . $shortcode) !== false) {
            $return = true;
        }

        return $return;
    }

    public function aaivu_delete_file()
    {
        $attach_id = $_POST['attach_id'];
        wp_delete_attachment($attach_id, true);
        exit;
    }

}

function aaivu_register_alchemist_menu_page()
{
    $menuSlug = 'alchemist_ajax_video_upload.php';
    add_menu_page('Waau', 'AAIVU Upload', 'manage_options', $menuSlug, 'aaivu_settings');

}

function aaivu_settings()
{
    ?>
<div class="wrap">
    <h2>AAIVU Settings</h2>

    <form method="post" name="aaivu-form" action="<?php echo 'options.php'; ?>">
        <?php settings_fields('aaivu_plugin_option'); ?>
        <?php $options = get_option('aaivu-options');?>
        <table class="form-table">
            <tbody>
            <tr valign="top">
                <th scope="row"><label for="max_upload_size">Max Upload Size</label></th>
                <td><input type="text" value="<?php echo $options['max_upload_size'];?>"  name="aaivu-options[max_upload_size]" size="10">

                    <p class="description">Size in MB.</p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="max_upload_no">Max Number of Image</label></th>
                <td><input type="text" value="<?php echo $options['max_upload_no'];?>"
                           name="aaivu-options[max_upload_no]" size="10">

                    <p class="description">Maximun number of Images user can upload.</p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="allow_ext">Allowed Extension</label></th>
                <td><input type="text" value="<?php echo $options['allow_ext'];?>"
                           name="aaivu-options[allow_ext]" size="20">

                    <p class="description">Eg: jpge,gif,png</p>
                </td>
            </tr>

            <tr valign="top">
                <td colspan="2"><?php submit_button(); ?></td>
            </tr>

            </tbody>
        </table>
    </form>
</div>
<?php
}

$aaivufile = WP_CONTENT_DIR . '/plugins/' . basename(dirname(__FILE__)) . '/' . basename(__FILE__);

$aaui = new Aaivu_Alchimest__Ajax_Image_Upload();
add_action('admin_init', array($aaui, 'aaivu_register'));
add_action('admin_menu', 'aaivu_register_alchemist_menu_page');
register_activation_hook($aaivufile, array($aaui, 'aaivu_initialize_default_options'));
add_action('wp_enqueue_scripts', array($aaui, 'aaivu_enquee'));
add_shortcode('AAIVU', array($aaui, 'aaivu_display'));
add_action('wp_ajax_aaivu_upload', array($aaui, 'aaivu_upload'));
add_action('wp_ajax_aaivu_delete', array($aaui, 'aaivu_delete_file'));

/* For non logged-in user */
add_action('wp_ajax_nopriv_aaivu_upload', array($aaui, 'aaivu_upload'));
add_action('wp_ajax_nopriv_aaivu_delete', array($aaui, 'aaivu_delete_file'));

