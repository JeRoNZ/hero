<?php  defined("C5_EXECUTE") or die("Access Denied."); ?>

<div class="form-group">
    <?php 
    if (isset($image) && $image > 0) {
        $image_o = File::getByID($image);
        if (!$image_o || $image_o->isError()) {
            unset($image_o);
        }
    } ?>
    <?php  echo $form->label('image', t("Image") . ' <i class="fa fa-question-circle launch-tooltip" data-original-title="' . t("PNG Image with transparent background") . '"></i>'); ?>
    <?php  echo isset($btFieldsRequired) && in_array('image', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo Core::make("helper/concrete/asset_library")->image('ccm-b-hero-image-' . Core::make('helper/validation/identifier')->getString(18), $view->field('image'), t("Choose Image"), $image_o); ?>
</div>

<div class="form-group">
    <?php  echo $form->label('title', t("Title")); ?>
    <?php  echo isset($btFieldsRequired) && in_array('title', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo $form->text($view->field('title'), $title, array (
  'maxlength' => 255,
  'placeholder' => 'Machine title',
)); ?>
</div>


<div class="form-group">
    <?php  echo $form->label('blurb', t("Blurb")); ?>
    <?php  echo isset($btFieldsRequired) && in_array('blurb', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo Core::make('editor')->outputBlockEditModeEditor($view->field('blurb'), $blurb); ?>
</div>

<div class="form-group">
    <?php  echo $form->label('page', t("Page Link")); ?>
    <?php  echo isset($btFieldsRequired) && in_array('page', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
    <?php  echo Core::make("helper/form/page_selector")->selectPage($view->field('page'), $page); ?>
</div>

<!--<div class="form-group">-->
<!--	--><?php // echo $form->label('page_text', t("Page Link") . " " . t("Text")); ?>
<!--    --><?php // echo $form->text($view->field('page_text'), $page_text, array()); ?>
<!--</div>-->

<p>- Or -</p>

<div class="form-group">
	<?php  echo $form->label('url', t("External URL")); ?>
	<?php  echo $form->text($view->field('url'), $url, array()); ?>
</div>

<p>- Or -</p>

<?php $file_1_o = null;
if ($file_1 > 0) {
	$file_1_o = File::getByID($file_1);
} ?>
<div class="form-group">
	<?php echo $form->label($view->field('file_1'), t("File")); ?>
	<?php echo isset($btFieldsRequired) && in_array('file_1', $btFieldsRequired) ? '<small class="required">' . t('Required') . '</small>' : null; ?>
	<?php echo Core::make("helper/concrete/asset_library")->file('ccm-b-file-file_1-' . $identifier_getString, $view->field('file_1'), t("Choose File"), $file_1_o); ?>
</div>
<!--<div class="form-group">-->
<!--	--><?php //echo $form->label($view->field('file_1_title'), t("File") . " " . t("Title")); ?>
<!--	--><?php //echo $form->text($view->field('file_1_title'), $file_1_title, array (
//		'maxlength' => 255,
//		'placeholder' => NULL,
//	)); ?>
<!--</div>-->
