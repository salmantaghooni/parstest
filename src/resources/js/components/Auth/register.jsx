import React, {useEffect, useRef, useState} from "react";
import postAxios from "../../utils/axios";
import ErrorHandler from "../../utils/errorHandler";
import baseUrl from "../../utils/baseUrl";
import {useLocation, useNavigate} from "react-router-dom";
import {ToastContainer} from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import AnimatePage from "../../utils/animatePage";
import "animate.css/animate.min.css";
import FixNumber from "../../utils/toEnNumber";
import AnimateLoading from "../../utils/loading";
import checkToken from "../../utils/checkToken";

const Register = () => {
    const [loading, setLoading] = useState(false);
    const [phoneNumber, setPhoneNumber] = useState("");
    const [errorPhoneNumber, setErrorPhoneNumber] = useState(false);
    const [errorNationalCode, setErrorNationalCode] = useState(false);
    const [errorPassword, setErrorPassword] = useState(false);
    const [errorPasswordNull, setErrorPasswordNull] = useState(false);
    const [errorConfirmPassword, setErrorConfirmPassword] = useState(false);
    const [handleKeyPass, setHandleKeyPass] = useState(false);
    const [isRtl, setIsRtl] = useState(false);
    const navigate = useNavigate();
    const location = useLocation();
    const [nationalCode, setNationalCode] = useState("");
    const [password, setPassword] = useState("");
    const [confirmPassword, setConfirmPassword] = useState("");

    const handleKeyDown = (event) => {
        if (nationalCode === "" && nationalCode == null) {
            setErrorNationalCode(false);
        }
        if (validateNationalCode(nationalCode) && password === "" && password == null) {
            setErrorPasswordNull(true);
        }

        if (validateNationalCode(nationalCode) && password === confirmPassword) {
            setErrorPassword(false);
            setPassword(event.target.value);
        }
        if (validateNationalCode(nationalCode) && password.length > 0) {
            setErrorPasswordNull(false);
            setErrorConfirmPassword(false);
        }
        if (validateNationalCode(nationalCode) && confirmPassword.length > 0) {
            setErrorConfirmPassword(false);
        }
        if (validateNationalCode(nationalCode) && password === "" && confirmPassword === "") {
            setErrorConfirmPassword("");
        }

        if (FixNumber(event.target.value)) {
            registerUser(FixNumber(event.target.value));
        }
        if (nationalCode.length > 0) {
            setIsRtl(false);
            setErrorNationalCode(false);
        }
    };
    const dis = () => {
        if (password != "" && password != null) {
            setHandleKeyPass({handleKeyPass: !handleKeyPass});
        } else {
            setHandleKeyPass(false);
        }
    };

    const handleEnter = (event) => {
        if (event.keyCode === 13) {
            event.preventDefault();
            setErrorPhoneNumber(false);
            setErrorPassword(false);
            setErrorConfirmPassword(false);
            if (!validateNationalCode(nationalCode)) return setErrorPhoneNumber(true);
            if (password.length >= 8) {
                return setErrorPassword(false);
                if (password === confirmPassword) {
                    registerUser(nationalCode, password);
                } else {
                    return setErrorConfirmPassword(true);
                }
            } else {
                return setErrorPassword(true);
            }
        }
    };
    useEffect(() => {
        // checkToken(true) ? navigate('/dashboard') : null;
        getPhoneNumber();
    }, []);

    const getPhoneNumber = () => {
        console.log(location?.state?.phoneNumber);
        if (location?.state?.phoneNumber !== undefined) setPhoneNumber(location?.state?.phoneNumber); else {
            navigate("/register");
        }
    };

    const validateNationalCode = (nc) => {
        if (nc.trim() == "") {
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
                lastDigit = 11 - divideRemaining;
            }
            if (parseInt(nc[9]) == lastDigit) {
                return true;
            } else {
                return false;
            }
        }
    };

    const registerUser = (nationalCode, password) => {
        if (validateNationalCode(nationalCode)) {
            setErrorNationalCode(false);
        } else {
            return setErrorNationalCode(true);
        }
        if (password.length >= 8 && nationalCode != "" && nationalCode != undefined && nationalCode != null && password !== "" && password === confirmPassword) {
            setLoading(true);
            setErrorNationalCode(false);
            let axios = postAxios(baseUrl() + "auth/metaregister", {
                national_code: nationalCode, phone_number: phoneNumber, password: password,
            }, false);
            axios.catch((error) => {
                ErrorHandler(error);
                setLoading(false);
                setErrorNationalCode(true);
            });
            axios.then((data) => {
                setLoading(false);
                if (data?.data?.response?.token != undefined && data?.data?.response?.token != "" && data?.data?.response?.token != null) {
                    localStorage.setItem("access_token", data?.data?.response?.token);
                    navigate("/dashboard");
                }
            });
        } else {
            if (password.length <= 8) {
                setErrorPassword(true);
            }
            if (password.length >= 8 && password !== confirmPassword) {
                setErrorConfirmPassword(true);
                setErrorPasswordNull(false);
            }
        }
    };

    return (<AnimatePage>
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
                                        <h1 className="title">
                                            ورود و ثبت نام{" "}
                                        </h1>
                                    </div>
                                    <div className="form-group form-group-login mb-3">
                                        <label>شناسه ملی</label>
                                        <div className="relative">
                                            <input
                                                style={isRtl ? {
                                                    textAlign: "left", direction: "ltr",
                                                } : {textAlign: "right"}}
                                                onKeyUp={(e) => {
                                                    handleKeyDown(e);
                                                }}
                                                onChange={(e) => setNationalCode(e.target.value)}
                                                name="nationalCode"
                                                type="tel"
                                                maxLength="10"
                                                className="form-control input-style-login"
                                                id="nationalCode"
                                                autoFocus={true}
                                                placeholder="شناسه ملی خود را وارد کنید"
                                            />
                                            {loading ? (<AnimateLoading
                                                    className={"absolute loading"}
                                                    type="spin"
                                                    color="#fff"
                                                />) : ("")}
                                        </div>
                                    </div>
                                    <div className="form-group form-group-login mb-3">
                                        <label>رمزعبور</label>
                                        <div className="relative">
                                            <input
                                                style={isRtl ? {
                                                    textAlign: "left", direction: "ltr",
                                                } : {textAlign: "right"}}
                                                onKeyUp={(e) => {
                                                    handleKeyDown(e), dis();
                                                }}
                                                onChange={(e) => setPassword(e.target.value)}
                                                name="password"
                                                type="password"
                                                maxLength="20"
                                                className="form-control input-style-login"
                                                id="password"
                                                autoFocus={true}
                                                placeholder="رمزعبور خود را وارد کنید"
                                            />
                                            {loading ? (<AnimateLoading
                                                    className={"absolute loading"}
                                                    type="spin"
                                                    color="#fff"
                                                />) : ("")}
                                        </div>
                                    </div>
                                    <div className="form-group form-group-login ">
                                        <label>تکرار رمز عبور</label>
                                        <div className="relative">
                                            <input
                                                style={isRtl ? {
                                                    textAlign: "left", direction: "ltr",
                                                } : {textAlign: "right"}}
                                                onKeyUp={(e) => {
                                                    handleKeyDown(e), dis();
                                                }}
                                                onChange={(e) => setConfirmPassword(e.target.value)}
                                                name="confirmPassword"
                                                type="password"
                                                maxLength="20"
                                                className="form-control input-style-login "
                                                disabled={handleKeyPass ? false : true}
                                                id="confirmPassword"
                                                autoFocus={true}
                                                placeholder="تکرار رمزعبور خود را وارد کنید"
                                            />
                                            {loading ? (<AnimateLoading
                                                    className={"absolute loading"}
                                                    type="spin"
                                                    color="#fff"
                                                />) : ("")}
                                        </div>
                                    </div>
                                    <div
                                        style={errorNationalCode ? {
                                            display: "flex",
                                            visibility: "visible",
                                            paddingTop: "4px",
                                            alignItems: "center",
                                        } : {visibility: "hidden"}}
                                        className="text-error "
                                    >
                                        شناسه ملی خود را وارد کنید
                                    </div>
                                    <div
                                        style={errorConfirmPassword ? {
                                            display: "flex", visibility: "visible",

                                            alignItems: "center",
                                        } : {visibility: "hidden"}}
                                        className="text-error "
                                    >
                                        رمز عبور با تکرار رمز عبور مطابقت ندارد
                                    </div>
                                    <div
                                        style={errorPassword ? {
                                            display: "flex", visibility: "visible",

                                            alignItems: "center",
                                        } : {visibility: "hidden"}}
                                        className="text-error "
                                    >
                                        رمز عبور کمتر از 8 کاراکتر نباشد
                                    </div>
                                    <div
                                        style={errorPasswordNull ? {
                                            display: "flex",
                                            visibility: "visible",
                                            paddingBottom: "4px",
                                            alignItems: "center",
                                        } : {visibility: "hidden"}}
                                        className="text-error "
                                    >
                                        رمز عبور را وارد نمایید
                                    </div>

                                    <div className="d-grid gap-2">
                                        <button
                                            onClick={() => {
                                                registerUser(nationalCode, password, confirmPassword);
                                            }}
                                            type="button"
                                            className="btn facility-btn  btn-primary btn-block btn-md rounded height-45"
                                        >
                                            {loading ? (<AnimateLoading
                                                    type="bubbles"
                                                    color="#fff"
                                                />) : ("ورود")}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="col-lg-5 col-12 order-lg-2 order-1 animate__animated animate__fadeInDown">
                            <div className="">
                                <div className="logo-style">
                                    <div className="logo">
                                        <img src="images/SVG/Metabank - B - Logo with text.svg"/>
                                    </div>
                                    <div className="logo-img">
                                        <img src="images/Apartment.svg"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AnimatePage>);
};

export default Register;
