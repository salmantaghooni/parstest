const userVerifyRoute = (page) => {
    let url="";
    if (page!=null)
    switch (parseInt(page)) {
        case 1:
            url = "/facilities/accounts";
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
            url = "/facilities/collateralissuing";
            break;
        case 7:
            url = "/facilities/collateralsuccess";
            break;
    }
    return url;
}

export default userVerifyRoute;
