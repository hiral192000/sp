<?php
namespace Seepossible\ProductPrefix\Plugin;

use Magento\Store\Model\ScopeInterface;

class ProductSuffix
{

    const PREFIX_PATH = 'prefix_section/general/prefix_field';

    public $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function afterGetName(\Magento\Catalog\Model\Product $subject, $result) {
        $prefixName = $this->getConfigValue();
        return $prefixName .' '. $result; 
    }

    public function getConfigValue()
	{ 
		return $this->scopeConfig->getValue(
            self::PREFIX_PATH,
            ScopeInterface::SCOPE_STORE
        );
	}
}