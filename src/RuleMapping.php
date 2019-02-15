<?php
namespace Pbxg33k\PhpmdCodeClimate;

class RuleMapping
{

    /**
     * @var string
     */
    private $rulename;

    /**
     * @var string
     */
    private $category;

    public function __construct(string $phpmdRuleName, string $category) : void
    {
        $this->setRulename($phpmdRuleName);
        $this->setCategory($category);
    }

    /**
     * @return string
     */
    public function getRulename()
    {
        return $this->rulename;
    }

    /**
     * @param string $rulename
     */
    public function setRulename($rulename)
    {
        $this->rulename = $rulename;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
}