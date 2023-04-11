<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpertSystemProjectController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/expertSystemExchange', function(Request $request) {
    $xmlString = $request->getContent();
    $dataObjects = simplexml_load_string($xmlString);
    $jsonEncoded = json_encode($dataObjects);
    $decodedArray = json_decode($jsonEncoded, true);
    //return print_r($decodedArray);
    try{
        (new ExpertSystemProjectController)->storeFromExchange($decodedArray);
        return __("Import successful!");
    } catch(Exception $e) {
        return response()->json(['response' => $e->getMessage()], 400);
    }
});


Route::get('/getExpertSystemProject/{projectName?}', [ExpertSystemProjectController::class, 'buildProjectXML']);