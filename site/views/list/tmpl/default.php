<?php
// No direct access 
defined('_JEXEC') or die('Restricted access');

if ($this->params->get('show_page_title', 1)) :
    ?>
    <div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
        <?php echo $this->params->get('page_title'); ?>
    </div>
<?php endif; ?>

<div class="<?php echo $this->params->get('css_class') . " " . $this->escape($this->params->get('pageclass_sfx')); ?>">
    <?php echo $this->formatted_result_text; ?>
</div>

<?php if (isset($this->backlink)) { ?>
    <div class="backlink"><a href="<?php echo $this->backlink ?>">Zpět</a></div>
<?php } ?>
