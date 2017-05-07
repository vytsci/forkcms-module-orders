<?php

namespace Backend\Modules\Orders\Engine;

use Api\V1\Engine\Api as BaseAPI;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Modules\Profiles\Engine\Api as BackendProfilesApi;
use Backend\Modules\Profiles\Engine\Model as BackendProfilesModel;
use Common\Modules\Orders\Engine\Model as CommonOrdersModel;
use Common\Modules\Orders\Entity\Order;
use Common\Modules\Orders\Entity\Item;

/**
 * Class Api
 * @package Backend\Modules\Orders\Engine
 */
class Api
{
    /**
     * @return array|bool
     */
    public static function getOrdersAsCustomer()
    {
        if (!BackendProfilesApi::isAuthorized()) {
            return BaseAPI::output(
                BaseAPI::NOT_AUTHORIZED,
                array('message' => 'Not authorized.')
            );
        }

        $email = BackendModel::getContainer()->get('request')->get('email');
        $profile = BackendProfilesModel::getByEmail($email);

        return CommonOrdersModel::getArrayOrdersAsCustomer($profile['id']);
    }

    /**
     * @return array|bool
     */
    public static function getOrdersAsSupplier()
    {
        if (!BackendProfilesApi::isAuthorized()) {
            return BaseAPI::output(
                BaseAPI::NOT_AUTHORIZED,
                array('message' => 'Not authorized.')
            );
        }

        $email = BackendModel::getContainer()->get('request')->get('email');
        $profile = BackendProfilesModel::getByEmail($email);

        return CommonOrdersModel::getArrayOrdersAsSupplier($profile['id']);
    }

    /**
     * @return array|bool
     */
    public static function getProfileOrder($id, $language)
    {
        if (!BackendProfilesApi::isAuthorized()) {
            return BaseAPI::output(
                BaseAPI::NOT_AUTHORIZED,
                array('message' => 'Not authorized.')
            );
        }

        $email = BackendModel::getContainer()->get('request')->get('email');
        $profile = BackendProfilesModel::getByEmail($email);

        $order = new Order(array($id));

        if (!$order->isCustomer($profile['id']) && !$order->isSupplier($profile['id'])) {
            return BaseAPI::output(
                BaseAPI::FORBIDDEN,
                array('message' => 'Order is available only to either customer or supplier.')
            );
        }

        if (!$order->isLoaded()) {
            return BaseAPI::output(
                BaseAPI::NOT_FOUND,
                array('message' => 'Order with specified ID was not found.')
            );
        }

        $order->loadItems();

        return $order->toArray();
    }
}
