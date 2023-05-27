import React, {useEffect, useState} from 'react';
import OTPInput from "otp-input-react";
import AnimateLoading from '../../utils/loading';
import postAxios from '../../utils/axios';
import {useLocation, useNavigate} from 'react-router-dom';
import ErrorHandler from '../../utils/errorHandler';
import {ToastContainer} from 'react-toastify';
import Countdown, {zeroPad} from 'react-countdown';
import ToPersianNumber from '../../utils/toPersianNumber';
import ReactTooltip from 'react-tooltip';
import baseUrl from '../../utils/baseUrl';
import "animate.css/animate.min.css";
import FixNumber from '../../utils/toEnNumber';


const Otp = () => {

    const location = useLocation();
    const [phoneNumber, setPhoneNumber] = useState(null);
    const [OTP, setOTP] = useState("");
    const [isOTPTime, setIsOTPTime] = useState(true);
    const [loading, setLoading] = useState(false);
    const [errorOtp, setErrorOtp] = useState("");
    const [counter, setCounter] = useState(0);
    const [otpCounter, setOtpCounter] = useState(119000);
    const navigate = useNavigate();
    const [countDown, setCountDown] = useState("");

    useEffect(() => {
        // checkToken(false) ? navigate('/dashboard') : null;
        if (localStorage.getItem("otp-time") !=null && localStorage.getItem("otp-time")!=="null" && localStorage.getItem("otp-time")!=="" && localStorage.getItem("otp-time")!==undefined){
            setOtpCounter(parseInt(localStorage.getItem("otp-time")));
        }
        let time = Date.now()+parseInt(otpCounter);
        setCountDown(<Countdown autoStart={true} key={'otp'} date={time} renderer={renderer}/>);
        let tm = parseInt(otpCounter);
       let interval =  setInterval(()=>{
            tm = tm - 1000;
            if (tm>0)
            localStorage.setItem("otp-time",tm);
            else {
                localStorage.removeItem("otp-time");
                clearInterval(interval);
            }
        },1000);


    }, [localStorage,setCountDown,otpCounter])

    useEffect(() => {
        getPhoneNumber();
        if (OTP?.length === 5) {
            userOtp();
        } else
            setErrorOtp("");
    }, [OTP]);
    const getPhoneNumber = () => {
        if (location?.state?.phoneNumber !== undefined && phoneNumber == null) {
            setPhoneNumber(location?.state?.phoneNumber);
        }
    }
    const Completionist = () => <span>کاربر گرامی زمان به پایان رسید</span>;
    const renderer = ({minutes, seconds, completed}) => {
        if (completed) {
            localStorage.removeItem("otp-time");
            setIsOTPTime(false);
            return <Completionist/>;
        } else {
                return <span>{ToPersianNumber(zeroPad(minutes))}:{ToPersianNumber(zeroPad(seconds))}</span>;
        }
    };

    const [countDown2, setCountDown2] = useState();

    const userOtp = () => {
        setLoading(true);
        setErrorOtp("");
        if (OTP.length === 5) {
            const otp = FixNumber(OTP);
            let axios = postAxios(baseUrl() + "auth/metaverifycode", {
                verify_code: otp,
                national_code: '',
                phone_number: phoneNumber
            }, false);
            axios.catch((error) => {
                if (error?.response?.data?.code == 400) {
                    setErrorOtp("کد تایید وارد شده نادرست است .");
                    setLoading(false);
                }
                ErrorHandler(error);
                setLoading(false);
            });
            axios.then(data => {
                setLoading(false);
                if (data?.data?.response?.ui_state == 201)
                    navigate('/register', {state: {phoneNumber: phoneNumber}});
                else if (data?.data?.response?.token != undefined) {
                    localStorage.setItem('access_token', data?.data?.response?.token);
                    navigate('/dashboard', {state: {phoneNumber: phoneNumber}});
                } else if (data?.data?.code == 12) {
                    setErrorOtp(data?.data?.message);
                }
            });
        } else {
            setErrorOtp("لطفا کد تایید را به صورت کامل وارد کنید");
            setLoading(false);
        }
    }

    const resendOtp = () => {
        if (!isOTPTime) {
            setIsOTPTime(true);
            localStorage.removeItem("otp-time");
            setOTP("");
            setErrorOtp("");
            let axios = postAxios(baseUrl() + "auth/resendcode", {phone_number:phoneNumber}, false);
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
                let time = Date.now()+parseInt(otpCounter);
                setCountDown2(<Countdown key={'otp' + counter + 1} autoStart={true} date={time}
                                         renderer={renderer}/>);
            });
        }
    }


    return (

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
                    <div className="header-logo">
                        <img src="images/Frame 3527.svg"/>
                    </div>
                    <div className="row">
                        <div className="col-12 order-2 order-lg-1 col-lg-7">

                            <div id="login-box" className='animate__animated animate__zoomIn'>
                                <form className="form">
                                    <div className="row form-page">
                                        <div className="col-5 otp-text">کد تایید</div>
                                        <div className="col-7 otp-text text-start">
                                            {isOTPTime ? <span>زمان باقی مانده تا دریافت کد</span> : ''}
                                            <span className='me-1'>{countDown ? countDown : countDown2}</span>
                                        </div>
                                    </div>
                                    <div className="userInput" style={{direction: "ltr"}}>
                                        <OTPInput autoFocus inputStyles={{
                                            height: "48px",
                                            width: "45px",
                                            border: "none",
                                            borderRadius: "5px",
                                            textAlign: "center",
                                            fontSize: "1.2rem",
                                            background: "rgba(246, 248, 251, 0.15)",
                                            color: "#ffffff",
                                        }} inputClassName="otp-input1" otpType={"number"} value={OTP}
                                                  onChange={setOTP} completed={userOtp} OTPLength={5}/>
                                    </div>
                                    <div className="d-grid gap-2">
                                        <div style={{height: "30px"}}
                                             className="invalid-feedback d-block">{errorOtp}</div>
                                        <button onClick={userOtp} type="button"
                                                className="btn  btn-primary btn-block btn-md rounded"> {loading ?
                                            <AnimateLoading type="bubbles" color="#fff"/> : 'ادامه'}</button>
                                    </div>
                                    <div className="row mt-3">
                                        <div className="col-8 text-verify">آیا هنوز کد تایید دریافت نکرده اید؟</div>
                                        <div className="col-4 text-verify "><span
                                            data-tip={isOTPTime ? 'تا دریافت کد زمان باقی مانده' : ''}
                                            className={isOTPTime ? 'opacity-50 send-sms cursor-pointer' : 'send-sms cursor-pointer'}
                                            onClick={resendOtp}>ارسال مجدد کد</span></div>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div className="col-lg-5 col-12 order-lg-2 order-1 animate__animated animate__zoomIn">
                            <div className="">
                                <div className="logo-style">
                                    <div className="logo"><img src="images/SVG/White - Topldpi.svg"/></div>
                                    <div>سامانه نئوبانک موسسه اعتباری ملل</div>
                                    <div className="logo-img"><img src="/images/Apartment.svg"/></div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

    )
}

export default Otp;
