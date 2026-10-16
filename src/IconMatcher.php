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

    public function match($label)
    {
        $text = trim(strip_tags((string) $label));
        if ($text === '') {
            return null;
        }

        foreach ($this->rules as $rule) {
            if (!is_array($rule)) {
                continue;
            }
            $pattern = $this->pattern($rule);
            if ($pattern === null) {
                continue;
            }
            $matched = @preg_match($pattern, $text);
            if ($matched === 1) {
                return $rule;
            }
        }

        return null;
    }

    public function emoji($label)
    {
        $rule = $this->match($label);
        if (!$rule || !isset($rule['emoji'])) {
            return '';
        }
        return (string) $rule['emoji'];
    }

    private function pattern(array $rule)
    {
        if (!empty($rule['pattern'])) {
            $source = (string) $rule['pattern'];
        } elseif (!empty($rule['word'])) {
            $source = preg_quote((string) $rule['word'], '#');
        } else {
            return null;
        }

        $flags = isset($rule['flags']) ? (string) $rule['flags'] : 'i';
        if (preg_match('#^/(.*)/([a-z]*)$#s', $source, $wrapped)) {
            $source = $wrapped[1];
            $flags = $wrapped[2];
        }
        $flags = str_replace('g', '', $flags);
        $delimited = '#' . str_replace('#', '\\#', $source) . '#' . $flags;

        $ok = @preg_match($delimited, '') !== false;
        return $ok ? $delimited : null;
    }
}
