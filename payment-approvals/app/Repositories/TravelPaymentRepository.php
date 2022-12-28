<?php

namespace App\Repositories;

use App\Models\TravelPayment;
use App\Repositories\Interfaces\PaymentInterface;

class TravelPaymentRepository extends AbstractCrudRepository implements PaymentInterface
{
    public function __construct(TravelPayment $model)
    {
        $this->model = $model;
    }
}