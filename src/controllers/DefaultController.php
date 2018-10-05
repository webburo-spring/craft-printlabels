<?php
/**
 * Print Labels plugin for Craft CMS 3.x
 *
 * Print shipping labels
 *
 * @link      https://www.webburo-spring.nl
 * @copyright Copyright (c) 2018 Webburo Spring
 */

namespace webburospring\printlabels\controllers;

//use webburospring\printlabels;
use webburospring\printlabels\PrintLabels;
use webburospring\printlabels\models\Settings;
use craft\commerce\Plugin as cPlugin;

use Craft;
use craft\commerce\base\Gateway;
use craft\commerce\elements\Order;
use craft\elements\Entry;
use craft\web\Controller;

/**
 * Default Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your plugin’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    Webburo Spring
 * @package   Spring
 * @since     1.0.0
 */
class DefaultController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['print'];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/spring/default
     *
     * @return mixed
     */
    
    public function actionIndex()
    {
        $result = '';

        return $result;
    }
    
    public function actionPrint()
    {
        $orderId = Craft::$app->request->getParam('orderId');
        if ($orderId) {
            $order = cPlugin::getInstance()->getOrders()->getOrderById($orderId);
            if($order)
            {
                $shippingAddress = $order->getShippingAddress();
                $country = cPlugin::getInstance()->getCountries()->getCountryById($shippingAddress->countryId);
                    
                $storeLocation = cPlugin::getInstance()->getAddresses()->getStoreLocationAddress();
				
				// DO NOT PRINT COUNTRY ON THE LABEL WHEN STORE LOCATION IS IN THE SAME COUNTRY AS THE ORDER COUNTRY
                if($storeLocation->countryId != $shippingAddress->countryId){
                    echo $shippingAddress->firstName.' '.$shippingAddress->lastName."\n".$shippingAddress->address1."\n".$shippingAddress->zipCode.' '.$shippingAddress->city."\n".$country->name;      
                } else {
                    echo $shippingAddress->firstName.' '.$shippingAddress->lastName."\n".$shippingAddress->address1."\n".$shippingAddress->zipCode.' '.$shippingAddress->city; 
                }
                // SET NEW ORDER STATUS
                if(PrintLabels::$plugin->getSettings()->dymoOrderStatus != '0'){
                    $orderStatus = cPlugin::getInstance()->getOrderStatuses()->getOrderStatusById(PrintLabels::$plugin->getSettings()->dymoOrderStatus);
                    $order->orderStatusId = PrintLabels::$plugin->getSettings()->dymoOrderStatus;
                    $order->message = PrintLabels::$plugin->getSettings()->dymoOrderStatusMessage;  
                    Craft::$app->getElements()->saveElement($order);               
                }  

            }
        }
    }
}
