<?php

namespace Modules\Analytics\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Modules\Analytics\Models\BidAsk;
use Modules\Analytics\Models\company;
use Modules\Analytics\Models\index;
use Modules\Analytics\Models\IndexValue;
use Modules\Analytics\Models\LegalTrade;

class AnalyticsController extends Controller
{
    public function index()
    {
        return view('analytics::front.index');
    }

    public function companies()
    {
        $company = Company::all();
//        if(is_Null($company) || $company->first->created_at < now()->subDays()){
//            Company::query()->delete();
//            $newData = ApiClient::companies();
//            foreach($newData as $company){
//                Company::create($company);
//            }
//            $company = Company::all();
//        }
        return $company->toJson();
    }

    public function indices()
    {
        $index = Index::all();
        return $index->toJson();
    }

    public function company($coId)
    {
        Company::where('coID', $coId)->get();
    }

    public function getIndex($indexId)
    {
        Index::where('indexID', $indexId)->get();
    }

    public function trades($coId)
    {
        Company::where('coID', $coId)->get();
    }

    public function legalTrades($coId)
    {
        LegalTrade::where('com_ID', $coId)->get();
    }

    public function indexValues($indexId)
    {
        IndexValue::where('indexID', $indexId)->get();
    }

    public function bidAsk($coId)
    {
        BidAsk::where('coID', $coId)->get();
    }

}
