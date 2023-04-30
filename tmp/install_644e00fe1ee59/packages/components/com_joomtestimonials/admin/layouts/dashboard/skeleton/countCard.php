<?php
/**
* @package		JoomProject
* @copyright	2013-2019 JoomBoost, joomboost.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

extract($displayData);

$title = isset($countTitle) ? $countTitle : $title;

?>

<div class="col-6 col-sm-6 col-md-3 col-lg-4 mb-2">
	<div class="shadow-sm card overflow-hidden">
		<a class="text-decoration-none" href="<?php echo $link; ?>" title="<?php echo JText::_($title) ?>">
			<div class="container m-0 p-0">
            <div class="row">
				<div class="col-md-4 <?php echo $iconClass ?>  d-flex align-items-center justify-content-center p-2 ps-4">
					<i class="fas fa-<?php echo $iconName ?> fa-2x"></i>
				</div>
				<div class="col-md-8">
                    <div class="p-2 d-flex align-items-center">
                        <div class="d-inline-block <?php echo $countClass ?>  text-center text-md-start w-100">
                            <h2 class="m-0"><?php echo $count; ?></h2>
                            <h4 class="m-0 text-muted font-weight-light text-truncate"><?php echo JText::_($title) ?></h4>
                        </div>
                    </div>

				</div>
            </div>
			</div>
		</a>
	</div>
</div>