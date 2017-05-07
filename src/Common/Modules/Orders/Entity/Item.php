<?php

namespace Common\Modules\Orders\Entity;

use Common\Core\Model as CommonModel;
use Common\Modules\Entities\Engine\Entity;
use Common\Modules\Orders\Engine\Model;

/**
 * Class Item
 * @package Common\Modules\Orders\Entity
 */
class Item extends Entity
{

    protected $_table = Model::TBL_ITEMS;

    protected $_query = Model::QRY_ENTITY_ITEM;

    protected $_columns = array(
        'order_id',
        'external_id',
        'module',
        'title',
        'unit_price',
        'quantity',
        'options',
        'callback_success',
        'callback_cancel',
    );

    protected $_relations = array(
        'total_price',
        'billable',
    );

    protected $orderId;

    protected $externalId;

    protected $module;

    protected $title;

    protected $unitPrice;

    protected $quantity;

    protected $options = array();

    protected $callbackSuccess;

    protected $callbackCancel;

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param $orderId
     *
     * @return $this
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param mixed $externalId
     *
     * @return $this
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param mixed $module
     *
     * @return $this
     */
    public function setModule($module)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return float
     */
    public function getUnitPrice()
    {
        return (float)$this->unitPrice;
    }

    /**
     * @param $unitPrice
     *
     * @return $this
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return (int)$this->quantity;
    }

    /**
     * @param mixed $quantity
     *
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getOption($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }

    /**
     * @param $name
     * @param $title
     *
     * @return $this
     */
    public function addOption($name, $title)
    {
        $this->options[$name] = $title;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param $options
     *
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = is_array($options) ? $options : (array)@unserialize($options);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCallbackSuccess()
    {
        return $this->callbackSuccess;
    }

    /**
     * @param mixed $callbackSuccess
     *
     * @return $this
     */
    public function setCallbackSuccess($callbackSuccess)
    {
        $this->callbackSuccess = $callbackSuccess;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCallbackCancel()
    {
        return $this->callbackCancel;
    }

    /**
     * @param $callbackCancel
     *
     * @return $this
     */
    public function setCallbackCancel($callbackCancel)
    {
        $this->callbackCancel = $callbackCancel;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalPrice()
    {
        return $this->getQuantity() * $this->getUnitPrice();
    }

    /**
     * @return bool
     */
    public function isBillable()
    {
        $billableModules = CommonModel::getContainer()
            ->get('fork.settings')
            ->get('Orders', 'billable_modules', array());

        return in_array($this->getModule(), $billableModules);
    }
}
