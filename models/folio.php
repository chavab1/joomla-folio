<?php

    defined('_JEXEC') or die;

    class FolioModelFolio extends JModelAdmin
    {
        protected $text_prefix = 'COM_FOLIO';

        public function getTable($type = 'Folio', $prefix = 'FolioTable', $config = array())
        {
            return JTable::getInstance($type, $prefix, $config);
        }

        public function getForm($data = array(), $loadData = true)
        {
            $app = JFactory::getApplication();

            $form = $this->loadForm('com_folio.folio', 'folio', array('control' => 'jform', 'load_data' => $loadData));

            if (empty($form))
            {
                return false;
            }

            return $form;
        }
        protected function loadFormData()
        {
            $data = JFactory::getApplication()->getUserState('com_folio.edit.folio.data', array());

            if (empty($data)) {
                $data = $this->getItem();
            }

            return $data;
        }
        protected function prepareTable($table)
        {
            $table->title = htmlspecialchars_decode($table->title,ENT_QUOTES);
        }

        /**
         * Make sure current user has permission to delete the node
         * @param mixed $record
         */
        protected function canDelete($record)
        {
            if (!empty($record->id))
            {
                if ($record->state != -2)
                {
                    return;
                }
                $user = JFactory::getUser();
                if ($record->catid)
                {
                    return $user->authorise('core.delete', 'com_folio.category.'.(int) $record->catid);
                }
                else{
                    return parent::canDelete($record);
                }
            }
        }

        /**
         * Make sure current user has permission to edit the state of a node
         * @param mixed $record
         * @return mixed
         */
        protected function canEditState($record)
        {
            $user = JFactory::getUser();

            if (!empty($record->catid))
            {
                return $user->authorise('core.edit.state', 'com_folio.category.'.(int) $record->catid);
            }
            else
            {
                return parent::canEditState($record);
            }
        }
    }