import React, {useEffect} from "react";
import {Route, Routes, useLocation} from "react-router-dom";
import Login from "./components/Auth/login";
import Password from "./components/Auth/password";
import Otp from "./components/Auth/otp";
import Dashboard from "./components/Auth/dashboard";
import AccountList from "./components/Account/AccountList/accountList";
import BirthdayPicker from "./components/Account/birthdayPicker/birthdayPicker";
import BirthdayPickerUserVerify from "./components/UserVerify/birthdayPicker/birthdayPicker";
import UploadNationalCardUserVerify from "./components/UserVerify/UploadNationalCode/uploadNationalCode";
import UploadBirthCertificateUserVerify from "./components/UserVerify/BirthCertificate/birthCertificate";
import NationalSerialUserVerify from "./components/UserVerify/NationalSerial/nationalSerial";
import SelfieUserVerify from "./components/UserVerify/UploadSelfie/uploadselfie";
import VideoSelfieUserVerify from "./components/UserVerify/VideoSelfie/videoSelfie";
import SignatureUserVerify from "./components/UserVerify/UploadUserSignature/uploadSignature";
import RulePage from "./components/Account/RulePage/rulePage";
import BasicInformation from "./components/Account/BasicInformation/basicInformation";
import UploadNationalCard from "./components/Account/UploadNationalCode/uploadNationalCode";
import BirthCertificate from "./components/Account/BirthCertificate/birthCertificate";
import NationalSerial from "./components/Account/NationalSerial/nationalSerial";
import UploadSelfie from "./components/Account/UploadSelfie/uploadselfie";
import VideoSelfie from "./components/Account/VideoSelfie/videoSelfie";
import LocationInformation from "./components/Account/LocationInformation/locationInformation";
import CompleteInformation from "./components/Account/CompleteInformation/completeInformation";
import SelectBranchFrom from "./components/Account/SelectBranchFrom/branchform";
import SelectAccountForm from "./components/Account/SelectAccountForm/accounts";
import RequestsList from "./components/Facilities/RequestList/RequestsList";
import RuleFacility from "./components/Facilities/Rule/rolePage";
import AccountSelection from "./components/Facilities/AccountSelection/accountSelection";
import InstallmentCalculation from "./components/Facilities/InstallmentCalculation/InstallmentCalculation";
import DetailsInstallmentCalculation from "./components/Facilities/DetailsInstallmentCalculation/DetailsInstallmentCalculation";
import CollateralIssuing from "./components/Facilities/CollateralIssuing/CollateralIssuing";
import ResultValidation from "./components/Facilities/ResultValidation/ResultValidation";
import CollateralSuccess from "./components/Facilities/CollateralSuccess/CollateralSuccess";
import CollateralError from "./components/Facilities/CollateralError/CollateralError";
// import Payment from "./components/Facilities/Payment/Payment";
import CollateralVersion from "./components/Facilities/CollateralSuccess/CollateralVersion";
import UploadSignature from "./components/Account/UploadUserSignature/uploadSignature";
import Final from "./components/Account/FinalInformation/finalInformation";
import Register from "./components/Auth/register";
import Validation from "./components/Facilities/Validation/Validation";
import SummaryFacilitiesStatus from "./components/Facilities/SummaryFacilitiesStatus/SummaryFacilitiesStatus";
import TransferList from "./components/Transfer/TransferList/transferList";
import SatnaForm from "./components/Transfer/Satna/SatnaForm/Satna";
import SatnaAlert from "./components/Transfer/Satna/SatnaAlert/SatnaAlert";
import PayaForm from "./components/Transfer/Paya/PayaForm/PayaForm";
import PayaAlert from "./components/Transfer/Paya/PayaAlert/PayaAlert";
import PayingBills from "./components/PayingBills/PayingBills/payingBills";
import TransactionPayingBills from "./components/PayingBills/TransactionPayingBills/TransactionPayingBills";
import ResultPayingBills from "./components/PayingBills/ResultPayingBills/resultPayingBills";
import InstallmentsAccount from "./components/Installments/InstallmentsAccount/InstallmentsAccount";
import Payment from "./components/Installments/Payment/Payment";
import Receipt from "./components/Installments/InstallmentPaymentReceipt/InstallmentPaymentReceipt";
import List from "./components/Installments/InstallmentsList/InstallmentList";
import DynamicPassword from "./components/CardServices/DynamicPassword/DynamicPassword";
import SelectCard from "./components/InventoryInquiry/SelectCard/selectCard";
import ListCard from "./components/InventoryInquiry/ListCard/listCard";
import Cards from "./components/CardServices/Cards/Cards";
import ForgetPasswordNationalCode from "./components/CardServices/ForgetFirstPassword/NationalCode/NatinalCode";
import ForgetPasswordActiveCode from "./components/CardServices/ForgetFirstPassword/ActiveCode/ActiveCode";
import ForgetPasswordInformation from "./components/Auth/ForgetPassword/PersonalInformation/personalInformation";
import ForgetPasswordOtp from "./components/Auth/ForgetPassword/Otp/otp";
import CardToCard from "./components/CardServices/CardToCard/MainPage/CardToCard";
import FormCardToCard from "./components/CardServices/CardToCard/FormCardToCard/FormCardToCard";
import SecondPasswordCardToCard from "./components/CardServices/CardToCard/SecondPasswordCardToCard/SecondPasswordCardToCard";
import ListSuccessCardToCard from "./components/CardServices/CardToCard/ListSuccesCardToCard/ListSuccessCardToCard";
import ChooseAccountTurnOver from "./components/Transfer/AccountTurnover/ChooseAccount/ChooseAccount";
import ListTurnOver from "./components/Transfer/AccountTurnover/ListTurnover/ListTurnover"
import AccountLawyer from "./components/Lawyers/changeLawyerAccount/Lawyer";
import InquiryType from "./components/InventoryInquiry/InqueryType/InquiryType";
import SelectAccountInventory from "./components/InventoryInquiry/SelectAccount/SelectAccount";
import Block from "./components/Account/Block/blockAccount.jsx";
import BlockConfirmation from "./components/Account/BlockConfirmation/blockConfirmation.jsx";
import ListAccount from "./components/InventoryInquiry/ListAccount/listAccount";


export default function AnimatedRouted() {
    const location = useLocation();
    const key = Date.now();

    return (
        <Routes location={location} key={location.pathname}>

            <Route key={key} path='/' exact element={<Login/>}/>
            <Route key={key} path='/password' exact element={<Password/>}/>
            <Route key={key} path='/dashboard' exact element={<Dashboard/>}/>
            <Route key={key} path='/register' exact element={<Register/>}/>
            <Route key={key} path='/otp' exact element={<Otp/>}/>
            <Route key={key} path='/forgetpassword/information' exact element={<ForgetPasswordInformation/>}/>
            <Route key={key} path='/forgetpassword/otp' exact element={<ForgetPasswordOtp/>}/>

            <Route key={key} path='/userverify/datepicker' exact element={<BirthdayPicker/>}/>
            <Route key={key} path='/userverify/baseinformation' exact element={<BasicInformation/>}/>
            <Route key={key} path='/userverify/locationinformation' exact element={<LocationInformation/>}/>
            <Route key={key} path='/userverify/uploadnationalcard' exact element={<UploadNationalCard/>}/>
            <Route key={key} path='/userverify/birthcertificate' exact element={<BirthCertificate/>}/>
            <Route key={key} path='/userverify/nationalserial' exact element={<NationalSerial/>}/>
            <Route key={key} path='/userverify/selectbranch' exact element={<SelectBranchFrom/>}/>
            <Route key={key} path='/userverify/selfie' exact element={<UploadSelfie/>}/>
            <Route key={key} path='/userverify/videoselfie' exact element={<VideoSelfie/>}/>
            <Route key={key} path='/userverify/uploadsignature' exact element={<UploadSignature/>}/>
            <Route key={key} path='/userverify/signature' exact element={<UploadSignature/>}/>
            <Route key={key} path='/userverify/completeinformation' exact element={<CompleteInformation/>}/>


            <Route key={key} path='/account/create' exact element={<AccountList/>}/>
            <Route key={key} path='/account/datepicker' exact element={<BirthdayPicker/>}/>
            <Route key={key} path='/account/rule' exact element={<RulePage/>}/>
            <Route key={key} path='/account/baseinformation' exact element={<BasicInformation/>}/>
            <Route key={key} path='/account/uploadnationalcard' exact element={<UploadNationalCard/>}/>
            <Route key={key} path='/account/birthcertificate' exact element={<BirthCertificate/>}/>
            <Route key={key} path='/account/nationalserial' exact element={<NationalSerial/>}/>
            <Route key={key} path='/account/selfie' exact element={<UploadSelfie/>}/>
            <Route key={key} path='/account/videoselfie' exact element={<VideoSelfie/>}/>
            <Route key={key} path='/account/locationinformation' exact element={<LocationInformation/>}/>
            <Route key={key} path='/account/completeinformation' exact element={<CompleteInformation/>}/>
            <Route key={key} path='/account/selectbranch' exact element={<SelectBranchFrom/>}/>
            <Route key={key} path='/account/accounts' exact element={<SelectAccountForm/>}/>
            <Route key={key} path='/account/signature' exact element={<UploadSignature/>}/>
            <Route key={key} path='/account/final' exact element={<Final/>}/>
            <Route key={key} path='/account/block' exact element={<Block/>}/>
            <Route key={key} path='/account/blockconfirmation' exact element={<BlockConfirmation/>}/>


            <Route key={key} path='/facilities/list' exact element={<RequestsList/>}/>
            <Route key={key} path='/facilities/rule' exact element={<RuleFacility/>}/>
            <Route key={key} path='/facilities/accounts' exact element={<AccountSelection/>}/>
            <Route key={key} path='/facilities/installmentcalculation' exact element={<InstallmentCalculation/>}/>
            <Route key={key} path='/facilities/detailsinstallmentcalculation' exact element={<DetailsInstallmentCalculation/>}/>
            <Route key={key} path='/facilities/collateralissuing' exact element={<CollateralIssuing/>}/>
            <Route key={key} path='/facilities/resultvalidation' exact element={<ResultValidation/>}/>
            <Route key={key} path='/facilities/collateralsuccess' exact element={<CollateralSuccess/>}/>
            <Route key={key} path='/facilities/collateralresult' exact element={<CollateralError/>}/>
            <Route key={key} path='/facilities/summaryfacilitystatus' exact element={<SummaryFacilitiesStatus/>}/>
            <Route key={key} path='/facilities/collateralversion' exact element={<CollateralVersion/>}/>
            <Route key={key} path='/facilities/validation' exact element={<Validation/>}/>
            <Route key={key} path='/facilities/payment' exact element={<Payment/>}/>


            <Route key={key} path='/transfer' exact element={<TransferList/>}/>
            <Route key={key} path='/transfer/satna' exact element={<SatnaForm/>}/>
            <Route key={key} path='/transfer/satnaalert' exact element={<SatnaAlert/>}/>
            <Route key={key} path='/transfer/paya' exact element={<PayaForm/>}/>
            <Route key={key} path='/transfer/payaAlert' exact element={<PayaAlert/>}/>
            <Route key={key} path='/transfer/accountturnover' exact element={<ChooseAccountTurnOver/>}/>
            <Route key={key} path='/transfer/listturnover' exact element={<ListTurnOver/>}/>
            <Route key={key} path='/transfer/payaalert' exact element={<PayaAlert/>}/>
            <Route key={key} path='/cardservices/formcardtocard' exact element={<FormCardToCard/>}/>
            <Route key={key} path='/cardservices/secondpassword' exact element={<SecondPasswordCardToCard/>}/>
            <Route key={key} path='/cardservices/listsuccesscardtocarfacilities/validationd' exact element={<ListSuccessCardToCard/>}/>




            {/*<Route key={key} path='/cardservices/cards' exact element={<Cards/>}/>*/}
            {/*<Route key={key} path='/cardservices/cardtocard' exact element={<CardToCard/>}/>*/}
            <Route key={key} path='/cardservices/dynamicpassword' exact element={<DynamicPassword/>}/>
            <Route key={key} path='/forgetfirstpassword/nationalcode' exact element={<ForgetPasswordNationalCode/>}/>
            <Route key={key} path='/forgetfirstpassword/activecode' exact element={<ForgetPasswordActiveCode/>}/>




            <Route key={key} path='/installments/accounts' exact element={<InstallmentsAccount/>}/>
            <Route key={key} path='/installments/payment' exact element={<Payment/>}/>
            <Route key={key} path='/installments/receipt' exact element={<Receipt/>}/>
            <Route key={key} path='/installments/list' exact element={<List/>}/>




            <Route key={key} path='/payingbill' exact element={<PayingBills/>}/>
            <Route key={key} path='/payingbill/transaction' exact element={<TransactionPayingBills/>}/>
            <Route key={key} path='/payingbill/result' exact element={<ResultPayingBills/>}/>



            <Route key={key} path='/inventoryinquiry' exact element={<InquiryType/>}/>
            <Route key={key} path='/inventoryinquiry/selectaccount' exact element={<SelectAccountInventory/>}/>
            <Route key={key} path='/inventoryinquiry/selectcard' exact element={<SelectCard/>}/>
            <Route key={key} path='/inventoryinquiry/listcard' exact element={<ListCard/>}/>
            <Route key={key} path='/inventoryinquiry/listaccount' exact element={<ListAccount/>}/>



            <Route key={key} path='/lawyer/account' exact element={<AccountLawyer/>}/>

        </Routes>
    );
}
