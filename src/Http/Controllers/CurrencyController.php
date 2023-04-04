<?php

namespace teusbarros\CurrencyExchange\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use teusbarros\CurrencyExchange\GetCurrency;
use teusbarros\CurrencyExchange\ConvertCurrency;


/**
 * @OA\Info(title="Currency Exchange Rate - Documentation", version="0.1")
 *
 *  @OA\Tag(
 *     name="Currency",
 *     description="Currency API endpoint",
 * )
 */
class CurrencyController extends Controller
{
    private GetCurrency $currency;
    public const VALID_CURRENCIES = [
        "USD","JPY","BGN","CZK","DKK","GBP","HUF","PLN","RON","SEK",
        "CHF","ISK","NOK","TRY","AUD","BRL","CAD","CNY","HKD","IDR",
        "ILS","INR","KRW","MXN","MYR","NZD","PHP","SGD","THB","ZAR",
    ];
    public function __construct(GetCurrency $currency)
    {
        $this->currency = $currency;
    }

    /**
     * @OA\Get(
     *     tags={"Currency"},
     *     path="/api/v1/exchange",
     *     summary="Get the exchange rate for the given amount.",
     *     @OA\Parameter(
     *         name="currency",
     *         required=true,
     *         in="path",
     *         description="The currency to exchange",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="amount",
     *         required=true,
     *         in="path",
     *         description="The amount to exchange",
     *         @OA\Schema(
     *             type="float"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     ),
     * )
     */
    public function rate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'currency' => 'required|in:' . implode(',', self::VALID_CURRENCIES),
            'amount' => 'required|decimal:2,4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'data' => [],
                'error' => $validator->errors()->get('*'),
                'errors' => [],
            ], 422);
        }

        $todayCurrency = $this->currency->execute($request->currency);

        if ($todayCurrency) {
            $value = ConvertCurrency::convert($request->amount, $todayCurrency);

            return response()->json([
                'success' => 1,
                'data' => ['rate' => $value],
                'error' => null,
                'errors' => [],
            ], 200);
        }

        return response()->json([
            'success' => 0,
            'data' => [],
            'error' => 'The European Central Bank has no available information for this currency right now. Try again later.',
            'errors' => [],
        ], 500);
    }

    public function getJsonDoc()
    {
        dd(asset(public_path('index.css')));
        return response()->json( public_path());
    }
}
