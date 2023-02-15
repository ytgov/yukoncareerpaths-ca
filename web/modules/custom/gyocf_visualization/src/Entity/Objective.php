<?php

namespace Drupal\gyocf_visualization\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the objective entity class.
 *
 * @ContentEntityType(
 *   id = "gyocf_objective",
 *   label = @Translation("Objective"),
 *   label_collection = @Translation("Objectives"),
 *   label_singular = @Translation("objective"),
 *   label_plural = @Translation("objectives"),
 *   label_count = @PluralTranslation(
 *     singular = "@count objectives",
 *     plural = "@count objectives",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\gyocf_visualization\ObjectiveListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\gyocf_visualization\Form\ObjectiveForm",
 *       "edit" = "Drupal\gyocf_visualization\Form\ObjectiveForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "gyocf_objective",
 *   admin_permission = "administer gyocf objective",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "id",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/gyocf-objective",
 *     "add-form" = "/gyocf/objective/add",
 *     "canonical" = "/gyocf/objective/{gyocf_objective}",
 *     "edit-form" = "/gyocf/objective/{gyocf_objective}/edit",
 *     "delete-form" = "/gyocf/objective/{gyocf_objective}/delete",
 *   },
 *   field_ui_base_route = "entity.gyocf_objective.settings",
 * )
 */
class Objective extends ContentEntityBase {

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

    $fields['goals'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Goals'))
      ->setDescription(t('list of goals'))
      ->setSetting('target_type', 'gyocf_goal')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', [
        'label'  => 'hidden',
        'type'   => 'string',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', FALSE)
      ->setDisplayOptions('form', [
        'type'     => 'entity_reference_autocomplete',
        'weight'   => 20,
        'settings' => [
          'match_operator'    => 'CONTAINS',
          'size'              => '60',
          'autocomplete_type' => 'tags',
          'placeholder'       => '',
        ],
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED);

    return $fields;
  }

}
