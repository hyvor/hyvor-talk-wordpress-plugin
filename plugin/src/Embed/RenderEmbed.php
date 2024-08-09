<?php

namespace Hyvor\HyvorTalkWP\Embed;

class RenderEmbed
{

    public static function render(
        string $template,
        array $attributes
    )
    {
        ob_start();
        include(__DIR__ . '/templates/' . $template . '.template.php');
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

}
