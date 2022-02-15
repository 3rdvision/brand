<?php declare(strict_types=1);

namespace Boolfly\Brand\Model;

use Magento\Framework\HTTP\Client\Curl;

class DataProviderr extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider {

    /**
     * Get data
     *
     * @return array
     */
    public function getData() {
        $curlClient = new Curl();
        $curlClient->get("https://ca52-2001-818-e77e-1900-dd13-da44-f41d-bd27.ngrok.io/api/stores/magento.test");
        $result = $curlClient->getBody();
        return array(
            "custom" => json_decode($result, True)
        );
    }

}
