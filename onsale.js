var onSale = setInterval(function(){

    var sec = jQuery('#Sec').text();
    var min = jQuery('#Min').text();
    var hour = jQuery('#Hour').text();
    var day = jQuery('#Day').text();

    if (day == 0 && hour == 0 && min == 0 && sec == 1) {
        jQuery('.onSaleFlash').hide();
        clearInterval(onSale);
    }

    if (sec == 0 && min != 0 ) {
        jQuery('#Min').text(min - 1);
        sec = 60;
    }
    jQuery('#Sec').text(sec - 1);

    if (min == 0 && hour != 0 ) {
        jQuery('#Hour').text(hour - 1);
        min = 60;
        jQuery('#Min').text(min);
    }
    if (hour == 0 && day != 0 ) {
        jQuery('#Day').text(day - 1);
        hour = 24;
        jQuery('#Hour').text(hour);
    }
},1)