<?php

namespace Drupal\gyocf_visualization\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the goal entity class.
 *
 * @ContentEntityType(
 *   id = "gyocf_goal",
 *   label = @Translation("Goal"),
 *   label_collection = @Translation("Goals"),
 *   label_singular = @Translation("goal"),
 *   label_plural = @Translation("goals"),
 *   label_count = @PluralTranslation(
 *     singular = "@count goals",
 *     plural = "@count goals",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\gyocf_visualization\GoalListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\gyocf_visualization\Form\GoalForm",
 *       "edit" = "Drupal\gyocf_visualization\Form\GoalForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "gyocf_goal",
 *   admin_permission = "administer gyocf goal",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "id",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/gyocf-goal",
 *     "add-form" = "/gyocf/goal/add",
 *     "canonical" = "/gyocf/goal/{gyocf_goal}",
 *     "edit-form" = "/gyocf/goal/{gyocf_goal}/edit",
 *     "delete-form" = "/gyocf/goal/{gyocf_goal}/delete",
 *   },
 *   field_ui_base_route = "entity.gyocf_goal.settings",
 * )
 */
class Goal extends ContentEntityBase {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['remote_id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Remote id'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'number',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'number_integer',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('view', FALSE);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('title'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', FALSE);

    return $fields;
  }

}
