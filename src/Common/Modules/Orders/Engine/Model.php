<?php

namespace Common\Modules\Orders\Engine;

use Frontend\Core\Engine\Language as FL;
use Common\Core\Model as CommonModel;
use Common\Modules\Orders\Engine\Model as CommonOrdersModel;
use Common\Modules\Orders\Entity\Item;
use Common\Modules\Orders\Entity\Order;

/**
 * Class Model
 * @package Common\Modules\Orders\Engine
 */
class Model
{

    /**
     * Name of a table where orders are stored
     */
    const TBL_ORDERS = 'orders';

    /**
     *
     */
    const TBL_ITEMS = 'orders_items';

    /**
     *
     */
    const SECTION_SUPPLIER = 'supplier';

    /**
     *
     */
    const SECTION_CUSTOMER = 'customer';

    /**
     *
     */
    const QRY_ENTITY_ORDER =
        'SELECT
            o.*,
            (SELECT SUM(quantity) FROM orders_items WHERE order_id = o.id) AS items_count,
            (SELECT SUM(unit_price * quantity) FROM orders_items WHERE order_id = o.id) AS items_amount
        FROM orders AS o
        LEFT JOIN payments AS pay ON pay.id = o.payment_id
        WHERE o.id = ?';

    /**
     *
     */
    const QRY_ENTITY_ITEM = 'SELECT oi.* FROM orders_items AS oi WHERE oi.id = ?';

    /**
     *
     */
    const QRY_ORDERS =
        'SELECT
            o.*,
            (SELECT COUNT(*) FROM orders_items WHERE order_id = o.id) AS items_count,
            (SELECT SUM(unit_price * quantity) FROM orders_items WHERE order_id = o.id) AS items_amount,
            pay.amount AS payment_amount
        FROM orders AS o
        LEFT JOIN payments AS pay ON pay.id = o.payment_id
        GROUP BY o.id';

    /**
     *
     */
    const QRY_SUPPLIER_ORDERS =
        'SELECT
            o.*,
            (SELECT SUM(quantity) FROM orders_items WHERE order_id = o.id) AS items_count,
            (SELECT SUM(unit_price * quantity) FROM orders_items WHERE order_id = o.id) AS items_amount,
            pay.amount AS payment_amount
        FROM orders AS o
        LEFT JOIN payments AS pay ON pay.id = o.payment_id
        WHERE o.supplier_profile_id = ?
        GROUP BY o.id
        ORDER BY o.created_on DESC';

    /**
     *
     */
    const QRY_CUSTOMER_ORDERS =
        'SELECT
            o.*,
            (SELECT SUM(quantity) FROM orders_items WHERE order_id = o.id) AS items_count,
            (SELECT SUM(unit_price * quantity) FROM orders_items WHERE order_id = o.id) AS items_amount,
            pay.amount AS payment_amount
        FROM orders AS o
        LEFT JOIN payments AS pay ON pay.id = o.payment_id
        WHERE o.customer_profile_id = ?
        GROUP BY o.id
        ORDER BY o.created_on DESC';

    /**
     * @var array
     */
    private static $ordersStatusesForDropdown = array();

    /**
     * @param $id
     *
     * @return array
     * @throws \SpoonDatabaseException
     */
    public static function getOrderItems($id)
    {
        $result = array();

        $records = (array)CommonModel::getContainer()->get('database')->getRecords(
            'SELECT oi.* FROM '.self::TBL_ITEMS.' AS oi WHERE oi.order_id = ?',
            (int)$id
        );

        foreach ($records as $record) {
            $item = new Item();
            $item
                ->assemble($record);
            $result[$item->getId()] = $item;
        }

        return $result;
    }

    /**
     * @param $section
     * @param $id
     *
     * @return array
     * @throws \SpoonDatabaseException
     */
    public static function getArrayOrders($section, $id)
    {
        $query = null;
        switch ($section) {
            case self::SECTION_SUPPLIER:
                $query = self::QRY_SUPPLIER_ORDERS;
                break;
            case self::SECTION_CUSTOMER:
                $query = self::QRY_CUSTOMER_ORDERS;
                break;
        }

        $records = array();

        if (isset($query)) {
            $records = (array)CommonModel::getContainer()->get('database')->getRecords(
                $query,
                (int)$id
            );

            foreach ($records as &$record) {
                $record['status_is_pending'] = $record['status'] == 'pending';
                $record['status_is_completed'] = $record['status'] == 'completed';
                $record['status_is_cancelled'] = $record['status'] == 'cancelled';
                $record['billable'] = (bool)$record['billable'];
            }
        }

        return $records;
    }

    /**
     * @param $id
     *
     * @return array
     */
    public static function getArrayOrdersAsSupplier($id)
    {
        return self::getArrayOrders(self::SECTION_SUPPLIER, $id);
    }

    /**
     * @param $id
     *
     * @return array
     */
    public static function getArrayOrdersAsCustomer($id)
    {
        return self::getArrayOrders(self::SECTION_CUSTOMER, $id);
    }

    /**
     * @return array
     */
    public static function getOrdersStatusesForDropdown()
    {
        if (empty(self::$ordersStatusesForDropdown)) {
            self::$ordersStatusesForDropdown = array();

            $statuses = (array)CommonModel::getContainer()->get('database')->getEnumValues(
                CommonOrdersModel::TBL_ORDERS,
                'status'
            );

            foreach ($statuses as $status) {
                self::$ordersStatusesForDropdown[$status] = FL::lbl('Orders'.\SpoonFilter::toCamelCase($status));
            }
        }

        return self::$ordersStatusesForDropdown;
    }

    /**
     * @return string
     */
    public static function getNextInvoiceNumber()
    {
        $number = intval(
                CommonModel::getContainer()->get('database')->getVar(
                    'SELECT MAX(o.invoice_number) FROM '.self::TBL_ORDERS.' AS o'
                )
            ) + 1;

        $format = CommonModel::getContainer()->get('fork.settings')->get('Orders', 'serial_number_format', '%08d');

        return sprintf($format, $number);
    }
}
