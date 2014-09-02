<?php

namespace FlexPress\Components\PopularPosts;

class Helper
{

    const TOTAL_SECONDS_IN_A_DAY = 86400;


    /**
     * Gets the popular pages/post/cpt
     *
     * @param string $postType
     * @param int $total
     * @param int $offset
     *
     * @return array
     * @author Tim Perry
     */
    public function getPopular($postType = 'any', $total = 5, $offset = 0)
    {

        // grab all the posts
        $args = array();
        $args['numberposts'] = -1;
        $args['post_type'] = $postType;
        $args['exclude'] = get_option('page_on_front');

        // loop and get the post views
        $posts = get_posts($args);

        if ($posts) {

            foreach ($posts as &$p) {

                // calulcate the score ( total views / total days page has been alive )
                $date = date("U");
                $secondsSinceLive = $date - date("U", strtotime($p->post_date));
                $totalDaysSinceLive = $secondsSinceLive / self::TOTAL_SECONDS_IN_A_DAY;
                $pageViews = get_post_meta($p->ID, PopularPostsPlugin::META_NAME_PAGEVIEW_TOTAL, true);

                $p->score = $pageViews / $totalDaysSinceLive;

            }

            usort($posts, array($this, 'sortByScore'));

        }

        return array_slice($posts, $offset, $total);

    }

    /**
     * Sorting function, uses the score of a object to determine the order of the array
     *
     * @param $a
     * @param $b
     *
     * @return int
     * @author Tim Perry
     *
     */
    protected function sortByScore($a, $b)
    {

        if ($a->score == $b->score) {
            return 0;
        }

        return ($a->score > $b->score) ? -1 : 1;

    }

}