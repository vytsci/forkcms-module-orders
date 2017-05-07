<?php

namespace Backend\Modules\Orders\Actions;

use Backend\Core\Engine\Base\ActionIndex as BackendBaseActionIndex;
use Backend\Core\Engine\DataGridDB as BackendDataGridDB;
use Backend\Core\Engine\Authentication as BackendAuthentication;
use Backend\Core\Engine\Language as BL;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Modules\Orders\Engine\Model as BackendOrdersModel;
use Common\Modules\Orders\Engine\Model as CommonOrdersModel;
use Common\Modules\Filter\Engine\Helper as CommonFilterHelper;
use Common\Modules\Filter\Engine\Filter;

/**
 * Class Index
 * @package Backend\Modules\Orders\Actions
 */
class Index extends BackendBaseActionIndex
{

    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var BackendDataGridDB
     */
    private $dgOrders;

    /**
     *
     */
    public function execute()
    {
        parent::execute();
        $this->loadFilter();
        $this->loadDataGrid();
        $this->parse();
        $this->display();
    }

    /**
     * Loads filter form
     */
    private function loadFilter()
    {
        $this->filter = new Filter();

        $this->filter
            ->addTextCriteria(
                'search',
                array('sp.email', 'cp.email', 'o.created_on'),
                CommonFilterHelper::OPERATOR_PATTERN
            );
    }

    /**
     * @throws \Exception
     * @throws \SpoonDatagridException
     */
    private function loadDataGrid()
    {
        $this->dgOrders = new BackendDataGridDB($this->filter->getQuery(BackendOrdersModel::QRY_DG_ORDERS));

        $this->dgOrders->setColumnHidden('id', false);
        $this->dgOrders->setSortingColumns($this->dgOrders->getColumns());

        if (BackendAuthentication::isAllowedAction('Edit')) {
            $this->dgOrders->addColumn(
                'edit',
                null,
                BL::getLabel('Edit'),
                BackendModel::createURLForAction('Edit', null, null, null).'&amp;id=[id]',
                BL::getLabel('Edit')
            );
        }
    }

    /**
     * @throws \SpoonTemplateException
     */
    protected function parse()
    {
        parent::parse();

        $this->filter->parse($this->tpl);

        $this->tpl->assign(
            'dgOrders',
            ($this->dgOrders->getNumResults() != 0) ? $this->dgOrders->getContent() : false
        );
    }
}
