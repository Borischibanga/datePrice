<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CalendarController extends Controller
{
    public function index(){
        $events=Users::all();
        return view('welcome', compact('events'));
    }
    public function getAmounts(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $amounts = User::whereBetween('date', [$start_date, $end_date])
            ->pluck('price', 'date')
            ->toArray();
        $html = '<ul>';
        foreach ($amounts as $date => $amount) {
            $html .= "<li>{$date}: ${$amount}</li>";
        }
        $html .= '</ul>';

        return $html;
    }
}
