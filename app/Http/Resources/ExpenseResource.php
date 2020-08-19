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
        $transactionDate = !is_null($this->transaction_date)
            ? $this->transaction_date->format($dateTimeFormat)
            : null;

        return [
            'id' => $this->id,
            'userId' => $this->user_id,
            'description' => $this->description,
            'amount' => $this->amount,
            'transactionDate' => $transactionDate,
            'createdAt' => $this->created_at->format($dateTimeFormat),
            'updatedAt' => $this->updated_at->format($dateTimeFormat),
        ];
    }
}
