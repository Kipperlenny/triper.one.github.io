<?php 	

    $current_users_id = get_current_user_id();
    $posts_per_page = POSTSPERPAGEINDEXPHP;
    $args = array(
        'post_type'=>array('event'),
        'author' => $current_users_id,
        'posts_per_page' => $posts_per_page,
    );
?>

 <div class="below-map">
<?php do_action( 'below-map' ); ?>  
 </div>	
<div id="content" class="site-content themeform">

	<?php get_sidebar('left'); ?>
	
	
	<div id="primary" class="content-area zilla-one-half">
		
			
                <?php // a join/cancel-event function which must stay outside the loop, because otherwise it adds multiple id's in the database
				get_template_part('controller/controller','eventparticipation');	?>
			
		
                <div id="indexTabNavi">
                    <div class="indexHeaderTab active" id="myEventsTab">

                        <h4>My Events</h4>

                    </div>
                    <div class="indexHeaderTab" id="globalActivityTab">

                        <h4>Global Activity</h4>

                    </div>
                   
                </div>
		      <div class="ajax-loader global-activity"><img src="<?php bloginfo('template_url') ?>/images/spinner.svg" width="32" height="32" /></div>
			
			
		
            <div id="indexHeader" class="none">
                <h1><?php _e('My events', 'triperone');  ?></h1>
            </div>
            
         
			
            <?php  get_template_part('template-parts/event','neweventform'); ?>
				
            <?php  get_template_part("template-parts/map","filter-form")?>
        
			<main id="main" class="site-main" role="main">
	
					<?php
					
				     query_posts($args);
				     $found_posts = $wp_query->found_posts;
					if ( have_posts() ) :


						if ( is_home() && ! is_front_page() ) : ?>
							<header>
								<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
							</header>

						<?php
						endif;

						while ( have_posts() ) : the_post();

						/* Start the Loop */
							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
				
							get_template_part( 'template-parts/content', get_post_format() );
						
						endwhile;

					else :

						//get_template_part( 'template-parts/content', 'none' );You have not created an event yet.
                            ?>
                         <h4 class="no-event"><?php _e('You have not created an event yet', 'triperone'); ?></h4>
                         <p class="no-event-desc"><?php _e('Just try it out.', 'triperone'); ?></p>

					<?php endif; ?>
						
		</main><!-- #main -->
                        
                        
        <!--load more button fo index.php page on load              -->
        <a id="loadMoreLinkIndex" class="loadMoreLink" href=""><?php _e('Load More', 'triperone'); ?></a>
        <div id="loadMoreAjaxLoaderIndex" class="load-more-ajax-loader"><img src="<?php bloginfo('template_url') ?>/images/spinner.svg" width="32" height="32" /></div>

        <script>
        
            var onLoadFoundPosts = <?php  echo $found_posts ?>;
            
        </script>
    
        <script id="userMainScript" type="text/javascript">

            window.addEventListener('load',function(){
                        (function($){
                                var ajaxUrl = "<?php echo get_bloginfo('url').'/wp-json/events/v2/index-pagination/'?>";
                                pageIndex = 1; // What page we are on.
                                pppIndex = <?php  echo $posts_per_page;?>; // Post per page
                                $("#loadMoreLinkIndex").on("click",function(e){ 
                                    e.preventDefault();
                                    $("#loadMoreAjaxLoaderIndex").show();
                                    var loadMoreLinkIndex = $("#loadMoreLinkIndex"); 
                                    loadMoreLinkIndex.hide();
                                    $("#loadMoreLinkIndex").attr("disabled",true); // Disable the button, temp
                                    $.ajax({
                                            method: "POST",
                                            url: ajaxUrl,
                                            data: {
                                                offset: (pageIndex * pppIndex)
                                            },
                                            beforeSend: function ( xhr ) {
                                                xhr.setRequestHeader( 'X-WP-Nonce', ajaxObject.nonce );
                                            },
                                            success : function( response ) {
                                                loadMoreLinkIndex.show();
                                                $("#loadMoreAjaxLoaderIndex").hide();
                                                $("#main").append(response.html);
                                                $("#loadMoreLinkIndex").attr("disabled",false);
                                                if (response.found_posts <= <?php echo FOUNDPOSTSLIMIT?> || response.found_posts === null){
                                                        $("#loadMoreLinkIndex").hide();
                                                        pageIndex = 1;
                                                };
                                                pageIndex++;
                                                console.log("response");
                                                console.log(response);
                                            },
                                            error: function(xhr, status, error) {
                                                console.log("xhr");
                                                console.log(xhr);
                                                console.log("status");
                                                console.log(status);
                                                console.log("error");
                                                console.log(error);
                                                console.log("xhr.responseText");
                                                console.log(xhr.responseText);
                                            }
                                    }); // ajax()
                               });
                            })(jQuery);
                },false);	
        </script>
	
       
	      <!--load more button for global events on main page -->
        <div id="loadMoreAjaxLoaderGlobal" class="load-more-ajax-loader"><img src="<?php bloginfo('template_url') ?>/images/spinner.svg" width="32" height="32" /></div>
        <a id="loadMoreLinkGlobal" class="loadMoreLink none" href=""><?php _e('Load More', 'triperone'); ?></a>
        <script id="globalActivityScript" type="text/javascript">

            window.addEventListener('load',function(){
                        (function($){
                                var ajaxUrl = "<?php echo get_bloginfo('url').'/wp-json/events/v2/global-pagination/'?>";
                                pageGlobal = 1; // What page we are on.
                                pppGlobal = <?php  echo $posts_per_page;?>; // Post per page
                                $("#loadMoreLinkGlobal").on("click",function(e){ 
                                    e.preventDefault();
                                    $("#loadMoreAjaxLoaderGlobal").show();
                                    var loadMoreLinkGlobal = $("#loadMoreLinkGlobal"); 
                                    loadMoreLinkGlobal.hide();
                                    $("#loadMoreLinkGlobal").attr("disabled",true); // Disable the button, temp
                                    $.ajax({
                                            method: "POST",
                                            url: ajaxUrl,
                                            data: {
                                                offset: (pageGlobal * pppGlobal)
                                            },
                                            beforeSend: function ( xhr ) {
                                                xhr.setRequestHeader( 'X-WP-Nonce', ajaxObject.nonce );
                                            },
                                            success : function( response ) {
                                                loadMoreLinkGlobal.show();
                                                $("#loadMoreAjaxLoaderGlobal").hide();
                                                $("#main").append(response.html);
                                                $("#loadMoreLinkGlobal").attr("disabled",false);
                                                if (response.found_posts <= <?php echo FOUNDPOSTSLIMIT?> || response.found_posts === null){
                                                        $("#loadMoreLinkGlobal").hide();
                                                        pageGlobal = 1;
                                                };
                                                console.log("response");
                                                console.log(response);
                                                pageGlobal++;
                                            },
                                            error: function(xhr, status, error) {
                                                console.log("xhr");
                                                console.log(xhr);
                                                console.log("status");
                                                console.log(status);
                                                console.log("error");
                                                console.log(error);
                                                console.log("xhr.responseText");
                                                console.log(xhr.responseText);
                                            }
                                    }); // ajax()
                               });
                        })(jQuery);
            },false);	
        </script>	
	
	    
        <!--load more button for my events (if global events were already loaded)-->
        <div id="loadMoreAjaxLoaderMyEvents" class="load-more-ajax-loader"><img src="<?php bloginfo('template_url') ?>/images/spinner.svg" width="32" height="32" /></div>
        <a id="loadMoreLinkMyEvents" class="loadMoreLink none" href=""><?php _e('Load More', 'triperone'); ?></a>
        <script id="myEventsActivityScript" type="text/javascript">

                window.addEventListener('load',function(){
                            (function($){
                                    var ajaxUrl = "<?php echo get_bloginfo('url').'/wp-json/events/v2/myevents-pagination/'?>";
                                    pageMyevents = 1; // What page we are on.
                                    pppMyevents = <?php  echo $posts_per_page;?>; // Post per page
                                    $("#loadMoreLinkMyEvents").on("click",function(e){ 
                                        e.preventDefault();
                                        $("#loadMoreAjaxLoaderMyEvents").show();
                                        var loadMoreLinkMyEvents = $("#loadMoreLinkMyEvents"); 
                                        loadMoreLinkMyEvents.hide();
                                        $("#loadMoreLinkMyEvents").attr("disabled",true); // Disable the button, temp
                                        $.ajax({
                                                method: "POST",
                                                url: ajaxUrl,
                                                data: {
                                                    offset: (pageMyevents * pppMyevents),
                                                },
                                                beforeSend: function ( xhr ) {
                                                    xhr.setRequestHeader( 'X-WP-Nonce', ajaxObject.nonce );
                                                },
                                                success : function( response ) {
                                                    loadMoreLinkMyEvents.show();
                                                    $("#loadMoreAjaxLoaderMyEvents").hide();
                                                    $("#main").append(response.html);
                                                    $("#loadMoreLinkMyEvents").attr("disabled",false);
                                                    if (response.found_posts <= <?php echo FOUNDPOSTSLIMIT?> || response.found_posts === null){
                                                            $("#loadMoreLinkMyEvents").hide();
                                                            pageMyevents = 1;	
                                                    };
                                                    console.log("response");
                                                    console.log(response);
                                                    pageMyevents++;
                                                },
                                                error: function(xhr, status, error) {
                                                    console.log("xhr");
                                                    console.log(xhr);
                                                    console.log("status");
                                                    console.log(status);
                                                    console.log("error");
                                                    console.log(error);
                                                    console.log("xhr.responseText");
                                                    console.log(xhr.responseText);
                                                }
                                        }); // ajax()
                                   });
                            })(jQuery);
                    },false);	
            </script>		
	
       
        <!--load more button for filter results -->
        <div id="loadMoreAjaxLoaderFilterResults" class="load-more-ajax-loader"><img src="<?php bloginfo('template_url') ?>/images/spinner.svg" width="32" height="32" /></div>
        <a id="loadMoreLinkFilterResults" class="loadMoreLink none" href=""><?php _e('Load More', 'triperone'); ?></a>
        <script id="filterResultsScript" type="text/javascript">

                window.addEventListener('load',function(){
                            (function($){
                                var dataBla;
                                    var ajaxUrl = "<?php echo get_bloginfo('url').'/wp-json/events/v2/filter-pagination/'?>";
                                    pageFilter = 1; // What page we are on.
                                    pppFilter = <?php  echo $posts_per_page;?>; // Post per page
                                    $("#loadMoreLinkFilterResults").on("click",function(e){ 
                                        e.preventDefault();
                                        $("#loadMoreAjaxLoaderFilterResults").show();
                                        var loadMoreLinkFilterResults = $("#loadMoreLinkFilterResults"); 
                                        loadMoreLinkFilterResults.addClass('none');
                                        $("#loadMoreLinkFilterResults").attr("disabled",true); // Disable the button, temp
                                        dataBla = {
                                                    offset: (pageFilter * pppFilter),
                                                    place_id: globalFilter.place_id,
                                                    from: globalFilter.from,
                                                    to: globalFilter.to,
                                                    category: globalFilter.category,
                                        };
                                        console.log("dataBla");
                                        console.log(dataBla);
                                        $.ajax({
                                                method: "GET",
                                                url: ajaxUrl,
                                                data: {
                                                    offset: (pageFilter * pppFilter),
                                                    place_id: globalFilter.place_id,
                                                    from: globalFilter.from,
                                                    to: globalFilter.to,
                                                    category: globalFilter.category,
                                                },
                                                beforeSend: function ( xhr ) {
                                                    xhr.setRequestHeader( 'X-WP-Nonce', ajaxObject.nonce );
                                                },
                                                success : function( response ) {
                                                    loadMoreLinkFilterResults.removeClass('none');
                                                    $("#loadMoreAjaxLoaderFilterResults").hide();
                                                    $("#main").append(response.html);
                                                    $("#loadMoreLinkFilterResults").attr("disabled",false);
                                                    if (response.found_posts <= <?php echo FOUNDPOSTSLIMIT?> || response.found_posts === null){
                                                            $("#loadMoreLinkFilterResults").addClass('none');
                                                            pageFilter = 1;	
                                                    };
                                                    console.log("response");
                                                    console.log(response);
                                                    pageFilter++;
                                                    
                                                },
                                                error: function(xhr, status, error) {
                                                    console.log("xhr");
                                                    console.log(xhr);
                                                    console.log("status");
                                                    console.log(status);
                                                    console.log("error");
                                                    console.log(error);
                                                    console.log("xhr.responseText");
                                                    console.log(xhr.responseText);
                                                    console.log("ajaxUrl");
                                                    console.log(ajaxUrl);
                                                    
                                                }
                                        }); // ajax()
                                   });
                            })(jQuery);
                    },false);	
            </script>		
	
</div><!-- #primary -->
<?php get_sidebar('right'); ?>
	