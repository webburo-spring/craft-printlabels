<?php
/**
 * Print Labels for Craft CMS 3.x
 *
 * 
 *
 * @link      https://www.webburo-spring.nl.nl
 * @copyright Copyright (c) 2018 Webburo Spring
 */

namespace webburospring\printlabels\elementactions;

use Craft;
use craft\base\ElementAction;
use craft\helpers\Json;
/**
 * PrintLabelsAction adds the 'Print shipping labels' action button to the element index's action dropdown
 * @since 1.0
 */
class PrintLabelsAction extends ElementAction
{
    public $label;

    /*
     * @inheritdoc
     */
    public function init()
    {
        if ($this->label === null) {
            $this->label = Craft::t('print-labels', 'Print shipping labels');            
        }
    }

    /*
     * @inheritdoc
     */
    public function getTriggerLabel(): string
    {
        return $this->label;
    }

    /*
     * @inheritdoc
     */
    public function getTriggerHtml()
    {
        $type = Json::encode(static::class);

        $js = <<<EOD
(function()
{
    var trigger = new Craft.ElementActionTrigger({
        type: {$type},
        batch: true,
        validateSelection: function(\$selectedItems)
        {
            return Garnish.hasAttr(\$selectedItems.find('.element'), 'data-editable');
        },
        activate: function(\$selectedItems)
        {
            var \$element = \$selectedItems.find('.element:first');
            var \$firstId = \$element.data('id');
            var \$type = \$element.data('type');
            \$selectedItems.each(function() {
                var elementId = $(this).data('id');
                var siteId = $(this).find('.element').data('site-id');
                alert(elementId);
            });            
        }
    });
})();
EOD;

        Craft::$app->getView()->registerJs($js);
    }
}
