import React from 'react';
import {BrowserRouter as Router, Route, Routes, useLocation} from "react-router-dom";
import AnimatedRouted from "./routes";
import ReactDOM from "react-dom/client";
import { IntlProvider, FormattedMessage } from 'react-intl';
import messages from '../js/src/lang/locales/fa-IR';

const root = ReactDOM.createRoot(document.getElementById("app"));
const locale = 'fa-IR';
root.render(
    <IntlProvider locale={'fa-IR'} messages={messages['fa-IR']}>
        <React.StrictMode>
            <Router>
                <AnimatedRouted/>
            </Router>
        </React.StrictMode>
    </IntlProvider>
);
