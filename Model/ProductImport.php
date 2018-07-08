<?php

namespace Ds\ProductImport\Model;

use Magento\Framework\File\Csv;
use Magento\Framework\App\State;
use Magento\Setup\Exception;

/**
 * Class ProductImport
 * @package Ds\ProductImport\Model
 */
class ProductImport
{
    /**
     * @var Csv
     */
    protected $_csv;

    /**
     * @var State
     */
    protected $_state;

    /**
     * ProductImport constructor.
     * @param Csv $csv
     */
    public function __construct(
        Csv $csv,
        State $state
    )
    {
        $this->_csv   = $csv;
        $this->_state = $state;
    }

    public function createProductSimple($file)
    {
        $importProducts = $this->_processorCsv($file);
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $filesystem = $objectManager->create('Magento\Framework\Filesystem');
        $this->_state->setAreaCode(\Magento\Framework\App\Area::AREA_ADMINHTML);

        foreach($importProducts as $importProduct) {

            try {
                $product = $objectManager->create('\Magento\Catalog\Model\Product');
                $product->setData($importProduct);
                $product->setWebsiteIds(array(1));
                $product->setAttributeSetId(4);
                $product->setTypeId(\Magento\Catalog\Model\Product\Type::TYPE_SIMPLE);
                $product->setStatus(1);
                $product->setTaxClassId(0); // (0 - none, 1 - default, 2 - taxable, 4 - shipping)
                $product->setVisibility(4); // catalog and search visibility
                $product->setColor(24);
                $product->setCost(1);

                $product->setStockData(
                    array(
                        'use_config_manage_stock' => 0,
                        'manage_stock' => 1, // manage stock
                        'min_sale_qty' => 1, // Shopping Cart Minimum Qty Allowed
                        'max_sale_qty' => 2, // Shopping Cart Maximum Qty Allowed
                        'is_in_stock' => 1, // Stock Availability of product
                        'qty' => (int)10
                    )
                );

                try {
                    $product->save();
                } catch (Exception $e) {

                }
            } catch(Exception $e) {
                die('Something failed for product import ' . $e->getMessage() . PHP_EOL);
                print_r($e);
            }
        }
    }

    protected function _processorCsv($file = null)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $filesystem = $objectManager->create(\Magento\Framework\Filesystem::class);
        $file = $filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::PUB)->getAbsolutePath() . 'ds-product-import/products.csv';

        $csvData = $this->_csv->getData($file);
        $items = [];
        $k = 0;
        foreach ($csvData as $row => $data) {
            if ($row === 0){
                $firstData = array_flip($data);
            } elseif(isset($firstData) && count($firstData) > 0) {
                $i = 0;
                foreach ($firstData as $key => $item) {
                    $items[$k][$key] = $data[$i];
                    $i++;
                }
                $k++;
            }
        }

        return $items;
    }
}
