import {useIntl} from 'react-intl';
import appLocales from "../src/lang";
import getLanguage from "../config/language";



export default function setErrorList(error) {

    appLocales[getLanguage()]

    // const PureFunciton = injectIntl(({ intl }) => {
    //     return (
    //             intl.formatMessage({ id: error })
    //     )
    // });
    // return PureFunciton;


        // if (error !== undefined)
        //     return <FormattedMessage
        //         id={error}
        //     />


}


