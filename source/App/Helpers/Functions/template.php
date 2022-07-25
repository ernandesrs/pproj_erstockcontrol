<?php

/**
 * @param string $text
 * @param string $style
 * @param string $activeIcon
 * @param string|null $link
 * @param string|null $altIcon
 * @param string|null $id
 * @return array
 */
function t_button_elem(string $text, string $style, string $activeIcon, ?string $link = null, ?string $altIcon = null, ?string $id = null): array
{
    return t_clickable_elem("button", $text, $style, $activeIcon, $link, $altIcon, $id);
}

/**
 * @param string $text
 * @param string $style
 * @param string $activeIcon
 * @param string|null $link
 * @param string|null $altIcon
 * @param string|null $id
 * @return array
 */
function t_button_link_elem(string $text, string $style, string $activeIcon, ?string $link = null, ?string $altIcon = null, ?string $id = null): array
{
    return t_clickable_elem("link", $text, $style, $activeIcon, $link, $altIcon, $id);
}

/**
 * @param string $type
 * @param string $text
 * @param string $style
 * @param string $activeIcon
 * @param string|null $link
 * @param string|null $altIcon
 * @param string|null $id
 * @return array
 */
function t_clickable_elem(string $type = "button", string $text, string $style, string $activeIcon, ?string $link = null, ?string $altIcon = null, ?string $id = null): array
{
    return [
        "id" => $id,
        "type" => $type,
        "text" => $text,
        "style" => $style,
        "link" => $link,
        "activeIcon" => $activeIcon,
        "altIcon" => $altIcon
    ];
}

/**
 * @param string $style
 * @param string $message
 * @param string|null $text
 * @param string|null $icon
 * @param string|null $link
 * @return string|null
 */
function t_button_confirmation_elem(string $style, string $message, ?string $text = null, ?string $icon = null, ?string $link = null): ?string
{
    return t_clickable_confirmation_elem("button", $style, $message, $text, $icon, $link);
}

/**
 * @param string $style
 * @param string $message
 * @param string|null $text
 * @param string|null $icon
 * @param string|null $link
 * @return string|null
 */
function t_button_link_confirmation_elem(string $style, string $message, ?string $text = null, ?string $icon = null, ?string $link = null): ?string
{
    return t_clickable_confirmation_elem("link", $style, $message, $text, $icon, $link);
}

/**
 * @param string $type
 * @param string $style
 * @param string $message
 * @param string $text
 * @param string $icon
 * @param string|null $link
 * @return string|null
 */
function t_clickable_confirmation_elem(string $type = "button", string $style, string $message, ?string $text = null, ?string $icon = null, ?string $link = null): ?string
{
    $btnType = $type;
    $btnText = $text;
    $btnStyle = $style;
    $btnMessage = $message;
    $btnIconClass = $icon;
    $btnUrlAction = $link;

    ob_start();
    require CONF_BASE_DIR . CONF_VIEWS_DIR . "/includes/button-confirmation.php";
    $button = ob_get_clean();

    return $button;
}
