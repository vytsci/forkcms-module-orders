<?php

namespace Backend\Modules\Orders\Engine;

use Backend\Core\Engine\Model as BackendModel;
use Backend\Core\Engine\Language as BL;

use Common\Modules\Orders\Engine\Model as CommonOrdersModel;

/**
 * Class Model
 * @package Backend\Modules\Orders\Engine
 */
class Model
{
    /**
     *
     */
    const QRY_DG_ORDERS =
        'SELECT
          o.id,
          o.created_on,
          (SELECT COUNT(*) FROM orders_items WHERE order_id = o.id) AS items_count,
          (SELECT SUM(unit_price * quantity) FROM orders_items WHERE order_id = o.id) AS items_amount,
          pay.amount AS payment_amount,
          o.status,
          sp.email AS supplier_email,
          cp.email AS customer_email
        FROM orders AS o
        LEFT JOIN payments AS pay ON pay.id = o.payment_id
        LEFT JOIN profiles AS sp ON sp.id = o.supplier_profile_id
        LEFT JOIN profiles AS cp ON cp.id = o.customer_profile_id
        GROUP BY o.id';
}
