<?php

namespace Drupal\gyocf_visualization\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the indicator entry entity edit forms.
 */
class IndicatorEntryForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);

    $entity = $this->getEntity();

    $message_arguments = ['%label' => $entity->toLink()->toString()];
    $logger_arguments = [
      '%label' => $entity->label(),
      'link' => $entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New indicator entry %label has been created.', $message_arguments));
        $this->logger('gyocf_visualization')->notice('Created new indicator entry %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The indicator entry %label has been updated.', $message_arguments));
        $this->logger('gyocf_visualization')->notice('Updated indicator entry %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.gyocf_indicator_entry.canonical', ['gyocf_indicator_entry' => $entity->id()]);

    return $result;
  }

}
