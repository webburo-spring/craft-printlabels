<?php
/**
 * Print Labels plugin for Craft CMS 3.x
 *
 * Print shipping labels
 *
 * @link      https://www.webburo-spring.nl
 * @copyright Copyright (c) 2018 Webburo Spring
 */

namespace webburospring\printlabels\services;

use webburospring\printlabels\PrintLabels;

use Craft;
use craft\base\Component;

/**
 * @author    Webburo Spring
 * @package   PrintLabels
 * @since     1.0.0
 */
class Printlabels extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';
        if (PrintLabels::$plugin->getSettings()->someAttribute) {
        }

        return $result;
    }
}
