<?php

namespace Granola;

/**
 * Retrieve a partial from the theme and pass arguments to it.
 *
 * Like https://developer.wordpress.org/reference/functions/get_template_part
 * but allows for arguments to be passed in the form or an array. Each partial
 * defines its own array arguments so view each partial to see what you
 * can/should pass
 * @param string $path
 * @param array $args
 * @return string $content
 */
function render(string $partial, $args = ''): string
{
    // Allow us to filter the data going through the render function
    $args = apply_filters('granola/render/' . $partial, $args);
    $args = apply_filters('granola/render', $args);

    $path = \Granola\resolve($partial);

    ob_start();

    // Push the current partial on to the stack
    \Granola\pushPartial($partial, $args);

    // Render the partial
    require $path;

    // Pop the current partial off the stack
    \Granola\popPartial();

    return ob_get_clean();
}

function partialStack(): array
{
    self:initRenderStack();

    global $granolaRenderStack;

    return $granolaRenderStack;
}

function currentPartial(): array
{
    self:initRenderStack();

    global $granolaRenderStack;

    if (!empty($granolaRenderStack)) {
        return array_values(array_slice($granolaRenderStack, -1))[0];
    }

    return [];
}

function pushPartial(string $partial, $args = ''): void
{
    self:initRenderStack();

    global $granolaRenderStack;

    $granolaRenderStack[] = [
        'partial' => $partial,
        'args' => $args
    ];
}

function popPartial(): void
{
    self:initRenderStack();

    global $granolaRenderStack;

    array_pop($granolaRenderStack);
}

function initRenderStack(): void
{
    global $granolaRenderStack;

    if (!is_array($granolaRenderStack)) {
        $granolaRenderStack = [];
    }
}
