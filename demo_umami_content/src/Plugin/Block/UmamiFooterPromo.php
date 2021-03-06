<?php

namespace Drupal\demo_umami_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Promo banner' block for footer.
 *
 * @Block(
 *   id = "umami_footer_promo",
 *   admin_label = @Translation("Umami Bundle")
 * )
 */
class UmamiFooterPromo extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'label_display' => FALSE,
      'promo_title' => '',
      'promo_text' => '',
      'findmore_url' => '',
      'findmore_text' => '',
    ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#type' => 'inline_template',
      '#template' => '<h2 class="footer-promo__title">{{ promo_title }}</h2><p class="footer-promo__text">{{ promo_text }} {% if findmore_url %} <a href="{{ findmore_url }}">{{ findmore_text }}</a> {% endif %}</p>',
      '#context' => [
        'promo_title' => $this->configuration['promo_title'],
        'promo_text' => $this->configuration['promo_text'],
        'findmore_url' => $this->configuration['findmore_url'],
        'findmore_text' => $this->configuration['findmore_text'],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $form['promo_title'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Promo Title'),
      '#default_value' => $this->configuration['promo_title'],
    );

    $form['promo_text'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Promo Text'),
      '#default_value' => $this->configuration['promo_text'],
    );

    $form['findmore'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Find more'),
    );

    $form['findmore']['url'] = array(
      '#type' => 'url',
      '#title' => $this->t('URL'),
      '#default_value' => $this->configuration['findmore_url'],
      '#description' => $this->t('Enter an absolute url. Eg: https://www.drupal.org'),
    );

    $form['findmore']['text'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Text'),
      '#default_value' => $this->configuration['findmore_text'],
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);

    $this->configuration['promo_title'] = $form_state->getValue('promo_title');
    $this->configuration['promo_text'] = $form_state->getValue('promo_text');
    $this->configuration['findmore_url'] = $form_state->getValue(['findmore', 'url']);
    $this->configuration['findmore_text'] = $form_state->getValue(['findmore', 'text']);
  }

}
