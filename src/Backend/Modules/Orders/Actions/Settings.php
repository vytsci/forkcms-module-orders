<?php

namespace Backend\Modules\Orders\Actions;

use Backend\Core\Engine\Base\ActionEdit as BackendBaseActionEdit;
use Backend\Core\Engine\Form as BackendForm;
use Backend\Core\Engine\Language as BL;
use Backend\Core\Engine\Model as BackendModel;

/**
 * Class Settings
 * @package Backend\Modules\Orders\Actions
 */
class Settings extends BackendBaseActionEdit
{

    /**
     * Execute the action
     */
    public function execute()
    {
        parent::execute();

        $this->loadForm();
        $this->validateForm();

        $this->parse();
        $this->display();
    }

    /**
     * Loads the settings form
     */
    private function loadForm()
    {
        $this->frm = new BackendForm('settings');

        $this->frm->addText(
            'catalogue_prefix',
            $this->getContainer()->get('fork.settings')->get($this->getModule(), 'catalogue_prefix')
        );
        $this->frm->addText(
            'serial_number_format',
            $this->getContainer()->get('fork.settings')->get($this->getModule(), 'serial_number_format')
        );

        $this->frm->addText(
            'requisites_company_name',
            $this->getContainer()->get('fork.settings')->get($this->getModule(), 'requisites_company_name')
        );
        $this->frm->addText(
            'requisites_company_code',
            $this->getContainer()->get('fork.settings')->get($this->getModule(), 'requisites_company_code')
        );
        $this->frm->addText(
            'requisites_vat_identifier',
            $this->getContainer()->get('fork.settings')->get($this->getModule(), 'requisites_vat_identifier')
        );
        $this->frm->addText(
            'requisites_company_address',
            $this->getContainer()->get('fork.settings')->get($this->getModule(), 'requisites_company_address')
        );
        $this->frm->addText(
            'requisites_email',
            $this->getContainer()->get('fork.settings')->get($this->getModule(), 'requisites_email')
        );
        $this->frm->addText(
            'requisites_phone',
            $this->getContainer()->get('fork.settings')->get($this->getModule(), 'requisites_phone')
        );

        $modules = array();
        foreach (BackendModel::getModules() as $module) {
            $modules[] = array(
                'value' => $module,
                'label' => $module,
            );
        }
        $this->frm->addMultiCheckbox(
            'billable_modules',
            $modules,
            $this->getContainer()->get('fork.settings')->get($this->getModule(), 'billable_modules')
        );
    }

    /**
     * Validates the settings form
     */
    private function validateForm()
    {
        if ($this->frm->isSubmitted()) {
            if ($this->frm->isCorrect()) {
                $this->getContainer()->get('fork.settings')->set(
                    $this->getModule(),
                    'catalogue_prefix',
                    $this->frm->getField('catalogue_prefix')->getValue()
                );
                $this->getContainer()->get('fork.settings')->set(
                    $this->getModule(),
                    'serial_number_format',
                    $this->frm->getField('serial_number_format')->getValue()
                );

                $this->getContainer()->get('fork.settings')->set(
                    $this->getModule(),
                    'requisites_company_name',
                    $this->frm->getField('requisites_company_name')->getValue()
                );
                $this->getContainer()->get('fork.settings')->set(
                    $this->getModule(),
                    'requisites_company_code',
                    $this->frm->getField('requisites_company_code')->getValue()
                );
                $this->getContainer()->get('fork.settings')->set(
                    $this->getModule(),
                    'requisites_vat_identifier',
                    $this->frm->getField('requisites_vat_identifier')->getValue()
                );
                $this->getContainer()->get('fork.settings')->set(
                    $this->getModule(),
                    'requisites_company_address',
                    $this->frm->getField('requisites_company_address')->getValue()
                );
                $this->getContainer()->get('fork.settings')->set(
                    $this->getModule(),
                    'requisites_email',
                    $this->frm->getField('requisites_email')->getValue()
                );
                $this->getContainer()->get('fork.settings')->set(
                    $this->getModule(),
                    'requisites_phone',
                    $this->frm->getField('requisites_phone')->getValue()
                );
                $this->getContainer()->get('fork.settings')->set(
                    $this->getModule(),
                    'billable_modules',
                    $this->frm->getField('billable_modules')->getValue()
                );

                $this->redirect(BackendModel::createURLForAction('Settings').'&report=saved');
            }
        }
    }

    protected function parse()
    {
        parent::parse();
    }
}
