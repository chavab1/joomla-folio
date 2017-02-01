<?php

    // no direct access
    defined('_JEXEC') or die;

    class FolioModelFolios extends JModelList
    {
        public function __construct($config = array())
        {
            if (empty($config['filter_fields']))
            {
                $config['filter_fields'] = array('id', 'a.id','title', 'a.title');
            } // End if (empty($config['filter_fields']))

            parent::__construct($config);
        }

        protected function getListQuery()
        {
            $db = $this->getDbo();
            $query  = $db->getQuery(true);
            $query->select($this->getState('list.select', 'a.id, a.title'));
            $query->from($db->quoteName('#__folio').' AS a');

            return $query;
        }
    }