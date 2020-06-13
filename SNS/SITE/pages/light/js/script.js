$(window).scroll(function(){
    var scroll = $(window).scrollTop();
    if(scroll < 300){
        $('.fixed-top').css('background', 'white');
        $('a').css('color', 'black');
    } else{
        $('.fixed-top').css('background', 'linear-gradient(90deg, rgba(86,107,229,1) 0%, rgba(50,168,240,1) 50%, rgba(15,230,251,1) 100%)');
        $('a').css('color', 'white');
    }
});