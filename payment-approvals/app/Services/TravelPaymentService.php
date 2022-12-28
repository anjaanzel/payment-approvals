<?php

namespace App\Services;

use App\Http\Resources\PaymentResource;
use App\Repositories\TravelPaymentRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Validator;

class TravelPaymentService
{
    public function __construct(
        TravelPaymentRepository $repository,
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
            'amount' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);
   
        if ($validator->fails()) {
            return $this->responseService->sendError('Validation Error.', $validator->errors());
        }
   
        $payment = $this->repository->store($data);
   
        return $this->responseService->sendResponse(
            new PaymentResource($payment),
            'Travel payment created successfully.'
        );
    }

    public function update(array $data, int $id): JsonResponse
    {
        $validator = Validator::make($data, [
            'amount' => 'required|numeric',
        ]);
   
        if ($validator->fails()) {
            return $this->responseService->sendError('Validation Error.', $validator->errors());
        }
   
        $payment = $this->repository->update($id, $data);
   
        return $this->responseService->sendResponse(
            new PaymentResource($payment),
            'Travel payment updated successfully.'
        );
    }

    public function delete(int $id)
    {
        $this->repository->delete($id);
    }

    public function find(int $id): Model
    {
        return $this->repository->findOrFail($id);
    }
}
