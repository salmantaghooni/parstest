import axios from "axios";
import React, { useState, useEffect } from "react";
import { Link, useNavigate } from "react-router-dom";
import AnimatePage from "../../utils/animatePage";
import baseUrl from "../../utils/baseUrl";
import postAxios from "../../../js/utils/axios";
import userVerifyRoute from "../../utils/helperRouteNavigation";
import { toast, ToastContainer } from "react-toastify";
import checkToken from "../../utils/checkToken";
import ErrorHandler from "../../utils/errorHandler";
import Modal from "../../utils/dashboardModal";


const Dashboard = () => {
    const navigate = useNavigate();
    const [information, setInformation] = useState([]);
    const [idBox, setIdBox] = useState("");
    const [loading, setLoading] = useState(false);
    const [displayBox, setDisplayBox] = useState(true);
    const [user, setUser] = useState("");
    const [onCloseNewRequestModal, setOnCloseNewRequestModal] = useState(false);
    const [onAccountServiceModal, setOnAccountServiceModal] = useState(false);

    useEffect(() => {
        // checkToken(true) ? navigate('/dashboard') : null;
        getInformation();
    }, []);

    const showDetail = () => {
        setDisplayBox(!displayBox);
    };

    const auth = (boxName, isActive) => {
        let url = "/";
        if (boxName == "Validation" && isActive) {
            url = "/userverify/datepicker";
            if (
                localStorage.getItem("user_validation_input_error") != null &&
                localStorage.getItem("user_validation_input_error") != "null" &&
                localStorage.getItem("user_validation_input_error") != ""
            ) {
                let steps = localStorage
                    .getItem("user_validation_input_error")
                    .split(",");
                url = userVerifyRoute(steps[0]);
            }
            navigate(url);
        } else if (boxName == "CreateAccount" && isActive) {
            url = "/account/create";
            navigate(url);
        } else if (boxName == "Transfer" && isActive) {
            url = "/transfer";
            navigate(url);
        } else if (boxName == "Facilities" && isActive) {
            url = "/facilities/list";
            navigate(url);
        } else if (boxName == "CardBalance" && isActive) {
            url = "/inventoryinquiry/selectcard";
            navigate(url);
        } else if (boxName == "CardToCard" && isActive) {
            url = "/cardservices/formcardtocard";
            navigate(url);
        } else if (boxName == "BillPayment" && isActive) {
            url = "/payingbill";
            navigate(url);
        } else if (boxName == "Instalment" && isActive) {
            url = "/installments/list";
            navigate(url);
        } else if (boxName == "OpenProxyAccount" && isActive) {
            url = "/lawyer/account";
            navigate(url);
        } else if (boxName == "CardService" && isActive) {
            setOnCloseNewRequestModal(true);
        } else if (boxName == "AccountService" && isActive) {
            setOnAccountServiceModal(true);
        } else if (boxName == "DynamicPassword" && isActive) {
            url = "/cardservices/dynamicpassword";
            navigate(url);
        } else if (boxName == "Satna" && isActive) {
            url = "/transfer/Satna";
            navigate(url);
        } else if (boxName == "Paya" && isActive) {
            url = "/transfer/Paya";
            navigate(url);
        } else if (boxName == "Turnover" && isActive) {
            url = "/transfer/accountturnover";
            navigate(url);
        } else if (boxName == "CloseAccount" && isActive) {
            url = "/account/block";
            navigate(url);
        } else if (boxName == "Balance" && isActive) {
            url = "/inventoryinquiry";
            navigate(url);
        } else if (boxName == "CardToCard" && isActive) {
            url = "/cardservices/formcardtocard";
            navigate(url);
        } else {
            toast.error("این سرویس به صورت موقت غیرفعال می باشد.", {
                position: "bottom-center",
                autoClose: 5000,
                hideProgressBar: false,
                closeOnClick: true,
                pauseOnHover: true,
                draggable: true,
                progress: undefined,
            });
        }
    };

    const getInformation = () => {
        setLoading(true);
        let axios = postAxios(baseUrl() + "auth/dashboardinfo", null, true);
        axios.catch((error) => {
            ErrorHandler(error);
            setLoading(false);
        });
        axios.then((data) => {
            setInformation(
                data?.data?.response?.service_list.sort((a, b) =>
                    a.priority > b.priority
                        ? 1
                        : b.priority > a.priority
                        ? -1
                        : 0
                )
            );
            setUser(data.data.response);
            localStorage.removeItem("user_validation_input_error");
            if (
                data?.data?.response?.user_validation_input_error !=
                    undefined &&
                data?.data?.response?.user_validation_input_error != null
            )
                localStorage.setItem(
                    "user_validation_input_error",
                    data?.data?.response?.user_validation_input_error
                );
        });
    };

    const logOut = () => {
        localStorage.removeItem("otp-time");
        localStorage.removeItem("access_token");
        navigate("/");
    };

    return (
        <AnimatePage>
            <div id="page">
                <div className="col-lg-12 col-12 pt-5">
                    <div className="row">
                        <div className="col-lg-6 col-6 text-end pe-5 ">
                            <img src="images/Frame 3527.svg" />
                        </div>
                        <div className="col-lg-6 col-6 text-start ps-5">
                            <img
                                onClick={showDetail}
                                className="pic-user-dashboard"
                                src="images/avatar.svg"
                            />
                            <div
                                style={
                                    displayBox
                                        ? { display: "none" }
                                        : { display: "" }
                                }
                                className="col-lg-12 box-user-dashboard"
                            >
                                <div className="row d-flex justify-content-center pt-2"></div>
                                <div
                                    className="pt-1 pb-0"
                                    style={{
                                        textAlign: "center",
                                        fontSize: "13px",
                                    }}
                                >
                                    {user.userName}
                                </div>
                                <div
                                    className=""
                                    style={{
                                        textAlign: "center",
                                        fontSize: "11px",
                                    }}
                                >
                                    خوش آمدید!
                                </div>
                                <hr className="ms-3 me-3" />
                                <div
                                    className="text-center"
                                    style={{ cursor: "pointer" }}
                                >
                                    <span onClick={logOut}>خروج</span>
                                    <img
                                        className="logout-icon pe-1"
                                        src="images/SVG/login.svg"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="container">
                    <div className="row">
                        <div className="col-12 order-2 order-lg-1 col-lg-7">
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
                            <div className="box-dashboard">
                                <div className=" mb-3 d-flex align-items-center animate__animated animate__fadeInDown">
                                    <span className="ms-1 ">
                                        <div className="center-body">
                                            <div className="loader-square-15">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                    </span>
                                    خدمات متابانک
                                </div>
                                {/*<div className="alert-item-dashboard  pb-3">پیش از استفاده از امکانات متابانک میبایست*/}
                                {/*    احراز هویت خود را تکمیل کنید*/}
                                {/*</div>*/}

                                <div className="animate__animated animate__zoomIn">
                                    <div className="row mb-lg-2">
                                        {information
                                            ?.filter(
                                                (opt) =>
                                                    !opt.parent_id &&
                                                    opt.is_available
                                            )
                                            ?.map((val) => {
                                                return (
                                                    <div
                                                        onClick={(e) => {
                                                            const data =
                                                                information.find(
                                                                    (value) =>
                                                                        value.id ===
                                                                        val.id
                                                                );
                                                            setIdBox(data);
                                                            auth(
                                                                val?.name,
                                                                val?.is_active
                                                            );
                                                        }}
                                                        className="max-width-130 relative"
                                                    >
                                                        <button
                                                            style={
                                                                val?.is_active
                                                                    ? {
                                                                          opacity:
                                                                              "1",
                                                                      }
                                                                    : {
                                                                          opacity:
                                                                              "0.6",
                                                                      }
                                                            }
                                                            className={
                                                                val?.is_active
                                                                    ? "item-dashboard test-shine"
                                                                    : "item-dashboard-disable"
                                                            }
                                                        >
                                                            <img
                                                                style={
                                                                    val?.is_active
                                                                        ? {
                                                                              opacity:
                                                                                  "1",
                                                                          }
                                                                        : {
                                                                              opacity:
                                                                                  "0.6",
                                                                          }
                                                                }
                                                                className="icon-item"
                                                                width={44}
                                                                src={
                                                                    "/images/" +
                                                                    val?.icon_name
                                                                }
                                                            />
                                                            <p
                                                                style={
                                                                    val?.is_active
                                                                        ? {
                                                                              opacity:
                                                                                  "1",
                                                                          }
                                                                        : {
                                                                              opacity:
                                                                                  "0.6",
                                                                          }
                                                                }
                                                                className="icon-item-text"
                                                            >
                                                                {
                                                                    val?.name_farsi
                                                                }
                                                            </p>
                                                            <div className="text-end">
                                                                {val?.id ===
                                                                    3 ||
                                                                val?.id === 4 ||
                                                                val?.id ===
                                                                    10 ? (
                                                                    <img
                                                                        className="icon-info"
                                                                        src="/images/SVG/import.svg"
                                                                    />
                                                                ) : (
                                                                    ""
                                                                )}
                                                            </div>
                                                        </button>
                                                    </div>
                                                );
                                            })}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="col-lg-5 col-12 order-lg-2 order-1 animate__animated animate__fadeInDown">
                            <div className="logo-style">
                                <div className="logo">
                                    <img src="images/SVG/White - Topldpi.svg" />
                                </div>
                                <div>سامانه نئوبانک موسسه اعتباری ملل</div>

                                        <div className="logo-img">
                                            {/* <img src="images/Apartment.svg" /> */}

                                        </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <Modal
                display={onCloseNewRequestModal}
                setOnClose={setOnCloseNewRequestModal}
                className={"dashboard-modal col-lg-3 col-11"}
                Children={
                    <div>
                        <h3 style={{ fontSize: "16px" }}>خدمات کارت</h3>
                        <div className="row p-4">
                            {information
                                ?.filter(
                                    (opt) =>
                                        opt.parent_id &&
                                        opt.is_available &&
                                        opt.parent_id == idBox.id
                                )
                                ?.map((val) => {
                                    return (
                                        <div
                                            onClick={(e) => {
                                                auth(val?.name, val?.is_active);
                                            }}
                                        >
                                            <div className="col-12">
                                                <div
                                                    className={
                                                        val?.is_active
                                                            ? "d-flex justify-content-between pb-3 dashboard-modal-content"
                                                            : "d-flex justify-content-between pb-3 dashboard-modal-content-disabled"
                                                    }
                                                >
                                                    <span
                                                        style={
                                                            val?.is_active
                                                                ? {
                                                                      opacity:
                                                                          "1",
                                                                  }
                                                                : {
                                                                      opacity:
                                                                          "0.6",
                                                                  }
                                                        }
                                                    >
                                                        {val.name_farsi}
                                                    </span>
                                                    <span
                                                        style={
                                                            val?.is_active
                                                                ? {
                                                                      opacity:
                                                                          "1",
                                                                  }
                                                                : {
                                                                      opacity:
                                                                          "0.6",
                                                                  }
                                                        }
                                                    >
                                                        {" "}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    );
                                })}
                        </div>
                    </div>
                }
            />

            <Modal
                display={onAccountServiceModal}
                setOnClose={setOnAccountServiceModal}
                className={"dashboard-modal col-lg-3 col-11"}
                Children={
                    <div>
                        <h3 style={{ fontSize: "16px" }}>خدمات حساب</h3>
                        <div className="row p-4">
                            {information
                                ?.filter(
                                    (opt) =>
                                        opt.parent_id &&
                                        opt.is_available &&
                                        opt.parent_id == idBox.id
                                )
                                ?.map((val) => {
                                    return (
                                        <div
                                            onClick={(e) => {
                                                auth(val?.name, val?.is_active);
                                            }}
                                        >
                                            <div className="col-12">
                                                <div
                                                    className={
                                                        val?.is_active
                                                            ? "d-flex justify-content-between pb-3 dashboard-modal-content"
                                                            : "d-flex justify-content-between pb-3 dashboard-modal-content-disabled"
                                                    }
                                                >
                                                    <span
                                                        style={
                                                            val?.is_active
                                                                ? {
                                                                      opacity:
                                                                          "1",
                                                                  }
                                                                : {
                                                                      opacity:
                                                                          "0.6",
                                                                  }
                                                        }
                                                    >
                                                        {val.name_farsi}
                                                    </span>
                                                    <span
                                                        style={
                                                            val?.is_active
                                                                ? {
                                                                      opacity:
                                                                          "1",
                                                                  }
                                                                : {
                                                                      opacity:
                                                                          "0.6",
                                                                  }
                                                        }
                                                    >
                                                        {" "}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    );
                                })}
                        </div>
                    </div>
                }
            />
        </AnimatePage>
    );
};

export default Dashboard;
