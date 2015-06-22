<?php
/**
 * The default template for displaying content
 *
 * Used for both single commission.
 *
 * @package WordPress
 * @subpackage Turbulence
 * @since Turbulence 1.0
 */

$artists = get_field('artist');
$artists = is_array($artists) ? $artists : array($artists);
$category = get_the_category();
?>

<section class="commission<?php if($category){ echo ' feature-page ' . $category[0]->slug; }?>">

    <?php if($category){ echo '<h2 class="label-category"> ' . $category[0]->name . '</h2>'; }?>
    <h1 class="commission__title"><?php the_title(); ?></h1>
    <?php if (get_field('sub_heading')){ echo '<h2 class="commission__sub_heading">' . get_field('sub_heading') . '</h2>'; } ?>
    <div class="commission__year"><span><?php $launch_date = date_create(get_field('year_realise')); echo date_format($launch_date,'F, Y')?></span></div>
    <div class="commission__author"><?php _e('by')?> <?php
        $arr = array();
        foreach($artists as $o) {
            $arr[] = '<a href="' . get_permalink( $o ) . '" title="'. $o->post_title .'">' . $o->post_title . '</a>';
        }
        echo implode(' & ', $arr);
    ?></div>

      <div class="commission__work
        <?php
          if($category){
            echo ' frame-type-' . $category[0]->slug;
          } else {
            echo ' frame-type-' . (get_field('list_frame_type') ? get_field('list_frame_type') : 'default');
          }
        ?>">
          <div class="commission__work-img">
              <?php
              if ( has_post_thumbnail() ) {
                echo get_the_post_thumbnail(null, array(240,180));
              } else {
                echo '<img src="'.get_template_directory_uri() . '/img/default_profile.png" alt="default"></img>';
              }
              ?>
          </div>
          <a href="<?php echo get_field('commission_link') ?>" target="_blank" class="commission__work-overlay"></a>
      </div>

    <?php
    $funder = get_field('funder');
    if ($funder){ ?>
    <div class="commission__small-desc">
        <p>Supported by <?php echo $funder?></p>
    </div>
    <?php } ?>
    <div class="commission__desc">
        <?php the_content(); ?>
    </div>
    <?php if($media = get_field('media')):?>
        <div class="commission__media">
            <?php echo apply_filters('the_content', "[embed]" . $media . "[/embed]");?>
        </div>
    <?php endif;?>
    <div class="commission__item">
        <h3><?php _e('TAXONOMY')?></h3>
        <p>
            <?php
                $tags = array();
                foreach ( wp_get_post_tags(get_the_ID()) as $tag ) {
                    $tag_link = get_tag_link( $tag->term_id );
                    $tags[] = "<a href='{$tag_link}' title='{$tag->name}' class='{$tag->slug}'>{$tag->name}</a>";
                }
                echo implode(' | ', $tags);
            ?>
        </p>
    </div>
    <?php if($requirements = get_field('requirements')):?>
        <div class="commission__item">
            <h3><?php _e('REQUIREMENTS')?></h3>
            <?php echo $requirements;?>
        </div>
    <?php endif;?>
    <?php if($media_and_achievments = get_field('media_and_achievments')):?>
        <div class="commission__item">
            <h3><?php _e('MEDIA &amp; ACHIEVMENTS')?></h3>
            <?php echo $media_and_achievments;?>
        </div>
    <?php endif;?>
    <?php if($addittional_notes = get_field('addittional_notes')):?>
        <div class="commission__item">
            <h3><?php _e('ADDITTIONAL NOTES')?></h3>
            <?php echo $addittional_notes;?>
        </div>
    <?php endif;?>
    <div class="commission__item commission__item_share">
        <h3><?php _e('SHARE')?></h3>
        <div>
            <script>
                document.write('<input type="text" value="' + document.location.href + '" readonly onclick="this.select();">');
            </script>
        </div>
    </div>
</section>
<?php foreach($artists as $artist): ?>
    <section class="artist-details">
        <div class="artist-details__info">
            <h1 class="artist-details__name"><?php echo $artist->post_title?></h1>
            <div class="artist-details__photo">
              <?php echo get_artist_pic($artist->ID); ?>
            </div>
            <?php if($map = get_field('artist_map', $artist->ID)):?>
                <div class="acf-map">
                    <div class="marker" data-lat="<?php echo $map['lat']; ?>" data-lng="<?php echo $map['lng']; ?>"></div>
                </div>
            <?php else:?>
                <div class="artist-details__map">
                </div>
            <?php endif;?>
            <div class="artist-details__place"><?php echo get_field('location', $artist->ID)?></div>
        </div>
        <div class="artist-details__content">
            <div class="artist-details__desc">
                <?php echo $artist->post_content?>
            </div>
            <?php if($website = get_field('web_site', $artist->ID)):?>
                <a href="http://<?php echo $website?>" target="_blank" class="artist-details__site"><?php echo $website?></a>
            <?php endif;?>
            <div class="artist-details__social">
                <?php if($value = get_field('facebook_link', $artist->ID)):?>
                    <a href="<?php echo $value?>" class="social-fb"></a>
                <?php endif;?>
                <?php if($value = get_field('twitter_link', $artist->ID)):?>
                    <a href="<?php echo $value?>" class="social-tw"></a>
                <?php endif;?>
                <?php if($value = get_field('github_link', $artist->ID)):?>
                    <a href="<?php echo $value?>" class="social-git"></a>
                <?php endif;?>
            </div>
        </div>
    </section>
<?php endforeach;?>
<div class="artist-details__relevant">
    <?php if ( function_exists( 'ald_crp_commissions' ) )  ald_crp_commissions(); ?>
</div>
