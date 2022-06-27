console.log('ok');


    
function placeFooter() {
    if( $(document.body).height() < $(window).height() ) {
        $("footer").css({position: "fixed", bottom:"0px"});
    } else {
        $("footer").css({position: ""});
    }
}

placeFooter();