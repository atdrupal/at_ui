<?php

function at_ui_include_code_mirror($extras = array(), $theme = 'monokai')
{
    $path = at_library('code.mirror', NULL, FALSE);

    drupal_add_js($path . '/lib/codemirror.js');
    drupal_add_css($path . '/lib/codemirror.css');
    drupal_add_css($path . '/theme/' . $theme . '.css');
    foreach ($extras as $extra) {
        drupal_add_js($path . '/' . $extra);
    }
}

/**
 * Add custom assets to /devel/php form to support php syntax.
 * Include CodeMirror assets.
 *
 * @param  array  $extras
 * @param  string $theme
 */
function at_ui_include_codemirror($extras = array(), $theme = 'monokai')
{
    $path = at_library('code.mirror', NULL, FALSE);

    drupal_add_js($path . '/lib/codemirror.js');
    drupal_add_css($path . '/lib/codemirror.css');
    drupal_add_css($path . '/theme/' . $theme . '.css');
    foreach ($extras as $extra) {
        drupal_add_js($path . '/' . $extra);
    }
}

/**
 * @return string.
 */
function at_ui_codemirror_submit_shortcut_hint()
{
    return 'Use <code>Ctrl+s</code> or <code>Cmd+s</code> to submit the form.';
}

/**
 * Display source code of a file support CodeMirror.
 */
function at_ui_display_file($form, $form_state, $file, $type = 'unknow')
{
    drupal_add_css(drupal_get_path('module', 'at_ui') . '/misc/css/cm.css');

    switch ($type) {
        case 'twig':
            at_ui_include_codemirror(array('mode/htmlmixed/htmlmixed.js', 'mode/xml/xml.js', 'addon/mode/overlay.js'));
            drupal_add_js(drupal_get_path('module', 'at_ui') . '/misc/js/at.twig.js');
            break;

        case 'yaml':
            at_ui_include_codemirror(array('mode/yaml/yaml.js'));
            drupal_add_js(drupal_get_path('module', 'at_ui') . '/misc/js/at.codemirror.yaml.js');
            break;

        case 'css':
            at_ui_include_codemirror(array('mode/css/css.js'));
            drupal_add_js(drupal_get_path('module', 'at_ui') . '/misc/js/at.codemirror.css.js');
            break;

        case 'javascript':
            at_ui_include_codemirror(array('mode/javascript/javascript.js'));
            drupal_add_js(drupal_get_path('module', 'at_ui') . '/misc/js/at.codemirror.javascript.js');
            break;

        case 'php':
            at_ui_include_codemirror(array('mode/clike/clike.js', 'mode/php/php.js'));
            drupal_add_js(drupal_get_path('module', 'at_ui') . '/misc/js/at.codemirror.php.js');
            break;
    }

    $write = is_writable($file) && isset($_GET['e']);

    $form['code'] = array(
        '#type'          => 'textarea',
        '#file'          => $file,
        '#default_value' => file_get_contents($file),
        '#disabled'      => !$write,
        '#resizable'     => FALSE,
    );

    if ($write) {
        $form['submit'] = array(
            '#type'  => 'submit',
            '#value' => t('Submit'),
        );
    }

    $form['#suffix'] = at_ui_tool_links();

    return $form;
}

/**
 * Submit handler for at_ui_display_file form.
 */
function at_ui_display_file_submit($form, $form_state)
{
    list($file, $content) = array($form['code']['#file'], $form_state['values']['code']);
    $fp = fopen($file, 'w');
    fwrite($fp, $content);
    fclose($fp);
}
