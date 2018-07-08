<?php

namespace Ds\ProductImport\Controller\CreateProduct;

use Magento\Framework\App\Action\Context;
use Ds\ProductImport\Model\ProductImport as ProductImportModel;
use Magento\Framework\App\ResponseInterface;

/**
 * Class ProductImport
 * @package Ds\ProductImport\Controller\CreateProduct
 */
class ProductImport extends \Magento\Framework\App\Action\Action
{
    /**
     * @var ProductImportModel
     */
    protected $_productImport;

    /**
     * ProductImport constructor.
     * @param Context $context
     * @param ProductImportModel $productImport
     */
    public function __construct(
        Context $context,
        ProductImportModel $productImport
    )
    {
        $this->_productImport = $productImport;
        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $this->_productImport->createProducts();
    }
}
