import React from 'react';
import {
    Show,
    SimpleShowLayout,
    TextField,
    RichTextField
} from 'react-admin';
import CustomizedBreadcrumbs from "../../../domain/components/breadCrumb";


export const EmailTemplateShow = (props) => {
    return (
        <React.Fragment>
            <CustomizedBreadcrumbs name="détail" link="/email-events" />
            <Show {...props} title="Page du contenu de mail personnalisé">
                <SimpleShowLayout label="Contenu de mail">
                    <RichTextField label="title" source="title" />
                    <RichTextField label='Contenu du mail' source="body" />
                    <TextField label="Langue" source="language" />
                </SimpleShowLayout>
            </Show>
        </React.Fragment>
    )
};