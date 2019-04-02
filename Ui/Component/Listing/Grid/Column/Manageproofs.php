<?php
namespace Halfprice\Designers\Ui\Component\Listing\Grid\Column;
 
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
 
class Manageproofs extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;
 
    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
 
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
       if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['entity_id'])) {
                    $item[$name]['proofs'] = [
                        'href' => $this->_urlBuilder->getUrl('grid/grid/proofs',['id' => $item['entity_id']]),
                        'label' => __('Proofs'),
						'class' => 'proof-button'
                    ];
					// $item[$this->getData('name')]  = "<a href='".$this->_urlBuilder->getUrl('grid/grid/proofs',['id' => $item['entity_id']])."' class='proof-button'>Proofs</a><a class='proof-button'>Assign</a>";
                }
            }
        }
         return $dataSource;
    }
}
