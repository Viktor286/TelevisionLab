<?php


function isChecked($get_data, $value)
{
    if (isset($get_data)) {
        echo(in_array($value, $get_data) ? 'checked="checked"' : '');
    };
}

;

function isSelected($get_data, $value)
{
    if (!is_array($get_data)) {
        $get_data = array($get_data);
    }
    if (isset($get_data)) {
        echo(in_array($value, $get_data) ? 'selected="selected"' : '');
    };
}

;

function matchChecked($mQ, $value)
{
    if (isset($mQ)) {
        echo(preg_match($value, $mQ) ? 'checked="checked"' : '');
    };
}

;

function matchSelected($mQ, $value)
{
    if (isset($mQ)) {
        echo(preg_match($value, $mQ) ? 'selected="selected"' : '');
    };
}

;
