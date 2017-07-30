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

class TranslateChoiceTokenParser extends TranslateTokenParser
{
    /**
     * Parses a token and returns a node.
     *
     * @param \Twig_Token $token A Twig_Token instance
     *
     * @throws \Twig_Error_Syntax
     * @return \Twig_Node         A Twig_Node instance
     */
    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $vars = new \Twig_Node_Expression_Array([], $lineno);

        $count = $this->parser->getExpressionParser()->parseExpression();

        $role = null;
        $domain = null;
        $locale = null;

        if ($stream->test('as')) {
            // {% translatechoice count as role %}
            $stream->next();
            $role = $this->parser->getExpressionParser()->parseExpression();
        }

        if ($stream->test('with')) {
            // {% translatechoice count with vars %}
            $stream->next();
            $vars = $this->parser->getExpressionParser()->parseExpression();
        }

        if ($stream->test('from')) {
            // {% translatechoice count from "messages" %}
            $stream->next();
            $domain = $this->parser->getExpressionParser()->parseExpression();
        }

        if ($stream->test('into')) {
            // {% translatechoice count into "fr" %}
            $stream->next();
            $locale = $this->parser->getExpressionParser()->parseExpression();
        }

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse([$this, 'decideTranslateChoiceFork'], true);

        if (!$body instanceof \Twig_Node_Text && !$body instanceof \Twig_Node_Expression) {
            throw new \Twig_Error_Syntax('A message inside a translatechoice tag must be a simple text.', $body->getTemplateLine(), $stream->getSourceContext()->getName());
        }

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        return new TranslateNode($body, $role, $domain, $count, $vars, $locale, $lineno, $this->getTag());
    }

    public function decideTranslateChoiceFork($token)
    {
        return $token->test(['endtranslatechoice']);
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @return string The tag name
     */
    public function getTag()
    {
        return 'translatechoice';
    }
}
