<?php

namespace Frontend\Modules\Orders\Actions;

use Frontend\Core\Engine\Base\Block as FrontendBaseBlock;
use Frontend\Core\Engine\Navigation as FrontendNavigation;
use Frontend\Modules\Profiles\Engine\Authentication as FrontendProfilesAuthentication;

use Common\Modules\Orders\Engine\Helper as CommonOrdersHelper;
use Common\Modules\Orders\Entity\Order;

/**
 * Class Invoice
 * @package Frontend\Modules\Orders\Actions
 */
class Invoice extends FrontendBaseBlock
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
        if (!FrontendProfilesAuthentication::isLoggedIn()) {
            $this->redirect(
                FrontendNavigation::getURLForBlock(
                    'Profiles',
                    'Login'
                ).'?queryString='.urlencode(
                    $this->get('request')->getUri()
                ),
                307
            );
        }

        parent::execute();

        $id = $this->URL->getParameter(1, 'int');

        $this->order = new Order(array($id));
        $this->order
            ->loadPayment()
            ->loadItems();

        if ($this->order->isLoaded() && $this->order->getStatus()->isCompleted() && $this->order->isBillable()) {
            CommonOrdersHelper::outputInvoicePDF($this->order);
        }

        die('Such order does not exist is not completed or is not billable');
    }
}
