<?php

use Illuminate\Http\Request;

Route::middleware('auth:sanctum')->post('/get_rp_by_id', function (Request $request) {
    return response()->json([
        'user' => $request->user(),
        'message' => 'Mantap, auth jalan'
    ]);
});