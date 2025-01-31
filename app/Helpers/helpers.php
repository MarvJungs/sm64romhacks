<?php

use Carbon\CarbonInterval;

function parseEditorText($prop)
{
    switch ($prop->type) {
        case 'paragraph':
            return '<p>' . $prop->data->text . '</p>';
        case 'header':
            $headerLevel = $prop->data->level;
            return "<h$headerLevel>" . $prop->data->text . "</h$headerLevel>";
        case 'list':
            $listStyle = $prop->data->style == 'ordered' ? 'ol' : 'ul';
            $listItems = '';
            foreach ($prop->data->items as $item) {
                $listItems .= '<li>' . $item . '</li>';
            }
            return "<$listStyle>$listItems</$listStyle>";
        case 'table':
            $table = '<table class="table table-bordered table-hover">';
            foreach ($prop->data->content as $rows) {
                $table .= '<tr>';
                foreach ($rows as $col) {
                    $table .= '<td>' . $col . '</td>';
                }
                $table .= '</tr>';
            }
            $table .= '</table>';
            return $table;
        default:
            break;
    }
}

function getDiscordEmbedText($text)
{
    $result = '';
    if (is_null($text)) {
        return $result;
    }
    foreach (json_decode($text) as $prop) {
        switch ($prop->type) {
            case 'paragraph':
                $result .= $prop->data->text;
                break;
            case 'list':
                $listItems = '';
                foreach ($prop->data->items as $index => $item) {
                    $listStyle = $prop->data->style == 'ordered' ? $index . '. ' : '- ';
                    $listItems .= $listStyle . $item;
                }
                $result .= $listItems;
                break;
            default:
                break;
        }
        $result .= "\n\n";
    }
    $result = strip_tags($result);
    $result = str_replace('&nbsp;', ' ', $result);
    return $result;
}

function getOpenGraphText($text)
{
    $result = '';
    if (is_null($text)) {
        return $result;
    }
    foreach (json_decode($text) as $prop) {
        if ($prop->type == 'paragraph') {
            $result .= $prop->data->text;
        }
    }
    return $result;
}

function getYouTubeVideoID($url)
{
    $parsedUrl = parse_url($url);

    // Check if the URL contains a query string
    if (!empty($parsedUrl['query'])) {
        parse_str($parsedUrl['query'], $queryVars);
        if (isset($queryVars['v'])) {
            return $queryVars['v'];
        }
    }

    // Check for shortened URL formats like youtu.be/VIDEO_ID
    if (isset($parsedUrl['host']) && $parsedUrl['host'] == 'youtu.be') {
        return trim($parsedUrl['path'], '/');
    }

    return false; // Return false if no video ID is found
}

function convertDurationToSeconds($duration): int
{
    try {
        [$hours, $minutes, $seconds] = explode(":", $duration);
        return $hours * 3600 + $minutes * 60 + $seconds;
    } catch (\Throwable $th) {
        return $duration;
    }
}

function convertSecondsToDuration($seconds): string
{
    return CarbonInterval::seconds($seconds)->cascade()->format('%H:%I:%S');
}
