<?php

namespace App\Helpers;

use Illuminate\Support\Facades\View;
use App\Events\ReadingDarkModePreference;
use App\Http\Controllers\DarkModeController;

class LayoutHelper
{
    /**
     * Holds the set of tokens related to screen sizes/breakpoints.
     *
     * @var array
     */
    protected static $screenBreakpoints = ['xs', 'sm', 'md', 'lg', 'xl'];

    /**
     * Holds the set of tokens related to the valid config values of the
     * sidebar mini option.
     *
     * @var array
     */
    protected static $sidebarMiniValues = ['xs', 'md', 'lg'];

    /**
     * Checks if layout topnav is enabled.
     *
     * @return bool
     */
    public static function isLayoutTopnavEnabled()
    {
        return config('adminlte.layout_topnav', false)
            || ! empty(View::getSection('layout_topnav'));
    }

    /**
     * Checks if layout boxed is enabled.
     *
     * @return bool
     */
    public static function isLayoutBoxedEnabled()
    {
        return config('adminlte.layout_boxed', false)
            || ! empty(View::getSection('layout_boxed'));
    }

    /**
     * Checks if right sidebar is enabled.
     *
     * @return bool
     */
    public static function isRightSidebarEnabled()
    {
        return config('adminlte.right_sidebar', false)
            || ! empty(View::getSection('right_sidebar'));
    }

    /**
     * Makes and return the set of classes related to the body tag.
     *
     * @return string
     */
    public static function makeBodyClasses()
    {
        $classes = [];
        array_push($classes, ...self::makeLayoutClasses());
        array_push($classes, ...self::makeSidebarClasses());
        array_push($classes, ...self::makeRightSidebarClasses());
        array_push($classes, ...self::makeCustomBodyClasses());
        array_push($classes, ...self::makeDarkModeClasses());

        return trim(implode(' ', $classes));
    }

    /**
     * Makes and return the set of data attributes related to the body tag.
     *
     * @return string
     */
    public static function makeBodyData()
    {
        $data = [];

        // Add data related to the "sidebar_scrollbar_theme" configuration.

        $sbTheme = config('adminlte.sidebar_scrollbar_theme', 'os-theme-light');

        if ($sbTheme != 'os-theme-light') {
            $data[] = "data-scrollbar-theme={$sbTheme}";
        }

        // Add data related to the "sidebar_scrollbar_auto_hide" configuration.

        $sbAutoHide = config('adminlte.sidebar_scrollbar_auto_hide', 'l');

        if ($sbAutoHide != 'l') {
            $data[] = "data-scrollbar-auto-hide={$sbAutoHide}";
        }

        return trim(implode(' ', $data));
    }

    /**
     * Makes and return the set of classes related to the content-wrapper
     * element.
     *
     * @return string
     */
    public static function makeContentWrapperClasses()
    {
        $classes = ['content-wrapper'];

        // Add classes from the configuration file.

        $cfg = config('adminlte.classes_content_wrapper', '');

        if (is_string($cfg) && ! empty($cfg)) {
            $classes[] = $cfg;
        }

        // Add position-relative when using a content-wrapper preloader.

        if (PreloaderHelper::isPreloaderEnabled('cwrapper')) {
            $classes[] = 'position-relative';
        }

        return trim(implode(' ', $classes));
    }

    /**
     * Makes and return the set of classes related to the layout configuration.
     *
     * @return array
     */
    private static function makeLayoutClasses()
    {
        $classes = [];

        // Add classes related to the "layout_topnav" configuration.

        if (self::isLayoutTopnavEnabled()) {
            $classes[] = 'layout-top-nav';
        }

        // Add classes related to the "layout_boxed" configuration.

        if (self::isLayoutBoxedEnabled()) {
            $classes[] = 'layout-boxed';
        }

        // Add classes related to fixed sidebar layout configuration. The fixed
        // sidebar is not compatible with layout topnav.

        $fixedSidebar = config('adminlte.layout_fixed_sidebar', false);

        if (! self::isLayoutTopnavEnabled() && $fixedSidebar) {
            $classes[] = 'layout-fixed';
        }

        // Add classes related to fixed navbar/footer configuration. The fixed
        // navbar/footer is not compatible with layout boxed.

        if (! self::isLayoutBoxedEnabled()) {
            array_push($classes, ...self::makeFixedResponsiveClasses('navbar'));
            array_push($classes, ...self::makeFixedResponsiveClasses('footer'));
        }

        return $classes;
    }

    /**
     * Makes the set of classes related to a fixed responsive configuration.
     *
     * @param  string  $section  The layout section (navbar or footer)
     * @return array
     */
    private static function makeFixedResponsiveClasses($section)
    {
        $classes = [];
        $cfg = config("adminlte.layout_fixed_{$section}", false);

        if ($cfg === true) {
            $cfg = ['xs' => true];
        }

        // At this point the config should be an array.

        if (! is_array($cfg)) {
            return $classes;
        }

        // Make the set of responsive classes in relation to the config.

        foreach ($cfg as $breakpoint => $enabled) {
            if (in_array($breakpoint, self::$screenBreakpoints)) {
                $classes[] = self::makeFixedResponsiveClass(
                    $section,
                    $breakpoint,
                    $enabled
                );
            }
        }

        return $classes;
    }

    /**
     * Makes a responsive class for the navbar/footer fixed mode on a particular
     * breakpoint token.
     *
     * @param  string  $section  The layout section (navbar or footer)
     * @param  string  $bp  The screen breakpoint (xs, sm, md, lg, xl)
     * @param  bool  $enabled  Whether to enable fixed mode (true, false)
     * @return string
     */
    private static function makeFixedResponsiveClass($section, $bp, $enabled)
    {
        // Create the class prefix.

        $prefix = ($bp === 'xs') ? 'layout' : "layout-{$bp}";

        // Create the class suffix.

        $suffix = $enabled ? 'fixed' : 'not-fixed';

        // Return the responsice class for fixed mode.

        return "{$prefix}-{$section}-{$suffix}";
    }

    /**
     * Makes the set of classes related to the main left sidebar configuration.
     *
     * @return array
     */
    private static function makeSidebarClasses()
    {
        $classes = [];

        // Add classes related to the "sidebar_mini" configuration.

        $sidebarMiniCfg = config('adminlte.sidebar_mini', 'lg');

        if (in_array($sidebarMiniCfg, self::$sidebarMiniValues)) {
            $suffix = $sidebarMiniCfg === 'lg' ? '' : "-{$sidebarMiniCfg}";
            $classes[] = "sidebar-mini{$suffix}";
        }

        // Add classes related to the "sidebar_collapse" configuration.

        $sidebarCollapse = config('adminlte.sidebar_collapse', false)
            || ! empty(View::getSection('sidebar_collapse'));

        if ($sidebarCollapse) {
            $classes[] = 'sidebar-collapse';
        }

        return $classes;
    }

    /**
     * Makes the set of classes related to the right sidebar configuration.
     *
     * @return array
     */
    private static function makeRightSidebarClasses()
    {
        $classes = [];

        // Add classes related to the "right_sidebar" configuration.

        $rightSidebarPush = config('adminlte.right_sidebar', false)
            && config('adminlte.right_sidebar_push', false);

        if ($rightSidebarPush) {
            $classes[] = 'control-sidebar-push';
        }

        return $classes;
    }

    /**
     * Makes the set of classes related to custom body classes configuration.
     *
     * @return array
     */
    private static function makeCustomBodyClasses()
    {
        $classes = [];
        $cfg = config('adminlte.classes_body', '');

        if (is_string($cfg) && ! empty($cfg)) {
            $classes[] = $cfg;
        }

        return $classes;
    }

    /**
     * Makes the set of classes related to the dark mode.
     *
     * @return array
     */
    private static function makeDarkModeClasses()
    {
        $classes = [];

        // Use the dark mode controller to check if dark mode is enabled.

        $darkModeCtrl = new DarkModeController();

        // Dispatch an event to notify we are about to read the dark mode
        // preference. A listener may catch this event in order to setup the
        // dark mode initial state using the methods provided by the controller.

        event(new ReadingDarkModePreference($darkModeCtrl));

        // Now, check if dark mode is enabled.

        if ($darkModeCtrl->isEnabled()) {
            $classes[] = 'dark-mode';
        }

        return $classes;
    }
}
