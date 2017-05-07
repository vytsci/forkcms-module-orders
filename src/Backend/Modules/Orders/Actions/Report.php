<?php

namespace Backend\Modules\Orders\Actions;

use Backend\Core\Engine\Base\Action as BackendBaseAction;
use Backend\Core\Engine\Language as BL;
use Common\Modules\Orders\Engine\Helper as CommonOrdersHelper;
use Common\Modules\Orders\Entity\Order;

/**
 * Class Report
 * @package Frontend\Modules\Orders\Actions
 */
class Report extends BackendBaseAction
{

    /**
     * @var Order
     */
    private $order;

    /**
     *
     */
    public function execute()
    {
        parent::execute();

        $id = $this->getParameter('id', 'int');

        $this->order = new Order(array($id));
        $this->order
            ->loadPayment()
            ->loadItems();

        if ($this->order->isLoaded()) {
            CommonOrdersHelper::outputInvoicePDF($this->order);
            exit;
        }

        die('Such order does not exist');
    }
}
