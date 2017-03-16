(function($){
    
    $('document').ready(function(){
        if (onLoadFoundPosts <= FOUNDPOSTSLIMIT || onLoadFoundPosts === null){
           $(".loadMoreLink").addClass('none');
        }           
    });
    
    
    $('#filterForm #filterHeading').on("click", function(){
        $('#filterForm').toggleClass('closed'); 
    });
    $('#cancelFilter').on("click", function(){
        $('#filterForm').addClass('closed'); 
    });
    
}(jQuery));
