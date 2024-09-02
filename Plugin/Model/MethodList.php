<?php

namespace Y2B\RestrictPayment\Plugin\Model;
 
class MethodList
{
	public function afterGetAvailableMethods(
        \Magento\Payment\Model\MethodList $subject,
    	$availableMethods,
    	\Magento\Quote\Api\Data\CartInterface $quote = null
	) {
    	$shippingMethod = $this->getShippingMethodFromQuote($quote);
    	foreach ($availableMethods as $key => $method) {

        	// Here we will hide CashonDeliver method while customer select Synthetic Grass Shipping(Doorstep delivery) Shipping Method.
            if( ($method->getCode() == 'cashondelivery') && ($shippingMethod == 'your_shipping_method') )
            {
				unset($availableMethods[$key]);
        	}
    	}
 
    	return $availableMethods;
	}
 
	/**
 	* @param \Magento\Quote\Api\Data\CartInterface $quote
 	* @return string
 	*/
	private function getShippingMethodFromQuote($quote)
	{
    	if($quote) {
        	return $quote->getShippingAddress()->getShippingMethod();
    	}
 
    	return '';
	}
}