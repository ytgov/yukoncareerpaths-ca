<?php

namespace Drupal\gyocf_visualization\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure GYOCF Custom settings for this site.
 */
class GyocfSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'gyocf_visualization_gyocf_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['gyocf_visualization.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Api key'),
      '#default_value' => $this->config('gyocf_visualization.settings')->get('api_key'),
    ];
    $form['request_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Request Url'),
      '#default_value' => $this->config('gyocf_visualization.settings')->get('request_url'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {}

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('gyocf_visualization.settings')
      ->set('api_key', $form_state->getValue('api_key'))
      ->set('request_url', $form_state->getValue('request_url'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
