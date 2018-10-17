<?php
/**
 * Print Labels plugin for Craft CMS 3.x
 *
 * Print shipping labels
 *
 * @link      https://www.webburo-spring.nl
 * @copyright Copyright (c) 2018 Webburo Spring
 */

namespace webburospring\printlabels;

use webburospring\printlabels\services\Printlabels as PrintlabelsService;
use webburospring\printlabels\models\Settings;
use webburospring\printlabels\assetbundles\printlabels\PrintLabelsAsset;
//use webburospring\printlabels\elementactions\PrintLabelsAction; // NOT NOW, MAYBE LATER

use Craft;
use craft\events\RegisterUrlRulesEvent;
use craft\events\TemplateEvent;
use craft\events\ModelEvent;
//use craft\events\RegisterElementActionsEvent; // NOT NOW, MAYBE LATER
use craft\web\View;
use craft\web\UrlManager;
use craft\db\Query;
use craft\commerce\elements\Order;
use craft\commerce\Plugin as cPlugin;
use craft\elements\Entry;
use craft\services\Plugins;
use craft\base\Element;
use craft\base\Plugin;
use yii\base\Event;

/**
 * Class PrintLabels
 *
 * @author    Webburo Spring
 * @package   PrintLabels
 * @since     1.0.0
 *
 * @property  PrintlabelsService $printlabels
 */
class PrintLabels extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var PrintLabels
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;
        
        $request = Craft::$app->request;
        
        // Register our CP routes
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['printlabels'] = 'print-labels/default/print';
            }
        );
        
        
        if ($this->isInstalled && !$request->isConsoleRequest && $request->isCpRequest) {
            
            Event::on(
                View::class,
                View::EVENT_BEFORE_RENDER_TEMPLATE,
                function (TemplateEvent $event) {
                    // Get view
                    $view = Craft::$app->getView();
                    // Load JS file
                    //if(isset($this->getSettings()->dymoPrinter) && !empty($this->getSettings()->dymoPrinter)){
                        $js = trim('var dymo_printer = "'.$this->getSettings()->dymoPrinter.'"'."\r\n".
                                   'var dymo_labelId = "'.$this->getSettings()->dymoLabelId.'"'."\r\n".
                                   'var dymo_fonttype = "'.$this->getSettings()->dymoFont.'"'."\r\n".
                                   'var dymo_fontsize = "'.$this->getSettings()->dymoFontSize.'"'."\r\n"
                                  );
                        if ($js) {
                            $view->registerJs($js, View::POS_END);
                        }
                    //}
                    $view->registerAssetBundle(printlabelsAsset::class);
                    
                }
            );
            
			// NOT NOW, MAYBE LATER
            /*Event::on(Order::class, Element::EVENT_REGISTER_ACTIONS, function(RegisterElementActionsEvent $event) {
                $event->actions[] = PrintlabelsAction::class;
            });*/
        }
        
        /*Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );*/

        Craft::info(
            Craft::t(
                'print-labels',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }
    
    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        
        $orderStatuses = cPlugin::getInstance()->getOrderStatuses()->getAllOrderStatuses();
        $options = ['0' => 'Don\'t set orderstatus'];
        foreach ($orderStatuses as $field)
        {
            $options[] = [
                'label' => $field['name'], 
                'value' => $field['id']
            ];
        }
        
        return Craft::$app->view->renderTemplate(
            'print-labels/settings',
            [
                'settings' => $this->getSettings(),
                'orderStatuses' => $options
            ]
        );
    }
}
