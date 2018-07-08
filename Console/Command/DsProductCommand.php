<?php

namespace Ds\ProductImport\Console\Command;

use Magento\Framework\App\Filesystem\DirectoryList;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DsProductCommand
 * @package Ds\ProductImport\Console\Command
 */
class DsProductCommand extends Command
{

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $_filesystem;

    /**
     * @var \Ds\ProductImport\Model\ProductImport
     */
    protected $_productImport;

    /**
     * DsProductCommand constructor.
     * @param \Magento\Framework\Filesystem $dsProductImportPath
     * @param \Ds\ProductImport\Model\ProductImport $productImport
     */
    public function __construct(
        \Magento\Framework\Filesystem $filesystem,
        \Ds\ProductImport\Model\ProductImport $productImport,
        $name = null
    )
    {
        $this->_productImport       = $productImport;
        $this->_filesystem = $filesystem;

        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setName('ds:product_import')->setDescription('Import Product');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $this->getImportPath() . 'ds-product-import';
        $this->_productImport->createProductSimple($path);
        $output->writeln($path);
    }

    /**
     * @return string
     */
    protected function getImportPath()
    {
        return $this->_filesystem->getDirectoryRead(DirectoryList::PUB)->getAbsolutePath();
    }
}
