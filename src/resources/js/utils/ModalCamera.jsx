import React from "react";

const ModalCamera = ({
                         Children,
                         setStopMicrophon,
                         isCaptcher,
                         setOnClose,
                         display,
                         height,
                         className,
                         width,
                         setVideo,
                         setPlayer,
                         setVisibaleWebCam,
                         setVideoUpload,
                         setVideoBlob,
                         setCountDown,
                         handleStopCaptureClicks,
                            stream

                     }) => {
    return (
        <>
            <div
                className={"modals " + className}
                style={
                    display
                        ? {
                            width: width,
                            borderRadius: "18px",
                            marginTop: "-10rem",
                            zIndex: "9999",
                            background: "#000",
                            height: "95%",
                            position: "absolute",
                            bottom: "25px"
                        }
                        : {display: "none"}
                }

            >
                <div
                    className={"row"}
                >
                    <div className={"col-12 d-flex justify-content-start pe-4"}>
                        <button
                            style={{
                                minHeight: "50px",
                                background: "transparent",
                                float: "right",
                            }}
                            onClick={() => {
                                if (!isCaptcher) {
                                    if (setStopMicrophon) setStopMicrophon(true);
                                    setOnClose(false);
                                }

                                handleStopCaptureClicks();
                                setVideo("");
                                setPlayer("");
                                setVisibaleWebCam(false);
                                setVideoUpload(false);
                                setVideoBlob(false);
                                setCountDown();
                                setOnClose(false);

                            }}
                            className={""}
                        >
                            <div style={{float: "right", cursor: "pointer", right: "6px"}} className={"pr-4"}>
                                <img
                                    src="/images/Close_2022-02-12/Closesvg.svg"
                                    alt={""}
                                    style={{cursor: "pointer"}}
                                />
                            </div>
                        </button>
                    </div>
                    <div className={"col-12 pt-2"}>
                        <div style={{opacity: "1"}}>{Children}</div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default ModalCamera;
