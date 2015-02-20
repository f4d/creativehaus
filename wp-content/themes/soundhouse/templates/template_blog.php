<?php
/*
Template Name: Blog
*/
get_header(); ?>

      <div class="inner-content-area">
        <div class="entry-content">
          <div class="blog-roll row">
            <div class="col-lg-9 col-md-9 single-content">
             <?php
		$wp_query= new WP_Query( array( 'showposts' =>3, 'cat' =>13, 'paged' => get_query_var('paged') ) );
		while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
              <div class="row post-content">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <a class = "bloganchor"  href= "<?php the_permalink(); ?>" ><h1><?php the_title(); ?></h1></a>
                  <p class="post-date"><?php the_time('F j, Y') ?>  |  Author - <?php the_author() ?></p>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5">
                 <?php the_post_thumbnail('blog-thum'); ?>
                  <div class="comment">
                    <a href="<?php echo get_comments_link( $post->ID ); ?>"><h2 class="text-center">COMMENT</h2></a>
                <?php
                $id = get_the_ID();
                $args = array(
	            'post_id' => $id, 
                'count' => true );
        
                $comments = get_comments($args);
                 ?>
                    <p class="pull-left">COMMENTS ( <span><?php echo $comments; ?></span> )</p>
                    <a href="#" target="_blank" class="pull-right">SHARE</a> </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 ">
                <p><?php $contact = get_the_content(); echo substr($contact, 0,708); ?></p>  
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="cpartition"></div>
                </div>
              </div>
           <?php 
				endwhile; 
				echo '<div class="newspg">';
				wp_pagenavi( array( 'query' => $wp_query ) );
				echo '</div>';
				 ?>
				<?php 
				wp_reset_query(); ?>              
              
         <!--     <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="paged">
              <ul>
              <li><span>PAGE </span></li>
              <li><a href="#" class="active"> 1</a> ,</li>
               <li><a href="#"> 2 </a> ,</li>
                <li><a href="#"> 3 </a> ,</li>
                 <li><a href="#"> 4 </a> ,</li>
                  <li><a href="#"> 5 </a> </li>
                  <li><span> &gt;&gt;</span></li>
              </ul></div>
              </div>
              </div> -->
              
            </div>
            <?php get_sidebar(); ?>
          </div>
        </div>
      </div>
    </div>

 
<?php get_footer(); ?>
