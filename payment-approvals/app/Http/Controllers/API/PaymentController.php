<?php
   
namespace App\Http\Controllers\API;

use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Services\PaymentService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;

class PaymentController extends BaseController
{
    public function __construct(
        PaymentService $paymentService,
        ResponseService $responseService
    ) {
        $this->paymentService = $paymentService;
        $this->responseService = $responseService;
    }

    public function index()
    {
        return $this->responseService->sendResponse(
            $this->paymentService->getAll(),
            'Payments retrieved successfully.'
        );
    }

    public function store(Request $request)
    {
        return $this->paymentService->create(array_merge($request->all(), ['user_id' => Auth::user()->id]));
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
