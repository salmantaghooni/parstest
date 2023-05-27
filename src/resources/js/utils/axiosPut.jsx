import axios from 'axios';
import { method } from 'lodash';
import React from 'react';
import { useNavigate } from 'react-router-dom';


export default async function putAxios(url, dataPost, isToken) {
    let access_token = localStorage?.getItem("access_token");
    if ((access_token == undefined || access_token == "" || access_token == null) && isToken)

    window.location.href = "/";

    let dt=null;
    let breaked =true;
    var data = dataPost;
    if(dataPost !=false)
    dt = Object?.keys(dataPost)?.map(function(key,value) {

          if(breaked){
            if (key == "openAccountId" && (value == 0 || value == null|| value == "null")) {
                breaked = false;
                return ({ ...dataPost,  openAccountId:localStorage?.getItem("openAccountId")});
             }else{
                breaked = false;
                return (data);
            }
          }

     });
    else if (localStorage?.getItem("openAccountId") != null && localStorage?.getItem("openAccountId") != "null" && localStorage?.getItem("openAccountId") != undefined && localStorage?.getItem("openAccountId") != "undefined")
        dt = { openAccountId: localStorage?.getItem("openAccountId") };
    else
        dt=[]
    return await axios
        .put(url, dt != null && dt != undefined && dataPost==false ? dt : dataPost, {
        headers: {
            'Authorization': `Bearer ` + access_token,
            'Accept-Language': "fa",

        }

    });
}
