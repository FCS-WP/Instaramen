<?php
$locations = get_option('custom_store_map_data', array());
$default_icon = '/wp-content/uploads/2024/07/icon-store.png';
?>
<div class="store-map-container">
    <div id="custom-map"></div>
    <div class="store-list">
        <input type="text" id="store-search" placeholder="Search for a store...">
        <div id="store-list">
            <?php foreach ($locations as $store) : 
                $icon_url = !empty($store['icon']) ? esc_url($store['icon']) : esc_url($default_icon);
            ?>
                <div class="store-item" data-location="<?php echo esc_attr($store['location']); ?>">
                    <img src="<?php echo $icon_url; ?>" alt="<?php echo esc_attr($store['name']); ?>" style="max-width: 50px; max-height: 50px;">
                    <strong><?php echo esc_html($store['name']); ?></strong><br>
                    <span><?php echo esc_html($store['address']); ?></span><br>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    var customStoreMapData = <?php echo json_encode($locations); ?>;
</script>
