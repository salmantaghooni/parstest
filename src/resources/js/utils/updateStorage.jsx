import React from 'react';
import postAxios from "./axios";
import baseUrl from "./baseUrl";
import ErrorHandler from "./errorHandler";

export default function updateStorage(storageName, storageValue, storageKey) {
    let array = JSON.parse(localStorage?.getItem(storageName.toString()));
    if (array != null && array !== "null") {
        Object.keys(array).forEach(function(key, index) {
            if (key == storageKey)
                array[key] = storageValue ;
        });
         localStorage.setItem(storageName, JSON.stringify(array));
    }
}

// export default function updateStorage(storageName, storageValue, storageKey) {
//     let array = JSON.parse(localStorage?.getItem(storageName.toString()));
//     // console.log(array["first_name_en"]);
//     if (array != null && array !== "null") {
//         storageKey.map((KeyA, indexA) => {
//                 Object.keys(array).forEach(function (KeyB, indexB) {
//                     if (KeyB == KeyA) {
//                         storageValue.map((KeyC, indexC) => {
//                             // console.log(array[arrKey]);
//                             console.log(storageValue[KeyC]);
//                             array[KeyB] = storageValue[KeyC];
//                             // console.log(array["first_name_en"]);
//                             // localStorage.setItem(storageName, JSON.stringify(array));
//                         });
//                     }
//                 });
//             }
//         );
//     }
//
// }


// export default function updateStorage() {
//     let axios = postAxios(baseUrl() + "account/openaccountlist", false, true);
//     axios.then(data => {
//         localStorage.removeItem("openAccountEdit");
//         if (data?.data?.response?.exist_acc != null){
//             localStorage.setItem("openAccountEdit", JSON.stringify(data?.data?.response?.exist_acc));
//         }
//     });
//     axios.catch(error => {
//         ErrorHandler(error);
//     });
// }
