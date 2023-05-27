export default function checkToken(isToken) {
    return isToken && (localStorage.getItem("access_token") !== "" || localStorage.getItem("access_token") !== "null" || localStorage?.getItem("access_token") !== null || localStorage?.getItem("access_token") !== undefined);
}
