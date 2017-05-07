<?php

namespace Backend\Modules\Orders\Actions;

use Backend\Core\Engine\Base\ActionEdit as BackendBaseActionEdit;
use Backend\Core\Engine\Language as BL;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Core\Engine\Form as BackendForm;
use Common\Modules\Orders\Engine\Model as CommonOrdersModel;
use Common\Modules\Orders\Entity\Order;

/**
 * Class Edit
 * @package Backend\Modules\Events\Actions
 */
class Edit extends BackendBaseActionEdit
{

    /**
     * @var Order
     */
    protected $order;

    /**
     * The form instance
     *
     * @var BackendForm
     */
    protected $frm;

    /**
     * Execute the action
     */
    public function execute()
    {
        $this->id = $this->getParameter('id', 'int');

        $this->order = new Order(array($this->id), BL::getActiveLanguages());
        $this->order
            ->loadPayment()
            ->loadItems();

        if (!$this->order->isLoaded()) {
            $this->redirect(BackendModel::createURLForAction('Index').'&error=non-existing');
        }

        parent::execute();
        $this->loadForm();
        $this->validateForm();
        $this->parse();
        $this->display();
    }

    /**
     * Load the form
     */
    private function loadForm()
    {
        $this->frm = new BackendForm('edit');
    }

    /**
     * Parse the page
     */
    protected function parse()
    {
        parent::parse();

        $this->frm->parse($this->tpl);

        $this->tpl->assign('item', $this->order->toArray());
        $this->tpl->assign(
            'report_url',
            BackendModel::getURLForBlock('Orders', 'Report').'/'.$this->order->getId()
        );
    }

    /**
     * Validate the form
     */
    private function validateForm()
    {
        if ($this->frm->isSubmitted()) {
            $this->frm->cleanupFields();

            if ($this->frm->isCorrect()) {
                $this->redirect(
                    BackendModel::createURLForAction('Index').'&report=edited&var='.
                    urlencode($this->order->getId()).
                    '&highlight='.$this->order->getId()
                );
            }
        }
    }
}
