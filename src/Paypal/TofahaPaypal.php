<?php


namespace Tofaha\Helper\Paypal;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tofaha\Helper\Paypal\Orders\OrdersCreateRequest;
use Tofaha\Helper\Paypal\Core\SandboxEnvironment;
use Tofaha\Helper\Paypal\Core\PayPalHttpClient;
use Tofaha\Helper\Paypal\Orders\OrdersGetRequest;
use Tofaha\Helper\Paypal\Orders\OrdersCaptureRequest;

class TofahaPaypal
{
    protected $cancel_url;
    protected $return_url;
    protected $client_id;
    protected $client_secret;
    protected $amount;
    protected $currency;
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
    public function setAmount($amount,$currency){
        $this->amount = $amount;
        $this->currency = $currency;
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
                    "value" => $this->amount,
                    "currency_code" => $this->currency
                ]
            ]],
            "application_context" => [
                "cancel_url" => $this->cancel_url,
                "return_url" => $this->return_url
            ]
        ];

        try {
            $response = $client->execute($request);
            session()->flash('payment_order_id',$response->result->id);
            return $response;

        }catch (HttpException $ex) {
            return ["error"=>$ex->getMessage(),"code"=>$ex->getStatusCode()];
        }
    }
    public function done(){
        $environment = new SandboxEnvironment($this->client_id,$this->client_secret);
        $client = new PayPalHttpClient($environment);
        $request = new OrdersCaptureRequest(session()->get('payment_order_id'));
        $request->prefer('return=representation');
        try {
            $response = $client->execute($request);
            return $response;
        }catch (HttpException $ex) {
            return ["statusCode"=>$ex->getStatusCode(),"message"=>$ex->getMessage()];
        }
    }
}
