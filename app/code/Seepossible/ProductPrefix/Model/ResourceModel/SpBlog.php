<?php
namespace Seepossible\ProductPrefix\Model\ResourceModel;
class SpBlog extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	)
	{
		parent::__construct($context);
	}
	
	protected function _construct()
	{
		$this->_init('sp_blog', 'id');
	}
}