<?php

namespace Common\Modules\Orders\Entity;

use Common\Core\Model as CommonModel;
use Common\Modules\Entities\Engine\Helper as CommonEntitiesHelper;
use Common\Modules\Entities\Engine\Entity;
use Common\Modules\Currencies\Engine\Model as CommonCurrenciesModel;
use Common\Modules\Payments\Entity\Payment;
use Common\Modules\Carts\Entity\Cart;
use Common\Modules\Orders\Engine\Model;

/**
 * Class Order
 * @package Common\Modules\Orders\Entity
 */
class Order extends Entity
{

    protected $_table = Model::TBL_ORDERS;

    protected $_query = Model::QRY_ENTITY_ORDER;

    protected $_columns = array(
        'supplier_profile_id',
        'customer_profile_id',
        'payment_id',
        'cart_id',
        'status',
        'billable',
        'invoice_number',
        'invoice_issued_on',
        'created_on',
        'completed_on',
        'cancelled_on',
    );

    protected $_relations = array(
        'payment',
        'cart',
        'url',
        'items_count',
        'items_amount',
        'items',
        'total_quantity',
        'total_price_vat_excl',
        'total_price_vat',
        'total_price_vat_incl',
        'total_price_in_words',
    );

    protected $supplierProfileId;

    protected $customerProfileId;

    protected $paymentId;

    protected $cartId;

    protected $status;

    protected $billable;

    protected $invoiceNumber;

    protected $invoiceIssuedOn;

    protected $createdOn;

    protected $completedOn;

    protected $cancelledOn;

    protected $payment;

    protected $cart;

    protected $url;

    protected $itemsCount;

    protected $itemsAmount;

    protected $items = array();
    
    private $totalQuantity;

    private $totalPriceVatExcl;

    private $totalPriceVat;

    private $totalPriceVatIncl;

    private $totalPriceInWords;

    /**
     * @return $this
     */
    public function loadPayment()
    {
        if ($this->isLoaded()) {
            $this->payment = new Payment(array($this->getPaymentId()));
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function loadItems()
    {
        if ($this->isLoaded()) {
            $this->items = Model::getOrderItems($this->getId());
        }

        return $this;
    }

    /**
     * @param $profileId
     * @return bool
     */
    public function isSupplier($profileId)
    {
        return $this->getSupplierProfileId() == $profileId;
    }

    /**
     * @return mixed
     */
    public function getSupplierProfileId()
    {
        return $this->supplierProfileId;
    }

    /**
     * @param mixed $supplierProfileId
     * @return $this
     */
    public function setSupplierProfileId($supplierProfileId)
    {
        $this->supplierProfileId = $supplierProfileId;

        return $this;
    }

    /**
     * @param $profileId
     * @return bool
     */
    public function isCustomer($profileId)
    {
        return $this->getCustomerProfileId() == $profileId;
    }

    /**
     * @return mixed
     */
    public function getCustomerProfileId()
    {
        return $this->customerProfileId;
    }

    /**
     * @param mixed $customerProfileId
     * @return $this
     */
    public function setCustomerProfileId($customerProfileId)
    {
        $this->customerProfileId = $customerProfileId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * @param $paymentId
     * @return $this
     */
    public function setPaymentId($paymentId)
    {
        $this->paymentId = $paymentId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCartId()
    {
        return $this->cartId;
    }

    /**
     * @param $cartId
     * @return $this
     */
    public function setCartId($cartId)
    {
        $this->cartId = $cartId;

        return $this;
    }

    /**
     * @return OrderStatus
     */
    public function getStatus()
    {
        if (is_null($this->status)) {
            $this->status = new OrderStatus();
        }

        return $this->status;
    }

    /**
     * @param $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = new OrderStatus($status);

        return $this;
    }

    /**
     * @return mixed
     */
    public function isBillable()
    {
        return $this->billable;
    }

    /**
     * If billable is null make sure items is loaded
     *
     * @param null $billable
     *
     * @return $this
     */
    public function setBillable($billable = null)
    {
        $this->billable = (bool) $billable;

        if ($billable === null) {
            foreach ($this->getItems() as $item) {
                if ($item->isBillable()) {
                    $this->billable = true;
                    break;
                }
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * @param mixed $invoiceNumber
     *
     * @return $this
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * @param string $format
     * @return bool|int|string
     */
    public function getInvoiceIssuedOn($format = 'Y-m-d H:i:s')
    {
        return CommonEntitiesHelper::getDateTime($this->invoiceIssuedOn, $format);
    }

    /**
     * @param $invoiceIssuedOn
     * @return $this
     */
    public function setInvoiceIssuedOn($invoiceIssuedOn)
    {
        $this->invoiceIssuedOn = CommonEntitiesHelper::prepareDateTime($invoiceIssuedOn);

        return $this;
    }

    /**
     * @param string $format
     * @return bool|int|string
     */
    public function getCreatedOn($format = 'Y-m-d H:i:s')
    {
        return CommonEntitiesHelper::getDateTime($this->createdOn, $format);
    }

    /**
     * @param $createdOn
     * @return $this
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = CommonEntitiesHelper::prepareDateTime($createdOn);

        return $this;
    }

    /**
     * @param string $format
     * @return bool|int|string
     */
    public function getCompletedOn($format = 'Y-m-d H:i:s')
    {
        return CommonEntitiesHelper::getDateTime($this->completedOn, $format);
    }

    /**
     * @param $completedOn
     * @return $this
     */
    public function setCompletedOn($completedOn)
    {
        $this->completedOn = CommonEntitiesHelper::prepareDateTime($completedOn);

        return $this;
    }

    /**
     * @param string $format
     * @return bool|int|string
     */
    public function getCancelledOn($format = 'Y-m-d H:i:s')
    {
        return CommonEntitiesHelper::getDateTime($this->cancelledOn, $format);
    }

    /**
     * @param $cancelledOn
     * @return $this
     */
    public function setCancelledOn($cancelledOn)
    {
        $this->cancelledOn = CommonEntitiesHelper::prepareDateTime($cancelledOn);

        return $this;
    }

    /**
     * @return Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param Payment $payment
     * @return $this
     */
    public function setPayment(Payment $payment)
    {
        $this->payment = $payment;
        $this->setPaymentId($this->payment->getId());

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param Cart $cart
     * @return $this
     */
    public function setCart(Cart $cart)
    {
        $this->cart = $cart;
        $this->setCartId($this->cart->getId());

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getItemsCount()
    {
        return $this->itemsCount;
    }

    /**
     * @param $itemsCount
     * @return $this
     */
    public function setItemsCount($itemsCount)
    {
        $this->purgeTotals();
        $this->itemsCount = $itemsCount;

        return $this;
    }

    /**
     * @param int $quantity
     * @return $this
     */
    public function addItemsCount($quantity = 1)
    {
        $this->purgeTotals();
        $this->itemsCount += $quantity;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getItemsAmount()
    {
        return $this->itemsAmount;
    }

    /**
     * @param $itemsAmount
     * @return $this
     */
    public function setItemsAmount($itemsAmount)
    {
        $this->purgeTotals();
        $this->itemsAmount = $itemsAmount;

        return $this;
    }

    /**
     * @param $unitPrice
     * @param int $quantity
     * @return $this
     */
    public function addItemsAmount($unitPrice, $quantity = 1)
    {
        $this->purgeTotals();
        $this->itemsAmount += $unitPrice * $quantity;

        return $this;
    }

    /**
     * @return Item[]|array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param $externalId
     * @param $module
     * @param $title
     * @param $unitPrice
     * @param $quantity
     * @param array $options
     * @param null $callbackCancel
     * @return $this
     * @throws \Exception
     */
    public function addItem(
        $externalId,
        $module,
        $title,
        $unitPrice,
        $quantity,
        $options = array(),
        $callbackCancel = null
    ) {
        if (!$this->isLoaded()) {
            throw new \Exception('Item cannot be added for unsaved order');
        }

        if (!is_array($options)) {
            throw new \Exception('Options parameter must be an array');
        }

        $this->purgeTotals();

        $item = new Item();
        $item
            ->setOrderId($this->getId())
            ->setExternalId($externalId)
            ->setModule(\SpoonFilter::toCamelCase($module))
            ->setTitle($title)
            ->setUnitPrice($unitPrice)
            ->setQuantity($quantity);

        if (isset($callbackCancel)) {
            $item->setCallbackCancel($callbackCancel);
        }

        $this->addItemsCount($quantity);
        $this->addItemsAmount($unitPrice, $quantity);

        foreach ($options as $optionName => $optionValue) {
            $item->addOption($optionName, $optionValue);
        }

        $item->save();

        return $this;
    }

    /**
     * @return null
     */
    public function getTotalQuantity()
    {
        if ($this->totalQuantity === null) {
            $this->calculateTotals();
        }

        return $this->totalQuantity;
    }

    /**
     * @return null
     */
    public function getTotalPriceVatExcl()
    {
        if ($this->totalPriceVatExcl === null) {
            $this->calculateTotals();
        }

        return $this->totalPriceVatExcl;
    }

    /**
     * @return float
     */
    public function getTotalPriceVat()
    {
        if ($this->totalPriceVat === null) {
            $this->totalPriceVat = 0.00;
        }

        return $this->totalPriceVat;
    }

    /**
     * @return null
     */
    public function getTotalPriceVatIncl()
    {
        if ($this->totalPriceVatExcl === null) {
            $this->calculateTotals();
            $this->totalPriceVatIncl = $this->getTotalPriceVat() + $this->getTotalPriceVatExcl();
        }

        return $this->totalPriceVatExcl;
    }

    /**
     * @return bool|string
     */
    public function getTotalPriceInWords()
    {
        $language = $this->getLanguage();

        if ($this->totalPriceInWords === null) {
            $f = new \NumberFormatter($language, \NumberFormatter::SPELLOUT);
            $integerValue = (int)floor($this->getTotalPriceVatIncl());
            $decimalsValue = (float)number_format(($this->getTotalPriceVatIncl() - $integerValue) * 100, 2, '.', '');
            $integerWord = CommonCurrenciesModel::getActiveCurrency()->getWordByNumber($integerValue, $language);
            $decimalsWord = CommonCurrenciesModel::getActiveCurrency()->getWordForCents($language);
            $integerValueInWords = $f->format($integerValue);

            $this->totalPriceInWords =
                $integerValueInWords
                . ' ' . $integerWord
                . ' ' . $decimalsValue
                . ' ' . $decimalsWord . ' ct';
        }

        return $this->totalPriceInWords;
    }

    /**
     *
     */
    private function calculateTotals()
    {
        $this->totalQuantity = 0;
        $this->totalPriceVatExcl = 0.00;

        foreach ($this->getItems() as $item) {
            $this->totalQuantity += $item->getQuantity();
            $this->totalPriceVatExcl += $item->getTotalPrice();
        }
    }

    /**
     *
     */
    private function purgeTotals()
    {
        $this->totalQuantity = null;
        $this->totalPriceVatExcl = null;
        $this->totalPriceVatIncl = null;
        $this->totalPriceInWords = null;
    }

    /**
     * This method will save order as cancelled
     *
     * @return $this
     */
    public function cancel()
    {
        if ($this->getStatus()->isCancelled()) {
            return $this;
        }

        $this
            ->setStatus('cancelled')
            ->save();

        $this
            ->loadPayment()
            ->getPayment()
            ->setStatus('failure')
            ->save();

        return $this;
    }

    /**
     *
     */
    protected function beforeSave()
    {
        if ($this->invoiceNumber === null && $this->isBillable() && $this->getStatus()->isCompleted()) {
            $this->setInvoiceNumber(Model::getNextInvoiceNumber());
            $this->setInvoiceIssuedOn(null);
        }
    }
}
