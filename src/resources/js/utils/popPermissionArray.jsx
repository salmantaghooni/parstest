import React from 'react';

export default function popPermissionArray(page, itemName) {
    if (page != null) {
        let arr = localStorage.getItem(itemName);
        if (arr != null && arr !== "null") {
            arr = arr.split(",").filter(item => item !== page);
            // localStorage.removeItem(itemName);
            arr.splice(0, 1);
            if (arr.length > 0) {
                localStorage.setItem(itemName, arr);
                let newIncorrect = localStorage.getItem(itemName).split(",");
                return newIncorrect;
            }
        }
    }
    return null;
}
