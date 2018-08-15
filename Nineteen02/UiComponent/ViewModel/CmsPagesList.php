<?php namespace Nineteen02\UiComponent\ViewModel;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Cms\Api\Data\PageInterface;

class CmsPagesList implements ArgumentInterface
{

  private $url;


  private $pageRepository;

  private $searchCriteriaBuilder;

  public function __construct(
    PageRepositoryInterface $pageRepository,
    SearchCriteriaBuilder $searchCriteriaBuilder,
    UrlInterface $url
   ) {
    $this->url = $url;
    $this->pageRepository = $pageRepository;
    $this->searchCriteriaBuilder = $searchCriteriaBuilder;
  }


  public function getItemsJson()
  {

    $result = [];

    foreach ($this->getItems() as $page) {
      $result[$page->getIdentifier()] = [
        'title' => $page->getTitle(),
        'url' => $this->url->getUrl($page->getIdentifier())
      ];
    }

    return json_encode($result);
  }


  private function getItems()
  {
    $searchCriteria = $this->searchCriteriaBuilder->create();
    $pageSearchResult = $this->pageRepository->getList($searchCriteria);

    return $pageSearchResult->getItems();
  }
}