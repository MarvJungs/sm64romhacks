<?php

use function PHPSTORM_META\type;

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
