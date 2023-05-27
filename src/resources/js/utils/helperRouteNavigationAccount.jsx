const userAccountRoute = (page) => {
    let url="a";
    switch (parseInt(page)) {
        case 1:
            url = "/account/datepicker";
            break;
        case 2:
            url = "/account/baseinformation";
            break;
        case 3:
            url = "/account/uploadnationalcard";
            break;
        case 4:
            url = "/account/birthcertificate";
            break;
        case 5:
            url = "/account/nationalserial";
            break;
        case 6:
            url = "/account/selfie";
            break;
        case 7:
            url = "/account/videoselfie";
            break;
        case 8:
            url = "/account/locationinformation";
            break;
        // case 9:
        //     url = "/account/completeinformation";
        //     break;
        case 10:
            url = "/account/selectbranch";
            break;
        case 11:
            url = "/account/signature";
            break;
        case 12:
            url = "/account/accounts";
            break;
    }
    return url;
}

export default userAccountRoute;
