import React from 'react';
import { 
    Edit, 
    TextInput, 
    SimpleForm, 
    required 
} from 'react-admin';
import RichTextInput from 'ra-input-rich-text';
import {formStyles} from "../../../assets/views/formStyles";
import {CardContent, CardHeader} from "@material-ui/core";
import CustomCard from "../../../domain/decorator/customCard";
import {configureQuill} from "../../../infrastructure/handler/quillImageHandler";
import {toolbarOptions} from "../../../data/richInputTextToolbarData";

function EmailTemplateEdit({...props }) {
    const classes = formStyles();

    return (
        <Edit title="Template à modifier" {...props} className={classes.root} redirect={"show"}>
            <SimpleForm>
                <CustomCard className={classes.card}>
                    <CardHeader className={classes.header} subheader="Template à modifier"/>
                    <CardContent>
                        <TextInput source="title" validate={required()} className={classes.field}/>
                        <RichTextInput
                            label="Contenu"
                            configureQuill={configureQuill}
                            toolbar={toolbarOptions}
                            source="body"
                            validate={required()}
                        />
                    </CardContent>
                </CustomCard>
            </SimpleForm>
        </Edit>
    )
}

export {
    EmailTemplateEdit
}