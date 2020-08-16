<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $dateTimeFormat = config('api.output_date_time_format');
        return [
            'id' => $this->id,
            'userId' => $this->user_id,
            'description' => $this->description,
            'amount' => $this->amount,
            'transactionDate' => $this->transaction_date->format($dateTimeFormat),
            'createdAt' => $this->created_at->format($dateTimeFormat),
            'updatedAt' => $this->updated_at->format($dateTimeFormat),
        ];
    }
}
