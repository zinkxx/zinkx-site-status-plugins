<?php
/**
 * Plugin Name: Site Durum Bilgisi
 * Description: Sunucu durumunu izler ve grafiksel olarak gösterir.
 * Version: 1.0
 * Author: [Adınız]
 * License: GPL2
 */

// Sunucu durumu fonksiyonları
include(plugin_dir_path(__FILE__) . 'includes/system-status.php');

// Eklenti stil ve script dosyalarını ekleyelim
function site_status_enqueue_scripts() {
    wp_enqueue_script('site-status-js', plugin_dir_url(__FILE__) . 'assets/js/site-status.js', array('jquery'), null, true);
    wp_enqueue_script('site-status-chart', plugin_dir_url(__FILE__) . 'assets/js/site-status-chart.js', array('chartjs'), null, true);

    // PHP'den JavaScript'e veri aktarımı
    $graph_data = get_system_graph_data(); // PHP fonksiyonundan veri al
    wp_localize_script('site-status-chart', 'siteStatus', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'graphData' => $graph_data // Veriyi JavaScript'e aktarıyoruz
    ));

    wp_enqueue_style('site-status-style', plugin_dir_url(__FILE__) . 'style.css');
}
add_action('admin_enqueue_scripts', 'site_status_enqueue_scripts');

// Sunucu durumunu al
function get_system_status() {
    $cpu_usage = get_cpu_usage();
    $memory_usage = get_memory_usage();
    $disk_usage = get_disk_usage();

    ob_start();
    ?>
    <h2>Sunucu Durumu</h2>
    <ul>
        <li><strong>CPU Kullanımı:</strong> <?php echo $cpu_usage; ?>%</li>
        <li><strong>RAM Kullanımı:</strong> <?php echo $memory_usage; ?>%</li>
        <li><strong>Disk Kullanımı:</strong> <?php echo $disk_usage; ?>%</li>
    </ul>
    <?php
    return ob_get_clean();
}

// Sunucu durumu sayfası (Yalnızca yönetici erişebilir)
function site_status_page() {
    if (!current_user_can('administrator')) {
        echo "Erişim reddedildi!";
        return;
    }

    ?>
    <div class="wrap">
        <h1>Site Durum Bilgisi</h1>
        <div class="status-widget">
            <?php echo get_system_status(); ?>
        </div>
        <canvas id="statusChart" width="400" height="200"></canvas>
    </div>
    <?php
}

// Menü öğesi ekleme
function add_site_status_menu_item() {
    add_menu_page(
        'Site Durum Bilgisi',
        'Site Durumu',
        'administrator',
        'site-status',
        'site_status_page',
        'dashicons-chart-bar',
        6
    );
}
add_action('admin_menu', 'add_site_status_menu_item');

// AJAX için veri çekme
function get_real_time_status() {
    echo get_system_status();
    wp_die();
}
add_action('wp_ajax_get_real_time_status', 'get_real_time_status');
