<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Bianco
 * @since bianco 1.0
 */
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
$comment_field     = '<p class="comment-form-comment"><textarea class="input-form" id="comment" placeholder="' . esc_attr__( 'Comment', 'bianco' ) . '" name="comment" cols="45" rows="8" aria-required="true">' .
	'</textarea></p>';
$fields            = array(
	'author' => '<div class="row"><div class="col-xs-12 col-sm-6"><p></span></label><input type="text" name="author" id="name" class="input-form" placeholder="' . esc_attr__( 'Name*', 'bianco' ) . '" /></p></div>',
	'email'  => '<div class="col-xs-12 col-sm-6"><p><input type="text" name="email" id="email" class="input-form" placeholder="' . esc_attr__( 'Email*', 'bianco' ) . '" /></p></div></div><!-- /.row -->',
);
$comment_form_args = array(
	'class_submit'  => 'button',
	'comment_field' => $comment_field,
	'fields'        => $fields,
	'label_submit'  => esc_html__( 'Post Comment', 'bianco' ),
	'title_reply'   => esc_html__( 'Leave a comment', 'bianco' ),
);
?>
<div id="comments" class="comments-area">
	<?php if ( have_comments() ) :
		$count = get_comments_number();
		$comment_text = esc_html__( 'Comment', 'bianco' );
		if ( get_comments_number() ) {
			ob_start(); ?>
            <span><?php printf( '%02d', get_comments_number() ); ?></span>
			<?php
			$comment_text = ob_get_clean();
			$comment_text .= esc_html__( 'Comments', 'bianco' );
		}
		?>
        <h4 class="comments-title"><?php echo wp_specialchars_decode( $comment_text ); ?></h4>
        <ol class="comment-list">
			<?php
			wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
					'callback'   => 'bianco_callback_comment',
					'max_depth'  => 3,
				)
			);
			?>
        </ol>
	<?php
	endif;
	the_comments_pagination( array(
			'screen_reader_text' => '',
			'prev_text'          => '<span class="screen-reader-text">' . esc_html__( 'Prev', 'bianco' ) . '</span>',
			'next_text'          => '<span class="screen-reader-text">' . esc_html__( 'Next', 'bianco' ) . '</span>',
		)
	);
	if ( !comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
        <p class="no-comments"><?php echo esc_html__( 'Comments are closed.', 'bianco' ); ?></p>
	<?php
	endif;
	comment_form( $comment_form_args );
	?>
</div><!-- #comments -->