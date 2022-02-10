<?php

namespace Magebit\Attributes\Block;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Block\Product\View\Description;

class Attributes extends Template
{
    public Description $description;

    public function __construct(
        Description      $description,
        Template\Context $context,
        array            $data = []
    )
    {
        parent::__construct($context, $data);
        $this->description = $description;
    }

    public function getThreeAttributes()
    {

        $_product = $this->description->getProduct();
        $getAllAttributes = $_product->getAttributes();

        foreach ($getAllAttributes as $a) {
            $allAttr[] = $a->getName();
        }

        $attributes = array("dimension", "color", "material");
        $otherAttributes = array_diff($allAttr, $attributes);
        $fullArray = $attributes + $otherAttributes;

        $count = 0;
        $i = 0;
        $threeAttribute = [];
        while ($count < 3 && $i < count($fullArray)) {
            $myAttr = $_product->getResource()->getAttribute($fullArray[$i]);
            if (!empty($myAttr->getStoreLabel()) && !empty($myAttr->getFrontend()->getValue($_product))) {
                $threeAttribute[] = [
                    'value' => $myAttr->getStoreLabel(),
                    'label' => $myAttr->getFrontend()->getValue($_product),
                ];
                $count++;
            }
            $i++;
        }
        return $threeAttribute;
    }

    public function showDesc(): ?string
    {
        $_product = $this->description->getProduct();
        $shortDescription = $_product->getShortDescription();
        if($shortDescription) {
            return $shortDescription;
        } else{
            return null;
        }
    }
}
