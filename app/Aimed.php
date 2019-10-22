<?php

namespace App;

use App\Ux\SettingsTabs;

class Aimed
{
    /**
     * The settings tabs configuration.
     *
     * @var \App\Ux\Tabs
     */
    public static $settingsTabs;

    /**
     * Get the configuration for the Spark settings tabs.
     *
     * @return \App\Ux\SettingsTabs
     */
    public static function settingsTabs()
    {
        return static::$settingsTabs ?:
            static::$settingsTabs = static::createDefaultSettingsTabs();
    }

    /**
     * Create the default settings tabs configuration.
     *
     * @return \App\Ux\SettingsTabs
     */
    protected static function createDefaultSettingsTabs()
    {
        $tabs = [(new SettingsTabs)->profile(), (new SettingsTabs)->security()];

        return new SettingsTabs($tabs);
    }

    /**
     * Get the key for the first settings tab in the collection.
     *
     * @return string
     */
    public static function firstSettingsTabKey()
    {
        return static::settingsTabs()->tabs[0]->key;
    }
}