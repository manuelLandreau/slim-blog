<?php

namespace App\Service;

use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Lookup;
use ApaiIO\Request\GuzzleRequest;
use GuzzleHttp\Client;
use Symfony\Component\VarDumper\VarDumper;

class AWSService
{
    /**
     * @return \ApaiIO\ApaiIO
     */
    static function getInstance()
    {
        $conf = new GenericConfiguration();
        $client = new Client();
        $request = new GuzzleRequest($client);
        $conf
            ->setCountry('fr')
            ->setAccessKey(getenv('AccessKey'))
            ->setSecretKey(getenv('SecretKey'))
            ->setAssociateTag(getenv('AssociateTag'))
            ->setRequest($request);
        return new ApaiIO($conf);
    }

    /**
     * @param string $asin
     * @return array
     */
    static function getProductInfo(string $asin): array
    {
        $lookup = new Lookup();
        $lookup->setItemId($asin);
        $lookup->setResponseGroup(array('Medium')); // More detailed information

        $response = self::getInstance()->runOperation($lookup);

        $parsed = \App\Service\XMLParser::xmlstr_to_array($response);

        VarDumper::dump($parsed);

        $productInfos['small_image'] = $parsed['Items']['Item']['SmallImage']['URL'];
        $productInfos['medium_image'] = $parsed['Items']['Item']['MediumImage']['URL'];
        $productInfos['large_image'] = $parsed['Items']['Item']['LargeImage']['URL'];
        $productInfos['description'] = $parsed['Items']['Item']['ItemAttributes']['Title'];
        $productInfos['price'] = $parsed['Items']['Item']['ItemAttributes']['ListPrice']['FormattedPrice'];
        $productInfos['content'] = $parsed['Items']['Item']['EditorialReviews']['EditorialReview']['Content'];
        $productInfos['title'] = $parsed['Items']['Item']['ItemAttributes']['Binding'] . ' ' .
            $parsed['Items']['Item']['ItemAttributes']['Brand'] . ' ' .
            $parsed['Items']['Item']['ItemAttributes']['color'] . ' ' .
            $parsed['Items']['Item']['ItemAttributes']['ClothingSize'];
        $productInfos['details'] = '';
        foreach ($parsed['Items']['Item']['ItemAttributes']['Feature'] as $detail) {
            $productInfos['details'] = $productInfos['details'] . '<p>' . $detail . '</p>';
        }
        foreach ($parsed['Items']['Item']['ImageSets']['ImageSet'] as $image) {
            $productInfos['image_set'] = $productInfos['image_set'] . '\n' . $image['SmallImage']['URL'];
        }

        return $productInfos;
    }
}