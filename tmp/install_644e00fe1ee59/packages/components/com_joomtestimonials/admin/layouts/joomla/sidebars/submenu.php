<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2012 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\Filter\OutputFilter;

HTMLHelper::_('behavior.core');
JFactory::getDocument()->addStyleDeclaration('

    .j-toggle-button-wrapper {
        z-index: 999;
    }
    
    .j-toggle-button-wrapper {
    position: absolute;
    display: block; 
    top: 16px !important;
    padding: 0;
    }
    
    .j-toggle-button-wrapper.hidden{
     left: -25px !important;
    }
    
    .j-toggle-transition {
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease;
    }
    
    .j-toggle-button-wrapper.visible {
    top: 16px !important;
    right: 0px !important;
    }
    
    
');

JFactory::getDocument()->addScriptDeclaration('
	jQuery(document).ready(function($)
	{
	toggleSidebar = function(force)
	{
		var context = \'jsidebar\';

		var $sidebar = $(\'#sidebar\'),
		    $sidebarContainer = $("#j-sidebar-container"),
			$main = $(\'#j-main-container\'),
			$message = $(\'#system-message-container\'),
			$debug = $(\'#system-debug\'),
			$toggleSidebarIcon = $(\'#j-toggle-sidebar-icon\'),
			$toggleButtonWrapper = $(\'#j-toggle-button-wrapper\'),
			$toggleButton = $(\'#j-toggle-sidebar-button\'),
			$sidebarToggle = $(\'#j-toggle-sidebar\');

		var openIcon = \'icon-arrow-left-2\',
			closedIcon = \'icon-arrow-right-2\';

		var $visible = $sidebarToggle.is(":visible");

		if (jQuery(document.querySelector("html")).attr(\'dir\') == \'rtl\')
		{
			openIcon = \'icon-arrow-right-2\';
			closedIcon = \'icon-arrow-left-2\';
		}

		var isComponent = $(\'body\').hasClass(\'component\');

	    //$sidebar.removeClass(\'col-md-2\').addClass(\'j-sidebar-container\');
		$message.addClass(\'j-toggle-main\');
		$main.addClass(\'j-toggle-main\');
		if (!isComponent) {
			$debug.addClass(\'j-toggle-main\');
		}

		var mainHeight = $main.outerHeight()+30,
			sidebarHeight = $sidebar.outerHeight(),
			bodyWidth = $(\'body\').outerWidth(),
			sidebarWidth = $sidebar.outerWidth(),
			contentWidth = $(\'#content\').outerWidth(),
			contentWidthRelative = contentWidth / bodyWidth * 100,
			mainWidthRelative = (contentWidth - sidebarWidth) / bodyWidth * 100;

		if (force)
		{
			// Load the value from localStorage
			if (typeof(Storage) !== "undefined")
			{
				$visible = localStorage.getItem(context);
			}

			// Need to convert the value to a boolean
			$visible = ($visible == \'true\');
		}
		else
		{
			$message.addClass(\'j-toggle-transition\');
			$sidebar.addClass(\'j-toggle-transition\');
			$toggleButtonWrapper.addClass(\'j-toggle-transition\');			
			if (!isComponent) {
				$debug.addClass(\'j-toggle-transition\');
			}
		}

		if ($visible)
		{
			$sidebarToggle.hide();
			$sidebarContainer.removeClass(\'col-md-2\').addClass(\'container\');
			$sidebar.removeClass(\'visible\').addClass(\'hidden\');
			$toggleButtonWrapper.removeClass(\'visible\').addClass(\'hidden\');
			$toggleSidebarIcon.removeClass(\'visible\').addClass(\'visible\');
			$message.removeClass(\'col-md-10\').addClass(\'col-md-12\');
			$main.removeClass(\'col-md-10\').addClass(\'col-md-12 expanded\');
			$toggleSidebarIcon.removeClass(openIcon).addClass(closedIcon);
			$toggleButton.attr( \'data-original-title\', Joomla.JText._(\'JTOGGLE_SHOW_SIDEBAR\') );
			$sidebar.attr(\'aria-hidden\', true);
			$sidebar.find(\'a\').attr(\'tabindex\', \'-1\');
			$sidebar.find(\':input\').attr(\'tabindex\', \'-1\');

			if (!isComponent) {
				$debug.css( \'width\', contentWidthRelative + \'%\' );
			}

			if (typeof(Storage) !== "undefined")
			{
				// Set the last selection in localStorage
				localStorage.setItem(context, true);
			}
			$toggleButton.attr("title", "Show component sidebar");
		}
		else
		{
			$sidebarToggle.show();
			$sidebarContainer.removeClass(\'container\').addClass(\'col-md-2\');
			$sidebar.removeClass(\'hidden\').addClass(\'visible\');
			$toggleButtonWrapper.removeClass(\'hidden\').addClass(\'visible\');
			$toggleSidebarIcon.removeClass(\'hidden\').addClass(\'visible\');
			$message.removeClass(\'col-md-12\').addClass(\'col-md-10\');
			$main.removeClass(\'col-md-12 expanded\').addClass(\'col-md-10\');
			$toggleSidebarIcon.removeClass(closedIcon).addClass(openIcon);
			$toggleButton.attr( \'data-original-title\', Joomla.JText._(\'JTOGGLE_HIDE_SIDEBAR\') );
			$sidebar.removeAttr(\'aria-hidden\');
			$sidebar.find(\'a\').removeAttr(\'tabindex\');
			$sidebar.find(\':input\').removeAttr(\'tabindex\');

			if (!isComponent && bodyWidth > 768 && mainHeight < sidebarHeight)
			{
				$debug.css( \'width\', mainWidthRelative + \'%\' );
			}
			else if (!isComponent)
			{
				$debug.css( \'width\', contentWidthRelative + \'%\' );
			}

			if (typeof(Storage) !== "undefined")
			{
				// Set the last selection in localStorage
				localStorage.setItem( context, false );
			}
			$toggleButton.attr("title", "Hide component sidebar");
		}
	}
	
    });
');

JFactory::getDocument()->addScriptDeclaration('
	jQuery(document).ready(function($)
	{
		if (window.toggleSidebar)
		{
			jQuery("#j-toggle-button-wrapper").addClass("visible");
			jQuery("#j-toggle-sidebar-icon").addClass("visible");
		}
		else
		{
			$("#j-toggle-sidebar-header").css("display", "none");
			$("#j-toggle-button-wrapper").css("display", "none");
		}
		
		if(!jQuery("#wrapper").hasClass("closed")){
		    jQuery("#wrapper").addClass("closed");		
		}
	});
');
?>
<?php if ($displayData->displayMenu || $displayData->displayFilters) : ?>
    <div id="j-toggle-sidebar-wrapper">
        <div id="j-toggle-button-wrapper" class="j-toggle-button-wrapper">
            <?php echo JLayoutHelper::render('joomla.sidebars.toggle'); ?>
        </div>
        <div id="sidebar" class="sidebar">
            <div class="sidebar-nav ps-0">
                <?php if ($displayData->displayMenu) : ?>
                    <ul class="nav flex-column">
                        <?php foreach ($displayData->list as $item) :
                            if (isset ($item[2]) && $item[2] == 1) : ?>
                                <li class="active">
                            <?php else : ?>
                                <li>
                            <?php endif;
                            if ($displayData->hide) : ?>
                                <a class="nolink"><?php echo $item[0]; ?></a>
                            <?php else :
                                if ($item[1] !== '') : ?>
                                    <a href="<?php echo OutputFilter::ampReplace($item[1]); ?>"><?php echo $item[0]; ?></a>
                                <?php else : ?>
                                    <?php echo $item[0]; ?>
                                <?php endif;
                            endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <?php if ($displayData->displayMenu && $displayData->displayFilters) : ?>
                    <hr>
                <?php endif; ?>
                <?php if ($displayData->displayFilters) : ?>
                    <div class="filter-select d-none d-md-block">
                        <h4 class="page-header"><?php echo Text::_('JSEARCH_FILTER_LABEL'); ?></h4>
                        <?php foreach ($displayData->filters as $filter) : ?>
                            <label for="<?php echo $filter['name']; ?>" class="visually-hidden"><?php echo $filter['label']; ?></label>
                            <select name="<?php echo $filter['name']; ?>" id="<?php echo $filter['name']; ?>" class="form-select" onchange="this.form.submit()">
                                <?php if (!$filter['noDefault']) : ?>
                                    <option value=""><?php echo $filter['label']; ?></option>
                                <?php endif; ?>
                                <?php echo $filter['options']; ?>
                            </select>
                            <hr>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div id="j-toggle-sidebar"></div>
    </div>
<?php endif; ?>
