<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DateRangeController extends Controller
{
    public function submitForm(Request $request)
    {
        // Validate the form data
        $request->validate([
            'dateRange' => 'required',
            'price' => 'required|numeric',
        ]);

        // Process the form data and save to the users table
        $dateRange = $request->input('dateRange');
        $price = $request->input('price');

        // Create a new user instance
        $user = new User();

        // Fill the user instance with the form data
        $user->dateRange = $dateRange;
        $user->price = $price;

        // Save the new user record to the database
        $user->save();

        // Return a response
        return response()->json(['message' => 'Form submitted successfully']);
    }
    public function yourView()
    {
        $prices = User::all(); // Replace with your actual way of fetching prices

        return view('your-view')->with('prices', $prices);
    }
    // app/Http/Controllers/YourController.php

    public function fetchPrices(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
    
        // Assuming 'dates' is the column in the 'users' table that contains the dates
        $prices = User::whereBetween('dateRange', [$start, $end])->get();
    
        return response()->json($prices);
    }

}
