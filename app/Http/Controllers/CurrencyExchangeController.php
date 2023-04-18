<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CurrencyExchange;

class CurrencyExchangeController extends Controller
{
    public function mesage(Request $request)
    {
        return response()->json(['message' => 'Currency rate added']);
    }

    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'currency' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $currencyRates = CurrencyExchange::where('currency', $validatedData['currency'])
            ->whereDate('date', $validatedData['date'])
            ->first();

        if (!$currencyRates) {
            $currencyRate = new CurrencyExchange;
            $currencyRate->currency = $validatedData['currency'];
            $currencyRate->amount = $validatedData['amount'];
            $currencyRate->date = $validatedData['date'];
            $currencyRate->save();

            return response()->json(['message' => 'Currency rate added']);
        }
        else
        {
            return response()->json(['message' => 'Currency rate already exist'], 403);
        }
    }

    public function list(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
        ]);
        $currencyRates = CurrencyExchange::where('date', $validatedData['date'])->get();

        return response()->json($currencyRates);
    }

    public function get(Request $request, $currency)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
        ]);

        $currencyRate = CurrencyExchange::where('currency', $currency)
            ->where('date', $validatedData['date'])
            ->first();

        if (!$currencyRate) {
            return response()->json(['error' => 'Currency rate not found'], 404);
        }

        return response()->json($currencyRate);
    }
}
