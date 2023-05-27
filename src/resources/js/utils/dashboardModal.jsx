import React from 'react';



const Modal = ({ Children, setOnClose, display,exit, width, height, className, ref, onClick}) => {
    return (
        <>
            <div onClick={onClick} ref={ref} style={display ? {borderRadius:"18px", marginTop:"-40rem", display: "block", width: width + "%" , height: height + "%"} : { display: "none" }} className={className} id="modal">
                <div className="text-end mt-2 me-2">
                    {
                        exit ? ""
                            :
                            <button className=" " style={{backgroundColor:"#323AE5",color:"white"}} onClick={
                                () => setOnClose(false)
                            }>
                                x
                            </button>
                    }
                </div>
                <div class="content">{Children}</div>
            </div>
        </>
    )
}

export default Modal;
