<?php

namespace Hyvor\HyvorTalkWP\Embed;

/**
 * @phpstan-import-type SelectedPages from SelectedPagesValidator
 * @phpstan-type GatedContentRule array{
 *      minimum_plan: string,
 *      post_types: SelectedPages[]
 *      gate: string | null
 *  }
 */
class GatedContent
{

    /**
     * @param GatedContentRule[] $rules
     * @return GatedContentRule|null
     */
    public static function getMatchedRule($rules)
    {
        foreach ($rules as $rule) {
            if (SelectedPagesValidator::isSelected($rule['post_types'])) {
                return $rule;
            }
        }
        return null;
    }

    /**
     * @param string $content
     * @param GatedContentRule $rule
     * @param string $key
     */
    public static function calculateSecure(
        $content,
        $minimumPlan,
        $gate,
        $key
    )
    {

        // source: https://github.com/hyvor/hyvor-talk-examples/blob/main/encryption/encryption.php

        $data = [
            'timestamp' => time(),
            'content' => $content,
            'minimum-plan' => $minimumPlan,
            'gate' => $gate ?? null,
        ];

        $data = json_encode($data);
        $iv = openssl_random_pseudo_bytes(16);
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', base64_decode($key), OPENSSL_RAW_DATA, $iv);

        return base64_encode($encrypted) . ':' . base64_encode($iv);

    }

}
