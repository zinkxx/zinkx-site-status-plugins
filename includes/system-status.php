<?php

// CPU kullanımını al
function get_cpu_usage() {
    $load = sys_getloadavg();
    return round($load[0], 2); // 1 dakikalık ortalama
}

// RAM kullanımını al
function get_memory_usage() {
    $memory = memory_get_usage(true);
    return round(($memory / 1024 / 1024), 2); // MB cinsinden
}

// Disk kullanımını al
function get_disk_usage() {
    $disk_total = disk_total_space('/');
    $disk_free = disk_free_space('/');
    $disk_used = $disk_total - $disk_free;
    return round(($disk_used / $disk_total) * 100, 2); // Yüzde cinsinden
}

// Grafik verilerini oluşturma
function get_system_graph_data() {
    $cpu_usage = get_cpu_usage();
    $memory_usage = get_memory_usage();
    $disk_usage = get_disk_usage();
    
    // Verileri JSON formatında döndürüyoruz
    return array(
        'cpu' => $cpu_usage,
        'memory' => $memory_usage,
        'disk' => $disk_usage
    );
}
