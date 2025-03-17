<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
extract( $args );

global $foogra_author_obj;
if ( empty($foogra_author_obj) ) {
    return;
}
$author_obj = $foogra_author_obj;

extract( $args );
extract( $instance );
echo trim($before_widget);
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}
$description = get_user_meta( $author_obj->ID, 'description', true );
?>
<div class="listing-author-description">
    <?php echo wpautop($description); ?>
</div>
<?php echo trim($after_widget);