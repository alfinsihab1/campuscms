<script type="text/javascript">
    // Image Lazy on Load
    $(window).on("load", function(){
        lazy_load();
    });
    
    // Image Lazy on Scroll
    $(window).on("scroll", function(){
        lazy_load();
    });
    
    // Function Lazy Load
    function lazy_load(){
        var scroll = $(window).scrollTop();
        var images = $("img.lazy");
        $(images).each(function(key,elem){
            if($(elem).offset().top - window.innerHeight < scroll){
                if($(elem).attr("src") == undefined) $(elem).attr("src", $(this).data("src"));
            }
        });
    }
    
    // Function Lazy Load Element
    function lazy_load_elem(selector){
        var scroll = $(selector).scrollTop();
        var images = $("img.lazy");
        $(images).each(function(key,elem){
            if($(elem).offset().top - $(selector).innerHeight() < scroll){
                if($(elem).attr("src") == undefined) $(elem).attr("src", $(this).data("src"));
            }
        });
    }
</script>