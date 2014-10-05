<?php
/**
 * EgoPay API JSON Class
 * For more information please visit https://www.egopay.com/developers/api
 */
require_once 'EgoPayApiAgentInterface.php';
/**
 * Class EgoPayJsonApiAgent
 */
class EgoPayJsonApiAgent implements EgoPayApiAgentInterface
{
    /**
     * Current API lib version
     */
    const VERSION = '1.3';
    /**
     * EgoPay API request url
     */
    const EGOPAY_API_PAYMENT_URL = "https://www.egopay.com/api/json/";
    /**
     * EgoPay API Auth object
     * @var EgoPayAuth
     */
    private $_oAuth;

    /**
     * EgoPay API lib constructor
     * @param EgoPayAuth $a Auth credentials
     */
    public function __construct(EgoPayAuth $a)
    {
        $this->_oAuth = $a;    
    }
    /**
     * Returns the attached API's wallet balance. If there is specified currency, then the requesting currency balance
     * is returned.
     * For more information see: https://www.egopay.com/developers/api
     * Since v1.0
     * @param string $sCurrency valid values:Empty,USD,EUR
     * @return mixed|null|object
     */
    public function getBalance($sCurrency = null)
    {
        $sResponse = $this->_getResponse('balance');
        $oBalance = $this->_parseResponse($sResponse);
        if ($sCurrency !== null)
            if (isset($oBalance->{$sCurrency}))
                return $oBalance->{$sCurrency};
            else
                return null;
        return $oBalance;
    }
    /**
     * Returns attached API's wallet operations list.
     * For more information see: https://www.egopay.com/developers/api
     * Since v1.0
     * @param $iTransactionId
     * @return array|mixed|object
     */
    public function getFindTransaction($iTransactionId)
    {
        $sResponse = $this->_getResponse('findTransaction',array(
            'transactionId' => $iTransactionId
        ));        
        $oTransactionDetails = $this->_parseResponse($sResponse);        
        return $oTransactionDetails;
    }
    /**
     * Transfer money to the EgoPay user Account.
     * For more information see: https://www.egopay.com/developers/api
     * Since v1.0
     * @param string $sPayeeEmail
     * @param float $fAmount
     * @param string $sCurrency
     * @param string $sDetails
     * @return array|mixed|object
     */
    public function getTransfer($sPayeeEmail, $fAmount, $sCurrency, $sDetails)
    {
        $sResponse = $this->_getResponse('transfer',array(
            'payeeEmail'    => $sPayeeEmail,
            'amount'        => $fAmount,
            'currency'      => $sCurrency,
            'details'       => $sDetails            
        ));        
        $oTransactionDetails = $this->_parseResponse($sResponse);        
        return $oTransactionDetails;
    }
    /**
     * Returns the attached API's wallet operations list.
     * For more information see: https://www.egopay.com/developers/api
     * Since v1.0
     * @param array $aParams
     * @return array|mixed|object
     */
    public function getHistory($aParams = array())
    {
        $sResponse = $this->_getResponse('history', $aParams);
        $oTransactionsDetails = $this->_parseResponse($sResponse);        
        return $oTransactionsDetails;
    }
    /**
     * Returns the attached API's user sold subscriptions
     * For more information see: https://www.egopay.com/developers/api
     * Since v1.3
     * @param array $aParams
     * @return array|mixed
     */
    public function getSoldSubscriptions($aParams = array())
    {
        $sResponse = $this->_getResponse('soldSubscriptions', $aParams);
        $oSoldSubscriptions = $this->_parseResponse($sResponse);
        return $oSoldSubscriptions;
    }
    /**
     * Returns the attached API's user purchased subscriptions
     * For more information see: https://www.egopay.com/developers/api
     * Since v1.3
     * @param array $aParams
     * @return array|mixed
     */
    public function getPurchasedSubscriptions($aParams = array())
    {
        $sResponse = $this->_getResponse('purchasedSubscriptions', $aParams);
        $oPurchasedSubscriptions = $this->_parseResponse($sResponse);
        return $oPurchasedSubscriptions;
    }
    /**
     * Returns provided subscription transactions list
     * For more information see: https://www.egopay.com/developers/api
     * Since v1.3
     * @param array $aParams
     * @return array|mixed
     */
    public function getSubscriptionTransactions($aParams = array())
    {
        $sResponse = $this->_getResponse('subscriptionTransactions', $aParams);
        $oSubscriptionTransactions = $this->_parseResponse($sResponse);
        return $oSubscriptionTransactions;
    }
    /**
     * Cancels provided subscription. Returns canceled subscription information on success.
     * For more information see: https://www.egopay.com/developers/api
     * Since v1.3
     * @param array $aParams
     * @return array|mixed
     */
    public function getCancelSubscription($aParams = array())
    {
        $sResponse = $this->_getResponse('cancelSubscription', $aParams);
        $oCancelSubscription = $this->_parseResponse($sResponse);
        return $oCancelSubscription;
    }
    /**
     * Gets a prefixed unique identifier based on the current time in microseconds.
     * For more information see http://php.net/manual/en/function.uniqid.php
     * Since v1.0
     * @return string
     */
    private static function _generateId()
    {
        return uniqid();
    }
    /**
     * Builds query that is accepted by EgoPay
     * Since v1.0
     * @param $aData
     * @return array
     */
    private function _buildQuery($aData)
    {
        $aData = array_merge(array(
            'id'            => self::_generateId(),
            'version'       => self::VERSION,
            'account_name'  => $this->_oAuth->getAccountName(),
            'api_id'        => $this->_oAuth->getApiId(),
            'ts'            => time(),
        ), array_filter($aData));
        
        ksort($aData);		
        $aData['h'] = hash('sha256',$this->_oAuth->getApiPass() . '|' . implode('|', $aData));
        return $aData;
    }
    /**
     * Retrieves Response that is sent from EgoPay
     * Since v1.0
     * @param $sAction
     * @param array $aData
     * @return bool|mixed
     * @throws EgoPayApiException
     */
    private function _getResponse($sAction, $aData = array())
    {
        if (!function_exists('curl_init')) {
            die("Curl library not installed.");
            return false;
        }
        
        $sRequestUrl = self::EGOPAY_API_PAYMENT_URL . $sAction;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $sRequestUrl);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_6; en-us) AppleWebKit/525.27.1 (KHTML, like Gecko) Version/3.2.1 Safari/525.27.1");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->_buildQuery($aData)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $sResponse = curl_exec($ch);
        
        if (!curl_errno($ch)) {
            $response_info = curl_getinfo($ch);
            if ($response_info['http_code'] != 200) {
                throw new EgoPayApiException('Invalid response from EgoPay. Response code: '. $response_info['http_code']);
            }
        }

    	curl_close($ch);

        return $sResponse;
    }
    /**
     * Parses response from EgoPay
     * Since v1.0
     * @param $sResponse
     * @return array|mixed
     */
    private function _parseResponse($sResponse)
    {      
        $oResponse = json_decode($sResponse);
        $this->_checkError($oResponse);
        return $oResponse;
    }
    /**
     * Checks if there was errors
     * Since v1.0
     * @param $oResponse
     * @throws EgoPayApiException
     */
    private function _checkError($oResponse)
    {
        if ($oResponse === null)
            throw new EgoPayApiException('Invalid Response Format', (int) 0);
        if (isset($oResponse->status) && $oResponse->status == 'ERROR')
            throw new EgoPayApiException($oResponse->error_message, (int) $oResponse->error_code);
    }        
}