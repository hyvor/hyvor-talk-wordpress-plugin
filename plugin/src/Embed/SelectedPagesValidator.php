<?php

namespace Hyvor\HyvorTalkWP\Embed;

/**
 * @phpstan-type SelectedPages array{
 *      logic: 'include'|'exclude',
 *      types: array{
 *           type: 'post_type'|'taxonomy_term',
 *           post_type?: string,
 *           taxonomy?: string,
 *           term?: string
 *      }[]
 *  }
 */
class SelectedPagesValidator
{

    /**
     * Validates if the current page is selected
     * based on the selection rules
     *
     * @param SelectedPages|null $config
     * @return void
     */
    public static function isSelected($config) : bool
    {

        // if no config, it means all pages are selected
        if (!is_array($config)) {
            return true;
        }

        $post = get_post();

        // no post means, this was called probably in a place where there is no post
        if ($post === null) {
            return false;
        }

        /** @var string $postType */
        $postType = get_post_type($post);

        /** @var string[] $taxonomies */
        $taxonomies = get_post_taxonomies($post);

        $configTypes = is_array($config['types']) ? $config['types'] : [];

        $matched = false;

        foreach ($configTypes as $type) {
            if ($type['type'] === 'post_type') {
                if ($type['post_type'] === $postType) {
                    $matched = true;
                    break;
                }
            } else {
                if (in_array($type['taxonomy'], $taxonomies)) {
                    $terms = get_the_terms($post, $type['taxonomy']);
                    foreach ($terms as $term) {
                        if ($term->slug === $type['term']) {
                            $matched = true;
                            break;
                        }
                    }
                }
            }
        }

        return $config['logic'] === 'include' ? $matched : !$matched;

    }
}
