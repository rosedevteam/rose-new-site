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
    static function isMarketOpen()
    {
        return true;
    }

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
//        $indices = Index::query();
//        if ($indices->first()?->created_at < now()->subDays(10)) {
//            $indices->delete();
//            $newIndices = ApiClient::indices();
//            foreach ($newIndices as $index) {
//                Index::create($index);
//            }
//        }
        return Index::all()->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function company($coId)
    {
        $company = Company::where('coID', $coId)->get();
        return $company->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function getIndex($indexId)
    {
        $index = Index::where('indexID', $indexId)->get();
        return $index->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function trades($coId)
    {
        $trades = Trade::where('coID', $coId);
        if (self::isMarketOpen() && $trades->first()?->created_at < now()->subMinutes(2)) {
            $trades->delete();
            $newTrade = ApiClient::trades($coId);
            foreach ($newTrade as $trade) {
                Trade::create($trade);
            }
            $trades = Trade::where('coID', $coId)->get();
        }
        return $trades->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function legalTrades($coId)
    {
        $legalTrades = LegalTrade::where('com_ID', $coId);
        if (self::isMarketOpen() && $legalTrades->first()?->created_at < now()->subMinutes(2)) {
            $legalTrades->delete();
            $newTrade = ApiClient::trades($coId);
            foreach ($newTrade as $trade) {
                LegalTrade::create($trade);
            }
            $legalTrades = LegalTrade::where('coID', $coId)->get();
        }
        return $legalTrades->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function indexValues($indexId)
    {
        $indexValues = IndexValue::where('indexID', $indexId)->get();
        if (self::isMarketOpen() && $indexValues->first()?->created_at < now()->subMinutes(2)) {
            $indexValues->delete();
            $newIndex = ApiClient::trades($indexId);
            foreach ($newIndex as $indexValue) {
                IndexValue::create($indexValue);
            }
            $indexValues = IndexValue::where('coID', $indexId)->get();
        }
        return $indexValues->toJson(JSON_UNESCAPED_UNICODE);
    }

    public function bidAsk($coId)
    {
        $bidAsks = BidAsk::where('coID', $coId)->get();
        if (self::isMarketOpen() && $bidAsks->first()?->created_at < now()->subMinutes(2)) {
            $bidAsks->delete();
            $newBidAsks = ApiClient::trades($coId);
            foreach ($newBidAsks as $bidAsk) {
                BidAsk::create($bidAsk);
            }
            $bidAsks = BidAsk::where('coID', $coId)->get();
        }
        return $bidAsks->toJson(JSON_UNESCAPED_UNICODE);
    }

}
