<?php

namespace Magebit\PageListWidget\Block\Widget;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class PageList extends Template implements BlockInterface
{

    protected $_template = "page-list.phtml";
    protected PageRepositoryInterface $pageRepositoryInterface;
    protected SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(
        Template\Context        $context,
        array                   $data = [],
        PageRepositoryInterface $pageRepositoryInterface,
        SearchCriteriaBuilder   $searchCriteriaBuilder
    )
    {
        parent::__construct($context, $data);
        $this->pageRepositoryInterface = $pageRepositoryInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }


    /**
     * @throws LocalizedException
     */
    public function getPageList($pageIds = []): array
    {
        $searchCriteria = $this->searchCriteriaBuilder;
        if (!empty($pageIds)) {
            $searchCriteria->addFilter('page_id', $pageIds, 'in');
        }
        $searchCriteria = $searchCriteria->create();
        return $this->pageRepositoryInterface->getList($searchCriteria)->getItems();
    }

}
