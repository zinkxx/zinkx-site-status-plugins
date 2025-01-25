jQuery(document).ready(function($) {
    var ctx = document.getElementById('statusChart').getContext('2d');
    
    // PHP'den gelen JSON verisi
    var chartData = siteStatus.graphData; // siteStatus, wp_localize_script ile aktarıldı
    
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['CPU Kullanımı', 'RAM Kullanımı', 'Disk Kullanımı'],
            datasets: [{
                label: 'Sunucu Durumu',
                data: [chartData.cpu, chartData.memory, chartData.disk],
                backgroundColor: ['#ff0000', '#ff9900', '#00ff00'],
                borderColor: ['#ff0000', '#ff9900', '#00ff00'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
