<?php

class IconMatcher
{
    private $rules;

    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    public static function load($path)
    {
        $rules = require $path;
        if (!is_array($rules)) {
            $rules = array();
        }
        return new self($rules);
    }

    public function emoji($label)
    {
        $text = strtolower(trim(strip_tags((string) $label)));
        if ($text === '') {
            return '';
        }

        foreach ($this->rules as $rule) {
            if (!is_array($rule) || empty($rule['word']) || !isset($rule['emoji'])) {
                continue;
            }
            $word = strtolower((string) $rule['word']);
            if ($word !== '' && strpos($text, $word) !== false) {
                return (string) $rule['emoji'];
            }
        }

        return '';
    }
}
