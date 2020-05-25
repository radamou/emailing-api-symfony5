import React from 'react';
import { 
    Create, 
    SimpleForm, 
    TextInput, 
    required, 
    ArrayInput, 
    SimpleFormIterator,
    BooleanInput,
    SelectInput 
} from 'react-admin';
import RichTextInput from 'ra-input-rich-text';
import FavoriteIcon from '@material-ui/icons/Favorite';
import { CrudToolbar } from '../../../domain/components/toolBar';
import { formStyles } from "../../../assets/views/formStyles";
import { CardHeader, CardContent } from "@material-ui/core";
import CustomCard from "../../../domain/decorator/customCard";
import { toolbarOptions } from "../../../data/richInputTextToolbarData";
import {configureQuill} from "../../../infrastructure/handler/quillImageHandler";

function  CreateEvent({onCancel, ...props }) {
    const classes = formStyles();
    const {hasList, hasEdit, hasShow, hasCreate, push, ...rest} = props;

    return (
        <Create {...rest} className={classes.root} >
        <SimpleForm {...rest}
            title="Ajout d'un évènement"
            toolbar={<CrudToolbar onCancel={onCancel} />}
            redirect="show"
        >
            <CustomCard className={classes.card} component={"div"}>
                <CardHeader className={classes.header} subheader="Evènement" component={"div"}/>
                <CardContent component={"div"}>
                    <TextInput
                        className={classes.field}
                        label="code" source="code" validate={required()}
                        helperText={'Le code de l\'évènement doit être au format text.text.text, example: command.successful.delivery.mail'}/>
                    <TextInput
                        className={classes.field}
                        label="description"
                        source="description" validate={required()} />
                    <BooleanInput
                        className={classes.field}
                        label = "Activer l'évènement par défaut"
                        source="isActive"
                        options={{
                            checkedIcon: <FavoriteIcon />,
                        }}
                        validate={required()}
                    />
                </CardContent>
            </CustomCard>
            <CustomCard className={classes.card} component={"div"}>
                <CardHeader className={classes.header} subheader="Ajouter le contenu du mail" component={"div"}/>
                <CardContent className={classes.group} component={"div"}>
                    <TextInput className={classes.field} label="Sujet du mail" source="emailTemplate.title" validate={required()} />
                    <RichTextInput
                        label="Contenu"
                        configureQuill={configureQuill}
                        toolbar={toolbarOptions}
                        source="emailTemplate.body"
                        validate={required()}
                    />
                    <SelectInput className={classes.choice}
                        label="langue"
                        source="emailTemplate.language"
                        choices={[
                            { id: 'fr', name: 'Français' },
                            { id: 'en', name: 'Anglais' },
                        ]}
                        validate={required()}
                    />
                </CardContent>
            </CustomCard>
            <CustomCard className={classes.card} component={"div"}>
                <CardHeader className={classes.header} subheader="Liste des variables à utiliser dans le mail" component={"div"}/>
                <CardContent component={"div"}>
                    <ArrayInput className={classes.field} source="emailEventVariables">
                        <SimpleFormIterator>
                            <TextInput
                                label="nom"
                                source="name" validate={required()}
                                helperText={'format text.text.text, example: command.email.receiver'}
                            />
                            <TextInput label="description" source="description" validate={required()} />
                        </SimpleFormIterator>
                    </ArrayInput>
                </CardContent>
            </CustomCard>
        </SimpleForm>
    </Create>)
};

export {
    CreateEvent
};