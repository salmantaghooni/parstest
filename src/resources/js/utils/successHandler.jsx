import { toast } from 'react-toastify';


const SuccessHandler = (toastText) => {
        toast.error(toastText, {
            position: "bottom-center",
            autoClose: 5000,
            hideProgressBar: false,
            closeOnClick: true,
            pauseOnHover: true,
            draggable: true,
            progress: undefined,
        });
}

export default SuccessHandler;