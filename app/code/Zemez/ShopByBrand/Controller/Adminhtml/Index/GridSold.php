<?php

namespace Zemez\ShopByBrand\Controller\Adminhtml\Index;

class GridSold extends \Magento\Catalog\Controller\Adminhtml\Category
{
    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;

    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    protected $layoutFactory;

    /**
     * @var \Zemez\ShopByBrand\Api\BrandRepositoryInterface
     */
    protected $brandRepository;

    protected $brandFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @param \Magento\Backend\App\Action\Context             $context
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     * @param \Magento\Framework\View\LayoutFactory           $layoutFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\View\LayoutFactory $layoutFactory,
        \Zemez\ShopByBrand\Api\BrandRepositoryInterface $brandRepository,
        \Zemez\ShopByBrand\Api\Data\BrandInterfaceFactory $brandFactory,
        \Magento\Framework\Registry $registry
    ) {
        parent::__construct($context);
        $this->resultRawFactory = $resultRawFactory;
        $this->layoutFactory = $layoutFactory;
        $this->brandRepository = $brandRepository;
        $this->brandFactory = $brandFactory;
        $this->registry = $registry;
    }

    /**
     * Grid Action
     * Display list of products related to current category.
     *
     * @return \Magento\Framework\Controller\Result\Raw
     */
    public function execute()
    {
        $brandId = (int) $this->getRequest()->getParam('brand_id', false);
        if ($brandId) {
            $brand = $this->brandRepository->getById($brandId);
        } else {
            $brand = $this->brandFactory->create();
        }

        $this->registry->register('brand', $brand);

        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultRaw = $this->resultRawFactory->create();

        return $resultRaw->setContents(
            $this->layoutFactory->create()->createBlock(
                'Zemez\ShopByBrand\Block\Adminhtml\Brand\Tab\SoldStatistics',
                'sold.brand.grid'
            )->toHtml()
        );
    }
}
