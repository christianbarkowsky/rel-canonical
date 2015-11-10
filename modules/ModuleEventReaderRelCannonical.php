<?php

/**
 * Rel Canonical
 *
 * @copyright Christian Barkowsky 2013-2015
 * @package   contao-rel-canonical
 * @author    Christian Barkowsky <http://www.christianbarkowsky.de>
 * @license   LGPL
 */


/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace RelCanonical;


class ModuleEventReader extends \Contao\ModuleEventReader
{

    public function generate()
    {
        return parent::generate();
    }


    protected function compile()
    {
        global $objPage;

        // Get the current event
        $objEvent = \CalendarEventsModel::findPublishedByParentAndIdOrAlias(\Input::get('events'), $this->cal_calendar);

        if ($objEvent === null) {
            parent::compile();
        }

        $objPage->canonicalType = $objEvent->canonicalType;
        $objPage->canonicalJumpTo = $objEvent->canonicalJumpTo;
        $objPage->canonicalWebsite = $objEvent->canonicalWebsite;

        if ($objEvent->canonicalType == 'self') {
            $objPage->canonicalType = 'external';
            $objPage->canonicalWebsite = \Environment::get('url') . TL_PATH . '/' . \Environment::get('request');
        }

        parent::compile();
    }
}
