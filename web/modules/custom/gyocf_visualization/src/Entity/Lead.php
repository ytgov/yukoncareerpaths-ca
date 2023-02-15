<?php

namespace Drupal\gyocf_visualization\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the lead entity class.
 *
 * @ContentEntityType(
 *   id = "gyocf_lead",
 *   label = @Translation("Lead"),
 *   label_collection = @Translation("Leads"),
 *   label_singular = @Translation("lead"),
 *   label_plural = @Translation("leads"),
 *   label_count = @PluralTranslation(
 *     singular = "@count leads",
 *     plural = "@count leads",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\gyocf_visualization\LeadListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\gyocf_visualization\Form\LeadForm",
 *       "edit" = "Drupal\gyocf_visualization\Form\LeadForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "gyocf_lead",
 *   admin_permission = "administer gyocf lead",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "id",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/gyocf-lead",
 *     "add-form" = "/goycf/lead/add",
 *     "canonical" = "/goycf/lead/{gyocf_lead}",
 *     "edit-form" = "/goycf/lead/{gyocf_lead}/edit",
 *     "delete-form" = "/goycf/lead/{gyocf_lead}/delete",
 *   },
 *   field_ui_base_route = "entity.gyocf_lead.settings",
 * )
 */
class Lead extends ContentEntityBase {

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

    $fields['organization'] = BaseFieldDefinition::create('string')
      ->setLabel(t('organization'))
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

    $fields['department'] = BaseFieldDefinition::create('string')
      ->setLabel(t('department'))
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

    $fields['branch'] = BaseFieldDefinition::create('string')
      ->setLabel(t('branch'))
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
