<?php

namespace PaulMaxwell\GuestbookBundle\Twig\Extension;

use Decoda\Decoda;

class BbCodeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('bbcode', array($this, 'bbCodeFilter')),
        );
    }

    public function bbCodeFilter($input)
    {
        $code = new Decoda($input);
        $code->defaults();

        return $code->parse();
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'bbcode_extension';
    }
}
