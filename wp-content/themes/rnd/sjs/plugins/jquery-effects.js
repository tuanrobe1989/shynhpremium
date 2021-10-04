jQuery(document).ready(function(){
    if(jQuery('#welcome__title-01').length > 0){
        new Waypoint({
            element: document.getElementById('welcome__title-01'),
            handler: function (direction) {
                jQuery('#welcome__title-01').addClass('eff_actived animate__animated animate__fadeIn')
                jQuery('#welcome__description-01').addClass('eff_actived animate__animated animate__fadeIn')
            },
            offset: '70%'
        })
    }
    if(jQuery('#welcome-slider-01').length > 0){
        jQuery('#welcome-slider-01').addClass('eff_actived animate__animated animate__fadeIn');
        jQuery('#welcome-content-01').addClass('eff_actived animate__animated animate__fadeIn');
    }
})