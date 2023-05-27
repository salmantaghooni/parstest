import axios from 'axios';
import React from 'react';
import { useNavigate } from 'react-router-dom';
import checkToken from "./checkToken";


export default async function postAxios(url, parameter, isToken) {
    return await axios
        .post(url, parameter != null  ? parameter : [], {
        headers: {
            'Authorization': isToken ? `Bearer ` + localStorage?.getItem("access_token") : '',
            'Accept-Language': "fa",

        }
    });
}
