<?php

namespace Drupal\travisci_api\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class TravisCiConfigForm.
 */
class TravisCiConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'travisci_api.travisciconfig',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'travis_ci_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('travisci_api.travisciconfig');
    $form['token'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Travis ci API token'),
      '#description' => $this->t('You’ll need the token to make most API requests.'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('token'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('travisci_api.travisciconfig')
      ->set('token', $form_state->getValue('token'))
      ->save();
  }

}
