<?php

class Phpro_RemoteMedia_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Module enabed
     */
    const XML_PATH_REMOTE_MEDIA_ENABLED = 'dev/remote_media/enabled';

    /**
     * Brands frontend route
     */
    const XML_PATH_REMOTE_MEDIA_PRODUCTION_URL = 'dev/remote_media/production_media_url';

    /**
     * Check if we're supposed to try to catch the remote media
     *
     * @retrun bool
     */
    public function getRemoteMediaEnabled($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_REMOTE_MEDIA_ENABLED, $store);
    }

    /**
     * Get the production URL where the images should be fetched from
     *
     * @return bool
     */
    public function getProductionMediaUrl($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_REMOTE_MEDIA_PRODUCTION_URL, $store);
    }

    /**
     * @param $filename
     * @return bool
     */
    public function fetchRemoteProductionImage($filename)
    {
        if(!$this->getRemoteMediaEnabled() || $this->getProductionMediaUrl() == '' || $filename == '') {
            return false;
        }

        $relativeFilePath = '/catalog/product' . $filename;

        $productionMediaUrl = $this->getProductionMediaUrl().$relativeFilePath;
        $targetMediaFilePath = Mage::getBaseDir('media').$relativeFilePath;

        try {
            $mediaFile = file_get_contents($productionMediaUrl);

            if($mediaFile) {
                $this->writeMediaFile($targetMediaFilePath, $mediaFile);
            } else {
                return false;
            }

        } catch(Exception $e) {
            Mage::log("Unable to fetch and store remote production image: ".$e->getMessage());
            Mage::log($filename);
            return false;
        }

        return $filename;
    }

    /**
     * Fetch the media file from the remote production and write it to a file
     * @param $target
     * @param $source
     * @return bool
     * @throws Exception
     */
    public function writeMediaFile($target, $source)
    {
        $file = new Varien_Io_File();
        $targetDir = $file->getDestinationFolder($target);

        // Create directory and cd to folder
        $file->checkAndCreateFolder($targetDir);
        $file->cd($targetDir);

        try {
            $file->streamOpen($target);
            $file->streamWrite($source);
            $file->streamClose();
        }catch(Exception $e) {
            throw new Exception('Unable to write media file '.$e->getMessage());
        }

        return true;
    }
}
