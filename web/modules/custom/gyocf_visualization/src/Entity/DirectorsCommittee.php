<?php

namespace Drupal\gyocf_visualization\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the directors committee entity class.
 *
 * @ContentEntityType(
 *   id = "gyocf_directors_committee",
 *   label = @Translation("Directors Committee"),
 *   label_collection = @Translation("Directors Committees"),
 *   label_singular = @Translation("directors committee"),
 *   label_plural = @Translation("directors committees"),
 *   label_count = @PluralTranslation(
 *     singular = "@count directors committees",
 *     plural = "@count directors committees",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\gyocf_visualization\DirectorsCommitteeListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\gyocf_visualization\Form\DirectorsCommitteeForm",
 *       "edit" = "Drupal\gyocf_visualization\Form\DirectorsCommitteeForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "gyocf_directors_committee",
 *   admin_permission = "administer gyocf directors committee",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "id",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/gyocf-directors-committee",
 *     "add-form" = "/gyocf/directors-committee/add",
 *     "canonical" = "/gyocf/directors-committee/{gyocf_directors_committee}",
 *     "edit-form" = "/gyocf/directors-committee/{gyocf_directors_committee}/edit",
 *     "delete-form" = "/gyocf/directors-committee/{gyocf_directors_committee}/delete",
 *   },
 *   field_ui_base_route = "entity.gyocf_directors_committee.settings",
 * )
 */
class DirectorsCommittee extends ContentEntityBase {

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

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('name'))
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
