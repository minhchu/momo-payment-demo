<?php

use App\Services\MomoPayment;
use Illuminate\Http\Request;
/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () {
    return view('momo.index');
});

$router->post('/payment', function (Request $request, MomoPayment $momo) {
    $orderId = rand(1, getrandmax());

    $response = $momo->requestPayment("{$orderId}", 'Item info', $request->amount);

    $body = (string) $response->getBody();

    $result = json_decode($body, true);

    if ($result['errorCode'] !== 0) {
        return $result;
    }

    return redirect($result['payUrl']);
});

$router->get('/success', function () {
    // @TODO:
    // Validate callback:
    // http://momo-demo.loc/success?partnerCode=xxx&accessKey=xxx&requestId=xxx&amount=xxx&orderId=xxx&orderInfo=xxx&orderType=xxx&transId=xxx&message=xxx&localMessage=xxx&responseTime=2021-04-29%2017:11:40&errorCode=0&payType=qr&extraData=&signature=xxx
    return 'Success';
});
