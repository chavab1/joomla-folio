<?php
    defined('_JEXEC') or die;
    $listOrder = $this->escape($this->state->get('list.ordering'));
    $listDirn = $this->escape($this->state->get('list.direction'));
?>

<form action="<?php echo JRoute::_('index.php?option=com_ folio&view=folios'); ?>" method="post" name="adminForm" id="adminForm">
    <div id="j-main-container" class="span10">
        <div class="clearfix"></div>
        <table class="table table-striped" id="folioList">
            <thead>
                <tr>
                    <th width="1%" class="hidden-phone">
                        <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
                    </th>
                    <th class="title">
                        <?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
                    </th>
                    <th width="25%" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'COM_FOLIO_HEADING_COMPANY', 'a.company', $listDirn, $listOrder); ?>
                    </th>
                    <th width="1%" class="nowrap center hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->items as $i => $item) :  ?>
                <tr class="row<?php echo $i % 2; ?>">
                    <td class="center hidden-phone">
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                    </td>
                    <td class="nowrap has-context">
                        <a href="<?php echo  JRoute::_('index.php?option=com_folio&task= folio.edit&id='.(int) $item->id); ?>"><?php echo $this->escape($item->title); ?></a>
                    </td>
                    <td class="hidden-phone">
                        <?php echo $this->escape($item->company); ?>
                    </td>
                    <td class="center hidden-phone">
                        <?php echo (int) $item->id; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
            <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
            <?php  echo JHtml::_('form.token'); ?>
    </div>
</form>