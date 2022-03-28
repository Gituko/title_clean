<?php

namespace Drupal\title_clean\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class TitleCleanForm.
 */
class TitleCleanForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'title_clean_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
//    $form['checkbox_clean'] = [
//      '#type' => 'checkbox',
//      '#title' => $this->t('checkbox'),
//      '#weight' => '0',
//    ];

    $node_types = \Drupal\node\Entity\NodeType::loadMultiple();
    // If you need to display them in a drop down:
    $options = [];
    foreach ($node_types as $node_type) {
      //$options[$node_type->id()] = $node_type->label();



      $form[$node_type->id()] = [
        '#type' => 'checkbox',
        '#title' => $this->t($node_type->label()),
        '#description' => $this->t('Clean all titles in ' . $node_type->label()),
      ];
    }




    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Clean Titles'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    foreach ($form_state->getValues() as $key => $value) {
      // @TODO: Validate fields.
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {


    // Display result.
    foreach ($form_state->getValues() as $key => $value) {

      if (empty($form_state['values'])) {
        //Get node title value
        $n_title = $entity->getTitle();

        //Remove any character that isn't A-Z,' ', a-z or 0-9.
        $clean_title = preg_replace("/[^A-Za-z0-9 ]/", '', $n_title);

        //Set Clean title
        $entity->setTitle($clean_title);

      }

    }
  }

}
