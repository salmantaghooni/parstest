import React, { useEffect, useRef, useState } from "react";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import postAxios from "../../utils/axios";
import { useNavigate, useLocation } from "react-router-dom";
import validator from "validator";
import ErrorHandler from "../../utils/errorHandler";
import FixNumber from "../../utils/toEnNumber";
import AnimatePage from "../../utils/animatePage";
import AnimateLoading from "../../utils/loading";
import baseUrl from "../../utils/baseUrl";
import "animate.css/animate.min.css";
import checkToken from "../../utils/checkToken";
import { FormattedMessage } from "react-intl";
import checkLength from "../../utils/checkLength";
import checkKeyCode from "../../utils/checkKeyCode";

const Password = () => {
    const navigate = useNavigate();
    const location = useLocation();
    const [loading, setLoading] = useState(false);
    const [errorPassword, setErrorPassword] = useState("");
    const [usePassword, setUsePassword] = useState("");
    const password = useRef("");
    const [isRtl, setIsRtl] = useState(false);

    useEffect(() => {
        password.current.focus();
        // checkToken(true) ? navigate('/dashboard') : null;
    }, []);

    useEffect(() => {
        password.current.value !== "" ? setIsRtl(true) : setIsRtl(false);
    }, [password.current.value]);

    const handleEnter = (event) => {
        if (event.keyCode === 13) {
            event.preventDefault();
            userLogin(FixNumber(password.current.value));
        }
    };
    const handleKeyUpPassword = (event) => {
        setUsePassword(event.target.value);
    };

    const userLogin = () => {
        setLoading(true);
        setErrorPassword("");
        let phoneNumber = location?.state?.phoneNumber;
        postAxios(
            baseUrl() + "auth/password",
            { password: usePassword, phone_number: phoneNumber },
            false
        )
            .catch(function (error) {
                if (error.response.data.code === 400) {
                    setLoading(false);
                    setErrorPassword(error.response.data.message);
                } else if (error.response.status === 500) {
                    setLoading(false);
                    setErrorPassword("لطفا پسوورد وارد کنید.");
                }
                ErrorHandler(error);
                setLoading(false);
            })
            .then(function (data) {
                    setLoading(false);
                    localStorage.removeItem("otp-time");
                    localStorage.setItem("access_token",data.data.access_token);
                    localStorage.setItem("refresh_token",data.data.refresh_token);
                    localStorage.setItem("token_type",data.data.token_type);
                    navigate("/otp", { state: { phoneNumber } });
            });
    };

    return (
        <AnimatePage>
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
                        <img src="/images/Frame 3527.svg" />
                    </div>
                </div>
                <div className="container">
                    <div className="row">
                        <div className="col-12 order-2 order-lg-1 col-lg-7 animate__animated animate__zoomIn">
                            <div id="login-box">
                                <form className="form">
                                    <div className="form-page">
                                        <h1 className="title">
                                            <FormattedMessage id="login.loginRegister" />
                                        </h1>
                                    </div>
                                    <div className="form-group form-group-login ">
                                        <label htmlFor="phoneNumber">
                                            رمز عبور
                                        </label>
                                        <div className="relative">
                                            <input
                                                ref={password}
                                                style={
                                                    isRtl
                                                        ? {
                                                              textAlign: "left",
                                                              direction: "ltr",
                                                          }
                                                        : { textAlign: "right" }
                                                }
                                                autoFocus
                                                name="password"
                                                onKeyDown={handleEnter}
                                                onKeyUp={handleKeyUpPassword}
                                                type="password"
                                                maxLength="20"
                                                className="form-control input-style-login"
                                                id="password"
                                                placeholder="رمز عبور خود را وارد کنید"
                                            />
                                            {loading ? (
                                                <AnimateLoading
                                                    className={
                                                        "absolute loading"
                                                    }
                                                    type="spin"
                                                    color="#fff"
                                                />
                                            ) : (
                                                ""
                                            )}
                                        </div>
                                        <div
                                            style={{ height: "30px" }}
                                            className="invalid-feedback d-flex"
                                        >
                                            {errorPassword}
                                        </div>
                                    </div>
                                    <div className="d-grid gap-2">
                                        <button
                                            onClick={userLogin}
                                            disabled={loading}
                                            type="button"
                                            className="btn facility-btn btn-primary btn-block btn-md rounded height-45 button"
                                        >
                                            {loading ? (
                                                <AnimateLoading
                                                    type="bubbles"
                                                    color="#fff"
                                                />
                                            ) : (
                                                "ورود"
                                            )}
                                        </button>
                                        <span
                                            className={
                                                "forget-password mt-3 w-50"
                                            }
                                            onClick={() => {
                                                navigate(
                                                    "/forgetpassword/information"
                                                );
                                            }}
                                        >
                                            رمز عبور خود را فراموش کرده ام
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div className="col-lg-5 col-12 order-lg-2 order-1">
                            <div className="logo-style animate__animated animate__zoomIn">
                                <div className="logo">
                                    <img src="images/SVG/White - Topldpi.svg" />
                                </div>
                                <div>سامانه نئوبانک موسسه اعتباری ملل</div>
                                <div className="logo-img">
                                    <img src="images/Apartment.svg" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AnimatePage>
    );
};

export default Password;
