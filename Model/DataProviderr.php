<?php declare(strict_types=1);

namespace Boolfly\Brand\Model;

class DataProviderr extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return json_decode('{"ripe":{"entity_id":"1","name":"Testy brand","url_key":"testy","description":"<style>#html-body [data-pb-style=MN79ABI]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}<\/style><div data-mspdevtools-ui=\"72acddf4853203928d67f71b89a6d621\" data-content-type=\"row\" data-appearance=\"contained\" data-element=\"main\"><div data-enable-parallax=\"0\" data-parallax-speed=\"0.5\" data-background-images=\"{}\" data-background-type=\"image\" data-video-loop=\"true\" data-video-play-only-visible=\"true\" data-video-lazy-load=\"true\" data-video-fallback-src=\"\" data-element=\"inner\" data-pb-style=\"MN79ABI\"><\/div><\/div>","visibility":"1","image":[{"name":"wallhaven-dpo38l.jpg","url":"https:\/\/magento.test\/media\/catalog\/brand\/wallhaven-dpo38l.jpg","size":1344739,"type":"image\/jpeg"}]}}', true);
    }

}
