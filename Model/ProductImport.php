<?php

namespace Ds\ProductImport\Model;

class ProductImport
{
    public function createProducts()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $filesystem = $objectManager->create('Magento\Framework\Filesystem');
        $mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $mediaPath = $mediaDirectory->getAbsolutePath();

        foreach( $importProducts as $importProduct ) {

            try {

                $product = $objectManager->create('\Magento\Catalog\Model\Product');
                $product->setWebsiteIds(array(1));
                $product->setAttributeSetId(4);
                $product->setTypeId('simple');
                $product->setCreatedAt(strtotime('now'));
                $product->setName($importProduct[1]);
                $product->setSku($importProduct[3]);
                $product->setWeight($importProduct[16]);
                $product->setStatus(1);
                $category_id= array(30,24);
                $product->setCategoryIds($category_id);
                $product->setTaxClassId(0); // (0 - none, 1 - default, 2 - taxable, 4 - shipping)
                $product->setVisibility(4); // catalog and search visibility
                $product->setColor(24);
                $product->setPrice($importProduct[11]) ;
                $product->setCost(1);
                $product->setMetaTitle($importProduct[1]);
                $product->setMetaKeyword($importProduct[26]);
                $product->setMetaDescription($importProduct[28]);
                $product->setDescription($importProduct[27]);
                $product->setShortDescription($importProduct[27]);

                $product->setStockData(
                    array(
                        'use_config_manage_stock' => 0,
                        'manage_stock' => 1, // manage stock
                        'min_sale_qty' => 1, // Shopping Cart Minimum Qty Allowed
                        'max_sale_qty' => 2, // Shopping Cart Maximum Qty Allowed
                        'is_in_stock' => 1, // Stock Availability of product
                        'qty' => (int)$importProduct[6]
                    )
                );


                $product->save();
                echo "Upload simple product id :: ".$product->getId()."\n";
            }
            catch(Exception $e)
            {
                echo 'Something failed for product import ' . $importProduct[1] . PHP_EOL;
                print_r($e);
            }
        }
    }
}
