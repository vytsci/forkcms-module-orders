<?php

namespace Common\Modules\Orders\Engine;

use Common\Core\Model as CommonModel;

use Frontend\Core\Engine\Template as FrontendTemplate;

use Common\Modules\Currencies\Engine\Helper as CommonCurrenciesHelper;
use Common\Modules\Members\Engine\Model as CommonMembersModel;
use Common\Modules\Orders\Entity\Order;

/**
 * Class Helper
 * @package Common\Modules\Orders\Engine
 */
class Helper
{
    /**
     * @param Order $order
     *
     * @return \mPDF
     */
    public static function outputInvoicePDF(Order $order)
    {
        $tpl = new FrontendTemplate();
        CommonCurrenciesHelper::parse($tpl);

        $contact = CommonModel::getContainer()->get('fork.settings')->get('Core', 'mailer_reply_to');
        $settings = CommonModel::getContainer()->get('fork.settings')->getForModule('Orders');
        $customer = CommonMembersModel::getMember($order->getCustomerProfileId())
            ->loadAddresses()
            ->loadRequisites();

        $tpl->assign('contact', $contact);
        $tpl->assign('settings', $settings);
        $tpl->assign('customer', $customer->toArray());
        $tpl->assign('order', $order->toArray());

        $title =
            (isset($settings['catalogue_prefix']) ? strtoupper($settings['catalogue_prefix']) : '')
            .$order->getCreatedOn('y')
            .'-'
            .$order->getInvoiceNumber();
        $author = CommonModel::get('fork.settings')->get('Core', 'site_title_'.FRONTEND_LANGUAGE, SITE_DEFAULT_TITLE);

        $content = $tpl->getContent(FRONTEND_MODULES_PATH.'/Orders/Layout/Templates/PDF/Invoice.tpl');

        $mPDF = new \mPDF('UTF-8');
        $mPDF->SetProtection(array('print'));
        $mPDF->SetTitle($title);
        $mPDF->SetAuthor($author);
        $mPDF->SetDisplayMode('fullpage');
        $mPDF->WriteHTML($content);

        $filename = $title.'.pdf';

        //$mPDF->Output();
        $mPDF->Output($filename, 'D');

        exit;
    }
}
