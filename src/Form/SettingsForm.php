<?php

namespace Drupal\random_quote\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Random Quote settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'random_quote_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['random_quote.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API url'),
      '#default_value' => $this->config('random_quote.settings')->get('url'),
    ];
    $form['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API key'),
      '#default_value' => $this->config('random_quote.settings')->get('api_key'),
    ];
    $form['category'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Quote category'),
      '#default_value' => $this->config('random_quote.settings')->get('category'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('url') == '') {
      $form_state->setErrorByName('url', $this->t('The value is not correct. You need API link'));
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('random_quote.settings')
      ->set('url', $form_state->getValue('url'))
      ->set('api_key', $form_state->getValue('api_key'))
      ->set('category', $form_state->getValue('category'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
