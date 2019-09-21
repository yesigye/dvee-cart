<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require __DIR__ . '/vendor/autoload.php';

use Omnipay\Omnipay;

class Payment
{
    protected $gateway;
    public $response = [];
    public $error_message = '';

	public function __construct()
	{
        /*
         Test buyer details
        
         First name:      test
         Last name:       buyer
         email address:   ignatiusyesigye-buyer@gmail.com
         password:        testbuyer123
         Phone number:    4088191359
         Card number:     4032038577747763 
         Card type:       VISA
         Expiration Date: 02/2021
 
        */

        // Load config file to select payment options
        $this->config->load('payments');
        $active_gateway = $this->config->item('active');
        $paypal_config = $this->config->item('paypal');

        switch ($active_gateway) {
            case 'stripe':
                $this->gateway = Omnipay::create('Stripe');
                $this->gateway->setApiKey('sk_test_fR0zWyB29ZAoxDjOe01jsm9P00uVcXA2pb');
                break;            
            case 'paypalPro':
                // use the PayPal Pro gateway
                $this->gateway = Omnipay::create('PayPal_Pro');
                $this->gateway->setTestMode($paypal_config['sandbox']);
                $this->gateway->setUsername($paypal_config['username']);
                $this->gateway->setPassword($paypal_config['password']);
                $this->gateway->setSignature($paypal_config['signature']);
                break;
            
            default:
                // By default, use the PayPal Express gateway
                $this->gateway = Omnipay::create('PayPal_Express');
                $this->gateway->setTestMode($paypal_config['sandbox']);
                $this->gateway->setLogoImageUrl($this->store->owner()->logo);
                $this->gateway->setBrandName($this->store->owner()->name);
                $this->gateway->setUsername($paypal_config['username']);
                $this->gateway->setPassword($paypal_config['password']);
                $this->gateway->setSignature($paypal_config['signature']);
                break;
        }
    }
    
	/**
	 * Enables the use of CI super-global without having to define an extra variable.
	 *
	 * @param	$var
     * 
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
    }

    /**
	 * Returns an error message.
	 *
	 * @return string
	 */
	public function error_message()
	{
		return $this->error_message;
    }

    /**
	 * Accept a credit card onsite and make a direct payment.
     * Requires business pro account type to be enable on the seller/merchant account
	 *
	 * @param  $details credit card infomation
     * 
	 * @return boolean
	 */
    public function purchase(Array $details = [])
    {
        try {
            $formtted_details = [
                'amount' => $details['amount'],
                'currency' => $details['currency'],
            ];

            // if(isset($details['card'])) $formtted_details['card'] = $details['card'];
            if(isset($details['tax'])) $formtted_details['taxAmount'] = $details['tax'];
            if(isset($details['shipping'])) $formtted_details['shippingAmount'] = $details['shipping'];
            if(isset($details['returnUrl'])) $formtted_details['returnUrl'] = $details['returnUrl'];
            if(isset($details['cancelUrl'])) $formtted_details['cancelUrl'] = $details['cancelUrl'];

            // Send purchase request
            $response = $this->gateway->purchase($formtted_details)->send();

            // Process response
            if ($response->isSuccessful()) {
                // Payment was successful
                $this->response = $response->getData();
                return true;
            } elseif ($response->isRedirect()) {
                // Redirect to offsite payment gateway
                $response->redirect();
                return true;
            } else {
                // Payment failed
                $this->error_message = $response->getMessage();
                return false;
            }
        } catch (Exception $e) {
            // Simple message for the user
            $this->error_message = 'Something went wrong will processing your payment';
            // Log error report in the log files for technical user
            log_message('error', 'internal error processing payment TOKEN. '.$e->getMessage());

            return false;
        }
    }

    public function done(Array $details = [])
    {
        /*
         TODO:
         - Check with DB that this is not a double payment
         */
        try {
            $formtted_details = [
                'amount' => $details['amount'],
                'currency' => $details['currency'],
            ];

            if(isset($details['card'])) $formtted_details['card'] = $details['card'];
            if(isset($details['tax'])) $formtted_details['taxAmount'] = $details['tax'];
            if(isset($details['shipping'])) $formtted_details['shippingAmount'] = $details['shipping'];

            // Send purchase request
            $response = $this->gateway->completePurchase($formtted_details)->send();

            if ($response->isSuccessful()) {
                // Return payment infomation
                $info = $response->getData();

                // Returns no data at this point. forums say it does after completePurchase()
                // $info = $this->gateway->fetchCheckout()->send();

                $response = $this->gateway->fetchCheckout()->send();
                $this->response = $data = $response->getData();

                return true;
            } else {
                // Payment failed
                $this->error_message = $response->getMessage();
                
                return false;
            }
        } catch (Exception $e) {
            // Simple message for the user
            $this->error_message = 'Something went wrong will processing your payment';
            // Log error report in the log files for technical user
            log_message('error', 'internal error processing payment TOKEN. '.$e->getMessage());

            return false;
        }
    }
}