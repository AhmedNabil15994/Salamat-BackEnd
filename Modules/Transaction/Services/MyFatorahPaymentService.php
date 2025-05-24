<?php

namespace Modules\Transaction\Services;

class MyFatorahPaymentService
{
	public function send($payment,$type,$method,$clinic)
	{
    	$url = $this->paymentUrls($type);

		$token = "2seBURsTWEu5j4CS6ahCnDe90r4mnY-NoJlJ_Tzl6g4uLVRAS3Pd44gyCNz7q-asvj0zlbFX_rs0Ci5hMb0nq66FAbiQnzWKzSuSjaJ3ClJnOR9Ymv7m8muG-3PV4Egx0CJJZp06WBt7-2bJJQMVghBZSjA6u1BNb5-HHNrpvwh9RC_4QQVW_lq1vEucZ83ycAr399N_8CeGOD7akDJSdBcJ-wUG08lwlrJYAD3R5QUFON44CKJGFMRPj7cfFyGRQmZa8-uG7r2i1GxRtIzzFR5WK7sG-fssd1kllQLD1KXpRq1qPEqtaeWWhJCCleumTI0JbvJCzWoa4DpO78HMDO4ilmiRVW9A1mjNy2Qd8PrEa_95WzFKhq8AjPNOJsFq1axjm_2UPvXxxssDeVszkaCWIkHi0AxN4ayO6YHY1-YxLb87pSXWrQh1-392fcW3ML9h04zWy--rsgwAtAc6ujFD9CzcO2FD23dn7aT9OaWXm8mJ15YcDAQd-3espaTXAZY7Mhv4YdWQmkuUJQBOjlNDKYQVnFb8WssMnrn13U4LKUbZ4UiKnRjGZgmgy4Hphpk9CLPjIVMut6h--P6H86LTRSnNgW1HtGLK8Kr_co2npCzoTujqcDPkBD0zc_UrVS1NydFrqxPw5yvAW9gFaNGZrwPEK8feoXqJ9AVlYB9wQfW9lwomrLppE1c1qOg-dfTZmA";

        // $basURL = "https://api.myfatoorah.com";

        $data = [
            "NotificationOption"    => "ALL",
            "CustomerName"          => auth()->user()->name,
            "MobileCountryCode"     => "+965",
            "CustomerMobile"        => auth()->user()->mobile,
            "CustomerCivilId"       => "234234",
            "CustomerEmail"         => auth()->user()->email,
            "CustomerReference"     => $payment['id'],
            "InvoiceValue"          => $payment['total'],
            "DisplayCurrencyIso"    => "KWD",
            "CallBackUrl"           => $url['success'],
            "ErrorUrl"              => $url['failed'],
            "Language"              => locale() ? locale() : "en",
            "UserDefinedField"      => $payment['id'],
            "ExpiryDate"            => date('Y-m-d H:i:s', strtotime("+360 minutes", strtotime(date('Y-m-d H:i:s')))),
			"SupplierCode"          => $clinic['supplier_code'],
            "SourceInfo"            => "string"
        ];

		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL 			=> "https://api.myfatoorah.com/v2/SendPayment",
		  	CURLOPT_CUSTOMREQUEST   => "POST",
		  	CURLOPT_POSTFIELDS    	=> json_encode($data),
	      	CURLOPT_HTTPHEADER 		=> [
			  	"Authorization: Bearer $token",
			  	"Content-Type: application/json"
		  	],
		]);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		return $json  = json_decode((string)$response, true);
	}

    public function paymentUrls($type)
    {
        if ($type == 'orders') {
            $url['success'] = url(route('frontend.orders.success'));
            $url['failed']  = url(route('frontend.orders.failed'));
        }

        if ($type == 'api-order') {
            $url['success'] = url(route('api.orders.success'));
            $url['failed']  = url(route('api.orders.failed'));
        }

        if ($type == 'api-offer') {
            $url['success'] = url(route('api.offers.success'));
            $url['failed']  = url(route('api.offers.failed'));
        }

        return $url;
    }

    public function paymentStatus($request)
    {
        $token = "2seBURsTWEu5j4CS6ahCnDe90r4mnY-NoJlJ_Tzl6g4uLVRAS3Pd44gyCNz7q-asvj0zlbFX_rs0Ci5hMb0nq66FAbiQnzWKzSuSjaJ3ClJnOR9Ymv7m8muG-3PV4Egx0CJJZp06WBt7-2bJJQMVghBZSjA6u1BNb5-HHNrpvwh9RC_4QQVW_lq1vEucZ83ycAr399N_8CeGOD7akDJSdBcJ-wUG08lwlrJYAD3R5QUFON44CKJGFMRPj7cfFyGRQmZa8-uG7r2i1GxRtIzzFR5WK7sG-fssd1kllQLD1KXpRq1qPEqtaeWWhJCCleumTI0JbvJCzWoa4DpO78HMDO4ilmiRVW9A1mjNy2Qd8PrEa_95WzFKhq8AjPNOJsFq1axjm_2UPvXxxssDeVszkaCWIkHi0AxN4ayO6YHY1-YxLb87pSXWrQh1-392fcW3ML9h04zWy--rsgwAtAc6ujFD9CzcO2FD23dn7aT9OaWXm8mJ15YcDAQd-3espaTXAZY7Mhv4YdWQmkuUJQBOjlNDKYQVnFb8WssMnrn13U4LKUbZ4UiKnRjGZgmgy4Hphpk9CLPjIVMut6h--P6H86LTRSnNgW1HtGLK8Kr_co2npCzoTujqcDPkBD0zc_UrVS1NydFrqxPw5yvAW9gFaNGZrwPEK8feoXqJ9AVlYB9wQfW9lwomrLppE1c1qOg-dfTZmA";

        $data = [
            'key'       => $request['paymentId'],
            'KeyType'   => 'PaymentId',
        ];

        $curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL 			=> "https://api.myfatoorah.com/v2/GetPaymentStatus",
		  	CURLOPT_CUSTOMREQUEST   => "POST",
		  	CURLOPT_POSTFIELDS    	=> json_encode($data),
	      	CURLOPT_HTTPHEADER 		=> [
			  	"Authorization: Bearer $token",
			  	"Content-Type: application/json"
		  	],
		]);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		return $json  = json_decode((string)$response, true);

    }

}
