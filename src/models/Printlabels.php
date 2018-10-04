<?php
/**
 * Print Labels plugin for Craft CMS 3.x
 *
 * Print shipping labels
 *
 * @link      https://www.webburo-spring.nl
 * @copyright Copyright (c) 2018 Webburo Spring
 */

namespace webburospring\printlabels\models;

use webburospring\printlabels\PrintLabels;

use Craft;
use craft\base\Model;

/**
 * @author    Webburo Spring
 * @package   PrintLabels
 * @since     1.0.0
 */
class Printlabels extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $someAttribute = 'Select DYMO Printer';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['printer', 'string'],
            ['printer', 'default', 'value' => ''],
        ];
    }
}
