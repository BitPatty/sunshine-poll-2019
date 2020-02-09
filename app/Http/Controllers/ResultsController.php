<?php

namespace App\Http\Controllers;

use App\Models\Aggr_Vote_Pb;
use App\Models\Aggr_Vote_Yr;
use App\Models\Flag;
use App\Models\Flags;
use App\Models\Result;
use Illuminate\Support\Facades\Gate;

class ResultsController extends Controller
{
    public function __construct()
    {
        try {
            if (Flag::getByKey(Flags::IS_RESULT_PUBLIC)->value !== true) {
                $this->middleware('auth');
            }
        } catch (\Exception $ex) {
            $this->middleware('auth');
        }
    }

    public function index()
    {
        if (!Gate::allows('read-results')) abort(403);

        $votes = Result::all();

        $aggregated_votes = [
            'pb' => Aggr_Vote_Pb::orderBy('pb', 'DESC')->get()->toArray(),
            'yr' => Aggr_Vote_Yr::orderBy('year', 'DESC')->get()->toArray(),
        ];


      // return response()->json($aggregated_votes);

        return view('results', ['votes' => $votes, 'aggregated_votes' => $aggregated_votes]);
    }
}
