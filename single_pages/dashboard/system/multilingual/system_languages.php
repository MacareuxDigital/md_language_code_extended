<?php

defined('C5_EXECUTE') or die('Access Denied.');

/** @var \Concrete\Core\View\View $view */
/** @var \Concrete\Core\Validation\CSRF\Token $token */
/** @var \Concrete\Core\Form\Service\Form $form */

$exclude_country_specific = $exclude_country_specific ?? null;
$exclude_script_specific = $exclude_script_specific ?? null;
?>
<form action="<?= $view->action('submit') ?>" method="post">
    <?php $token->output('update_system_languages'); ?>

    <div class="form-group">
        <div class="checkbox form-check">
            <label>
                <?= $form->checkbox('exclude_country_specific', 1, $exclude_country_specific) ?>
                <?= t('Exclude Country Specific Languages') ?>
            </label>
            <div class="help-block form-text"><?= t('Exclude Country-specific languages (eg "U.S. English" in addition to "English")') ?></div>
        </div>
    </div>

    <div class="form-group">
        <div class="checkbox form-check">
            <label>
                <?= $form->checkbox('exclude_script_specific', 1, $exclude_script_specific) ?>
                <?= t('Exclude Script Specific Languages') ?>
            </label>
            <div class="help-block form-text"><?= t('Exclude Script-specific languages (eg "Simplified Chinese" in addition to "Chinese")') ?></div>
        </div>
    </div>

    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <button type="submit" class="btn btn-primary float-end pull-right">
                <?php echo t('Save') ?>
            </button>
        </div>
    </div>
</form>