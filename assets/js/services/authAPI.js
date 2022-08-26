import axios from 'axios';
import jwtDecode from 'jwt-decode';

function logout(){
    window.localStorage.removeItem('authToken');
    delete axios.defaults.headers["Authorization"];
}

function authenticate(credentials){
    return axios.post("http://localhost:8000/api/login_check", credentials)
        .then(response => response.data.token)
        .then(token => {
            // Stock token in local storage
            window.localStorage.setItem("authToken", token);
            // Authorization header HTTP
            setAxiosToken(token);

            return true;
        })
}

function setAxiosToken(token){
    return axios.defaults.headers['Authorization'] = "Bearer " + token;
}

function setup(){
    const token = window.localStorage.getItem("authToken");
    if (isAuthenticated()){
        setAxiosToken(token);
    }
}

function isAuthenticated(){
    const token = window.localStorage.getItem("authToken");
    if(token){
        const jwtData = jwtDecode(token);
        if(jwtData.exp * 1000 > new Date().getTime()){
            return true;
        } else {
            return false;
        }
    }
}

export default {
    authenticate,
    logout,
    setup,
    isAuthenticated
}
