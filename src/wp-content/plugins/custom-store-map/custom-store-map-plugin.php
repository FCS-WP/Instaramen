<?php
/*
Plugin Name: Custom Store Map Plugin
Description: Plugin hiển thị bản đồ với các cửa hàng và chức năng tìm kiếm.
Version: 1.0
Author: ToanPham
*/

if (!defined('ABSPATH')) {
    exit;
}

class CustomStoreMapPlugin
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'create_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_shortcode('custom_store_map', array($this, 'shortcode_callback'));
        add_action('admin_init', array($this, 'register_settings'));

        register_deactivation_hook(__FILE__, array($this, 'plugin_deactivation'));
    }

    public function create_admin_menu()
    {
        add_menu_page(
            'Custom Store Map',
            'Custom Store Map',
            'manage_options',
            'custom-store-map',
            array($this, 'admin_page_callback'),
            'dashicons-location',
            100
        );
    }

    public function enqueue_admin_scripts()
    {
        wp_enqueue_script('custom-store-map-admin', plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery', 'media-upload', 'thickbox'), null, true);
        wp_enqueue_style('custom-store-map-admin', plugin_dir_url(__FILE__) . 'css/admin.css');
        wp_enqueue_style('thickbox');
    }

    public function enqueue_scripts()
    {
        $api_key = get_option('custom_store_map_api_key', '');
        wp_enqueue_script('google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=' . $api_key, array(), null, true);
        wp_enqueue_script('custom-store-map', plugin_dir_url(__FILE__) . 'js/custom-store-map.js', array('jquery'), null, true);
        wp_enqueue_style('custom-store-map', plugin_dir_url(__FILE__) . 'css/custom-store-map.css');
    }

    public function admin_page_callback()
    {
        include 'admin/admin-page.php';
    }

    public function shortcode_callback()
    {
        ob_start();
        include 'templates/map-template.php';
        return ob_get_clean();
    }

    public function register_settings()
    {
        register_setting('custom_store_map_settings', 'custom_store_map_data', array($this, 'sanitize_data'));
        register_setting('custom_store_map_settings', 'custom_store_map_api_key');

        add_settings_section(
            'custom_store_map_section',
            'Store Locations',
            array($this, 'section_callback'),
            'custom-store-map'
        );
        add_settings_field(
            'api_key',
            'Google Maps API Key',
            array($this, 'api_key_callback'),
            'custom-store-map',
            'custom_store_map_section'
        );
        add_settings_field(
            'store_locations',
            'Store Locations',
            array($this, 'store_locations_callback'),
            'custom-store-map',
            'custom_store_map_section'
        );
    }

    public function sanitize_data($input)
    {
        return $input;
    }

    public function section_callback()
    {
        echo '<p>Enter store locations and details below.</p>';
    }

    public function store_locations_callback()
    {
        $data = get_option('custom_store_map_data', array());
        $default_icon = plugin_dir_url(__FILE__) . 'images/default.jpg';
        wp_localize_script('custom-store-map-admin', 'customStoreMapAdmin', array(
            'defaultIcon' => $default_icon
        ));
?>
        <div id="custom-store-map-locations">
            <?php if (!empty($data)) : ?>
                <table class="custom-store-map-table">
                    <thead>
                        <tr>
                            <th>Store Icon</th>
                            <th>Store Name</th>
                            <th>Store Address</th>
                            <th>Store Location (lat,lng)</th>
                            <th>Map Link</th>
                            <th>Page Link</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $index => $store) : ?>
                            <tr class="custom-store-map-location">
                                
                                <td>
                                    <input type="hidden" name="custom_store_map_data[<?php echo $index; ?>][icon]" value="<?php echo esc_attr($store['icon']); ?>" class="custom-store-map-icon-url" />
                                    <img src="<?php echo !empty($store['icon']) ? esc_attr($store['icon']) : $default_icon; ?>" class="custom-store-map-icon-preview" style="max-width: 100px; max-height: 100px;" />
                                    <button type="button" class="upload-icon-button button">Upload Icon</button>
                                </td>
                                <td><input type="text" name="custom_store_map_data[<?php echo $index; ?>][name]" value="<?php echo esc_attr($store['name']); ?>" placeholder="Store Name" required /></td>
                                <td><input type="text" name="custom_store_map_data[<?php echo $index; ?>][address]" value="<?php echo esc_attr($store['address']); ?>" placeholder="Store Address" required /></td>
                                <td><input type="text" name="custom_store_map_data[<?php echo $index; ?>][location]" value="<?php echo esc_attr($store['location']); ?>" placeholder="Store Location (lat,lng)" required /></td>
                                <td><input type="text" name="custom_store_map_data[<?php echo $index; ?>][map_link]" value="<?php echo esc_attr($store['map_link']); ?>" placeholder="Map Link" required /></td>
                                <td><input type="text" name="custom_store_map_data[<?php echo $index; ?>][page_link]" value="<?php echo esc_attr($store['page_link']); ?>" placeholder="Page Link" required /></td>
                                <td><button type="button" class="remove-location">Remove</button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <button type="button" id="add-location">Add Store</button>
    <?php
    }

    public function api_key_callback()
    {
        $api_key = get_option('custom_store_map_api_key', '');
    ?>
        <input type="text" name="custom_store_map_api_key" value="<?php echo esc_attr($api_key); ?>" placeholder="Enter Google Maps API Key" />
<?php
    }

    public function plugin_deactivation()
    {
        delete_option('custom_store_map_data');
        delete_option('custom_store_map_api_key');
    }
}

new CustomStoreMapPlugin();
