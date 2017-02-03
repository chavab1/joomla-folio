<?php

    defined('_JEXEC') or die;

    class FolioViewFolios extends JViewLegacy
    {
        protected $items;
        protected $state;
        protected $pagination;


        public function display($tpl = null)
        {
            //Retrieves Data
            $this->items = $this->get('Items');
            //Retrieves User State
            $this->state = $this->get('State');
            //Allows Backend Pagination
            $this->pagination = $this->get('Pagination');
            // Makes View Active in Submenu
            FolioHelper::addSubmenu('folios');

            if (count($errors = $this->get('Errors')))
            {
                JError::raiseError(500, implode("\n", $errors));

                return false;
            }
            $this->addToolbar();
            $this->sidebar = JHtmlSidebar::render();
            parent::display($tpl);
        }

        protected function addToolbar()
        {
            //Retrieves User State
            $state  = $this->get('State');
            //Checks to see what category is selected
            $canDo  = FolioHelper::getActions($state->get('filter.category_id'));
            //Retrieves current user
            $user  = JFactory::getUser();

            $bar = JToolBar::getInstance('toolbar');

            //Sets title name of Toolbar
            JToolbarHelper::title(JText::_('COM_FOLIO_MANAGER_FOLIOS'), '');

            // Display New button to allow current user to create a node only if authorized
            if (count($user->getAuthorisedCategories('com_folio', 'core.create')) > 0)
            {
                JToolbarHelper::addNew('folio.add');
            }

            if ($canDo->get('core.edit'))
            {
                JToolbarHelper::editList('folio.edit');
            }
            if ($canDo->get('core.admin'))
            {
                JToolbarHelper::preferences('com_folio');
            }
            if ($canDo->get('core.edit.state'))
            {
                JToolbarHelper::publish('folios.publish', 'JTOOLBAR_PUBLISH', true);
                JToolbarHelper::unpublish('folios.unpublish', 'JTOOLBAR_UNPUBLISH', true);

                JToolbarHelper::archiveList('folios.archive');
                JToolbarHelper::checkin('folios.checkin');
            }

            if ($state->get('filter.state') == -2 && $canDo->get('core.delete'))
            {
                JToolbarHelper::deleteList('', 'folios.delete', 'JTOOLBAR_EMPTY_TRASH');
            }
            elseif ($canDo->get('core.edit.state'))
            {
                JToolbarHelper::trash('folios.trash');
            }

            JHtmlSidebar::setAction('index.php?option=com_folio&view=folios');

            JHtmlSidebar::addFilter(JText::_('JOPTION_SELECT_PUBLISHED'), 'filter_state', JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true));
        }



        protected function getSortFields()
        {
            return array(
                'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
                'a.state' => JText::_('JSTATUS'),
                'a.title' => JText::_('JGLOBAL_TITLE'),
                'a.id' => JText::_('JGRID_HEADING_ID')
            );
        }
    }