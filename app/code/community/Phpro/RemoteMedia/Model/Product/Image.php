<?php

class Phpro_RemoteMedia_Model_Product_Image extends Mage_Catalog_Model_Product_Image
{
    /**
     * Set filenames for base file and new file
     *
     * @param string $file
     * @return Mage_Catalog_Model_Product_Image
     */
    public function setBaseFile($file)
    {
        $file = Mage::helper('phpro_remotemedia')->fetchRemoteProductionImage($file);

        parent::setBaseFile($file);
    }

}
