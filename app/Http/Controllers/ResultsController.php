<?php

namespace App\Http\Controllers;

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

        $votes = Result::orderBy('label', 'ASC')->get();

        return view('results', ['votes' => $votes]);
    }
}
