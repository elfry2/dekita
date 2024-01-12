<?php
function url_update_query_string(string $url, array $newQueries) : string {

    /**
     *  If there's no query to update, just return the url right away.
     */
    if(count($newQueries) <= 0) return $url;

    /**
     * Parse the URL and its query string.
     */
    $url = parse_url($url);

    parse_str($url['query'], $urlQueries);

    /**
     * Replace the value of every matching URL query string key with the
     * supplied value. If the supplied key is inexistent in the URL, create it.
     */
    foreach($newQueries as $key => $value) {
        $isFound = false;

        foreach($urlQueries as $urlQueryKey => $urlQueryValue) {

            if($urlQueryKey == $key) {

                $urlQueries[$urlQueryKey] = $value;

                $isFound = true;
            }

            if(!$isFound) $urlQueries[$key] = $value;
        }
    }

    /**
     * Rebuild the URL with the new query string.
     */
    $url['query'] = http_build_query($urlQueries);

    $newUrl = '';

    if(isset($url['scheme'])) $newUrl .= $url['scheme'];

    if(isset($url['host'])) $newUrl .= '://' . $url['host'];

    if(isset($url['port'])) $newUrl .= ':' . $url['port'];

    if(isset($url['path'])) $newUrl .= $url['path'];

    if(isset($url['query'])) $newUrl .= '?' . $url['query'];

    if(isset($url['fragment'])) $newUrl .= '#' . $url['fragment'];


    return $newUrl;
}
