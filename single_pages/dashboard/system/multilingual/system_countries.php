<?php

defined('C5_EXECUTE') or die('Access Denied.');

/** @var \Concrete\Core\View\View $view */
/** @var \Concrete\Core\Validation\CSRF\Token $token */
/** @var \Concrete\Core\Form\Service\Form $form */
$country_codes = $country_codes ?? [];
?>
    <form action="<?= $view->action('add') ?>" method="post" class="form-inline">
        <?php $token->output('add_system_countries'); ?>
        <fieldset>
            <legend><?= t('Additional country codes') ?></legend>
            <?= $form->label('tag', t('Country Tag')) ?>
            <?= $form->text('tag', ['placeholder' => 'US-x-twain']) ?>
            <?= $form->label('label', t('Country Label')) ?>
            <?= $form->text('label', ['placeholder' => 'Written by Mark Twain']) ?>
            <?= $form->submit('submit', t('Add'), ['class' => 'btn-primary']) ?>
        </fieldset>
    </form>
    <p><?= t('Additional country codes can be used as region subtags, variant subtags, extension subtags, private-use subtags, or combination of subtags.') ?></p>
    <p><?= t('Ref: %sW3C: Understanding the New Language Tags%s', '<a href="https://www.w3.org/International/articles/bcp47/" target="_blank">', '</a>') ?></p>
<?php
if (count($country_codes) > 0) {
    ?>
    <h4 style="margin-top: 3em"><?= t('Registered additional country codes') ?></h4>
    <table class="table">
        <thead>
        <tr>
            <th><?= t('Country Tag') ?></th>
            <th><?= t('Country Label') ?></th>
            <th><?= t('Remove') ?></th>
        </tr>
        </thead>
        <?php foreach ($country_codes as $country_code => $country_label) { ?>
            <tr>
                <td><?= h($country_code) ?></td>
                <td><?= h($country_label) ?></td>
                <td>
                    <a href="<?= $view->action('delete', $country_code, $token->generate('delete_system_country')) ?>">
                        <i class="fa fa-trash"></i>
                    </a></td>
            </tr>
        <?php } ?>
    </table>
    <?php
}
