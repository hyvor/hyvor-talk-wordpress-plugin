<?php

namespace Hyvor\HyvorTalkWP\Admin\Helpers;

class PostTypeObject
{

    /**
     * The main type
     * It can be a post_type from get_post_types() or a taxonomy from get_taxonomies()
     *
     * @var 'post_type'|'taxonomy_term'
     */
    public $type;

    /**
     * If the type is 'post_type', this will be the post type
     * @var string
     */
    public $post_type;

    /**
     * If the type is 'taxonomy_term', this will be the taxonomy
     * @var string
     */
    public $taxonomy;

    /**
     * If the type is 'taxonomy_term', this will be the term
     * @var string
     */
    public $term;


    public function __construct(
        string $type,
        string $post_type = null,
        string $taxonomy = null,
        string $term = null
    ) {
        $this->type = $type;
        if ($type === 'post_type') {
            $this->post_type = $post_type;
        } else {
            $this->taxonomy = $taxonomy;
            $this->term = $term;
        }
    }


    public static function fromPostType(string $post_type): PostTypeObject
    {
        return new PostTypeObject('post_type', $post_type);
    }

    public static function fromTaxonomy(string $taxonomy, string $term = null): PostTypeObject
    {
        return new PostTypeObject('taxonomy', null, $taxonomy, $term);
    }

    /**
     * @return self[]
     */
    public static function search(string $search): array
    {

        $postTypes = get_post_types(['public' => true], 'names');
        $taxonomies = get_taxonomies(['public' => true], 'objects');

        $objects = [];

        foreach ($postTypes as $postType) {
            if ($search && stripos($postType, $search) !== false) {
                $objects[] = self::fromPostType($postType);
            }
        }


        foreach ($taxonomies as $taxonomy) {
            $terms = get_terms($taxonomy->name, [
                'search' => $search,
                'hide_empty' => false,
            ]);

            foreach ($terms as $term) {
                $objects[] = self::fromTaxonomy($taxonomy->name, $term->slug);
            }
        }

        return $objects;

    }

}
