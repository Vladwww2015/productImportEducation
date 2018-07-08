<?php

class DsProductImport extends Command
{

    protected $ds_product_import_path;
    protected $productImport;

    public function __construct(
        \Magento\Framework\Filesystem $ds_product_import_path,
        \Ds\ProductImport\Model\ProductImport $productImport
    )
    {
        $this->ds_product_import_path = $ds_product_import_path;
        $this->productImport = $productImport;
    }

    protected function configure()
    {
        $this->setName('ds:product_import')->setDescription('Import Product');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->productImport->createProductSimple();
        $output->writeln('Import Product');
    }

    protected function getImportPath()
    {
        return $this->ds_product_import_path->getDirectoryRead(DirectoryList::PUB)->getAbsolutePath();
    }
}
