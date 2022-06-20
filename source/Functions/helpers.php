<?php

/**
 * @return boolean
 */
function in_dev(): bool
{
    return CONF_APP_LOCAL === "dev" ? true : false;
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
 * @return string|null
 */
function app_name(): ?string
{
    return CONF_APP_NAME;
}
