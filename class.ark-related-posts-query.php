<?php 

class Ark_Related_Posts{

    private $post_id;

    public function __construct($post_id){
        $this->post_id = $post_id;
    }

    public function ark_get_posts(){
        $ark_tags = get_the_tags($this->post_id);
        $ark_tag_ids = wp_list_pluck($ark_tags, 'term_id');
        $ark_cache_key = 'ark_related_posts_' . $this->post_id;

        // TODO: create different $args to avoid repeated queries.
        $args = array(
            'post_type' => 'post', // get only posts.
            'posts_per_page' => 3, // display all the related posts.
            'post__not_in' => array(get_the_ID()), //avoid the current post.
            'tag__in' => $ark_tag_ids // get the tags of the current post, also possible to use tag__and if it is required to match all the tags.
        );

        //if cache is not set, create a new query and set the cache for 24 hours.
        if (false === ($the_query = get_transient($ark_cache_key))) {
            $the_query = new WP_Query($args);

            wp_reset_postdata();
            set_transient($ark_cache_key, $the_query, 24 * HOUR_IN_SECONDS);
        }

        // if the $the_query have no posts, get the latest posts.
        if (!$the_query->have_posts()) {
            $args = array(
                'post_type' => 'post', // get only posts.
                'posts_per_page' => 3, // display all the related posts.
                'post__not_in' => array(get_the_ID()), //avoid the current post.
                'orderby' => 'date',
                'order' => 'DESC' // show the most recent posts.
            );

            if (false === ($latest_posts = get_transient('ark_latest_posts_cache'))) {
                $latest_posts = new WP_Query($args);
                set_transient('ark_latest_posts_cache', $latest_posts, 24 * HOUR_IN_SECONDS);
            }

            wp_reset_postdata();

            return $latest_posts->posts; 
        }

        return $the_query->posts; 
    }
}