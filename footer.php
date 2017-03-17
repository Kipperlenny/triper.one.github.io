<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package triperone
 */
?>
<footer id="colophon" class="site-footer clear" role="contentinfo">
    <div class="site-info">
        <div class="site-copyright">
           <?php do_action( 'footer' ); ?>
            <?php echo triper_dynamic_copyright(); ?> Triper One - Alle Rechte vorbehalten.
        </div>
        <!-- /.site-copyright -->
    </div>
    <!-- .site-info -->
</footer>
<!-- #colophon -->
<?php wp_footer(); ?>
</body>
</html>