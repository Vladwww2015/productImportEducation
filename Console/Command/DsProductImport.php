<?php


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command;

class DsProductImport extends Command
{

    protected $_dsProductImportPath;
    protected $_productImport;

    public function __construct(
        \Magento\Framework\Filesystem $dsProductImportPath,
        \Ds\ProductImport\Model\ProductImport $productImport,
        $name
    )
    {
        $this->_dsProductImportPath = $dsProductImportPath;
        $this->_productImport = $productImport;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('ds:product_import')
              ->setDescription('Import Product')
              ->addArgument('path', InputArgument::REQUIRED, 'Path to import file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');

//        $this->productImport->createProductSimple();
        $output->writeln($path);
    }

    protected function getImportPath()
    {
        return $this->_dsProductImportPath->getDirectoryRead(DirectoryList::PUB)->getAbsolutePath();
    }
}
