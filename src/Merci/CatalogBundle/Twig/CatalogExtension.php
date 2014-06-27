<?php

namespace Merci\CatalogBundle\Twig;

class CatalogExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('image_path', array($this, 'imagePath')),
        );
    }

    /**
     * $sizes: 1 = small, 2 = medium, 3 = big
     */
    public function imagePath($name, $size = 2, $format = 'jpg')
    {
        return $renderPath = '/bundles/mercicatalog/images/'.$name.'-'.$size.'.'.$format;
    }

    public function getName()
    {
        return 'catalog_extension';
    }
}