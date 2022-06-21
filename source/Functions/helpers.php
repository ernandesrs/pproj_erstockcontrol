<?php

/**
 * @return boolean
 */
function in_dev(): bool
{
    return CONF_APP_LOCAL === "dev" ? true : false;
}

/**
 * @return string|null
 */
function app_name(): ?string
{
    return CONF_APP_NAME;
}

/**
 * @param string|null $path
 * @return string
 */
function url(?string $path = null): string
{
    return $path ? (CONF_URL_BASE . "/{$path}") : CONF_URL_BASE;
}

/**
 * @param string $asset
 * @return string|null
 */
function asset(string $asset): ?string
{
    if ($asset[0] == "/")
        $asset = substr($asset, 1, strlen($asset));

    return url() . CONF_ASSETS_DIR . "/" . $asset;
}

/**
 * @param string $name
 * @return string
 */
function icon_class(string $name): string
{
    return (CONF_ICONS[$name] ?? null) ? "icon " . CONF_ICONS[$name] : "";
}

/**
 * @param string $name
 * @param string|null $alt
 * @return string
 */
function icon_elem(string $name, ?string $alt = null): string
{
    $icon = icon_class($name);
    $attr = "class='icon {$icon}'";
    if ($alt)
        $attr .= " data-active-icon='{$icon}' data-alt-icon='" . icon_class($alt) . "'";

    return "<i {$attr}></i>";
}
