import {toast} from 'react-toastify';


const ErrorHandler = (err) => {
    toast.error(err?.response?.data?.messages);
}

export default ErrorHandler;
