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


        public function featured($pks, $value = 0)
        {
            // Sanitize the ids.
            $pks = (array) $pks;
            JArrayHelper::toInteger($pks);
            if (empty($pks))
            {
                $this->setError(JText::_('COM_FOLIO_NO_ITEM_SELECTED'));
                return false;
            }
            try
            {
                $db = $this->getDbo();
                $db->setQuery('UPDATE #__folio' .' SET featured = ' . (int) $value .' WHERE id IN (' . implode(',', $pks) . ')'
                );
                $db->execute();
            }
            catch (Exception $e)
            {
                $this->setError($e->getMessage());
                return false;
            }
            $this->cleanCache();
            return true;

        }

    }