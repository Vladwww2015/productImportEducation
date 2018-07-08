<?php

namespace Ds\ProductImport\Model;


use Magento\Framework\File\Csv;

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
     * ProductImport constructor.
     * @param Csv $csv
     */
    public function __construct(
        Csv $csv
    )
    {
        $this->_csv = $csv;
    }

    public function createProductSimple($file)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $filesystem = $objectManager->create('Magento\Framework\Filesystem');
        $mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $mediaPath = $mediaDirectory->getAbsolutePath();

        $importProducts = [
            [
                'name'              => 'Product L',
                'sku'               => 'product_l_blue',
                'weight'            => '23',
                'tax_class_id'      => 0,
                'price'             => 233,
                'meta_title'        => 'title',
                'meta_keyword'      => 'l,blue',
                'meta_description'  => 'meta description',
                'description'       => 'description'
            ]
        ];

        foreach( $importProducts as $importProduct ) {

            try {
                $product = $objectManager->create('\Magento\Catalog\Model\Product');
                $product->setWebsiteIds(array(1));
                $product->setAttributeSetId(4);
                $product->setTypeId(\Magento\Catalog\Model\Product\Type::TYPE_SIMPLE);
                $product->setCreatedAt(strtotime('now'));
                $product->setName($importProduct['name']);
                $product->setSku($importProduct['sku']);
                $product->setWeight($importProduct['weight']);
                $product->setStatus(1);
                $product->setTaxClassId(0); // (0 - none, 1 - default, 2 - taxable, 4 - shipping)
                $product->setVisibility(4); // catalog and search visibility
                $product->setColor(24);
                $product->setPrice($importProduct['price']) ;
                $product->setCost(1);
                $product->setMetaTitle($importProduct['meta_title']);
                $product->setMetaKeyword($importProduct['meta_keyword']);
                $product->setMetaDescription($importProduct['meta_description']);
                $product->setDescription($importProduct['description']);

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


                $product->save();
                echo "Upload simple product id :: ".$product->getId()."\n";
            }
            catch(Exception $e)
            {
                die('Something failed for product import ' . $e->getMessage() . PHP_EOL);
                print_r($e);
            }
        }
    }

    protected function _processorCsv($file)
    {
        $csvData = $this->_csv->getData($file);
        foreach ($csvData as $row => $data) {
            if ($row > 0){

            }
        }
    }
}
