<?php

namespace Seepossible\ProductPrefix\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Module\Setup\Migration;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class AddData implements DataPatchInterface
{
     private $spBlogFactory;

     public function __construct(
          \Seepossible\ProductPrefix\Model\SpBlogFactory $spBlogFactory
     ) {
          $this->spBlogFactory = $spBlogFactory;
     }

     public function apply()
     {
          $sampleData = [
               [
                    'title' => 'Blog title 1', 
                    'description' => 'Description for blog 1',
                    'is_active' => 1
               ],
               [
                    'title' => 'Blog title 2', 
                    'description' => 'Description for blog 2',
                    'is_active' => 1
               ],
               [
                    'title' => 'Blog title 3', 
                    'description' => 'Description for blog 3',
                    'is_active' => 1
               ],
               [
                    'title' => 'Blog title 4', 
                    'description' => 'Description for blog 4',
                    'is_active' => 0
               ],
               [
                    'title' => 'Blog title 5', 
                    'description' => 'Description for blog 5',
                    'is_active' => 0
               ]
          ];
          foreach ($sampleData as $data) {
               $this->spBlogFactory->create()->setData($data)->save();
          }
     }

     public static function getDependencies()
     {
          return [];
     }

     public function getAliases()
     {
          return [];
     }
     
}