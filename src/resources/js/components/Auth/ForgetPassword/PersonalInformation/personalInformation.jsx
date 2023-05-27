import React, {useEffect, useRef, useState} from 'react';
import postAxios from '../../../../utils/axios';
import ErrorHandler from '../../../../utils/errorHandler';
import baseUrl from '../../../../utils/baseUrl';
import {useLocation, useNavigate} from 'react-router-dom';
import {ToastContainer} from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import AnimatePage from '../../../../utils/animatePage';
import "animate.css/animate.min.css";
import FixNumber from '../../../../utils/toEnNumber';
import AnimateLoading from '../../../../utils/loading';
import checkToken from "../../../../utils/checkToken";
import {FormattedMessage} from "react-intl";
import validator from 'validator';

const PersonalInformation = () => {

    const [loading, setLoading] = useState(false);
    const [phoneNumber, setPhoneNumber] = useState("");
    const [errorEmptyPhoneNumber, setErrorEmptyPhoneNumber] = useState(false);
    const [errorWrongPhoneNumber, setErrorWrongPhoneNumber] = useState(false);
    const [errorNationalCode, setErrorNationalCode] = useState(false);
    const [handleKeyPass, setHandleKeyPass] = useState(false);
    const [isRtl, setIsRtl] = useState(false);
    const navigate = useNavigate();
    const [nationalCode, setNationalCode] = useState("");


    const userInformation = () => {
        setLoading(true);
        setErrorEmptyPhoneNumber(false);
        setErrorWrongPhoneNumber(false);
        setErrorNationalCode(false);
        const NationalCodevalidate = validateNationalCode(nationalCode);
        if (NationalCodevalidate) {
            if (phoneNumber.length === 0) {
                setErrorEmptyPhoneNumber(true);
                setLoading(false);
            } else if (phoneNumber.length < 11) {
                setErrorWrongPhoneNumber(true);
                setLoading(false);
            } else if (!validator?.isMobilePhone(phoneNumber, 'fa-IR')) {
                setErrorWrongPhoneNumber(true);
                setLoading(false);
            } else {
                let axios = postAxios(baseUrl() + "forgetpassword/information", {
                    national_code: nationalCode,
                    phone_number: phoneNumber,
                }, false);
                axios.catch(error => {
                    ErrorHandler(error);
                    setLoading(false);
                });
                axios.then(data => {
                    setLoading(false);
                    if (data?.data?.response?.ui_state == 205) {
                        localStorage.removeItem("otp-time");
                        navigate('/forgetpassword/otp', {
                            state: {
                                phoneNumber: phoneNumber,
                                nationalCode: nationalCode
                            }
                        });
                    } else if (data?.data?.response?.ui_state == 204) {
                        navigate('/forgetpassword/information');
                    }
                });
            }
        } else {
            setErrorNationalCode(true);
            setLoading(false);
        }

    }

    const validateNationalCode = (nc) => {
        if (nc.trim() == '') {
            return false;
        } else if (nc.length != 10) {
            return false;
        } else {
            var sum = 0;
            for (var i = 0; i < 9; i++) {
                sum += parseInt(nc[i]) * (10 - i);
            }
            var lastDigit;
            var divideRemaining = sum % 11;
            if (divideRemaining < 2) {
                lastDigit = divideRemaining;
            } else {
                lastDigit = 11 - (divideRemaining);
            }
            if (parseInt(nc[9]) == lastDigit) {
                return true;
            } else {
                return false;
            }
        }
    }


    return (
        <AnimatePage>
            <div id="page">
                <div className="col-lg-12 col-12 text-end mx-auto p-2">
                    <div className="header-logo text-end">
                        <img src="/images/Frame 3527.svg"/>
                    </div>
                </div>
                <div className="container">
                    <div className="row">
                        <div className="col-12 order-2 order-lg-1 col-lg-7  animate__animated animate__fadeInDown">
                            <div className="form-register form">
                                <div id="login-box">
                                    <div className="form-page">
                                        <h1 className="title">فراموشی رمز عبور</h1>
                                    </div>
                                    <div className="form-group form-group-login mb-3">
                                        <label>شناسه ملی</label>
                                        <input
                                            style={isRtl ? {textAlign: "left", direction: "ltr"} : {textAlign: "right"}}
                                            onChange={(e) => {
                                                setNationalCode(e.target.value)
                                            }}
                                            name="nationalCode" type="tel"
                                            maxLength="10" className="form-control input-style-login" id="nationalCode"
                                            autoFocus={true} placeholder="شناسه ملی خود را وارد کنید"/>
                                    </div>
                                    <div style={errorNationalCode ? {
                                        display: "flex",
                                        visibility: "visible",
                                        paddingBottom: "7px",
                                        alignItems: "center"
                                    } : {
                                        visibility: "hidden",
                                        display: "none"
                                    }}
                                         className="text-error ">شناسه ملی خود را به صورت صحیح وارد کنید
                                    </div>
                                    <div className="form-group form-group-login mb-3">
                                        <label>شماره همراه</label>
                                        <input
                                            style={isRtl ? {textAlign: "left", direction: "ltr"} : {textAlign: "right"}}
                                            onChange={(e) => {
                                                setPhoneNumber(e.target.value)
                                            }}
                                            name="password" type="tel"
                                            maxLength="20" className="form-control input-style-login" id="password"
                                            placeholder="شماره همراه خود را وارد کنید"
                                        />
                                    </div>
                                    <div style={errorWrongPhoneNumber ? {
                                        display: "flex",
                                        visibility: "visible",
                                        paddingBottom: "15px",
                                        alignItems: "center"
                                    } : {
                                        visibility: "hidden",
                                        display: "none"
                                    }}
                                         className="text-error ">فرمت شماره همراه وارد شده صحیح نمیباشد.
                                    </div>
                                    <div style={errorEmptyPhoneNumber ? {
                                        display: "flex",
                                        visibility: "visible",
                                        paddingBottom: "15px",
                                        alignItems: "center"
                                    } : {
                                        visibility: "hidden",
                                    }}
                                         className="text-error ">شماره همراه خود را وارد کنید
                                    </div>
                                    <div className="d-grid gap-2">
                                        <button
                                            onClick={userInformation}
                                            type="button"
                                            className="btn facility-btn  btn-primary btn-block btn-md rounded height-45">
                                            {loading ? <AnimateLoading type="bubbles" color="#fff"/> : 'ورود'}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="col-lg-5 col-12 order-lg-2 order-1 animate__animated animate__fadeInDown">
                            <div className="">
                                <div className="logo-style">
                                    <div className="logo"><img src="/images/SVG/Metabank - B - Logo with text.svg"/>
                                    </div>
                                    <div className="logo-img"><img src="/images/Apartment.svg"/></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AnimatePage>
    )
}

export default PersonalInformation;
