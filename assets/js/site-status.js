jQuery(document).ready(function($) {
    function fetchServerStatus() {
        $.ajax({
            url: siteStatus.ajax_url,
            method: 'GET',
            data: {
                action: 'get_real_time_status'
            },
            success: function(response) {
                $('.status-widget').html(response);
            }
        });
    }

    // Sunucu bilgilerini her 10 saniyede bir güncelle
    setInterval(fetchServerStatus, 10000);

    // İlk başta bir kez veri çekelim
    fetchServerStatus();
});
