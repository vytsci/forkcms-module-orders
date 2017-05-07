<?php

namespace Frontend\Modules\Orders\Engine;

use Frontend\Core\Engine\Language as FL;
use Frontend\Core\Engine\Navigation as FrontendNavigation;

use Common\Core\Model as CommonModel;
use Common\Modules\Entities\Engine\Helper as CommonEntitiesHelper;

use Common\Modules\Orders\Engine\Model as CommonOrdersModel;
use Common\Modules\Orders\Entity\Order;
use Common\Modules\Orders\Entity\Item;

/**
 * Class Model
 * @package Frontend\Modules\Orders\Engine
 */
class Model
{

    /**
     * @param $id
     * @param $language
     * @return array
     * @throws \SpoonDatabaseException
     */
    public static function callbackPaymentsInfo($id, $language)
    {
        $result = array();

        if (empty($id)) {
            return $result;
        }

        $result['title'] = ucfirst(sprintf(FL::lbl('OrdersOrder'), $id));
        $result['url'] =
            SITE_URL
            .FrontendNavigation::getURLForBlock('Orders', null, $language)
            .'/'.$id;

        return $result;
    }

    /**
     * @param $id
     * @param $language
     */
    public static function callbackPaymentsSuccess($id, $language)
    {
        $order = new Order(array($id));

        $order
            ->setStatus('completed')
            ->setCompletedOn(null)
            ->save();

        /**
         * @var Item $orderItem
         */
        $order->loadItems();
        foreach ($order->getItems() as $orderItem) {
            $class = '\\Frontend\\Modules\\'.$orderItem->getModule().'\\Engine\\Model';
            $method = $orderItem->getCallbackSuccess();

            if (is_callable(array($class, $method))) {
                $call = $class.'::'.$method;
                call_user_func($call, $order->getCustomerProfileId(), $orderItem->getExternalId(), $order->getId());
            }
        }
    }
}
