<?php

namespace WarpHtmx;

// WHY?
class ScriptLocalizations {

    static public function languageStrings(){
        return [
            'search_title' => _x('Enter search terms', 'search form title', WARP_HTMX_TEXT_DOMAIN)
        ];
    }

    static public function locationStrings(){
        return [
            'ajax_url' => admin_url('admin-ajax.php'),
        ];
    }

    static public function as_array(){
        return array_merge(self::languageStrings(), self::locationStrings() );
    }
}