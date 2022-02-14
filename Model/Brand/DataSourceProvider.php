<?php declare(strict_types=1);

namespace Boolfly\Brand\Model\Brand;

use Magento\Ui\Component\Form;

class DataSourceProvider extends Form
{

    /**
     * @inheritdoc
     */
    public function getDataSourceData()
    {
        $data = $this->getContext()->getDataProvider()->getData();

        if (isset($data["ripe"])) {
            return [
                'data' => $data["ripe"]
            ];
        }

        return parent::getDataSourceData();
    }
}
