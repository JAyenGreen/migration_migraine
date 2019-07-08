<?php
namespace Drupal\location2address\Plugin\migrate\process;

use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Plugin\MigratePluginManager;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;
/**
 * Process plugin.
 *
 * @MigrateProcessPlugin(
 *   id = "location2address"
 * )
 */
class Location2Address extends ProcessPluginBase{
  /**
   * The row from the source to process.
   *
   * @var \Drupal\migrate\Row
   */
  protected $row;

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
      if (!isset($this->configuration['source'])) {
          throw new MigrateException('"source" must be configured.');
      }
      // get the location entity record
      $location_rec = $this->getLocationRec($value['lid']);
      if ( $location_rec ) {
          $this->createAddressRec($this->configuration['source'], $row, $destination_property, $location_rec);
      }
  }

  private function createAddressRec($field, Row $row, $destination_property, $location_rec) {
      $db = \Drupal\Core\Database\Database::getConnection();
      foreach (['node__', 'node_revision__'] as $prefix) {
          $db->insert($prefix . $destination_property)
              ->fields(
                  [
                      'delta' => 0,
                      'entity_id' => $row->getSourceProperty('nid'),
                      'revision_id' => $row->getSourceProperty('vid'),
                      'bundle' => $row->getSourceProperty('type'),
                      'langcode' => empty($row->getDestinationProperty('langcode')) ? 'und' : $row->getDestinationProperty('langcode'),
                      $destination_property . '_country_code'           => strtoupper( $location_rec->country ),
                      $destination_property . '_langcode'               => '',
                      $destination_property . '_locality'               => $location_rec->city,
                      $destination_property . '_administrative_area'    => $location_rec->province,
                      $destination_property . '_postal_code'            => $location_rec->postal_code,
                      $destination_property . '_address_line1'          => $location_rec->street,
                      $destination_property . '_address_line2'          => $location_rec->additional,
                      $destination_property . '_organization'           => $location_rec->name,
                      $destination_property . '_given_name'             => '',
                      $destination_property . '_family_name'            => '',
                  ]
              )
              ->execute();
      }
  }

  private function getLocationRec($lid) {

      // get the entity reference
      $field_table = 'field_data_' . $this->configuration['source'];

      $terms = FALSE;
      if ($lid) {

          // get the location entity
          \Drupal\Core\Database\Database::setActiveConnection('migrate');
          $db = \Drupal\Core\Database\Database::getConnection();

          $terms = $db->select('location', 'l')
              ->fields('l', [
                  'name',
                  'city',
                  'province',
                  'postal_code',
                  'street',
                  'additional',
                  'country',
              ])
              ->condition('lid', $lid)
              ->execute()
              ->fetch();

          \Drupal\Core\Database\Database::setActiveConnection();
      }
      return $terms;
  }
}