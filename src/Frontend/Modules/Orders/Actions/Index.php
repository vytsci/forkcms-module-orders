<?php

namespace Frontend\Modules\Orders\Actions;

use Frontend\Core\Engine\Base\Block as FrontendBaseBlock;
use Frontend\Core\Engine\Navigation as FrontendNavigation;
use Frontend\Modules\Profiles\Engine\Authentication as FrontendProfilesAuthentication;

use Common\Modules\Orders\Engine\Model as CommonOrdersModel;

/**
 * Class Category
 * @package Frontend\Modules\Events\Actions
 */
class Index extends FrontendBaseBlock
{

    /**
     * @var array
     */
    private $orders;

    /**
     *
     */
    public function execute()
    {
        if ($this->loadDetail()) {
            return;
        }

        if (!FrontendProfilesAuthentication::isLoggedIn()) {
            $this->redirect(
                FrontendNavigation::getURLForBlock(
                    'Profiles',
                    'Login'
                ).'?queryString='.FrontendNavigation::getURLForBlock('Orders'),
                307
            );
        }

        parent::execute();

        $this->loadData();
        $this->loadTemplate();
        $this->parse();
    }

    /**
     *
     */
    public function loadData()
    {
        $this->orders = array(
            'supplier' => CommonOrdersModel::getArrayOrdersAsSupplier(
                FrontendProfilesAuthentication::getProfile()->getId()
            ),
            'customer' => CommonOrdersModel::getArrayOrdersAsCustomer(
                FrontendProfilesAuthentication::getProfile()->getId()
            ),
        );
    }

    /**
     * @return bool
     */
    private function loadDetail()
    {
        $detail = new Detail($this->getKernel(), $this->getModule(), 'Detail');
        if ($detail->hasRecord()) {
            $detail->execute();
            $this->tpl = $detail->getTemplate();
            $this->setTemplatePath($detail->getTemplatePath());

            return true;
        }

        return false;
    }

    /**
     *
     */
    private function parse()
    {
        $this->tpl->assign('orders', $this->orders);
    }
}
