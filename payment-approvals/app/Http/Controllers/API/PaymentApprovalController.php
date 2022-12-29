<?php
   
namespace App\Http\Controllers\API;

use App\Http\Resources\ApproverResource;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\PaymentApproval;
use App\Models\TravelPayment;
use App\Models\User;
use App\Services\PaymentService;
use App\Services\PaymentApprovalService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;
use Illuminate\Support\Facades\DB;

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

    public function report()
    {
        $approvedPaymentIds = Payment::get()->where('isApproved', true)->pluck('id')->toArray();
        $approvedTravelPaymentIds = TravelPayment::get()->where('isApproved', true)->pluck('id')->toArray();
        $approvers = User::where('type', 'APPROVER')->get();
        $data = [];
        foreach ($approvers as $approver) {
            $approver->regularPaymentApprovalCount = $this->
                getApprovalCount('REGULAR', $approvedPaymentIds, $approver->id);

            $approver->travelPaymentApprovalCount = $this->
                getApprovalCount('TRAVEL', $approvedTravelPaymentIds, $approver->id);
            
            $approver->givenApprovals = PaymentApproval::where('user_id', $approver->id)->count();

            $data[] = new ApproverResource($approver);
        }

        return $this->responseService->sendResponse(
            $data,
            'Successfully retrieved data.'
        );
    }

    private function getApprovalCount(string $type, array $ids, int $approverId): int
    {
        return PaymentApproval::where('user_id', $approverId)
            ->where('payment_type', $type)
            ->whereIn('payment_id', $ids)
            ->count();
    }
}
