<?php

namespace Backend\Modules\Orders;

use Backend\Core\Engine\Base\Config as BackendBaseConfig;

/**
 * Class Config
 * @package Backend\Modules\Order
 */
class Config extends BackendBaseConfig
{

    /**
     * The default action.
     *
     * @var    string
     */
    protected $defaultAction = 'Index';

    /**
     * The disabled actions.
     *
     * @var    array
     */
    protected $disabledActions = array();
}
