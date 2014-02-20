<?php
class Amazon {

    private $_accessKeyId;
    private $_associateTag;
    private $_secretAccessKey;

    public function __construct($accessKeyId, $associateTag,  $secretAccessKey){
        $this->_accessKeyId = $accessKeyId;
        $this->_associateTag = $associateTag;
        $this->_secretAccessKey = $secretAccessKey;

    }

    private function _urlEncode($string) {
        return urlencode($string);
    }

    public function itemSearch($operation, $options = array(), $responseGroup = array()) {
        $params = array();
        $params['Service']        = 'AWSECommerceService';
        $params['AWSAccessKeyId'] = $this->_accessKeyId;
        $params['Version']        = '2009-07-01';
        $params['Operation']      = $operation;
        $params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');
        $params['ResponseGroup'] = implode(',', $responseGroup); //Request,Images';
        $params['AssociateTag'] = $this->_associateTag;
        if(isset($options['idType'])) $params['IdType'] = $options['idType'];
        if(isset($options['itemId'])) $params['ItemId'] = $options['itemId'];
        if(isset($options['keywords'])) $params['Keywords'] = $options['keywords'];
        if(isset($options['searchIndex'])) $params['SearchIndex'] = $options['searchIndex'];
        ksort($params);


        $request = "http://ecs.amazonaws.jp/onca/xml?";
        $query = null;
        foreach ($params as $k => $v) {
            $query .= "&" . urlencode($k) . "=" . rawurlencode($v);
        }
        $parsedUrl = parse_url($request);
        $stringToSignature = "GET\n{$parsedUrl['host']}\n{$parsedUrl['path']}\n" . ltrim($query, '&');
        $signature = base64_encode(hash_hmac('sha256', $stringToSignature, $this->_secretAccessKey, true));
        $url = $request . $query . '&Signature=' . urlencode($signature);

        $parsed_xml = simplexml_load_string(file_get_contents($url));
        return $parsed_xml;
    }
}

?>