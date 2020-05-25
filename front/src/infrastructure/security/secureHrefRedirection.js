import {getUrl} from "../../config";

export const externalMenuClick = (e) => {
    e.preventDefault();
    const href = e.target.getAttribute('external-key');

    const token = localStorage.getItem('token');
   window.location = `${getUrl().secureUrl}/secure-emailing?__jwt=${token}&href=${href}`;
};