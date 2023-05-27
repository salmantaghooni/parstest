import axios from 'axios';
import React from 'react';
import { useNavigate } from 'react-router-dom';


export default async function getAxios(url, isToken) {
    let access_token = localStorage?.getItem("access_token");
    if ((access_token == undefined || access_token == "" || access_token == null) && isToken)
    window.location.href = "/";
    return await axios
        .get(url, {
        headers: {
            'Authorization': `Bearer ` + access_token,
            'Accept-Language': "fa",
        }
    });
}
