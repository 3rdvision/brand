<?php declare(strict_types=1);

namespace Boolfly\Brand\Model\Brand;

use Boolfly\Brand\Model\Brand;
use Boolfly\Brand\Model\BrandFactory;
use Boolfly\Brand\Model\ResourceModel\Brand\Collection;
use Boolfly\Brand\Model\ResourceModel\Brand\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;

class DataProvider extends ModifierPoolDataProvider
{
    /**
     * @var File
     */
    private $fileInfo;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var BrandFactory
     */
    private $brandFactory;

    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param File $fileInfo
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param BrandFactory $brandFactory
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        File $fileInfo,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        BrandFactory $brandFactory,
        RequestInterface $request,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->fileInfo = $fileInfo;
        $this->request = $request;
        $this->brandFactory = $brandFactory;
        $this->dataPersistor = $dataPersistor;
        $this->collection = $collectionFactory->create();
        $this->collection->addFieldToSelect('*');
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * @return array
     * @throws LocalizedException
     */
    public function getData()
    {
        // debug code \/
        // $this->loadedData = json_decode('{"1":{"entity_id":"1","name":"Testy brand","url_key":"testy","description":"<style>#html-body [data-pb-style=MN79ABI]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}<\/style><div data-mspdevtools-ui=\"72acddf4853203928d67f71b89a6d621\" data-content-type=\"row\" data-appearance=\"contained\" data-element=\"main\"><div data-enable-parallax=\"0\" data-parallax-speed=\"0.5\" data-background-images=\"{}\" data-background-type=\"image\" data-video-loop=\"true\" data-video-play-only-visible=\"true\" data-video-lazy-load=\"true\" data-video-fallback-src=\"\" data-element=\"inner\" data-pb-style=\"MN79ABI\"><\/div><\/div>","visibility":"1","image":[{"name":"wallhaven-dpo38l.jpg","url":"https:\/\/magento.test\/media\/catalog\/brand\/wallhaven-dpo38l.jpg","size":1344739,"type":"image\/jpeg"}]}}', true);
        // debug code /\
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var Brand $brand */
        foreach ($items as $brand) {
            $brandData = $brand->getData();
            $brandData = $this->convertValues($brand, $brandData);
            $this->loadedData[$brand->getId()] = $brandData;
        }

        $data = $this->dataPersistor->get('bf_brand');
        if (!empty($data)) {
            $brand = $this->collection->getNewEmptyItem();
            $brand->setData($data);
            $this->loadedData[$brand->getId()] = $brand->getData();
            $this->dataPersistor->clear('bf_brand');
        }

        return $this->loadedData;
    }

    /**
     * Converts brand image data to acceptable for rendering format
     *
     * @param Brand $brand
     * @param array $brandData
     * @return array
     * @throws LocalizedException
     */
    private function convertValues($brand, $brandData)
    {
        $fileName = $brand->getData('image');
        $fileInfo = $this->getFileInfo();
        if ($fileName && $fileInfo->isFile($fileName)) {
            $stat = $fileInfo->getStat($fileName);
            $mime = $fileInfo->getMimeType($fileName);
            unset($brandData['image']);
            $brandData['image'][0]['name'] = basename($fileName);
            $brandData['image'][0]['url'] = $brand->getImageUrl();
            $brandData['image'][0]['size'] = isset($stat) ? $stat['size'] : 0;
            $brandData['image'][0]['type'] = $mime;
        } else {
            $brandData['image'] = null;
        }
        return $brandData;
    }

    /**
     * @return File
     */
    private function getFileInfo()
    {
        return $this->fileInfo;
    }
}
