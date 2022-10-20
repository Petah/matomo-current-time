<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\CurrentTime\Widgets;

use Piwik\Common;
use Piwik\Tracker\Cache;
use Piwik\Widget\Widget;
use Piwik\Widget\WidgetConfig;

class CurrentTimeWidget extends Widget
{
    public static function configure(WidgetConfig $config)
    {
        $config->setCategoryId('About Matomo');
        $config->setName('Current Time');
    }

    public function render()
    {
        // @todo unsure if this is the correct way to get the current site
        // @todo check if there is a better way to inject site settings to vue components, or if matomo provides escaping helpers
        $website = Cache::getCacheWebsiteAttributes(Common::getRequestVar('idSite'));
        return '<div vue-entry="CurrentTime.CurrentTime" timezone="' . htmlentities($website['timezone'] ?? '') . '"></div>';
    }
}
