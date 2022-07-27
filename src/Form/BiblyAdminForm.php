<?php

namespace Drupal\bibly\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Path\PathValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * The settings form for bibly.
 *
 * @package Drupal\bibly
 */
class BiblyAdminForm extends ConfigFormBase {

  /**
   * Drupal\Core\Config\ConfigFactory definition.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;

  /**
   * Drupal\Core\Path\PathValidator definition.
   *
   * @var \Drupal\Core\Path\PathValidator
   */
  protected $pathValidator;

  /**
   * Constructs a new AjaxSettingsForm object.
   *
   * @param \Drupal\Core\Config\ConfigFactory $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\Core\Path\PathValidator $path_validator
   *   The path validator.
   */
  public function __construct(ConfigFactory $config_factory, PathValidator $path_validator) {
    parent::__construct($config_factory);
    $this->configFactory = $config_factory;
    $this->pathValidator = $path_validator;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('path.validator')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'bibly.bibly_location',
      'bibly.bibly_linkVersion',
      'bibly.bibly_enablePopups',
      'bibly.bibly_classname',
      'bibly.bibly_startNodeId',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'bibly_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->configFactory->getEditable('bibly.settings');

    $form['bibly_linkVersion'] = [
      '#type' => 'select',
      '#title' => $this->t('Linked version'),
      '#default_value' => $config->get('bibly_linkVersion'),
      '#options' => [
        '' => $this->t('None'),
        'ESV' => $this->t('ESV - English Standard Version'),
        'HCSB' => $this->t('HCSB - Holman Christian Standard Bible'),
        'KJV' => $this->t('KJV - King James Version'),
        'NASB' => $this->t('NASB - New American Standard Version'),
        'NCV' => $this->t('NCV - New Century Version'),
        'NJKV' => $this->t('NKJV - New King James Version'),
        'NIV' => $this->t('NIV - New International Version'),
        'NET' => $this->t('NET - New English Translation'),
        'NLT' => $this->t('NLT - New Living Translation'),
        'MSG' => $this->t('MSG - The Message'),
      ],
      '#description' => $this->t('The version selected when a person clicks a link. Leave blank to let the user select a version.'),
    ];

    $form['bibly_enablePopups'] = [
      '#type' => 'radios',
      '#title' => $this->t('Enable popups'),
      '#default_value' => $config->get('bibly_enablePopups'),
      '#options' => [
        $this->t('No'),
        $this->t('YES'),
      ],
      '#description' => $this->t('Determines whether or not the Biblical text is shown in a hover box when a person mouses over a Bible link.'),
    ];

    $form['bibly_classname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Class name'),
      '#description' => $this->t('A class name for bible links.'),
      '#default_value' => $config->get('bibly_classname'),
    ];

    $form['bibly_startNodeId'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Start node ID'),
      '#description' => $this->t('The DOM ID of an element you want to limit bib.ly to checking. Leave blank to check the entire page (the &lt;body&gt; tag).'),
      '#default_value' => $config->get('bibly_startNodeId'),
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save configuration'),
      '#button_type' => 'primary',
    ];

    $form['#theme'] = 'system_config_form';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $config = $this->configFactory->getEditable('bibly.settings');
    $config
      ->set('bibly_location', $form_state->getValue('bibly_location'))
      ->set('bibly_linkVersion', $form_state->getValue('bibly_linkVersion'))
      ->set('bibly_enablePopups', $form_state->getValue('bibly_enablePopups'))
      ->set('bibly_classname', $form_state->getValue('bibly_classname'))
      ->set('bibly_startNodeId', $form_state->getValue('bibly_startNodeId'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
