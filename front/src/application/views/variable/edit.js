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

function EmailVariableEdit({...props }) {
    const classes = formStyles();

    return (
        <Edit title="Variable de mail à mettre à jour" {...props} className={classes.root} redirect={"show"}>
            <SimpleForm>
                <CustomCard className={classes.card}>
                    <CardHeader className={classes.header} subheader="Variable à mettre à jour"/>
                    <CardContent>
                        <TextInput source="name" validate={required()} className={classes.field}/>
                        <RichTextInput source="description" validate={required()} className={classes.field}/>
                    </CardContent>
                </CustomCard>
            </SimpleForm>
        </Edit>
    )
}

export {
    EmailVariableEdit
}