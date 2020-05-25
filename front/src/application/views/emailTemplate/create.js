import React from 'react';
import { 
    Create, 
    SimpleForm, 
    TextInput, 
    required,
    SelectInput 
} from 'react-admin';
import RichTextInput from 'ra-input-rich-text';
import {formStyles} from "../../../assets/views/formStyles";
import { CrudToolbar } from '../../../domain/components/toolBar';
import {Card, CardContent, CardHeader} from "@material-ui/core";

function CreateTemplate({onCancel, ...props }){
    const classes = formStyles();

    return (
        <Create {...props}>
            <SimpleForm title="Ajout d'un évènement" toolbar={<CrudToolbar onCancel={onCancel} />} className={classes.root}>
                <Card className={classes.card}>
                    <CardHeader className={classes.header} subheader="Créer un nouveau template"/>
                    <CardContent>
                        <TextInput label="titre du contenu de mail" source="title" style={{width:'100%'}}/>
                        <RichTextInput label="Contenu" source="body" style={{width:'100%'}}/>
                        <SelectInput style={{width:'100%'}}
                                     label="langue"
                                     source="language"
                                     choices={[
                                         { id: 'fr', name: 'Francais' },
                                         { id: 'en', name: 'Anglais' },
                                     ]}
                                     validate={required()}
                        />
                    </CardContent>
                </Card>
            </SimpleForm>
        </Create>)
};

export {
    CreateTemplate
}