import { LOGIN_URL } from "../../Endpoint";
import decodeJwt from 'jwt-decode';
import { getUrl } from "../../config";

const authProvider = {
    login: ({ username, password }) =>  {
        const baseBody = {
            "loginType": "password",
            "accountType": "admin",
            "tokenFormat": "jwt",
            "email": username,
            "password": password
        };
        const request = new Request(`${getUrl().symplApp}${LOGIN_URL}`, {
            method: 'POST',
            body: JSON.stringify(baseBody),
            headers: new Headers({ 'Content-Type': 'application/json' }),
        });
        return fetch(request)
            .then(response => {
                if (response.status < 200 || response.status >= 300) {
                    throw new Error(response.statusText);

                }
    
                return response.json();
            })
            .then(({admin}) => {
                if(admin) {
                    localStorage.setItem('token', admin.token);
                    let data = decodeJwt(admin.token);
                    
                    if(data && data.company) {
                        localStorage.setItem('permissions', data.company);
                    }
                } 
            });
    },
    logout: () => {
        localStorage.removeItem('token');
        localStorage.removeItem('permissions');

        return Promise.resolve();
    },
    checkError: (error) => {
        const status = error.status;
        if (status === 401 || status === 403) {
            localStorage.removeItem('token');
            return Promise.reject();
        }
        return Promise.resolve();
    },
    checkAuth: () => {
        return localStorage.getItem('token') ? Promise.resolve() : Promise.reject();
    },
    getPermissions: () => {
        const role = localStorage.getItem('permissions');
        
        return role ? Promise.resolve(role) : Promise.reject();
    }
};

export default authProvider;