import React from 'react';
import {
    Edit,
    TextInput, 
    SimpleForm, 
    BooleanInput,
    ArrayInput,
    SimpleFormIterator,
    required 
} from 'react-admin';
import FavoriteIcon from '@material-ui/icons/Favorite';
import { CrudToolbar } from '../../../domain/components/toolBar';
import {formStyles} from "../../../assets/views/formStyles";
import { CardHeader, CardContent } from "@material-ui/core";
import CustomCard from "../../../domain/decorator/customCard";

function EmailEventEdit({onCancel, ...props}) {
    const classes = formStyles();
    const {hasList, hasEdit, hasShow, hasCreate, push, ...rest} = props;

    return (
        <Edit {...rest} className={classes.root}>
            <SimpleForm  toolbar={<CrudToolbar onCancel={onCancel} />}>
                <CustomCard className={classes.card}>
                    <CardHeader className={classes.header} subheader="Evènement"/>
                    <CardContent>
                        <TextInput source="code" className={classes.field} />
                        <TextInput source="description" className={classes.field} multiline={true}/>
                        <BooleanInput
                            label = "activé par défaut"
                            source="isActive"
                            options={{
                                checkedIcon: <FavoriteIcon />,
                            }}
                            className={classes.field}
                        />
                    </CardContent>
                </CustomCard>
                <CustomCard className={classes.card}>
                    <CardHeader className={classes.header} subheader="Variables à mèttre à jour" />
                    <CardContent>
                        <ArrayInput source="emailEventVariables" className={classes.field}>
                            <SimpleFormIterator>
                                <TextInput label="nom de la variable" source="name" validate={required()} />
                                <TextInput label="description" source="description" validate={required()} />
                            </SimpleFormIterator>
                        </ArrayInput>
                    </CardContent>
                </CustomCard>
            </SimpleForm>
        </Edit>
    )
}

export {
    EmailEventEdit
}