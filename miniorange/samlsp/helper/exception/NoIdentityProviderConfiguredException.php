<?php

namespace Miniorange\Samlsp\Helper\Exception;

use Miniorange\Samlsp\Helper\Messages;

/**
 * Exception denotes that user has not configured a SP.
 */
class NoIdentityProviderConfiguredException extends SAMLResponseException
{
	public function __construct() 
	{
		$message 	= Messages::parse('NO_IDP_CONFIG');
		$code 		= 101;		
        parent::__construct($message, $code, NULL, NULL);
    }

    public function __toString() 
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}