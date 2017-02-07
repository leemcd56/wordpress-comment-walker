<?php

/**
 * WordPress Comment Walker
 *
 * @package     Wordpress
 * @subpackage  Comment_Walker
 * @author      Boone Software <support@boone.io>
 */
class Comment_Walker extends Walker_Comment
{
    /**
    * Output a comment in the HTML5 format. Don't worry, we're
    * just extending default WordPress functionality.
    *
    * @access protected
    * @since 3.6.0
    *
    * @see wp_list_comments()
    *
    * @param object $comment Comment to display.
    * @param int    $depth   Depth of comment.
    * @param array  $args    An array of arguments.
    */
    protected function html5_comment($comment, $depth, $args) {
        // Determine which tag we're using
        $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
?>
<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
    <section id="div-comment-<?php comment_ID(); ?>" class="comment-body">
        <div class="comment-meta">
            <div class="comment-avatar">
                <?php if ($args['avatar_size'] !== 0) echo get_avatar($comment, $args['avatar_size']); ?>
            </div>

            <div class="comment-content">
                <?php
                    // Nifty "In Reply To" feature that doesn't come with vanilla comments
                    if (intval($comment->comment_parent) !== 0) {
                        printf(__('<div class="author">%1$s in reply to %2$s</span></div>'), get_comment_author($comment), get_comment_author($comment->comment_parent));
                    } else {
                        printf(__('<div class="author">%s</div>'), get_comment_author($comment));
                    }
                ?>

                <div class="time">
                    <time datetime="<?php comment_time('c'); ?>">
                        <?php
                            printf(__('%1$s at %2$s'), get_comment_date('', $comment), get_comment_time());
                        ?>
                    </time>
                </div>

                <?php if (!$comment->comment_approved): ?>
                    <p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.'); ?></p>
                <?php endif; ?>

                <?php comment_text(); ?>

                <?php
                    // Output Edit link
                    edit_comment_link(__('Edit'), '<span class="edit-link">', '</span>');

                    // Output Reply link
                    comment_reply_link([
                        'add_below'     => 'div-comment',
                        'depth'         => $depth,
                        'max_depth'     => $args['max_depth']
                    ]);
                ?>
            </div>
        </div>
    </section>
<?php
    }
}
