<?php

    defined('_JEXEC') or die;

    
    /**
     * View for Folio Preview
     */
    class FolioControllerPreview extends JControllerAdmin
    {
        /**
         * Connects with FolioModelPreview model
         * @param mixed $name 
         * @param mixed $prefix 
         * @param mixed $config 
         * @return mixed
         */
        public function getModel($name = 'Preview', $prefix = 'FolioModel', $config = array('ignore_request' => true))
        {
            $model = parent::getModel($name, $prefix, $config);
            return $model;
        }
    }
