import React from 'react';

export default function checkEditPermission(page, pages) {
    let bool = true;
    if (pages != null && pages != "null" && pages != "" && pages != undefined && page != "undefined") {
        let pg = pages?.split(",")?.filter(result => parseInt(result) == parseInt(page));
        if (pg?.length>0) {
            return true;
        }else return false;
        return bool;
    }
}

