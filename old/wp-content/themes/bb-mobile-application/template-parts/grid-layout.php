<?php
/**
 * The template part for displaying services
 *
 * @package BB Mobile Application
 * @subpackage bb_mobile_application
 * @since BB Mobile Application 1.0
 */
?>
<div class="col-lg-4 col-md-4">
  <article class="page-box">
    <div class="box-image">
      <?php if( get_theme_mod( 'bb_mobile_application_show_featured_image_post',true) != '') { ?>
        <?php 
          if(has_post_thumbnail()) { 
            the_post_thumbnail(); 
          }
        ?>
      <?php } ?>
    </div>
    <div class="new-text"<?php if(has_post_thumbnail()) { ?><?php } ?>>
  	  <h2><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo the_title_attribute(); ?>"><?php the_title();?><span class="screen-reader-text"><?php the_title(); ?></span></a></h2>
      <div class="entry-content"><p><?php $bb_mobile_application_excerpt = get_the_excerpt(); echo esc_html( bb_mobile_application_string_limit_words( $bb_mobile_application_excerpt, esc_attr(get_theme_mod('bb_mobile_application_excerpt_number','20')))); ?><?php echo esc_html( get_theme_mod('bb_mobile_application_post_suffix_option','...') ); ?></p></div>
      <?php if( get_theme_mod('bb_mobile_application_button_text','Read More') != ''){ ?>
        <a href="<?php the_permalink(); ?>" class="read-more-box" title="<?php esc_attr_e('Read More','bb-mobile-application'); ?>"><?php echo esc_html(get_theme_mod('bb_mobile_application_button_text','Read More'));?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('bb_mobile_application_button_text','Read More'));?></span></a> 
      <?php }?>
    </div>
    <div class="clearfix"></div>
  </article>
</div>
  