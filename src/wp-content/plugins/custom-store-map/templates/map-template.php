<?php
$terms = get_terms(array(
    'taxonomy' => 'store-name',
    'hide_empty' => false,
));

$locations = array();

foreach ($terms as $term) {
    $term_meta = get_option("taxonomy_$term->term_id");

    if ($term_meta && isset($term_meta['store-address']) && isset($term_meta['store-location'])) {
        $location_data = array(
            'name' => $term->name,
            'address' => $term_meta['store-address'],
            'location' => $term_meta['store-location'],
            'page_link' => get_term_link($term), 
            'icon' => isset($term_meta['store-icon']) ? esc_url($term_meta['store-icon']) : '',
        );
        $locations[] = $location_data;
    }
}

$default_icon = '/wp-content/uploads/2024/07/icon-map-store.png';
?>
<div class="store-map-container">
    <div id="custom-map"></div>
    <div class="store-list">
        <input type="text" id="store-search" placeholder="Search for a store...">
        <div id="store-list">
            <?php foreach ($locations as $location) : ?>
                <div class="store-item" data-location="<?php echo esc_attr($location['location']); ?>">
                    <img src="<?php echo $location['icon'] ? esc_url($location['icon']) : esc_url($default_icon); ?>" alt="<?php echo esc_attr($location['name']); ?>" style="max-width: 50px; max-height: 50px;">
                    <strong><?php echo esc_html($location['name']); ?></strong><br>
                    <span><?php echo esc_html($location['address']); ?></span><br>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    var customStoreMapData = <?php echo json_encode($locations); ?>;
</script>
