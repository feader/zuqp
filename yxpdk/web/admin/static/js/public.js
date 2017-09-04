$(document).ready(function(){     
    var true_width = window.innerWidth;
    if(true_width>100 && true_width<1200){
        $('.show_br').show();
    }else{
        $('.show_br').hide();
    }
});