<?php
namespace Crossjoin\Css\Format\Rule\AtKeyframes;

use Crossjoin\Css\Format\Rule\AtRuleAbstract;
use Crossjoin\Css\Format\Rule\HasRulesInterface;
use Crossjoin\Css\Format\Rule\TraitRules;
use Crossjoin\Css\Format\StyleSheet\StyleSheet;
use Crossjoin\Css\Helper\Placeholder;

class KeyframesRule
extends AtRuleAbstract
implements HasRulesInterface
{
    use TraitRules;

    /**
     * @var string|null Keyframes identifier
     */
    protected $identifier;

    /**
     * @param string|null $ruleString
     * @param StyleSheet|null $styleSheet
     */
    public function __construct($ruleString = null, StyleSheet $styleSheet = null)
    {
        if ($styleSheet !== null) {
            $this->setStyleSheet($styleSheet);
        }
        if ($ruleString !== null) {
            $ruleString = Placeholder::replaceStringsAndComments($ruleString);
            $ruleString = Placeholder::removeCommentPlaceholders($ruleString, true);
            $this->parseRuleString($ruleString);
        }
    }

    /**
     * Sets the keyframes identifier.
     *
     * @param string $identifier
     */
    public function setIdentifier($identifier)
    {
        if (is_string($identifier)) {
            $this->identifier = $identifier;
        } else {
            throw new \InvalidArgumentException(
                "Invalid type '" . gettype($identifier). "' for argument 'identifier' given."
            );
        }
    }

    /**
     * Gets the keyframes identifier.
     *
     * @return string|null
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Adds a keyframes rule set.
     *
     * @param KeyframesRuleSet $rule
     * @return $this
     */
    public function addRule(KeyframesRuleSet $rule)
    {
        // TODO Keyframes with duplicate identifiers do NOT cascade!
        // Last one overwrites previous ones.
        // @see https://developer.mozilla.org/en-US/docs/Web/CSS/@keyframes#Duplicate_resolution

        $this->rules[] = $rule;

        return $this;
    }

    /**
     * Parses the keyframes rule.
     *
     * @param string $ruleString
     */
    protected function parseRuleString($ruleString)
    {
        if (is_string($ruleString)) {
            if (preg_match('/^@keyframes[ \r\n\t\f]+([^ \r\n\t\f]+)[ \r\n\t\f]*/i', $ruleString, $matches)) {
                $identifier = $matches[1];
                $this->setIdentifier($identifier, $this->getStyleSheet());
            } else {
                throw new \InvalidArgumentException("Invalid format for @keyframes rule.");
            }
        } else {
            throw new \InvalidArgumentException(
                "Invalid type '" . gettype($ruleString). "' for argument 'ruleString' given."
            );
        }
    }
}