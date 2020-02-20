<?php
    
    function mt_str_to_url($stringa)
        {
            $urlstyle = filter_var($stringa, FILTER_SANITIZE_ENCODED);
            //$urlstyle = urlencode($stringa);
            return $urlstyle;
        }

    function mt_url_to_str($stringa)
        {
            $rightstyle = urldecode($stringa);
            return $rightstyle;
        }