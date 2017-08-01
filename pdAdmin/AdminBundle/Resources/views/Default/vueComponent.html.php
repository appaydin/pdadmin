<?php
$vueComponent = [
    'template' => $view['slots']->get('template'),
    'script' => $view['slots']->get('script')
];

/**
 * Remove <script> Tag && export default
 */
if ($vueComponent['script']) {
    $vueComponent['script'] = str_replace('<script>', '', $vueComponent['script']);
    $vueComponent['script'] = str_replace('</script>', '', $vueComponent['script']);
    $vueComponent['script'] = str_replace('export default', '', $vueComponent['script']);
}
echo json_encode($vueComponent);