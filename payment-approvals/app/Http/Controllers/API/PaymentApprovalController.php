<?php
   
namespace App\Http\Controllers\API;

use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Services\PaymentService;
use App\Services\PaymentApprovalService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;

class PaymentApprovalController extends BaseController
{
    public function __construct(
        PaymentApprovalService $paymentApprovalService,
        ResponseService $responseService
    ) {
        $this->paymentApprovalService = $paymentApprovalService;
        $this->responseService = $responseService;
    }

    public function store(Request $request)
    {
        try {
            return $this->paymentApprovalService->create(array_merge($request->all(), ['user_id' => Auth::user()->id]));
        } catch (ModelNotFoundException $e) {
            return $this->responseService->sendError('Payment not found.');
        }
    }

    public function show($id)
    {
        try {
            return $this->responseService->sendResponse(
                new PaymentResource($this->paymentService->find($id)),
                'Payment retrieved successfully.'
            );
        } catch (ModelNotFoundException $e) {
            return $this->responseService->sendError('Payment not found.');
        }
    }
    
    public function update(Request $request, int $id)
    {
        try {
            return $this->paymentService->update($request->all(), $id);
        } catch (ModelNotFoundException $e) {
            return $this->responseService->sendError('Payment not found.');
        }
    }
   
    public function destroy(int $id)
    {
        try {
            $this->paymentService->delete($id);
            return $this->responseService->sendResponse([], 'Payment deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return $this->responseService->sendError('Payment not found.');
        }
    }
}
