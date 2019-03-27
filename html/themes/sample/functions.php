<?php
register_sidebar();


//アイキャッチ画像
add_theme_support('post-thumbnails');

//ログインしているときの管理バーを削除
add_filter('show_admin_bar', '__return_false');

/**
 * 投稿画面から不要な機能を削除します。
*/
function remove_post_supports() {
//  remove_post_type_support( 'post', 'editor' ); // 本文欄
}
add_action( 'init', 'remove_post_supports' );


/**
 * 投稿画面から不要な枠(メタボックス)を無効にします。
*/
function remove_post_meta_boxes() {
    remove_meta_box( 'slugdiv', 'post', 'normal' ); // スラッグ
}
add_action( 'admin_menu', 'remove_post_meta_boxes' );


/**
 * 管理画面のメディアの位置を調整
 */
function customize_menus(){
    global $menu;
    $menu[19] = $menu[10];  //メディアの移動(20が固定ページ)
    unset($menu[10]);
}
add_action( 'admin_menu', 'customize_menus' );

// svgファイルのアップロードを許可
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

// 不要なwp_headを削除
remove_action('wp_head', 'feed_links_extra',3);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'parent_post_rel_link');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'rel_canonical');

// 絵文字の無効化
remove_action('wp_head', 'print_emoji_detection_script',7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');


/*【管理画面】メディアを追加で挿入されるimgタグから不要な属性を削除 */
add_filter('image_send_to_editor', 'remove_image_attribute', 10);
add_filter('post_thumbnail_html', 'remove_image_attribute', 10);
function remove_image_attribute($html){
  $html = preg_replace('/(width|height)="\d*"\s/', '', $html); // width と heifht を削除
  return $html;
}

/* -----------------------------------------------
タクソノミー追加
----------------------------------------------- */
/* 投稿タイプを追加 */
add_action( 'init', 'create_post_type' );
function create_post_type() {
    // 管理画面順番用
    $num = [4,5,6,7,8,9,10];

    //NEWS
	register_post_type( 'news', //投稿タイプ名を指定
		array(
			'labels' => array(
				'name' => __( 'NEWS' ),
				'all_items' => '投稿一覧',
				'singular_name' => __( 'NEWS' ),
				'parent' => '親'
			),
			'public' => true,
			'has_archive' => true, /* アーカイブページを持つ */
			'menu_position' =>$num[0], //管理画面のメニュー順位
			'supports' => array( 'title', 'author' ),
			'taxonomies' => array('news_cat'),
		)
	);
	register_taxonomy(
		'news_cat', /* タクソノミーの名前 */
		'news', /* 使用するカスタム投稿タイプ名 */
		array(
			'hierarchical' => true,
			'update_count_callback' => '_update_post_term_count',
			'label' => 'カテゴリー',
			'singular_label' => 'カテゴリー',
			'public' => true,
			'show_ui' => true,
			'publicly_queryable' => true,
			'has_archive' => true,
			'query_var' => true
		)
	);
};

//カスタム投稿用post_typeセット
add_filter('template_include','custom_search_template');
function custom_search_template($template){
  if ( is_search() ){
    $post_types = get_query_var('post_type');
    foreach ( (array) $post_types as $post_type )
      $templates[] = "{$post_type}-search.php";
    $templates[] = 'search.php';
    $template = get_query_template('search',$templates);
  }
  return $template;
}

//検索機能にカスタムフィールドの内容も含ませる
function custom_search($search, $wp_query) {
	global $wpdb;

	if (!$wp_query->is_search)
			return $search;
	if (!isset($wp_query->query_vars))
			return $search;

	$search_words = explode(' ', isset($wp_query->query_vars['s']) ? $wp_query->query_vars['s'] : '');
	if ( count($search_words) > 0 ) {
			$search = '';
			$search .= "AND post_type = 'news'";
			foreach ( $search_words as $word ) {
					if ( !empty($word) ) {
							$search_word = '%' . esc_sql( $word ) . '%';
							$search .= " AND (
								 {$wpdb->posts}.post_title LIKE '{$search_word}'
								OR {$wpdb->posts}.post_content LIKE '{$search_word}'
								OR {$wpdb->posts}.ID IN (
								SELECT distinct post_id
								FROM {$wpdb->postmeta}
								WHERE meta_value LIKE '{$search_word}'
								)
							) ";
					}
			}
	}
	return $search;
}
add_filter('posts_search','custom_search', 10, 2);

/**
* ページネーション出力関数
* $paged : 現在のページ
* $pages : 全ページ数
* $range : 左右に何ページ表示するか
* $show_only : 1ページしかない時に表示するかどうか
*/
function pagination( $pages, $paged, $range = 2, $show_only = false ) {

    $pages = ( int ) $pages;    //float型で渡ってくるので明示的に int型 へ
    $paged = $paged ?: 1;       //get_query_var('paged')をそのまま投げても大丈夫なように

    //表示テキスト
    $text_first   = "« 最初へ";
    $text_before  = "前へ";
    $text_next    = "次へ";
    $text_last    = "最後へ »";

    if ( $show_only && $pages === 1 ) {
        // １ページのみで表示設定が true の時
        echo '<div class="pagination"><span class="current pager">1</span></div>';
        return;
    }

    if ( $pages === 1 ) return;    // １ページのみで表示設定もない場合

    if ( 1 !== $pages ) {
        //２ページ以上の時
        echo '<nav class="pagination"><!--<span class="page_num">Page ', $paged ,' of ', $pages ,'</span>--><div class="nav-links">';
        if ( $paged > $range + 1 ) {
            // 「最初へ」 の表示
            //echo '<a href="', get_pagenum_link(1) ,'" class="first">', $text_first ,'</a>';
        }
        if ( $paged > 1 ) {
            // 「前へ」 の表示
            echo '<a href="', get_pagenum_link( $paged - 1 ) ,'" class="prev page-numbers">', $text_before ,'</a>';
        }
        for ( $i = 1; $i <= $pages; $i++ ) {
            if ( $i <= $paged + $range && $i >= $paged - $range ) {
                // $paged +- $range 以内であればページ番号を出力
                if ( $paged === $i ) {
                    echo '<span class="page-numbers current">', $i ,'</span>';
                } else {
                    echo '<a href="', get_pagenum_link( $i ) ,'" class="page-numbers">', $i ,'</a>';
                }
            }
        }
        if ( $paged < $pages ) {
            // 「次へ」 の表示
            echo '<a href="', get_pagenum_link( $paged + 1 ) ,'" class="next page-numbers">', $text_next ,'</a>';
        }
        if ( $paged + $range < $pages ) {
            // 「最後へ」 の表示
            //echo '<a href="', get_pagenum_link( $pages ) ,'" class="last">', $text_last ,'</a>';
        }
        echo '</div></nav>';
    }
}
