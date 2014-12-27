;
var xmas_snow_options = xmas_snow_options || { };
$(function(){
    if (xmas_snow_options) {
        $(document).snowfall(xmas_snow_options);
    } else {
        $(document).snowfall();
    }
});