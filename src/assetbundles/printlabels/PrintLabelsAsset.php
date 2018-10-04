<?php
/**
 * Print Labels plugin for Craft CMS 3.x
 *
 * Print shipping labels
 *
 * @link      https://www.webburo-spring.nl
 * @copyright Copyright (c) 2018 Webburo Spring
 */

namespace webburospring\printlabels\assetbundles\PrintLabels;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Webburo Spring
 * @package   PrintLabels
 * @since     1.0.0
 */
class PrintLabelsAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@webburospring/printlabels/assetbundles/printlabels/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/dymo.js',
            'js/PrintLabels.js',
            'js/print.js',
        ];

        $this->css = [
            'css/PrintLabels.css',
        ];

        parent::init();
    }
}
