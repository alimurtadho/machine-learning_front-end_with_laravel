<?php

namespace App\Ux;

class SettingsTabs extends Tabs
{
    /**
     * Get the tab configuration for the "profile" tab.
     *
     * @return Tab
     */
    public function profile()
    {
        return new Tab('Profile', 'users.tabs.profile', 'fa-user');
    }

    /**
     * Get the tab configuration for the "security" tab.
     *
     * @return Tab
     */
    public function security()
    {
        return new Tab('Security', 'users.tabs.security', 'fa-lock');
    }
}