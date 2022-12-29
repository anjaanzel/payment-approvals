<?php
  
namespace App\Http\Resources;
   
use Illuminate\Http\Resources\Json\JsonResource;
  
class ApproverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'approver' => $this->first_name . ' ' . $this->last_name,
            'numberOfGivenApprovals' => $this->givenApprovals,
            'numberOfApprovedPayments' => $this->regularPaymentApprovalCount + $this->travelPaymentApprovalCount
        ];
    }
}