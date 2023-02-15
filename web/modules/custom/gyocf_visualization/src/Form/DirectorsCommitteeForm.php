<?php

namespace Drupal\gyocf_visualization\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the directors committee entity edit forms.
 */
class DirectorsCommitteeForm extends ContentEntityForm {

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
        $this->messenger()->addStatus($this->t('New directors committee %label has been created.', $message_arguments));
        $this->logger('gyocf_visualization')->notice('Created new directors committee %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The directors committee %label has been updated.', $message_arguments));
        $this->logger('gyocf_visualization')->notice('Updated directors committee %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.gyocf_directors_committee.canonical', ['gyocf_directors_committee' => $entity->id()]);

    return $result;
  }

}
