import React, {Fragment} from 'react';
import {
    Show,
    SimpleShowLayout,
    TextField,
    RichTextField,
    TabbedShowLayout,
    ShowButton,
    EditButton,
    ReferenceManyField,
    Datagrid,
    Tab,
} from 'react-admin';
import { connect } from "react-redux";
import { push } from "react-router-redux";
import CustomizedBreadcrumbs from '../../../domain/components/breadCrumb';
import {EventListShowActions} from "../../../domain/components/toolBar";

class EmailEventShow extends React.Component {
    render() {
        const props = this.props;
        const {hasList, hasEdit, hasShow, hasCreate, push, ...rest} = props;

        return (
            <Fragment>
                <CustomizedBreadcrumbs name="détail d'un évènement" link="/email-events"/>
                <Show {...rest}
                    title={"Page d'affichage détaillé de l'évènement déclancheur de l'envoi de mail"}
                    actions={<EventListShowActions />}
                    >
                    <SimpleShowLayout>
                        <TextField label="Code" source="code" />
                        <RichTextField label="Description" source="description" />
                        <TabbedShowLayout>
                            <Tab label="Templates">
                                <ReferenceManyField reference="email-templates" target="emailEvent" addLabel={false}>
                                    <Datagrid>
                                        <TextField label="Brève description" source="title" />
                                        <RichTextField label="Contenu personalisé" source="body" />
                                        <ShowButton label=""/>
                                        <EditButton label=""/>
                                    </Datagrid>
                                </ReferenceManyField>
                            </Tab>
                            <Tab label="Variables">
                                <ReferenceManyField reference="email-variables" target="emailEvent" addLabel={false}>
                                    <Datagrid label="liste des variables utilisables dans le contenu du mail" >
                                        <TextField label="Nom de la variable" source="name" />
                                        <RichTextField label="Description" source="description" />
                                        <ShowButton label=""/>
                                        <EditButton label=""/>
                                    </Datagrid>
                                </ReferenceManyField>
                            </Tab>
                        </TabbedShowLayout>
                    </SimpleShowLayout>
                </Show>
            </Fragment>
        )
    }
}

export default connect(
    undefined,
    { push }
)(EmailEventShow);

   