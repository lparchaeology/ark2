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
 * TranslateNodeVisitor extracts translation messages.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class TranslateNodeVisitor extends \Twig_BaseNodeVisitor
{
    public const UNDEFINED_DOMAIN = '_undefined';

    private $enabled = false;
    private $messages = [];

    public function enable() : void
    {
        $this->enabled = true;
        $this->messages = [];
    }

    public function disable() : void
    {
        $this->enabled = false;
        $this->messages = [];
    }

    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    protected function doEnterNode(\Twig_Node $node, \Twig_Environment $env)
    {
        if (!$this->enabled) {
            return $node;
        }

        if (
            $node instanceof \Twig_Node_Expression_Filter &&
            'translate' === $node->getNode('filter')->getAttribute('value') &&
            $node->getNode('node') instanceof \Twig_Node_Expression_Constant
        ) {
            // extract constant nodes with a translate filter
            $this->messages[] = [
                $node->getNode('node')->getAttribute('value'),
                $this->getReadDomainFromArguments($node->getNode('arguments'), 1),
            ];
        } elseif (
            $node instanceof \Twig_Node_Expression_Filter &&
            'translatechoice' === $node->getNode('filter')->getAttribute('value') &&
            $node->getNode('node') instanceof \Twig_Node_Expression_Constant
        ) {
            // extract constant nodes with a translatechoice filter
            $this->messages[] = [
                $node->getNode('node')->getAttribute('value'),
                $this->getReadDomainFromArguments($node->getNode('arguments'), 2),
            ];
        } elseif ($node instanceof TranslateNode) {
            // extract translate nodes
            $this->messages[] = [
                $node->getNode('body')->getAttribute('data'),
                $node->hasNode('domain') ? $this->getReadDomainFromNode($node->getNode('domain')) : null,
            ];
        }

        return $node;
    }

    /**
     * {@inheritdoc}
     */
    protected function doLeaveNode(\Twig_Node $node, \Twig_Environment $env)
    {
        return $node;
    }

    /**
     * @param \Twig_Node $arguments
     * @param int        $index
     *
     * @return string|null
     */
    private function getReadDomainFromArguments(\Twig_Node $arguments, $index)
    {
        if ($arguments->hasNode('domain')) {
            $argument = $arguments->getNode('domain');
        } elseif ($arguments->hasNode($index)) {
            $argument = $arguments->getNode($index);
        } else {
            return;
        }

        return $this->getReadDomainFromNode($argument);
    }

    /**
     * @param \Twig_Node $node
     *
     * @return string|null
     */
    private function getReadDomainFromNode(\Twig_Node $node)
    {
        if ($node instanceof \Twig_Node_Expression_Constant) {
            return $node->getAttribute('value');
        }

        return self::UNDEFINED_DOMAIN;
    }
}
