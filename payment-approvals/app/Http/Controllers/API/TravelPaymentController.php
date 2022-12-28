<?php
   
namespace App\Http\Controllers\API;

use App\Http\Resources\PaymentResource;
use App\Models\TravelPayment;
use App\Services\TravelPaymentService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;

class TravelPaymentController extends BaseController
{
    public function __construct(
        TravelPaymentService $travelPaymentService,
        ResponseService $responseService
    ) {
        $this->travelPaymentService = $travelPaymentService;
        $this->responseService = $responseService;
    }

    public function index()
    {
        return $this->responseService->sendResponse(
            $this->travelPaymentService->getAll(),
            'Travel payments retrieved successfully.'
        );
    }

    public function store(Request $request)
    {
        return $this->travelPaymentService->create(array_merge($request->all(), ['user_id' => Auth::user()->id]));
    }

    public function show($id)
    {
        try {
            return $this->responseService->sendResponse(
                new PaymentResource($this->travelPaymentService->find($id)),
                'Travel payment retrieved successfully.'
            );
        } catch (ModelNotFoundException $e) {
            return $this->responseService->sendError('Travel payment not found.');
        }
    }
    
    public function update(Request $request, int $id)
    {
        try {
            return $this->travelPaymentService->update($request->all(), $id);
        } catch (ModelNotFoundException $e) {
            return $this->responseService->sendError('Payment not found.');
        }
    }
   
    public function destroy(int $id)
    {
        try {
            $this->travelPaymentService->delete($id);
            return $this->responseService->sendResponse([], 'Payment deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return $this->responseService->sendError('Payment not found.');
        }
    }
}
