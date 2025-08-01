<?php

namespace App\Services\Campaigns\CampaignManager;

use App\Models\Campaign;
use App\Models\CampaignDiscount;
use App\Traits\Campaigns\SabahattinTrait;

class SabahattinAliCampaign implements CampaignInterface
{
    use SabahattinTrait;

    protected $campaign;

    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    public function isApplicable(array $products): bool 
    {
        return $this->isSabahattinAli($products);
    }

    public function calculateDiscount(array $products): array
    {
        $eligible = $this->getEligibleProducts($products);

        //En ucuz ürün için
        $totalQuantity = $eligible->sum('quantity'); 
        if($totalQuantity < 2) {
            return ['discount' => 0, 'description' =>''];
        }
        $discountRule = CampaignDiscount::where('campaign_id', $this->campaign->id)->first();
        $x = $discountRule ? json_decode($discountRule->discount_value)->x : 2;
        $y = $discountRule ? json_decode($discountRule->discount_value)->y : 1;

        $cheapest = $eligible->sortBy('product.list_price')->first();
        $discount = $cheapest ? $cheapest->product->list_price : 0;

        return [
            'description' => $this->campaign->description, 
            'discount' => $discount
        ];
    }
}   