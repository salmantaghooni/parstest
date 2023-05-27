const  detailsDrawerTitle = (status) => {
    let title = "a";
    let situation = "a";
    switch (parseInt(status)) {
        case 0:
            title = "شروع افتتاح حساب";
            situation = "ایجاد شده"
            break;
        case 1:
            title = "فرآیند افتتاح حساب";
            situation = "ثبت شده";
            break;
        case 2:
            title = "فرآیند افتتاح حساب";
            situation = "رد شده";
            break;
        case 3:
            title = "اصلاح مدارک";
            situation = "نیاز به اصلاح";
            break;
        case 4:
            title = "فرآیند افتتاح حساب";
            situation = "تایید شده";
            break;
        case 5:
            title = "فرآیند افتتاح حساب";
            situation = "تعریف شده";
            break;
        case 6:
            title = "فرآیند افتتاح حساب";
            situation = "افتتاح شده";
            break;
        case 7:
            title = "فرآیند افتتاح حساب";
            situation = "صدور کارت";
            break;
        case 8:
            title = "فرآیند افتتاح حساب";
            situation = "تکمیل شده";
            break;
    }
    return {title, situation};
}

export default detailsDrawerTitle;
