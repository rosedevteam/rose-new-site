<?php

namespace Modules\Analytics\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Modules\Analytics\Http\client\ApiClient;
use Modules\Analytics\Models\BidAsk;
use Modules\Analytics\Models\company;
use Modules\Analytics\Models\index;
use Modules\Analytics\Models\IndexValue;
use Modules\Analytics\Models\LegalTrade;
use Modules\Analytics\Models\Trade;

class AnalyticsController extends Controller
{
    public function index()
    {
        return view('analytics::front.index');
    }

    public function companies()
    {
        return Company::all()->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function indices()
    {
        return Index::all()->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function company($coId)
    {
        return Company::where('coID', $coId)->get()->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function getIndex($indexId)
    {
        return Index::where('indexID', $indexId)->get()->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function trades($coId)
    {
        $trades = Trade::where('coID', $coId);
        if (self::shouldApiCall($trades)) {
            $trades->delete();
            $newTrade = ApiClient::trades($coId);
            foreach ($newTrade as $trade) {
                Trade::create($trade);
            }
        }
        return Trade::where('coID', $coId)->get()->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function legalTrades($coId)
    {
        $legalTrades = LegalTrade::where('com_ID', $coId);
        if (self::shouldApiCall($legalTrades)) {
            $legalTrades->delete();
            $newTrade = ApiClient::trades($coId);
            foreach ($newTrade as $trade) {
                LegalTrade::create($trade);
            }
        }
        return LegalTrade::where('com_ID', $coId)->get()->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function indexValues($indexId)
    {
        $indexValues = IndexValue::where('indexID', $indexId);
        if (self::shouldApiCall($indexValues)) {
            $indexValues->delete();
            $newIndex = ApiClient::trades($indexId);
            foreach ($newIndex as $indexValue) {
                IndexValue::create($indexValue);
            }
        }
        return IndexValue::where('indexID', $indexId)->get()->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function bidAsk($coId)
    {
        $bidAsks = BidAsk::where('coID', $coId);
        if (self::shouldApiCall($bidAsks)) {
            $bidAsks->delete();
            $newBidAsks = ApiClient::trades($coId);
            foreach ($newBidAsks as $bidAsk) {
                BidAsk::create($bidAsk);
            }
        }
        return BidAsk::where('coID', $coId)->get()->toJson(JSON_UNESCAPED_UNICODE);
    }

    private static function shouldApiCall($builderQuery)
    {
        return $builderQuery->count() == 0 || (self::isMarketOpen() && $builderQuery->first()?->created_at < now()->subMinutes(2));
    }

    private static function isMarketOpen()
    {
        // todo
        return true;
    }

}
