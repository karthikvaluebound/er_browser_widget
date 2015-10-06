<?php
/**
 * @file
 * Contains \Drupal\er_browser_widget\Plugin\Field\FieldWidget\EntityReferenceBrowserWidget.
 */

namespace Drupal\er_browser_widget\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;

use \Drupal\Core\Ajax\OpenModalDialogCommand;
use \Drupal\Core\Ajax\CloseModalDialogCommand;

use \Drupal\Core\Ajax\ReplaceCommand;;
use \Drupal\Core\Entity;

use \Drupal\Core\Ajax;

/**
 * Plugin implementation of the 'er_browser_widget' widget.
 *
 * @FieldWidget(
 *   id = "er_browser_widget",
 *   label = @Translation("Customized Entity Reference field."),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class EntityReferenceBrowserWidget extends WidgetBase {

    // Custom code which handles the value insertions
    public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
        $main_element = $element + $custom['search_content'] = array(
            '#type' => 'submit',
            '#value' => t('search content'),
            '#title' => $this->t('Search Content'),
            '#ajax' => [
                'callback' => array($this, 'er_browser_widget_search_content'),
                'event' => 'click',
                'progress' => array(
                    'type' => 'throbber',
                    'message' => t('In progress..'),
                ),
            ],
            '#suffix' => '<span class="er_html"></span>'
        );
        $referenced_entities = $items->referencedEntities();
        $target_type = $this->getFieldSetting('target_type');
        $handler = $this->getFieldSetting('handler');
        $handler_settings = $this->getFieldSetting('handler_settings');  // gets the handler settings.
        $field_settings = $this->fieldDefinition->getSettings();  // gets the field settings, like content type selected for entities references.
        $cardinality = $this->fieldDefinition->getFieldStorageDefinition();  // gets the number of entity values to be stored.
        $k = 1;
        /*$entity = $items->getEntity();
        $referenced_entities = $items->referencedEntities();
        $element += array(
            '#type' => 'entity_autocomplete',
            '#target_type' => $this->getFieldSetting('target_type'),
            '#selection_handler' => $this->getFieldSetting('handler'),
            '#selection_settings' => $this->getFieldSetting('handler_settings'),
            // Entity reference field items are handling validation themselves via
            // the 'ValidReference' constraint.
            '#validate_reference' => FALSE,
            '#maxlength' => 1024,
            '#default_value' => isset($referenced_entities[$delta]) ? $referenced_entities[$delta] : NULL,
            '#size' => $this->getSetting('size'),
            '#placeholder' => $this->getSetting('placeholder'),
        );
        if ($this->getSelectionHandlerSetting('auto_create')) {
            $element['#autocreate'] = array(
                'bundle' => $this->getAutocreateBundle(),
                'uid' => ($entity instanceof EntityOwnerInterface) ? $entity->getOwnerId() : \Drupal::currentUser()->id()
            );
        }*/
        return $main_element;
    }

    function er_browser_widget_search_content(array &$form, FormStateInterface $form_state) {
        $response = new AjaxResponse();
        $title = $this->t('Entity Search and Reference.');
        $content['#attached']['library'][] = 'core/drupal.dialog.ajax';
        //$content['data'] = 'asdasdasd';
        //$content12 = array("#markup" => "heloo");
        //$con = "<div>asd</div>";
        $modal = new OpenModalDialogCommand($title, $content);
        //$modal->setDialogTitle("Rakesh James");
        //$modal->setDialogOptions($content12);
        $response->addCommand($modal);
        return $response;
    }

}

