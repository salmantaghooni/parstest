import React, {useEffect, useState} from 'react';
import OTPInput from "otp-input-react";
import AnimatePage from '../../../../utils/animatePage';
import AnimateLoading from '../../../../utils/loading';
import postAxios from '../../../../utils/axios';
import {useLocation, useNavigate} from 'react-router-dom';
import ErrorHandler from '../../../../utils/errorHandler';
import {toast, ToastContainer} from 'react-toastify';
import Countdown, {zeroPad} from 'react-countdown';
import ToPersianNumber from '../../../../utils/toPersianNumber';
import ReactTooltip from 'react-tooltip';
import baseUrl from '../../../../utils/baseUrl';
import "animate.css/animate.min.css";
import FixNumber from '../../../../utils/toEnNumber';


const Otp = () => {

    const navigate = useNavigate();
    const location = useLocation();
    const [OTP, setOTP] = useState("");
    const [isOTPTime, setIsOTPTime] = useState(true);
    const [errorOtp, setErrorOtp] = useState("");
    const [otpCounter, setOtpCounter] = useState(119000);
    const [counter, setCounter] = useState(0);
    const [countDown, setCountDown] = useState("");
    const [disabled, setDisabled] = useState(false);
    const [newPassword, setNewPassword] = useState("");
    const [errorNewPassword, setErrorNewPassword] = useState("");
    const [newConfirmPassword, setNewConfirmPassword] = useState("");
    const [errorNewConfirmPassword, setErrorNewConfirmPassword] = useState("");
    const [loading, setLoading] = useState(false);
    const [isRtl, setIsRtl] = useState(false);



    useEffect(() => {
        // checkToken(false) ? navigate('/dashboard') : null;
        if (localStorage.getItem("otp-time") != null && localStorage.getItem("otp-time") !== "null" && localStorage.getItem("otp-time") !== "" && localStorage.getItem("otp-time") !== undefined) {
            setOtpCounter(parseInt(localStorage.getItem("otp-time")));
        }
        let time = Date.now() + parseInt(otpCounter);
        setCountDown(<Countdown autoStart={true} key={'otp'} date={time} renderer={renderer}/>);
        let tm = parseInt(otpCounter);
        let interval = setInterval(() => {
            tm = tm - 1000;
            if (tm > 0)
                localStorage.setItem("otp-time", tm);
            else {
                localStorage.removeItem("otp-time");
                clearInterval(interval);
            }
        }, 1000);
    }, [localStorage, setCountDown, otpCounter])

    const Completionist = () => <span>کاربر گرامی زمان به پایان رسید</span>;

    const renderer = ({minutes, seconds, completed}) => {
        if (completed) {
            localStorage.removeItem("otp-time");
            setIsOTPTime(false);
            setDisabled(true);
            return <Completionist/>;
        } else {
            return <span>{ToPersianNumber(zeroPad(minutes))}:{ToPersianNumber(zeroPad(seconds))}</span>;
        }
    };

    const [countDown2, setCountDown2] = useState();

    const userOtp = () => {
        setLoading(true);
        setErrorOtp("");
        setErrorNewPassword("");
        setErrorNewConfirmPassword("");
        if (OTP.length === 5) {
            if(newPassword.length == 0) {
                setLoading(false);
                setErrorNewPassword("رمز عبور خود را وارد کنید");
            }else if(newPassword.length < 8) {
                setLoading(false);
                setErrorNewPassword("رمز شما باید حداقل شامل 8 کاراکتر باشد");
            } else{
                if(newConfirmPassword.length == 0){
                    setLoading(false);
                    setErrorNewConfirmPassword("لطفا تکرار رمز عبور خود را وارد کنید");
                }else{
                    if(newPassword !== newConfirmPassword){
                        setLoading(false);
                        setErrorNewConfirmPassword("رمز عبور با تکرار رمز عبور شما مطابقت ندارد");
                    }else{
                        const otp = FixNumber(OTP);
                        let axios = postAxios(baseUrl() + "forgetpassword/otp", {
                            verify_code: otp,
                            national_code: location.state.nationalCode,
                            phone_number: location.state.phoneNumber,
                            password: newPassword,
                        }, false);
                        axios.catch((error) => {
                            ErrorHandler(error);
                            setLoading(false);
                        });
                        axios.then(data => {
                            setLoading(false);
                            toast.error(data.data.messages);
                            setTimeout(() => {
                                navigate("/password", {state: {phoneNumber: location.state.phoneNumber}});
                            },5000)
                        });
                    }
                }
            }
        } else {
            setErrorOtp("لطفا کد تایید را به صورت کامل وارد کنید");
            setLoading(false);
        }
    }

    const resendOtp = () => {
        if (!isOTPTime) {
            setDisabled(false);
            setIsOTPTime(true);
            localStorage.removeItem("otp-time");
            setOTP("");
            setErrorOtp("");
            let axios = postAxios(baseUrl() + "forgetpassword/information", {phone_number: location.state.phoneNumber, national_code: location.state.nationalCode}, false);
            axios.catch((error) => {
                ErrorHandler(error);
                setLoading(false);
                setIsOTPTime(false);
                localStorage.removeItem("otp-time");
            });
            axios.then(data => {
                localStorage.removeItem("otp-time");
                setLoading(false);
                setIsOTPTime(true);
                setCountDown(false);
                let time = Date.now() + parseInt(otpCounter);
                setCountDown2(<Countdown key={'otp' + counter + 1} autoStart={true} date={time}
                                         renderer={renderer}/>);
            });
        }
    }


    return (
        <AnimatePage>
            <div id="page">
                <div className="container">
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
                    <ReactTooltip/>
                    <div className="header-logo mt-4">
                        <img src="/images/Frame 3527.svg"/>
                    </div>
                    <div className="row">
                        <div className="col-12 order-2 order-lg-1 col-lg-7">
                            <div id="login-box" className='animate__animated animate__zoomIn'>
                                <form className="form">
                                    <div className="">
                                        <h1 className="title">تعیین رمز عبور جدید</h1>
                                    </div>
                                    <div className="row">
                                        <div className="col-5 otp-text">کد تایید</div>
                                        <div className="col-7 otp-text text-start">
                                            {isOTPTime ? <span>زمان باقی مانده تا دریافت کد</span> : ''}
                                            <span className='me-1'>{countDown ? countDown : countDown2}</span>
                                        </div>
                                    </div>
                                    <div className="userInput" style={{direction: "ltr"}}>
                                        <OTPInput
                                            autoFocus={true}
                                            inputStyles={{
                                                height: "48px",
                                                width: "45px",
                                                border: "none",
                                                borderRadius: "5px",
                                                textAlign: "center",
                                                fontSize: "1.2rem",
                                                background: "rgba(246, 248, 251, 0.15)",
                                                color: "#ffffff",
                                            }}
                                            inputClassName="otp-input1"
                                            otpType={"number"}
                                            autoComplete={"new-password"}
                                            value={OTP}
                                            onChange={setOTP}
                                            OTPLength={5}
                                        />
                                    </div>
                                    <div className="row mt-3">
                                        <div className="col-8 text-verify">آیا هنوز کد تایید دریافت نکرده اید؟</div>
                                        <div className="col-4 text-verify "><span
                                            data-tip={isOTPTime ? 'تا دریافت کد زمان باقی مانده' : ''}
                                            className={isOTPTime ? 'opacity-50 send-sms cursor-pointer' : 'send-sms cursor-pointer'}
                                            onClick={resendOtp}>ارسال مجدد کد</span></div>
                                    </div>
                                    <div style={errorOtp ? {height: "30px"} : {display : "none"}}
                                         className="invalid-feedback d-block">{errorOtp}</div>
                                    <div className="form-group form-group-login mb-3 mt-4">
                                        <label>رمز عبور جدید</label>
                                        <input
                                            style={isRtl ? {textAlign: "left", direction: "ltr"} : {textAlign: "right"}}
                                            onChange={(e) => {
                                                setNewPassword(e.target.value);
                                            }}
                                            autoComplete={"new-password"}
                                            type="password"
                                            className="form-control input-style-login"
                                            placeholder="لطفا رمز جدید خود را وارد کنید"/>
                                    </div>
                                    <div style={errorNewPassword ? {height: "30px"} : {display : "none"}}
                                         className="invalid-feedback d-block">{errorNewPassword}</div>
                                    <div className="form-group form-group-login mb-3 mt-4">
                                        <label>تکرار رمز عبور جدید</label>
                                        <input
                                            style={isRtl ? {textAlign: "left", direction: "ltr"} : {textAlign: "right"}}
                                            onChange={(e) => {
                                                setNewConfirmPassword(e.target.value);
                                            }}
                                            type="password"
                                            className="form-control input-style-login"
                                            placeholder="لطفا رمز جدید خود را مجددا وارد کنید"/>
                                    </div>
                                    <div style={errorNewConfirmPassword ? {height: "30px"} : {display : "none"}}
                                         className="invalid-feedback d-block">{errorNewConfirmPassword}</div>
                                    <div className="d-grid gap-2">
                                        <button onClick={userOtp} type="button"
                                                className="btn  btn-primary btn-block btn-md rounded" disabled={disabled}> {loading ?
                                            <AnimateLoading type="bubbles" color="#fff"/> : 'ثبت'}</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div className="col-lg-5 col-12 order-lg-2 order-1 animate__animated animate__zoomIn">
                            <div className="">
                                <div className="logo-style">
                                    <div className="logo"><img src="/images/SVG/White - Topldpi.svg"/></div>
                                    <div>سامانه نئوبانک موسسه اعتباری ملل</div>
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

export default Otp;
