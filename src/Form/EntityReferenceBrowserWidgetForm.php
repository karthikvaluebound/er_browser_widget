<?php
/**
 * @file
 * Contains \Drupal\er_browser_widget\Plugin\Field\FieldWidget\EntityReferenceBrowserWidget.
 */

namespace Drupal\er_browser_widget\Form\EntityReferenceBrowserWidgetForm;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form;

/**
 * Custom Form
 */
class EntityReferenceBrowserWidgetForm {

    public function randomUsernameCallback(array &$form, FormStateInterface $form_state) {
        $response = new AjaxResponse();
        $message = $this->t('You click this..');
        $response->addCommand(new HtmlCommand('.er_html', $message));
        $title = $this->t('AJAX Dialog contents');
        $content['#attached']['library'][] = 'core/drupal.dialog.ajax';
        $response->addCommand(new OpenModalDialogCommand($title, $content));
        return $response;
    }
}
