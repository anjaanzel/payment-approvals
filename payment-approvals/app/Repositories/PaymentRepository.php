<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Repositories\Interfaces\PaymentInterface;

class PaymentRepository extends AbstractCrudRepository implements PaymentInterface
{
    public function __construct(Payment $model)
    {
        $this->model = $model;
    }
}