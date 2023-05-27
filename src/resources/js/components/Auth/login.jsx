import React, {useEffect, useRef, useState} from "react";
import {ToastContainer} from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import postAxios from "../../utils/axios";
import {useNavigate} from "react-router-dom";
import validator from "validator";
import ErrorHandler from "../../utils/errorHandler";
import FixNumber from "../../utils/toEnNumber";
import AnimatePage from "../../utils/animatePage";
import AnimateLoading from "../../utils/loading";
import baseUrl from "../../utils/baseUrl";
import "animate.css/animate.min.css";
import checkToken from "../../utils/checkToken";
import {FormattedMessage} from "react-intl";
import checkLength from "../../utils/checkLength";
import checkKeyCode from "../../utils/checkKeyCode";

const Login = () => {
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [errorphoneNumber, setErrorphoneNumber] = useState("");
    const phone_number = useRef("");
    const [isRtl, setIsRtl] = useState(false);

    useEffect(() => {
        phone_number.current.focus();
        // checkToken(false) ? navigate('/dashboard') : null;
    }, []);

    useEffect(() => {
        phone_number.current.value !== "" ? setIsRtl(true) : setIsRtl(false);
    }, [phone_number.current.value]);

    const handleEnter = (event) => {
        if (event.keyCode === 13) {
            event.preventDefault();
            userLogin();
        }
    };
    const handleKeyUpphoneNumber = (event) => {
        let phone = FixNumber(phone_number.current.value);
        // !validator?.isMobilePhone(phone, 'fa-IR') ? setErrorphoneNumber(<FormattedMessage
        //     id="login.error.number"/>) : null
        // setErrorphoneNumber(checkKeyCode(event.keyCode));
        checkLength(phone, 11) ? userLogin() : "";
    };

    const userLogin = () => {
        setLoading(true);
        setErrorphoneNumber("");
        if (phone_number.current.value.length <= 0) {
            setErrorphoneNumber(<FormattedMessage id="login.empty.number"/>);
            setLoading(false);
        } else {
            let axios = postAxios(baseUrl() + "auth/login", {phone_number: phone_number.current.value}, false);
            axios.catch((error) => {
                    setErrorphoneNumber(<FormattedMessage id="login.error.number"/>);
                setLoading(false);
            });
            axios.then((data) => {
                setLoading(false);
                if (data?.data?.response?.ui_state == 200) {
                    localStorage.removeItem("otp-time");
                    navigate("/otp", {
                        state: {phoneNumber: phone_number.current.value},
                    });
                } else if (data?.data?.response?.ui_state == 202) {
                    navigate("/password", {
                        state: {phoneNumber: phone_number.current.value},
                    });
                }
            });
        }
    };

    return (<AnimatePage>
            <div id="page">
                <ToastContainer
                    position="bottom-center"
                    autoClose={5000}
                    hideProgressBar={false}
                    newestOnTop={false}
                    closeOnClick
                    rtl={true}
                    pauseOnFocusLoss
                    draggable
                    pauseOnHover
                />

                <div className="col-lg-12 col-12 text-end mx-auto p-2">
                    <div className="header-logo text-end">
                        <img src="/images/Frame 3527.svg"/>
                    </div>
                </div>
                <div className="container">
                    <div className="row">
                        <div className="col-12 order-2 order-lg-1 col-lg-7 animate__animated animate__zoomIn">
                            <div id="login-box">
                                <form className="form">
                                    <div className="form-page">
                                        <h1 className="title">
                                            <FormattedMessage id="login.loginRegister"/>
                                        </h1>
                                    </div>
                                    <div className="form-group form-group-login mb-3">
                                        <label htmlFor="phoneNumber">
                                            شماره همراه
                                        </label>
                                        <div className="relative">
                                            <input
                                                ref={phone_number}
                                                style={isRtl ? {
                                                    textAlign: "left", direction: "ltr",
                                                } : {textAlign: "right"}}
                                                autoFocus
                                                name="phoneNumber"
                                                onKeyDown={handleEnter}
                                                onKeyUp={handleKeyUpphoneNumber}
                                                type="tel"
                                                maxLength="11"
                                                className="form-control input-style-login"
                                                id="phoneNumber"
                                                placeholder="شماره همراه خود را وارد کنید"
                                            />
                                            {loading ? (<AnimateLoading
                                                    className={"absolute loading"}
                                                    type="spin"
                                                    color="#fff"
                                                />) : ("")}
                                        </div>
                                        <div
                                            style={{height: "30px"}}
                                            className="invalid-feedback d-flex"
                                        >
                                            {errorphoneNumber}
                                        </div>
                                    </div>
                                    <div className="d-grid gap-2">
                                        <button
                                            disabled={loading}
                                            onClick={(e) => {
                                                userLogin(phoneNumber);
                                            }}
                                            type="button"
                                            className="btn facility-btn btn-primary btn-block btn-md rounded height-45 button"
                                        >
                                            {loading ? (<AnimateLoading
                                                    type="bubbles"
                                                    color="#fff"
                                                />) : ("ورود")}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div className="col-lg-5 col-12 order-lg-2 order-1">
                            <div className="logo-style animate__animated animate__zoomIn">
                                <div className="logo">
                                    <img src="images/SVG/White - Topldpi.svg"/>
                                </div>
                                <div>سامانه نئوبانک موسسه اعتباری ملل</div>
                                <div className="logo-img">
                                    <img src="images/Apartment.svg"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AnimatePage>);
};

export default Login;
