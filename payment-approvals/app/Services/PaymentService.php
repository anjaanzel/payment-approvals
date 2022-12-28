<?php

namespace App\Services;

use App\Http\Resources\PaymentResource;
use App\Repositories\PaymentRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Validator;

class PaymentService
{
    public function __construct(
        PaymentRepository $repository,
        ResponseService $responseService
    ) {
        $this->repository = $repository;
        $this->responseService = $responseService;
    }

    public function getAll()
    {
        return PaymentResource::collection($this->repository->getAll());
    }

    public function create(array $data): JsonResponse
    {
        $validator = Validator::make($data, [
            'total_amount' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);
   
        if ($validator->fails()) {
            return $this->responseService->sendError('Validation Error.', $validator->errors());
        }
   
        $payment = $this->repository->store($data);
   
        return $this->responseService->sendResponse(new PaymentResource($payment), 'Payment created successfully.');
    }

    public function update(array $data, int $paymentId): JsonResponse
    {
        $validator = Validator::make($data, [
            'total_amount' => 'required|numeric',
        ]);
   
        if ($validator->fails()) {
            return $this->responseService->sendError('Validation Error.', $validator->errors());
        }
   
        $payment = $this->repository->update($paymentId, $data);
   
        return $this->responseService->sendResponse(new PaymentResource($payment), 'Payment updated successfully.');
    }

    public function delete(int $paymentId)
    {
        $this->repository->delete($paymentId);
    }

    public function find(int $id): Model
    {
        return $this->repository->findOrFail($id);
    }
}
