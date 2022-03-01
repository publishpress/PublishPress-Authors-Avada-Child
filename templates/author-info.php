<?php // phpcs:disable WPThemeReview.Templates.ReservedFileNamePrefix
/**
 * Author-info template.
 *
 * @author     ThemeFusion
 * @copyright  (c) Copyright by ThemeFusion
 * @link       https://theme-fusion.com
 * @package    Avada
 * @subpackage Core
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}
?>
<?php
$social_icons = fusion_get_social_icons_class();

// Initialize needed variables.

$author = get_multiple_authors( 0, false, true );
$author = $author[0];

$author_id          = (int) $author->ID;

$author_description = $author->description;
$author_custom      = get_the_author_meta( 'author_custom', $author->user_id );

// If no description was added by user, add some default text and stats.
if ( empty( $author_description ) ) {
    $author_description = esc_html__( 'This author has not yet filled in any details.', 'Avada' );
    /* translators: %1$s: Username. %2$s: Number. */

    $count = apply_filters('get_authornumposts', 0, $author);

    $author_description .= '<br />' . sprintf( esc_html__( 'So far %1$s has created %2$s blog entries.', 'Avada' ), $author->display_name, $count );
}
?>
<div class="fusion-author">
    <div class="fusion-author-avatar">
        <?php echo $author->get_avatar(82); // phpcs:ignore WordPress.Security.EscapeOutput ?>
    </div>
    <div class="fusion-author-info">
        <h3 class="fusion-author-title<?php echo ( Avada()->settings->get( 'disable_date_rich_snippet_pages' ) && Avada()->settings->get( 'disable_rich_snippet_author' ) ) ? ' vcard' : ''; ?>">
            <?php
            printf(
            /* translators: The user. */
                esc_html__( 'About %s', 'Avada' ),
                ( Avada()->settings->get( 'disable_date_rich_snippet_pages' ) && Avada()->settings->get( 'disable_rich_snippet_author' ) ) ? '<span class="fn">' . esc_attr( $author_name ) . '</span>' : esc_attr( $author_name )
            );
            ?>
            <?php // If user can edit his profile, offer a link for it. ?>
            <?php if ( current_user_can( 'edit_users' ) || get_current_user_id() === $author->user_id ) : ?>
                <?php
                $author_url = admin_url( 'term.php?taxonomy=author&tag_ID=' . $author->term_id );
                ?>
                <span class="fusion-edit-profile">(<a href="<?php echo esc_url_raw( $author_url ); ?>"><?php esc_attr_e( 'Edit profile', 'Avada' ); ?></a>)</span>
            <?php endif; ?>
        </h3>
        <?php echo $author_description; // phpcs:ignore WordPress.Security.EscapeOutput ?>
    </div>

    <div style="clear:both;"></div>

    <div class="fusion-author-social clearfix">
        <div class="fusion-author-tagline">
            <?php if ( $author_custom ) : ?>
                <?php echo $author_custom; // phpcs:ignore WordPress.Security.EscapeOutput ?>
            <?php endif; ?>
        </div>

        <?php
        // Get the social icons for the author set on his profile page.
        $author_social_icon_options = [
            'authorpage'        => 'yes',
            'author_id'         => $author->user_id,
            'position'          => 'author',
            'icon_colors'       => Avada()->settings->get( 'social_links_icon_color' ),
            'box_colors'        => Avada()->settings->get( 'social_links_box_color' ),
            'icon_boxed'        => Avada()->settings->get( 'social_links_boxed' ),
            'icon_boxed_radius' => Fusion_Sanitize::size( Avada()->settings->get( 'social_links_boxed_radius' ) ),
            'tooltip_placement' => Avada()->settings->get( 'social_links_tooltip_placement' ),
            'linktarget'        => Avada()->settings->get( 'social_icons_new' ),
        ];

        echo fusion_library()->social_sharing->render_social_icons( $author_social_icon_options ); // phpcs:ignore WordPress.Security.EscapeOutput
        ?>
    </div>
</div>
