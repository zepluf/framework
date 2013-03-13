<?php

namespace Zepluf\Bundle\StoreBundle\Utility;

class String
{

    /**
     * Convert to string that is delimited by "_" from camel case
     *
     * Usage:
     * <code>
     * $result = String::fromCamelCase($string);
     * </code>
     *
     * @param string $string
     * @return string
     */
    public static function fromCamelCase($string)
    {
        return preg_replace(
            '/(^|[a-z])([A-Z])/e',
            'strtolower(strlen("\\1") ? "\\1_\\2" : "\\2")',
            $string
        );
    }

    /**
     * Convert a string that is delimited by "_", "-" or space to camel case
     *
     * Usage:
     * <code>
     * $result = String::toCamelCase($string);
     * </code>
     *
     * @param string $string
     * @param bool $capitaliseFirstChar
     * @return string
     */
    public static function toCamelCase($string, $capitaliseFirstChar = false)
    {
        $string = str_replace(array('-', '_'), ' ', $string);
        $string = ucwords($string);
        $string = str_replace(' ', '', $string);

        if (!$capitaliseFirstChar) {
            return lcfirst($string);
        }
        return $string;
    }

    /**
     * @param string $string
     * @param string $replacement
     * @return string
     * echo normal_chars('�lix----_�xel!?!?'); // Alix Axel
     * echo normal_chars('����������'); // aeiouAEIOU
     * echo normal_chars('������ܟ��'); // uyAEIOUYaA
     */
    public function normalizeCharacters($string, $replacement = ' ')
    {
        $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
        $string = preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', $string);
        $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
        $string = preg_replace(array('~[^0-9a-z]~i', '~[ -]+~'), $replacement, $string);

        return trim($string, ' -');
    }

    /**
     * Remove all characters except letters, numbers, and spaces.
     *
     * @param string $string
     * @return string
     */
    function stripNonAlphaNumeric($string)
    {
        return preg_replace("/[^a-z0-9]/i", "", $string);
    }

    /**
     * Transform two or more spaces into just one space.
     *
     * @param string $string
     * @return string
     */
    function stripExcessWhitespace($string)
    {
        return preg_replace('/  +/', ' ', $string);
    }


    /**
     * Generate a random string of specified length from a set of specified characters
     *
     * @param integer $size Default size is 30 characters.
     * @param string $chars The characters to use for randomization.
     * @return string
     */
    function randomString($size = 30, $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789")
    {
        $string = "";
        $length = strlen($chars);

        for ($i = 0; $i < $size; $i++) {
            $string .= $chars{rand(0, $length)};
        }

        return $string;
    }
}