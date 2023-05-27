import React from 'react';

export default function navigateFacilities(page) {
    switch (parseInt(page)) {
        case 1:
            url = "/facilities/rule";
            break;
        case 2:
            url = "/userverify/datepicker";
            break
        case 3:
            url = "/userverify/validation";
            break;
        case 4:
            url = "/facilities/installmentcalculation";
            break;
        case 5:
            url = "/facilities/detailsinstallmentcalculation";
            break;
        case 6:
            url = "/facilities/collateralresult";
            break;
        case 7:
            url = "/facilities/collateralsuccess";
            break;
    }
    return url;
}
