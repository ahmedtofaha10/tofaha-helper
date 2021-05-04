<?php


namespace Tofaha\Helper\Paypal;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tofaha\Helper\Paypal\Orders\OrdersCreateRequest;
use Tofaha\Helper\Paypal\Core\SandboxEnvironment;
use Tofaha\Helper\Paypal\Core\PayPalHttpClient;
class TofahaPaypal
{
    protected $cancel_url;
    protected $return_url;
    protected $client_id;
    protected $client_secret;
    public function setUrls($return_url,$cancel_url){
        $this->return_url = $return_url;
        $this->cancel_url = $cancel_url;
        return $this;
    }
    public function setEnv($client_id,$client_secret){
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        return $this;
    }
    public function execute($order){
        $environment = new SandboxEnvironment($this->client_id,$this->client_secret);
        $client = new PayPalHttpClient($environment);
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => "test_ref_id1",
                "amount" => [
                    "value" => "100.00",
                    "currency_code" => "USD"
                ]
            ]],
            "application_context" => [
                "cancel_url" => $this->cancel_url,
                "return_url" => $this->return_url
            ]
        ];

        try {
            $response = $client->execute($request);
            dd($response);
        }catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }
}
