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
                // 'callback' => 'Drupal\er_browser_widget\Form\EntityReferenceBrowserWidgetForm::randomUsernameCallback',
                'event' => 'click',
                'progress' => array(
                    'type' => 'throbber',
                    'message' => t('In progress..'),
                ),
            ],
            '#suffix' => '<span class="er_html"></span>'
        );
        return $main_element;
    }

    function er_browser_widget_search_content(array &$form, FormStateInterface $form_state) {
        $form = \Drupal::formBuilder()->getForm('Drupal\er_browser_widget\Form\EntityReferenceBrowserWidgetForm');
        $response = new AjaxResponse();
        $title = $this->t('Entity Search and Reference.');
        $form['#attached']['library'][] = 'core/drupal.dialog.ajax';
        $response->setAttachments($form['#attached']);
        $content = views_embed_view('entity_reference_browser_widget');
        $options = array(
          'dialogClass' => 'test-dialog',
          'width' => '75%',
        );
        $modal = new OpenModalDialogCommand($title, $form, $options);
        $response->addCommand($modal);
        return $response;
    }

}

