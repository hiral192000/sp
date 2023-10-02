<?php
namespace Seepossible\ProductPrefix\Model;
class SpBlog extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'seepossible_productprefix_spblog';

	protected $_cacheTag = 'seepossible_productprefix_spblog';

	protected $_eventPrefix = 'seepossible_productprefix_spblog';

	protected function _construct()
	{
		$this->_init('Seepossible\ProductPrefix\Model\ResourceModel\SpBlog');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}