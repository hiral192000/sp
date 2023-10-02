<?php

namespace Seepossible\CheckoutCustomization\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\View\LayoutInterface;

class CheckoutConfigProvider implements ConfigProviderInterface {
    
    /**
     *
     * @var LayoutInterface
     */
    private $_layout;
    
    public function __construct(LayoutInterface $layout) {
        $this->_layout = $layout;
    }
    
    public function getConfig() {
        $block = $this->_layout->createBlock(\Magento\Cms\Block\Block::class)->setBlockId('checkout_summary_info');
        
        return [
            'checkout_summary_info' => $block->toHtml()
        ];
    }
}