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
        $title = $this->t('Entity Search and Reference.');
        $form['#attached']['library'][] = 'core/drupal.dialog.ajax';
        $response->setAttachments($form['#attached']);
        $content = '<div class="views-test123">' . 'rakesh, karthik' . '</div>';
        $options = array(
            'dialogClass' => 'test-dialog',
            'width' => '75%',
        );
        $modal = new OpenModalDialogCommand($title, $content, $options);
        $response->addCommand($modal);
        return $response;
    }
}
