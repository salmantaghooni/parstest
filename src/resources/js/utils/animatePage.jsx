import { motion } from 'framer-motion';
import React from 'react';
import { useLocation } from 'react-router-dom';

const AnimatePage = ({ children }) => {
    return (
              <div id="pg">{children}</div>
    )
}
export default AnimatePage;
