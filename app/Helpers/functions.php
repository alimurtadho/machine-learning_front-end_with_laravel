<?php

function demoteHtmlHeaderTags($html)
{
    $originalHeaderTags = [];
    $demotedHeaderTags = [];
    foreach (range(100, 1) as $index) {
        $originalHeaderTags[] = '<h'.$index.'>';
        $originalHeaderTags[] = '</h'.$index.'>';
        $demotedHeaderTags[] = '<h'.($index + 2).'>';
        $demotedHeaderTags[] = '</h'.($index + 2).'>';
    }
    return str_ireplace($originalHeaderTags, $demotedHeaderTags, $html);
}

function markdownToDemotedHtml($markdown)
{
    return \Markdown::convertToHtml($markdown);
}

function makeLinksClickable($string , $tags = [])
{
    $url = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';
    $string = preg_replace($url, '<a href="$0" target="_blank" title="$0">$0</a>', htmlentities($string));
    $string = preg_replace('/(^|\s)@([a-z0-9_]+)/i', '$1<a href="https://www.twitter.com/$2" target="_blank">@$2</a>', $string);
    foreach($tags as $tag) {
        $string = str_replace("#".$tag, "<a href=\"https://twitter.com/search?f=tweets&q=%23{$tag}\" target=\"_blank\">#{$tag}</a>", $string);
    }
    return $string;
}

if (!function_exists('alert')) {
    /**
     * Arrange for an alert message.
     *
     * @param string|null $message
     * @param string      $title
     *
     * @return \App\Ux\SweetAlert\SweetAlertNotifier
     */
    function alert($message = null, $title = '')
    {
        $notifier = app('alert');
        if (!is_null($message)) {
            return $notifier->message($message, $title);
        }
        return $notifier;
    }
}

if (!function_exists('sizeForHumans')) {
    /**
     * Convert bytes to human readable format.
     *
     * @param     $bytes
     * @param int $decimals
     *
     * @return string
     */
    function sizeForHumans ($bytes, $decimals = 2)
    {
        $size   = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
}