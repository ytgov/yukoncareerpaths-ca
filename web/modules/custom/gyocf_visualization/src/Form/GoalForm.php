<?php

namespace Drupal\gyocf_visualization\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the goal entity edit forms.
 */
class GoalForm extends ContentEntityForm {

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
        $this->messenger()->addStatus($this->t('New goal %label has been created.', $message_arguments));
        $this->logger('gyocf_visualization')->notice('Created new goal %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The goal %label has been updated.', $message_arguments));
        $this->logger('gyocf_visualization')->notice('Updated goal %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.gyocf_goal.canonical', ['gyocf_goal' => $entity->id()]);

    return $result;
  }

}
