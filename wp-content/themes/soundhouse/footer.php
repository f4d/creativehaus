<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after. Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>
  </div>
</div>
<footer>
  <div class="bottom-bar">
    <div class="container">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php dynamic_sidebar('copyright');  ?>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
       <?php dynamic_sidebar('webdesign');   ?>
      </div>
    </div>
  </div>
</footer>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
