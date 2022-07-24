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
    return t_clicable_elem("button", $text, $style, $activeIcon, $link, $altIcon, $id);
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
    return t_clicable_elem("link", $text, $style, $activeIcon, $link, $altIcon, $id);
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
function t_clicable_elem(string $type = "button", string $text, string $style, string $activeIcon, ?string $link = null, ?string $altIcon = null, ?string $id = null): array
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
