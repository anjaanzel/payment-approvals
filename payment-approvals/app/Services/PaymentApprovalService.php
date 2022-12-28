<?php

namespace App\Services;

use App\Http\Resources\ApprovementResource;
use App\Repositories\PaymentApprovalRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;

class PaymentApprovalService
{
    public function __construct(
        PaymentApprovalRepository $repository,
        PaymentService $paymentService,
        TravelPaymentService $travelPaymentService,
        ResponseService $responseService
    ) {
        $this->repository = $repository;
        $this->paymentService = $paymentService;
        $this->travelPaymentService = $travelPaymentService;
        $this->responseService = $responseService;
    }

    public function create(array $data): JsonResponse
    {
        $validator = Validator::make($data, [
            'payment_id' => 'required|numeric',
            'payment_type' => 'required|string',
            'status' => 'in: "APPROVED", "DISAPPROVED"',
            'user_id' => 'required|numeric',
        ]);
   
        if ($validator->fails()) {
            return $this->responseService->sendError('Validation Error.', $validator->errors());
        }

        $this->doesPaymentExist($data);
   
        $approvement = $this->repository->store($data);

        $statusMessage = ucfirst($data['payment_type']) . ' payment no. ' . $data['payment_id'] . ' ' . $data['status'];
   
        return $this->responseService->sendResponse(new ApprovementResource($approvement), $statusMessage);
    }


    private function doesPaymentExist(array $data)
    {
        switch ($data['payment_type']) {
            case 'REGULAR':
                $this->paymentService->find($data['payment_id']);
                break;
            case 'TRAVEL':
                $this->travelPaymentService->find($data['payment_id']);
                break;
            default:
                throw new ModelNotFoundException($data['payment_id']);
        }
    }
}
