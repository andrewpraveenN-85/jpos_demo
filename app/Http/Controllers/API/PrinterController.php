<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Traits\PrinterTrait;
use App\Http\Controllers\Controller;

class PrinterController extends Controller
{
    use PrinterTrait;

    /**
     * Open the cash drawer via API.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function openDrawer(Request $request)
    {
        // Open the cash drawer
        $result = $this->openCashDrawer();

        // Return the result
        if ($result === true) {
            return response()->json(['message' => 'Cash drawer opened successfully!'], 200);
        }

        return response()->json(['error' => $result], 500);
    }
}
