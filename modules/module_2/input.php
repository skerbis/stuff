<?php 
$fragment = new rex_fragment();
$fragment->setVar('name', 'REX_INPUT_VALUE[1]['.$i.'][links]', false);
$fragment->setVar('value', $existingValue);
echo $fragment->parse(rex_addon::get('link_widget')->getPath('fragments/widget.php'));
?>