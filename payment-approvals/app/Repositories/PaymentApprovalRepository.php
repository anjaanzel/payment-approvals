<?php

namespace App\Repositories;

use App\Models\PaymentApproval;
use App\Repositories\Interfaces\PaymentInterface;

class PaymentApprovalRepository extends AbstractCrudRepository implements PaymentInterface
{
    public function __construct(PaymentApproval $model)
    {
        $this->model = $model;
    }
}