import React from 'react';
import {
    Show,
    SimpleShowLayout,
    RichTextField
} from 'react-admin';
import CustomizedBreadcrumbs from "../../../domain/components/breadCrumb";

export const EmailVariableShow = (props) => {
    return (
        <React.Fragment>
            <CustomizedBreadcrumbs name="détail" link="/email-events" />
            <Show {...props} title="Page du contenu de mail personnalisé">
                <SimpleShowLayout label="Page de détail d'une variable dynamique utilisable dans l'ajout des contenus des mails">
                    <RichTextField label="nom" source="name" />
                    <RichTextField label='Descritpion de la variable' source="description" />
                </SimpleShowLayout>
            </Show>
        </React.Fragment>
    )
};