<?php

/**
 * ARK Translation Twig Token Parser
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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

/*
 * Copied from Symfony\Bridge\Twig\TokenChoiceParser.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 */

 namespace ARK\Translation\Twig;

 use ARK\Translation\Twig\TranslateNode;

/**
 * Token Parser for the 'translate' tag.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class TranslateTokenParser extends \Twig_TokenParser
{
    /**
     * Parses a token and returns a node.
     *
     * @param \Twig_Token $token A Twig_Token instance
     *
     * @return \Twig_Node A Twig_Node instance
     *
     * @throws \Twig_Error_Syntax
     */
    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $vars = new \Twig_Node_Expression_Array(array(), $lineno);
        $role = null;
        $domain = null;
        $locale = null;
        if (!$stream->test(\Twig_Token::BLOCK_END_TYPE)) {
            if ($stream->test('as')) {
                // {% translate as role %}
                $stream->next();
                $role = $this->parser->getExpressionParser()->parseExpression();
            }

            if ($stream->test('with')) {
                // {% translate with vars %}
                $stream->next();
                $vars = $this->parser->getExpressionParser()->parseExpression();
            }

            if ($stream->test('from')) {
                // {% translate from "messages" %}
                $stream->next();
                $domain = $this->parser->getExpressionParser()->parseExpression();
            }

            if ($stream->test('into')) {
                // {% translate into "fr" %}
                $stream->next();
                $locale = $this->parser->getExpressionParser()->parseExpression();
            } elseif (!$stream->test(\Twig_Token::BLOCK_END_TYPE)) {
                throw new \Twig_Error_Syntax('Unexpected token. Twig was looking for the "as", "with", "from", or "into" keyword.', $stream->getCurrent()->getLine(), $stream->getSourceContext()->getName());
            }
        }

        // {% trans %}message{% endtrans %}
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse(array($this, 'decideTranslateFork'), true);

        if (!$body instanceof \Twig_Node_Text && !$body instanceof \Twig_Node_Expression) {
            throw new \Twig_Error_Syntax('A message inside a translate tag must be a simple text.', $body->getTemplateLine(), $stream->getSourceContext()->getName());
        }

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        return new TranslateNode($body, $role, $domain, null, $vars, $locale, $lineno, $this->getTag());
    }

    public function decideTranslateFork($token)
    {
        return $token->test(array('endtranslate'));
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @return string The tag name
     */
    public function getTag()
    {
        return 'translate';
    }
}
