<?php

namespace Frontend\Modules\Orders\Actions;

use Frontend\Core\Engine\Base\Block as FrontendBaseBlock;
use Frontend\Core\Engine\Language as FL;
use Frontend\Core\Engine\Navigation as FrontendNavigation;
use Frontend\Modules\Profiles\Engine\Authentication as FrontendProfilesAuthentication;

use Common\Modules\Currencies\Engine\Helper as CommonCurrenciesHelper;

use Common\Modules\Orders\Entity\Order;

/**
 * Class Detail
 * @package Frontend\Modules\Orders\Actions
 */
class Detail extends FrontendBaseBlock
{

    /**
     * @var Order
     */
    private $order;

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

        $this->overrideHeader();
        $this->fillBreadcrumb();
        $this->loadTemplate();
        $this->parse();
    }

    public function loadRecord()
    {
        $id = $this->URL->getParameter(0, 'int');

        $this->order = new Order(array($id));
        $this->order
            ->loadPayment()
            ->loadItems();
    }

    public function hasRecord()
    {
        $this->loadRecord();

        if ($this->order->isLoaded()) {
            return true;
        }

        return false;
    }

    private function overrideHeader()
    {
        $this->header->setPageTitle($this->order->getId());
    }

    private function fillBreadcrumb()
    {
        $this->breadcrumb->addElement(ucfirst(FL::lbl('Order')));
    }

    private function parse()
    {
        CommonCurrenciesHelper::parse($this->tpl);

        $this->tpl->assign('hideContentTitle', true);
        $this->tpl->assign('order', $this->order->toArray());
    }
}
