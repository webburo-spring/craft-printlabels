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
 * @author    sdfsfds
 * @package   PrintLabels
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $dymoPrinter;
    
	/**
     * @var string
     */
    public $dymoFont;
    
	/**
     * @var integer
     */
    public $dymoFontSize;
    
	/**
     * @var integer
     */
    public $dymoOrderStatus;
	
	/**
     * @var string
     */
    public $dymoOrderStatusMessage;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['dymoPrinter', 'string'],
            ['dymoPrinter', 'default', 'value' => ''],
            ['dymoFont', 'string'],
            ['dymoFont', 'default', 'value' => 'Verdana'], 
            ['dymoFontSize', 'integer'],
            ['dymoFontSize', 'default', 'value' => '12'],
            ['dymoOrderStatus', 'integer'],
            ['dymoOrderStatus', 'default', 'value' => '0'],
            ['dymoOrderStatusMessage', 'string'],
            ['dymoOrderStatusMessage', 'default', 'value' => ''],
        ];
    }
}
