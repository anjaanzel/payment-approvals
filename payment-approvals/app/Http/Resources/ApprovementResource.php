<?php
  
namespace App\Http\Resources;
   
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApprovementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        switch ($this->payment_type) {
            case 'REGULAR':
                $payment = $this->payment;
                $amount = $payment->total_amount;
                break;
            case 'TRAVEL':
                $payment = $this->travelPayment;
                $amount = $payment->amount;
                break;
            default:
                throw new ModelNotFoundException($data['payment_id']);
        }
        return [
            'user' => $this->user->first_name . ' ' . $this->user->last_name,
            'payment_type' => $this->payment_type,
            'payment' => 'Payment no.' . $payment->id . ' by ' . $payment->user->first_name . ' ' . $payment->user->last_name . ': ' . $amount,
            'voted_at' => $this->created_at->format('d/m/Y H:m:s'),
        ];
    }
}