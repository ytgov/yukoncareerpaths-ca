<?php

namespace Drupal\gyocf_visualization\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the indicator entity class.
 *
 * @ContentEntityType(
 *   id = "gyocf_indicator",
 *   label = @Translation("Indicator"),
 *   label_collection = @Translation("Indicators"),
 *   label_singular = @Translation("indicator"),
 *   label_plural = @Translation("indicators"),
 *   label_count = @PluralTranslation(
 *     singular = "@count indicators",
 *     plural = "@count indicators",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\gyocf_visualization\IndicatorListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\gyocf_visualization\Form\IndicatorForm",
 *       "edit" = "Drupal\gyocf_visualization\Form\IndicatorForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "gyocf_indicator",
 *   admin_permission = "administer gyocf indicator",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "id",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/gyocf-indicator",
 *     "add-form" = "/gyocf/indicator/add",
 *     "canonical" = "/gyocf/indicator/{gyocf_indicator}",
 *     "edit-form" = "/gyocf/indicator/{gyocf_indicator}/edit",
 *     "delete-form" = "/gyocf/indicator/{gyocf_indicator}/delete",
 *   },
 *   field_ui_base_route = "entity.gyocf_indicator.settings",
 * )
 */
class Indicator extends ContentEntityBase {

  use EntityChangedTrait;

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
        'weight' => -3,
      ])
      ->setDisplayConfigurable('view', FALSE);

    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Description'))
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'text_default',
        'label' => 'above',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setDescription(t('The time that the indicator was created.'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the indicator was last edited.'));

    $fields['collectionInterval'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Collection Interval'))
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
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', FALSE);

    $fields['dataType'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Data Type'))
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
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', FALSE);

    $fields['unitOfMeasurementName'] = BaseFieldDefinition::create('string')
      ->setLabel(t('unit Of Measurement Name'))
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

    $fields['unitOfMeasurementSymbol'] = BaseFieldDefinition::create('string')
      ->setLabel(t('unit Of Measurement Symbol'))
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

    $fields['parentType'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('parent Type'))
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
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', FALSE);

    $fields['targetDescription'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Target Description'))
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayOptions('view', [
        'type' => 'text_default',
        'label' => 'above',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', FALSE);

    $fields['targetValue'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Target Value'))
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
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', FALSE);

    $fields['targetCompletionDate'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Target Completion Date'))
      ->setDisplayOptions('form', [
        'type' => 'datetime_default',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'datetime_default',
        'settings' => [
          'format_type' => 'medium',
        ],
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', FALSE);

    $fields['note'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Note'))
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayOptions('view', [
        'type' => 'text_default',
        'label' => 'above',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', FALSE);

    $fields['leads'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Leads'))
      ->setDescription(t('list of leads'))
      ->setSetting('target_type', 'gyocf_lead')
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

    $fields['area'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Area'))
      ->setSetting('target_type', 'gyocf_area')
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
      ->setDisplayConfigurable('form', FALSE);

    $fields['objective'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Ojbective'))
      ->setSetting('target_type', 'gyocf_objective')
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
      ->setDisplayConfigurable('form', FALSE);

    $fields['action'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Action'))
      ->setSetting('target_type', 'gyocf_action')
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
      ->setDisplayConfigurable('form', FALSE);

    $fields['entries'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Indicator Entries'))
      ->setDescription(t('list of entries'))
      ->setSetting('target_type', 'gyocf_indicator_entry')
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
