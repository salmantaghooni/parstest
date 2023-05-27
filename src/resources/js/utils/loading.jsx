import React from 'react';
import ReactLoading from 'react-loading';

const AnimateLoading = ({ type, color,className }) => (
    <ReactLoading className={className+" mx-auto"} type={type} color={color} height={'100%'}  width={'12%'} />
);

export default AnimateLoading;
