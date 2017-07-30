<?php

/**
 * ARK Translation Twig Token Parser.
 *
 * Copyright (C) 2017  L - P : Heritage LLP.
 *
 * This file is part of ARK, the Archaeological Recording Kit.
 *
 * ARK is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ARK is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ARK.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     John Layt <j.layt@lparchaeology.com>
 * @copyright  2017 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

/*
 * Copied from Symfony\Bridge\Twig\TokenParser.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 */

namespace ARK\Translation\Twig;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
class TranslateNode extends \Twig_Node
{
    public function __construct(\Twig_Node $body, \Twig_Node $role = null, \Twig_Node $domain = null, \Twig_Node_Expression $count = null, \Twig_Node_Expression $vars = null, \Twig_Node_Expression $locale = null, $lineno = 0, $tag = null)
    {
        $nodes = ['body' => $body];
        if (null !== $role) {
            $nodes['role'] = $role;
        }
        if (null !== $domain) {
            $nodes['domain'] = $domain;
        }
        if (null !== $count) {
            $nodes['count'] = $count;
        }
        if (null !== $vars) {
            $nodes['vars'] = $vars;
        }
        if (null !== $locale) {
            $nodes['locale'] = $locale;
        }

        parent::__construct($nodes, [], $lineno, $tag);
    }

    /**
     * Compiles the node to PHP.
     *
     * @param \Twig_Compiler $compiler A Twig_Compiler instance
     */
    public function compile(\Twig_Compiler $compiler) : void
    {
        $compiler->addDebugInfo($this);

        $defaults = new \Twig_Node_Expression_Array([], -1);
        if ($this->hasNode('vars') && ($vars = $this->getNode('vars')) instanceof \Twig_Node_Expression_Array) {
            $defaults = $this->getNode('vars');
            $vars = null;
        }
        list($msg, $defaults) = $this->compileString($this->getNode('body'), $defaults, (bool) $vars);

        $method = !$this->hasNode('count') ? 'translate' : 'translateChoice';

        $compiler
            ->write('echo $this->env->getExtension(\'ARK\Twig\TranslateExtension\')->getTranslator()->'.$method.'(')
            ->subcompile($msg)
        ;

        $compiler->raw(', ');

        if ($this->hasNode('count')) {
            $compiler
                ->subcompile($this->getNode('count'))
                ->raw(', ')
            ;
        }

        if ($this->hasNode('role')) {
            $compiler
                ->subcompile($this->getNode('role'))
                ->raw(', ')
            ;
        } else {
            $compiler
                ->raw('null, ')
            ;
        }

        if (null !== $vars) {
            $compiler
                ->raw('array_merge(')
                ->subcompile($defaults)
                ->raw(', ')
                ->subcompile($this->getNode('vars'))
                ->raw(')')
            ;
        } else {
            $compiler->subcompile($defaults);
        }

        $compiler->raw(', ');

        if (!$this->hasNode('domain')) {
            $compiler->repr('messages');
        } else {
            $compiler->subcompile($this->getNode('domain'));
        }

        if ($this->hasNode('locale')) {
            $compiler
                ->raw(', ')
                ->subcompile($this->getNode('locale'))
            ;
        }
        $compiler->raw(");\n");
    }

    protected function compileString(\Twig_Node $body, \Twig_Node_Expression_Array $vars, $ignoreStrictCheck = false)
    {
        if ($body instanceof \Twig_Node_Expression_Constant) {
            $msg = $body->getAttribute('value');
        } elseif ($body instanceof \Twig_Node_Text) {
            $msg = $body->getAttribute('data');
        } else {
            return [$body, $vars];
        }

        preg_match_all('/(?<!%)%([^%]+)%/', $msg, $matches);

        foreach ($matches[1] as $var) {
            $key = new \Twig_Node_Expression_Constant('%'.$var.'%', $body->getTemplateLine());
            if (!$vars->hasElement($key)) {
                if ('count' === $var && $this->hasNode('count')) {
                    $vars->addElement($this->getNode('count'), $key);
                } else {
                    $varExpr = new \Twig_Node_Expression_Name($var, $body->getTemplateLine());
                    $varExpr->setAttribute('ignore_strict_check', $ignoreStrictCheck);
                    $vars->addElement($varExpr, $key);
                }
            }
        }

        return [new \Twig_Node_Expression_Constant(str_replace('%%', '%', trim($msg)), $body->getTemplateLine()), $vars];
    }
}
