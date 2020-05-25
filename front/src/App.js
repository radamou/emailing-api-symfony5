import React from 'react';
import { Admin, Resource } from 'react-admin';
import jsonServerProvider from 'ra-data-json-server';
import EmailEventList  from './application/views/emailEvent/list';
import EmailEventShow from './application/views/emailEvent/show';
import authProvider from "./infrastructure/authentication/authProvider";
import EmailIcon from '@material-ui/icons/Email';
import SignInSide from "./application/views/login/login";
import MyLayout from "./domain/components/layout";
import httpClient from "./infrastructure/authentication/httpClient";
import theme from "./assets/views/AppStyle";
import {EmailTemplateEdit} from "./application/views/emailTemplate/edit";
import {EmailTemplateShow} from "./application/views/emailTemplate/show";
import {EmailVariableEdit} from "./application/views/variable/edit";
import {EmailVariableShow} from "./application/views/variable/show";
import {getUrl} from "./config";

const App = () => (
    <Admin layout={MyLayout}
        theme={theme}
        authProvider={authProvider}
        Title="Sympl Emailing" 
        dataProvider={jsonServerProvider(`${getUrl().symplApp}`, httpClient)}
        loginPage={SignInSide}
    >
        <Resource
            name="email-events"
            keys="events"
            list={EmailEventList}
            show={EmailEventShow}
            icon={EmailIcon}
            options={{ label: 'Liste des évènements' }}
        />
        <Resource
            name="email-templates"
            keys="email-templates"
            edit={EmailTemplateEdit}
            show={EmailTemplateShow}
        />
        <Resource
            name="email-variables"
            keys="email-variables"
            edit={EmailVariableEdit}
            show={EmailVariableShow}
        />
    </Admin>
);

export default App;