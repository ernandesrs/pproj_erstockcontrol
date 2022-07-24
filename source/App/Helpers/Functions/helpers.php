<?php

use Components\Router\Router;

/**
 * @return boolean
 */
function in_dev(): bool
{
    return CONF_APP_LOCAL;
}

/**
 * @return boolean
 */
function is_post_request(): bool
{
    return $_SERVER["REQUEST_METHOD"] == "POST";
}

/**
 * @return boolean
 */
function is_get_request(): bool
{
    return $_SERVER["REQUEST_METHOD"] == "GET";
}

/**
 * @return boolean
 */
function is_ajax_request(): bool
{
    return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
}

/**
 * @return string
 */
function csrf_token(): string
{
    $token = base64_encode(uniqid());
    session()->add("____csrfToken", $token);
    return $token;
}

/**
 * @return string
 */
function csrf_input(): string
{
    return "<input type='hidden' name='__csrfToken' value='" . csrf_token() . "' />";
}

/**
 * @param array $form
 * @return boolean
 */
function csrf_token_verify(array $form): bool
{
    $formToken = $form["__csrfToken"] ?? null;
    $globalToken = $_SERVER["HTTP_X_CSRF_TOKEN"] ?? null;

    if (!$formToken && !$globalToken)
        return false;

    $token = $formToken ?? $globalToken;
    if ($token === session()->get("____csrfToken"))
        return true;

    return false;
}

/**
 * @param string $name
 * @param integer $limit
 * @param integer $block_time
 * @return boolean
 */
function attempt_limit(string $name, int $limit = 3, int $block_time = 5): bool
{
    $attempts = session()->get($name);

    if (!$attempts) {
        session()->add($name, (object) [
            "count" => 1,
            "limit" => $limit,
            "block_time" => $block_time,
            "time" => null,
            "last_update" => time()
        ]);
        return false;
    }

    // COUNT RESET
    if (strtotime("+{$attempts->block_time}minutes", $attempts->last_update) <= time())
        $attempts->count = 0;

    $attempts->last_update = time();

    if ($attempts->count < $limit) {
        $attempts->count += 1;
        session()->update($name, $attempts);
        return false;
    }

    if ($attempts->time && strtotime("+{$attempts->block_time}minutes", $attempts->time) <= time()) {
        $attempts->count = 1;
        $attempts->time = null;
        session()->update($name, $attempts);
        return false;
    }

    $attempts->time = $attempts->time ?? time();
    session()->update($name, $attempts);

    return true;
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
    $path = $path ? ($path[0] == "/" ? (substr($path, 1, strlen($path))) : $path) : null;
    return $path ? (CONF_URL_BASE . "/{$path}") : CONF_URL_BASE;
}

/**
 * @param array|null $exceptArr
 * @return array|null
 */
function url_params(?array $exceptArr = null): ?array
{
    $get = $_GET;
    $except = array_merge(($exceptArr ?? []), ["route"]);

    foreach ($except as $expt)
        unset($get[$expt]);

    return count($get) == 0 ? null : $get;
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
 * @param string $routeName
 * @param array $params
 * @return string|null
 */
function route(string $routeName, array $params = []): ?string
{
    return router()->route($routeName, $params);
}

/**
 * @param string $routeName
 * @param array $params
 * @return void
 */
function redirect(string $routeName, array $params = []): void
{
    router()->redirect($routeName, $params);
    return;
}

/**
 * @return Router
 */
function router(): Router
{
    return $GLOBALS["router"];
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

/**
 * @param string $name
 * @return string|null
 */
function get_term(string $name): ?string
{
    $names = explode(".", $name);

    if (count($names) > 5) return "";

    $terms = CONF_TERMS;

    foreach ($names as $name) {
        $terms = $terms[$name] ?? null;

        if (!$terms || is_string($terms))
            return $terms;
    }

    return null;
}

/**
 * @param string $name
 * @param null|array|object $datas
 * @return null|string
 */
function input_value(string $name, $datas): ?string
{
    $datas = is_array($datas) ? (object) $datas : (is_object($datas) ? $datas : null);
    if (!$datas) return null;
    return $datas->$name ?? null;
}

/**
 * @param null|string $path
 * @return string
 */
function shared_path(?string $path): string
{
    return CONF_BASE_DIR . "/shared" . ($path ? ($path[0] == "/" ? $path : "/{$path}") : null);
}

