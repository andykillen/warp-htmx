<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage lm_parent
 * @since CV Parent 2018 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">
    <?php if(comments_open()){ 
        $aria_req ='';
        $commenter = wp_get_current_commenter();

        $req = false;                        
        $title = _x('Tell us what you think','comment area heading', WARP_HTMX_TEXT_DOMAIN);
        $args = [
                'title_reply_before' => '<p id="reply-title" class="comment-form-title">',
                'title_reply_after'  => '</p>',
                'title_reply'        => $title,
                'avatar_size'        => 0, // change to a number to show and avatar in Comment form
                'comment_notes_before' => '',
                'class_form'         => 'comment-form',
                'id_form'            =>'comment-form',
                
                'fields'             => [
                                        'author' =>
                                        '<div class="form-item form-type-textfield form-item-name comment-form-author"><label for="author" aria-label="your name" class="visually-hidden">' . _x( 'Your Name', 'comment form field', WARP_HTMX_TEXT_DOMAIN ) .
                                        ( true ? '<span class="required">*</span>' : '' ) . '</label> ' .
                                        '<input id="author" name="author" type="text" placeholder="' . _x( 'Name or nickname', 'comment form field', WARP_HTMX_TEXT_DOMAIN ) . ' *" value="' . esc_attr( $commenter['comment_author'] ) .
                                        '" size="30"' . $aria_req . ' /></div>',

                                        'email' =>
                                        '<div class="form-item form-type-textfield form-item-name comment-form-email"><label for="email">' . _x( 'Email', 'comment form field', WARP_HTMX_TEXT_DOMAIN ) . '</label> ' .
                                        ( false ? '<span class="required">*</span>' : '' ) .
                                        '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
                                        '" size="30"' . $aria_req . ' /></div>',
                ],

                'comment_field'      => '<div class="comment-form-comment">
                                        <label for="comment-textarea" aria-label="comment message" class="visually-hidden">' . _x( 'Comment','comment form field label' , WARP_HTMX_TEXT_DOMAIN ) . ' *</label>
                                        <div class="form-textarea-wrapper resizable textarea-processed resizable-textarea">
                                        <textarea class="text-full form-textarea required" id="comment-textarea" name="comment" cols="45" rows="8" placeholder="'. _x( 'Comment','comment form field placeholder', WARP_HTMX_TEXT_DOMAIN ) .' *" aria-required="true"></textarea>
                                        </div>
                                </div>',
                ];
        comment_form( $args, get_the_ID() );
        
        
        } ?>

        <?php if ( have_comments() ) : ?>
                <p class="comments-title"><?php echo esc_html_x('Recent Comments','comments listing', WARP_HTMX_TEXT_DOMAIN); ?> <span>(<?php echo get_comments_number() ?>)</span></p>
                <ol class="comment-list">
                        <?php
                                wp_list_comments( [
                                        'style'       => 'ol',
                                        'short_ping'  => true,
                                        'avatar_size' => apply_filters('warp_htmx_comment_avatar_size', 0),
                                        'per_page'    => -1
                                ] );
                        ?>
                </ol>
        <?php endif ; ?>
</div>