<?php
namespace Pbxg33k\PhpmdCodeClimate;


use PHPMD\AbstractRenderer;
use PHPMD\Report;

class CodeClimateRenderer extends AbstractRenderer
{
    const CAT_BUG_RISK = 'Bug Risk';
    const CAT_CLARITY  = 'Clarity';
    const CAT_COMPAT   = 'Compatibility';
    const CAT_COMPLEX  = 'Complexity';
    const CAT_DUPLICAT = 'Duplication';
    const CAT_PERF     = 'Performance';
    const CAT_SEC      = 'Security';
    const CAT_STYLE    = 'Style';

    private $catmap    = [
        'BooleanArgumentFlag'      => self::CAT_STYLE,
        'ElseExpression'           => self::CAT_STYLE,
        'StaticAccess'             => self::CAT_STYLE,
        'CyclomaticComplexity'     => self::CAT_COMPLEX,
        'NPathComplexity'          => self::CAT_COMPLEX,
        'ExcessiveMethodLength'    => self::CAT_COMPLEX,
        'ExcessiveClassLength'     => self::CAT_COMPLEX,
        'ExcessiveParameterList'   => self::CAT_COMPLEX,
        'ExcessivePublicCount'     => self::CAT_COMPLEX,
        'TooManyFields'            => self::CAT_COMPLEX,
        'NcssMethodCount'          => self::CAT_COMPLEX,
        'NcssTypeCount'            => self::CAT_COMPLEX,
        'NcssConstructorCount'     => self::CAT_COMPLEX,
        'TooManyMethods'           => self::CAT_COMPLEX,
        'TooManyPublicMethods'     => self::CAT_COMPLEX,
        'ExcessiveClassComplexity' => self::CAT_COMPLEX,
        'Superglobals'             => self::CAT_SEC,
        'CamelCaseClassName'       => self::CAT_STYLE,
        'CamelCasePropertyName'    => self::CAT_STYLE,
        'CamelCaseMethodName'      => self::CAT_STYLE,
        'CamelCaseParameterName'   => self::CAT_STYLE,
        'CamelCaseVariableName'    => self::CAT_STYLE,
        'UnusedFormalParameter'    => self::CAT_BUG_RISK,
        'UnusedLocalVariable'      => self::CAT_BUG_RISK,
        'UnusedPrivateField'       => self::CAT_BUG_RISK,
        'UnusedPrivateMethod'      => self::CAT_BUG_RISK,
    ];

    /**
     * This method will be called when the engine has finished the source analysis
     * phase.
     *
     * @param \PHPMD\Report $report
     * @return void
     */
    public function renderReport(Report $report)
    {
        foreach($report->getRuleViolations() as $violation) {
            $rule = $violation->getRule();

            $line = [
                'type'          => 'issue',
                'check_name'    => $violation->getRule()->getName(),
                'description'   => $violation->getDescription(),
                'categories'    => [
                    $this->catmap[$violation->getRule()->getName()]
                ],
                'location'      => [
                    'path'      => $violation->getFileName(),
                    'lines'     => [
                        'begin' => $violation->getBeginLine(),
                        'end'   => $violation->getEndLine()
                    ]
                ]
            ];

            $this->getWriter()->write(sprintf('%s%s',json_encode($line), PHP_EOL));
        }
    }

    protected function addCatMap(RuleMapping $mapping, bool $override = false) {
        if(!$override && array_key_exists($mapping->getRulename(),$this->catmap)) {
            throw new \Exception('Rulename is already mapped to a category');
        }

        $this->catmap[$mapping->getRulename()] = $mapping->getCategory();
    }
}