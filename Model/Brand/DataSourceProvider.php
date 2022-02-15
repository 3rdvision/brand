<?php declare(strict_types=1);

namespace Boolfly\Brand\Model\Brand;

use Magento\Ui\Component\Form;

class DataSourceProvider extends Form {
    /**
     * @inheritdoc
     */
    public function getDataSourceData() {
        $data = $this->getContext()->getDataProvider()->getData();

        if (isset($data["custom"])) {
            return [
                'data' => $data["custom"]
            ];
        }

        return parent::getDataSourceData();
    }
}
