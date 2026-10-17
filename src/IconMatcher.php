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

    public function html($label)
    {
        $rule = $this->match($label);
        if (!$rule) {
            return '';
        }
        $inner = $this->inner($rule);
        if ($inner === '') {
            return '';
        }
        return '<span class="icon-match" aria-hidden="true">' . $inner . '</span>';
    }

    private function inner(array $rule)
    {
        if (isset($rule['emoji']) && (string) $rule['emoji'] !== '') {
            return $this->escape((string) $rule['emoji']);
        }
        if (!empty($rule['font'])) {
            $class = trim((string) $rule['font']);
            if (!preg_match('/^[\w\-\s]+$/', $class)) {
                return '';
            }
            return '<i class="' . $this->escape($class) . '" aria-hidden="true"></i>';
        }
        if (!empty($rule['svg'])) {
            return (string) $rule['svg'];
        }
        if (!empty($rule['src'])) {
            $src = $this->safeSrc((string) $rule['src']);
            if ($src === '') {
                return '';
            }
            return '<img src="' . $this->escape($src) . '" alt="" class="icon-match__img">';
        }
        return '';
    }

    private function safeSrc($src)
    {
        $src = trim($src);
        if ($src === '' || preg_match('/^\s*javascript:/i', $src)) {
            return '';
        }
        if (preg_match('#^(?:https?:)?//#i', $src) || preg_match('#^\.\.?/#', $src) || preg_match('#^[A-Za-z0-9_./-]+$#', $src)) {
            return $src;
        }
        return '';
    }

    private function escape($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
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
