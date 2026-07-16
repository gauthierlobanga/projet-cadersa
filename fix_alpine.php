<?php
$content = file_get_contents('resources/js/app.js');

$helper = <<<EOT
const onAlpineInit = (cb) => {
    if (window.Alpine && window.Alpine.version) {
        cb();
    } else {
        document.addEventListener('alpine:init', cb);
    }
};

EOT;

$content = str_replace('// Rendre disponibles globalement', $helper . '// Rendre disponibles globalement', $content);
$content = str_replace('document.addEventListener("alpine:init", () => {', 'onAlpineInit(() => {', $content);
$content = preg_replace('/document\.addEventListener\("alpine:init", registerAlpineExtensions, \{[\s\S]*?\}\);/', 'onAlpineInit(registerAlpineExtensions);', $content);
$content = preg_replace('/document\.addEventListener\("alpine:init", register, \{ once: true \}\);/', 'onAlpineInit(register);', $content);

file_put_contents('resources/js/app.js', $content);
echo "done";
