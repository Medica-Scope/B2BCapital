<?php
    /**
     * @Filename: class-B2b_Post.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 1/4/2023
     */

    namespace B2B\APP\CLASSES;

    use B2B\B2b;
    use WP_Error;
    use WP_Post;

    /**
     * Description...
     *
     * @class B2b_Post
     * @version 1.0
     * @since 1.0.0
     * @package b2b
     * @author Mustafa Shaaban
     */
    class B2b_Post
    {

        /**
         * @var \B2B\APP\CLASSES\B2b_Post|null
         */
        private static ?B2b_Post $instance = NULL;
        /**
         * The post's meta data
         *
         * @var array
         */
        public array $meta_data = [];
        /**
         * Post ID.
         *
         * @since 1.0.0
         * @var int
         */
        protected int $ID = 0;
        /**
         * ID of post author.
         *
         * A numeric string, for compatibility reasons.
         *
         * @since 1.0.0
         * @var int
         */
        protected int $author = 0;
        /**
         * The post's title.
         *
         * @since 1.0.0
         * @var string
         */
        protected string $title = '';
        /**
         * The post's content.
         *
         * @since 1.0.0
         * @var string
         */
        protected string $content = '';
        /**
         * The post's excerpt.
         *
         * @since 1.0.0
         * @var string
         */
        protected string $excerpt = '';
        /**
         * The post's status.
         *
         * @since 1.0.0
         * @var string
         */
        protected string $status = 'publish';
        /**
         * The post's slug.
         *
         * @since 1.0.0
         * @var string
         */
        protected string $name = '';
        /**
         * ID of a post's parent post.
         *
         * @since 1.0.0
         * @var int
         */
        protected int $parent = 0;
        /**
         * The post's type, like post or page.
         *
         * @since 1.0.0
         * @var string
         */
        protected string $type = 'post';
        /**
         * The post's local publication time.
         *
         * @since 1.0.0
         * @var string
         */
        protected string $created_date = '0000-00-00 00:00:00';
        /**
         * The post's local modified time.
         *
         * @since 1.0.0
         * @var string
         */
        protected string $modified_date = '0000-00-00 00:00:00';
        /**
         * The post's featured image.
         *
         * @since 1.0.0
         * @var string
         */
        protected string $thumbnail = '';
        /**
         * The post's URL.
         *
         * @since 1.0.0
         * @var string
         */
        protected string $link = '';
        /**
         * The post's category/taxonomy.
         *
         * @since 1.0.0
         * @var array
         */
        protected array $taxonomy = [];

        public function __construct()
        {
            // Reformat class metadata
            $this->meta_data = $this->reformat_metadata($this->meta_data);
        }

        /**
         * Description...
         *
         * @param $name
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return false
         */
        public function __get($name)
        {
            return property_exists($this, $name) ? $this->{$name} : FALSE;
        }

        /**
         * Description...
         *
         * @param $name
         * @param $value
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return void
         */
        public function __set($name, $value)
        {
            $this->{$name} = $value;
        }

        /**
         * @param \WP_Post $post
         * @param array    $meta_data
         *
         * @return \B2B\APP\CLASSES\B2b_Post
         * @version 1.0
         * @since 1.0.0
         * @author Mustafa Shaaban
         */
        public static function get_post(WP_Post $post, array $meta_data = []): B2b_Post
        {
            $class          = __CLASS__;
            self::$instance = new $class();

            // Reformat class metadata
            $meta_data = self::$instance->reformat_metadata($meta_data);

            return self::$instance->convert($post, $meta_data);
        }

        /**
         * @param \WP_Post $post
         * @param array    $meta_data
         *
         * @return \B2B\APP\CLASSES\B2b_Post
         * @version 1.0
         * @since 1.0.0
         * @author Mustafa Shaaban
         */
        public function convert(WP_Post $post, array $meta_data = []): B2b_Post
        {
            global $wpdb;

            $class    = __CLASS__;
            $new_post = new $class();

            $new_post->ID            = $post->ID;
            $new_post->author        = $post->post_author;
            $new_post->type          = $post->post_type;
            $new_post->name          = $post->post_name;
            $new_post->title         = $post->post_title;
            $new_post->content       = $post->post_content;
            $new_post->excerpt       = $post->post_excerpt;
            $new_post->status        = $post->post_status;
            $new_post->parent        = $post->post_parent;
            $new_post->created_date  = $post->post_date;
            $new_post->modified_date = $post->post_modified;
            $new_post->thumbnail     = get_the_post_thumbnail_url($post);
            $new_post->link          = get_permalink($post->ID);
            $new_post->taxonomy      = [];

            $groupedByTaxonomy = $wpdb->get_results("SELECT tr.term_taxonomy_id AS term_id , t.name, t.slug, tt.parent, tt.taxonomy
																FROM `" . $wpdb->prefix . "term_relationships` tr
																LEFT JOIN `" . $wpdb->prefix . "terms` t ON t.term_id = tr.term_taxonomy_id
																LEFT JOIN `" . $wpdb->prefix . "term_taxonomy` tt ON tt.term_id = t.term_id
																WHERE tr.object_id = '$post->ID' AND tt.taxonomy != 'translation_priority';");

            foreach ($groupedByTaxonomy as $item) {
                $new_post->taxonomy[$item->taxonomy][] = $item;
            }

            if (empty($meta_data)) {
                $meta_data = $wpdb->get_results("SELECT `meta_key`, `meta_value`
                                                                    FROM `" . $wpdb->prefix . "postmeta` AS meta
                                                                    WHERE meta.`post_id` = '$post->ID';");

                foreach ($meta_data as $meta) {
                    $new_post->meta_data[$meta->meta_key] = $meta->meta_value;
                }

            } else {
                foreach ($meta_data as $key => $meta) {
                    $new_post->meta_data[$key] = get_post_meta($post->ID, $key, TRUE);
                }
            }

            return $new_post;
        }

        /**
         * @return int|\WP_Error|\B2B\APP\CLASSES\B2b_Post
         *
         * @version 1.0
         * @since 1.0.0
         * @author Mustafa Shaaban
         */
        public function insert(): int|WP_Error|B2b_Post
        {
            $insert = wp_insert_post([
                'ID'            => $this->ID,
                'post_title'    => $this->title,
                'post_content'  => $this->content,
                'post_excerpt'  => $this->excerpt,
                'post_status'   => $this->status,
                'post_parent'   => $this->parent,
                'post_author'   => $this->author,
                'post_name'     => $this->name,
                'post_type'     => $this->type
            ]);

            if (is_wp_error($insert)) {
                return $insert;
            }

            if ($insert) {
                foreach ($this->meta_data as $key => $meta) {
                    add_post_meta($insert, $key, $meta);
                }
                foreach ($this->taxonomy as $tax_name => $taxonomies) {
                    wp_set_post_terms($this->ID, $taxonomies, $tax_name, false);
                }
                $this->ID = $insert;

                do_action(B2b::_DOMAIN_NAME . "_after_insert_" . $this->type, $this);
            }

            return $this;
        }

        /**
         * @return \B2B\APP\CLASSES\B2b_Post|\WP_Error
         *
         * @version 1.0
         * @since 1.0.0
         * @author Mustafa Shaaban
         */
        public function update(): B2b_Post|WP_Error
        {
            $update = wp_update_post([
                'ID'           => $this->ID,
                'post_title'   => $this->title,
                'post_content' => $this->content,
                'post_excerpt' => $this->excerpt,
                'post_status'  => $this->status,
                'post_parent'  => $this->parent,
                'post_author'  => $this->author,
                'post_name'    => $this->name
            ]);

            if (is_wp_error($update)) {
                return $update;
            }

            if ($update) {
                foreach ($this->meta_data as $key => $meta) {
                    update_post_meta($update, $key, $meta);
                }

                foreach ($this->taxonomy as $tax_name => $terms) {
                    if (is_object($terms[0])) {
                        $terms = array_map(function($term){
                            return $term->term_id;
                        }, $terms);
                    }
                    wp_set_post_terms($this->ID, $terms, $tax_name, false);
                }


                do_action(B2b::_DOMAIN_NAME . "_after_update_" . $this->type, $this);
            }

            return $this;
        }

        /**
         * @param bool $force_delete
         *
         * @return array|false|\WP_Post|null
         *
         * @version 1.0
         * @since 1.0.0
         * @author Mustafa Shaaban
         */
        public function delete(bool $force_delete = FALSE): WP_Post
        {
            $delete = wp_delete_post($this->ID, $force_delete);
            do_action(B2b::_DOMAIN_NAME . "_after_delete_" . $this->type, $this->ID);
            return $delete;

        }

        /**
         * Description...
         *
         * @param $meta_data
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return array
         */
        private function reformat_metadata($meta_data): array
        {
            foreach ($meta_data as $k => $meta) {
                $meta_data[$meta] = '';
                unset($meta_data[$k]);
            }

            return $meta_data;
        }

        /**
         * @param string $name
         * @param string $value
         *
         * @return bool
         *
         * @version 1.0
         * @since 1.0.0
         * @author Mustafa Shaaban
         */
        public function set_meta_data(string $name, string|array $value): bool
        {
            if (array_key_exists($name, $this->meta_data)) {
                $this->meta_data[$name] = $value;

                return TRUE;
            }

            return FALSE;
        }

        /**
         * Description...
         *
         * @param $meta_name
         *
         * @return string|bool
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         */
        public function get($meta_name): string|bool
        {
            return get_post_meta($this->ID, $meta_name, TRUE);
        }

    }
