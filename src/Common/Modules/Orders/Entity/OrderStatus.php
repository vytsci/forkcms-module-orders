<?php

namespace Common\Modules\Orders\Entity;

use Common\Modules\Entities\Engine\EnumValue;

/**
 * Class OrderStatus
 * @package Common\Modules\Orders\Entity
 */
class OrderStatus extends EnumValue
{

    /**
     * @var string
     */
    protected $defaultValue = 'pending';

    /**
     * @return bool
     */
    public function isPending()
    {
        return $this->getValue() == 'pending';
    }

    /**
     * @return bool
     */
    public function isCompleted()
    {
        return $this->getValue() == 'completed';
    }

    /**
     * @return bool
     */
    public function isCancelled()
    {
        return $this->getValue() == 'cancelled';
    }

    /**
     * @param bool $lazyLoad
     * @return array
     */
    public function toArray($lazyLoad = true)
    {
        return parent::toArray() + array(
            'is_pending' => $this->isPending(),
            'is_completed' => $this->isCompleted(),
            'is_cancelled' => $this->isCancelled(),
        );
    }
}
